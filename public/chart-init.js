/**
 * @copyright  Bright Cloud Studio
 * @author     Bright Cloud Studio
 * @package    Contao CE Chart
 * @license    MIT
 * @see        https://github.com/bright-cloud-studio/contao-ce-chart
 */

(function () {
    'use strict';

    // Paint each bar with a gradient running from its base to its tip. Gradients
    // need the bar's position on the canvas, so they can't travel in the JSON.
    var gradientPlugin = {
        id: 'bcsGradient',
        beforeDatasetDraw: function (chart, args, options) {
            var horizontal = 'y' === chart.options.indexAxis;

            args.meta.data.forEach(function (bar) {
                var gradient = horizontal
                    ? chart.ctx.createLinearGradient(bar.base, 0, bar.x, 0)
                    : chart.ctx.createLinearGradient(0, bar.base, 0, bar.y);

                gradient.addColorStop(0, options.from);
                gradient.addColorStop(1, options.to);
                bar.options.backgroundColor = gradient;
            });
        }
    };

    /**
     * Draw two-line category labels with the last line in bold
     *
     * A tick label only takes one font, so Chart.js still lays the labels out
     * (in bold, to reserve the wider of the two widths) but paints them
     * transparent, and this plugin draws the visible text over the same spots.
     */
    var splitLabelsPlugin = {
        id: 'bcsSplitLabels',
        afterDraw: function (chart, args, options) {
            var scale = chart.scales[options.axis];
            var ticks = scale.options.ticks;
            var grid = scale.options.grid;
            var regular = Chart.helpers.toFont(Object.assign({}, ticks.font, {weight: options.weight}));
            var bold = Chart.helpers.toFont(Object.assign({}, ticks.font, {weight: 'bold'}));
            var offset = ticks.padding + (grid.drawTicks ? grid.tickLength : 0);
            var vertical = 'y' === options.axis;
            var ctx = chart.ctx;

            ctx.save();
            ctx.fillStyle = options.color;
            ctx.textAlign = vertical ? 'right' : 'center';
            ctx.textBaseline = 'middle';

            scale.ticks.forEach(function (tick, index) {
                var lines = [].concat(chart.data.labels[tick.value]);
                var position = scale.getPixelForTick(index);

                // Centre the block on the tick beside a vertical axis, hang it below a horizontal one
                var first = vertical
                    ? position - (lines.length - 1) * regular.lineHeight / 2
                    : scale.top + offset + regular.lineHeight / 2;

                lines.forEach(function (line, i) {
                    var at = first + i * regular.lineHeight;

                    ctx.font = i === lines.length - 1 ? bold.string : regular.string;

                    if (vertical) {
                        ctx.fillText(line, scale.right - offset, at);
                    } else {
                        ctx.fillText(line, position, at);
                    }
                });
            });

            ctx.restore();
        }
    };

    // Break text into lines no wider than maxWidth in the context's current font
    function wrapText(ctx, text, maxWidth) {
        var lines = [];
        var line = '';

        text.split(/\s+/).forEach(function (word) {
            var next = line ? line + ' ' + word : word;

            if (line && ctx.measureText(next).width > maxWidth) {
                lines.push(line);
                next = word;
            }

            line = next;
        });

        lines.push(line);

        return lines;
    }

    /**
     * Draw boxed notes with a white leader line to a point on the chart
     *
     * Only drawn where the site sets --chart-callouts: show. Positions come
     * from the data, so the callouts follow the chart at any size.
     *
     * Flow:
     *  1. Pull the leader in from the plot edges, so it never sits on an axis
     *  2. Put the box on the side facing the chart's centre, level with its height
     *  3. Skip them all if any two boxes would overlap — the chart is too narrow
     *  4. Run the leader from a dot by the box across and down to the point,
     *     ending in a bracket when the callout spans two values
     *  5. Draw the box and its wrapped text over the leader
     */
    var calloutsPlugin = {
        id: 'bcsCallouts',
        afterDraw: function (chart, args, options) {
            if (!chart.$bcsShowCallouts) {
                return;
            }

            var area = chart.chartArea;
            var xScale = chart.scales.x;
            var yScale = chart.scales.y;
            var ticks = yScale.options.ticks;

            // Box text is about 70% of the axis values, as in the design, and wraps at 15em
            var font = Chart.helpers.toFont(Object.assign({}, ticks.font, {size: Math.round(ticks.font.size * 0.7), weight: 'bold'}));
            var ctx = chart.ctx;

            ctx.save();
            ctx.font = font.string;

            var callouts = options.items.map(function (item) {
                var x = Math.min(Math.max(xScale.getPixelForValue(item.x), area.left + 16), area.right - 16);
                var side = x < (area.left + area.right) / 2 ? 1 : -1;
                var lines = wrapText(ctx, item.text, font.size * 15);
                var width = Math.max.apply(null, lines.map(function (line) {
                    return ctx.measureText(line).width;
                })) + 18;
                var height = lines.length * font.lineHeight + 12;
                var level = yScale.getPixelForValue(item.height);

                return {
                    item: item,
                    x: x,
                    side: side,
                    dot: x + side * 17,
                    level: level,
                    lines: lines,
                    left: side > 0 ? x + 29 : x - 29 - width,
                    top: level - height / 2,
                    width: width,
                    height: height
                };
            });

            var overlap = callouts.some(function (a, i) {
                return callouts.slice(i + 1).some(function (b) {
                    return a.left < b.left + b.width + 8 && b.left < a.left + a.width + 8
                        && a.top < b.top + b.height + 8 && b.top < a.top + a.height + 8;
                });
            });

            if (overlap) {
                ctx.restore();

                return;
            }

            ctx.lineWidth = 2;
            ctx.strokeStyle = '#fff';
            ctx.textAlign = 'left';
            ctx.textBaseline = 'middle';

            callouts.forEach(function (c) {
                var y = yScale.getPixelForValue(c.item.y);

                // Leader, then a bracket from Value to Bracket To, closed on the box's side
                ctx.beginPath();
                ctx.moveTo(c.dot, c.level);
                ctx.lineTo(c.x, c.level);
                ctx.lineTo(c.x, y);

                if (null !== c.item.to) {
                    var to = yScale.getPixelForValue(c.item.to);

                    ctx.moveTo(c.x - c.side * 9, y);
                    ctx.lineTo(c.x + c.side * 9, y);
                    ctx.lineTo(c.x + c.side * 9, to);
                    ctx.lineTo(c.x - c.side * 9, to);
                }

                ctx.stroke();

                ctx.fillStyle = '#fff';
                ctx.beginPath();
                ctx.arc(c.dot, c.level, 4, 0, 2 * Math.PI);
                ctx.fill();

                // Box in the axis colour, white text
                ctx.fillStyle = ticks.color;
                ctx.fillRect(c.left, c.top, c.width, c.height);
                ctx.fillStyle = '#fff';

                c.lines.forEach(function (line, i) {
                    ctx.fillText(line, c.left + 9, c.top + 6 + font.lineHeight * (i + 0.5));
                });
            });

            ctx.restore();
        }
    };

    /**
     * Keep a chart in step with the CSS around it
     *
     * The custom properties are read again before every update, so a chart
     * restyles itself when it moves somewhere they differ (e.g. into a popup)
     * and redraws. After layout, where the plotting area starts is published
     * as --chart-area-left on the wrapper, so site CSS can decorate around the
     * axis (e.g. shade the labels).
     *
     * Two more properties change what is drawn rather than how text looks:
     *
     *   --chart-axis-values: show   values on axes set to "Line only" appear
     *   --chart-area-background     colour filled behind the plotting area
     *   --chart-callouts: show      line chart callouts are drawn
     */
    var stylesPlugin = {
        id: 'bcsStyles',

        // Note the axes saved as "Line only" before anything changes them
        beforeInit: function (chart) {
            var scales = chart.config.options.scales || {};

            chart.$bcsLineAxes = Object.keys(scales).filter(function (id) {
                return false !== scales[id].display && scales[id].ticks && false === scales[id].ticks.display;
            });
        },
        beforeUpdate: function (chart) {
            var options = chart.config.options;
            var style = getComputedStyle(chart.canvas);
            var showValues = 'show' === style.getPropertyValue('--chart-axis-values').trim();

            applyStyles(chart.canvas, options);
            hideSplitLabels(options);

            chart.$bcsLineAxes.forEach(function (id) {
                options.scales[id].ticks.display = showValues;
            });

            chart.$bcsAreaBackground = style.getPropertyValue('--chart-area-background').trim();
            chart.$bcsShowCallouts = 'show' === style.getPropertyValue('--chart-callouts').trim();
        },
        afterLayout: function (chart) {
            chart.canvas.parentNode.style.setProperty('--chart-area-left', chart.chartArea.left + 'px');
        },
        beforeDraw: function (chart) {
            var area = chart.chartArea;

            if (chart.$bcsAreaBackground) {
                chart.ctx.save();
                chart.ctx.fillStyle = chart.$bcsAreaBackground;
                chart.ctx.fillRect(area.left, area.top, area.width, area.height);
                chart.ctx.restore();
            }
        }
    };

    /**
     * Hand the label colour and weight to the split labels plugin, then hide
     * Chart.js's own labels while keeping them in bold so they reserve enough
     * room. The weight and a colour no variable supplied are kept from the
     * first pass, before the labels were hidden.
     */
    function hideSplitLabels(options) {
        var split = options.plugins && options.plugins.bcsSplitLabels;

        if (!split) {
            return;
        }

        var ticks = options.scales[split.axis].ticks;
        var font = ticks.font || {};

        if ('transparent' !== ticks.color) {
            split.color = ticks.color || Chart.defaults.color;
        }

        if (!split.weight) {
            split.weight = font.weight || 'normal';
        }

        ticks.color = 'transparent';
        ticks.font = Object.assign({}, font, {weight: 'bold'});
    }

    // Merge a font and colour into one text option of the configuration
    function applyText(target, font, color) {
        if (!target) {
            return;
        }

        if (font) {
            target.font = Object.assign({}, target.font, font);
        }

        if (color) {
            target.color = color;
        }
    }

    /**
     * Style a chart's text from CSS custom properties on or above its canvas
     *
     * Canvas text ignores CSS, so the site sets these variables instead. Each
     * one is opt-in: an unset variable leaves the Chart.js default alone.
     *
     *   --chart-font-family    every label, tick and title
     *   --chart-font-size      every label, tick and title, in pixels
     *   --chart-color          every label, tick and title, and the axis lines
     *   --chart-title-weight   axis titles and the chart title
     */
    function applyStyles(canvas, options) {
        var style = getComputedStyle(canvas);
        var family = style.getPropertyValue('--chart-font-family').trim();
        var size = parseFloat(style.getPropertyValue('--chart-font-size'));
        var color = style.getPropertyValue('--chart-color').trim();
        var weight = style.getPropertyValue('--chart-title-weight').trim();

        var font = {};

        if (family) {
            font.family = family;
        }

        if (size) {
            font.size = size;
        }

        // Titles share the text font and add the weight on top
        var titleFont = Object.assign({}, font);

        if (weight) {
            titleFont.weight = weight;
        }

        font = Object.keys(font).length ? font : null;
        titleFont = Object.keys(titleFont).length ? titleFont : null;

        // Axis lines, values and titles
        Object.keys(options.scales || {}).forEach(function (id) {
            var scale = options.scales[id];

            scale.ticks = scale.ticks || {};
            applyText(scale.ticks, font, color);
            applyText(scale.title, titleFont, color);

            if (color) {
                scale.border = Object.assign({}, scale.border, {color: color});
            }
        });

        // Legend entries and the chart title
        if (options.plugins) {
            if (options.plugins.legend) {
                options.plugins.legend.labels = options.plugins.legend.labels || {};
                applyText(options.plugins.legend.labels, font, color);
            }

            applyText(options.plugins.title, titleFont, color);
        }
    }

    // Build every chart whose configuration was rendered next to its canvas
    function init() {
        var configs = document.querySelectorAll('script[data-bcs-chart]');

        for (var i = 0; i < configs.length; i++) {
            var canvas = document.getElementById(configs[i].getAttribute('data-bcs-chart'));

            if (canvas) {
                var config = JSON.parse(configs[i].textContent);
                var plugins = config.options.plugins || {};

                config.plugins = [stylesPlugin];

                // Only gradient bar charts carry the plugin's options
                if (plugins.bcsGradient) {
                    config.plugins.push(gradientPlugin);
                }

                if (plugins.bcsSplitLabels) {
                    config.plugins.push(splitLabelsPlugin);
                }

                if (plugins.bcsCallouts) {
                    config.plugins.push(calloutsPlugin);
                }

                new Chart(canvas, config);
            }
        }
    }

    // This file loads in the <head>, so wait for the canvases to exist
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
})();
