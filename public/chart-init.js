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
    function applyStyles(canvas, config) {
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

        var options = config.options;

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

                applyStyles(canvas, config);

                // Only gradient bar charts carry the plugin's options
                if (config.options.plugins && config.options.plugins.bcsGradient) {
                    config.plugins = [gradientPlugin];
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
