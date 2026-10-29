# Bright Cloud Studio's Contao Content Elements - Chart.js

Integrates [Chart.js](https://www.chartjs.org/) into Contao as two custom
content elements: **Line Chart** and **Bar Chart**. Both appear in the element
picker under the **Dataset elements** group.

General-purpose and reusable — nothing in it is client-specific.

## Requirements

| | |
|---|---|
| PHP | 8.3 – 8.4 |
| Contao | 5.7 |
| MultiColumnWizard | 3.7 |

Contao 5.7 itself requires PHP 8.3, which sets the floor here.

## Installation

```
composer require bright-cloud-studio/contao-ce-chart
```

Then run the database update in the Contao Manager or via
`vendor/bin/contao-console contao:migrate`.

## Usage

Add a **Line Chart** or **Bar Chart** element to an article and fill in the
**Dataset Details**:

- **Table data** uses Contao's table wizard. The **first row** is the header:
  its leading cell becomes the chart title, and every cell after it becomes an
  x-axis label. **Each row below** is one series — its leading cell is the
  series name, the rest are its values.
- **X/Y-Axis Label** are optional; an axis title is only drawn when you enter one.
- **Chart Description** renders below the canvas and accepts insert tags.

| | A | B | C |
|---|---|---|---|
| **1** | Attacks by Year | 2023 | 2024 |
| **2** | Phishing | 35 | 42 |
| **3** | Ransomware | 25 | 31 |

That grid produces a chart titled "Attacks by Year", with 2023/2024 on the
x-axis and two series.

### Colors

The colour fields take **RGBA components as separate values** — one row per
series, in the same order as the rows of the data grid. Alpha is `0`–`1`, so
`255 / 0 / 0 / 0.5` is a half-transparent red.

The line border colours have a fourth column, **Style**, that draws a series
as a solid, dashed or dotted line. A row of constant values with a dotted style
makes a reference line, e.g. a target of `0.5` in every column.

### Display

Every display setting defaults to drawing everything, so charts saved before
these fields existed are unchanged.

- **Hide Chart Parts** turns off the legend, the title and/or the grid lines.
- **X/Y-Axis Display** is *Full* (line and values), *Line only* (the axis line
  and its label, without values) or *Hidden*.
- **Value Minimum/Maximum** pin the value axis. Leave them blank to fit the
  data. Set the minimum to `0` so the smallest bar still shows, and give a set
  of related charts the same maximum so they can be compared.
- **Value Step** sets the gap between the values on the value axis, e.g. `0.5`
  for 0, 0.5, 1.0 … Leave it blank to let Chart.js choose.

### Bar options

- **Horizontal Bars** runs the bars sideways. The x-axis then carries the
  values, so *X-Axis Display* and *Value Minimum/Maximum* refer to it.
- **Gradient Bars** fades each bar from the first background colour to the
  second, from its base to its tip.
- **Two-Line Labels** shows each bar label in capitals, broken before its last
  word, with that last word in bold — "Surround Precision" becomes SURROUND over
  **PRECISION**. A one-word label is a single bold line.

### Fonts and colours

Chart.js draws on a canvas, which CSS can't style. Instead, `chart-init.js`
reads these custom properties from the chart's canvas, so they can be set on any
wrapper in the site stylesheet. Each one is optional, and an unset property
leaves the Chart.js default in place.

| Property | Applies to |
|---|---|
| `--chart-font-family` | every label, value and title |
| `--chart-font-size` | every label, value and title (a number, in pixels) |
| `--chart-color` | every label, value and title, plus the axis lines |
| `--chart-title-weight` | axis titles and the chart title |

```scss
.level_card {
    --chart-font-family: "Gotham", sans-serif;
    --chart-font-size: 12;
    --chart-color: #151744;
    --chart-title-weight: 700;
}
```

The properties are read again every time a chart updates, so a chart moved
somewhere they differ (a popup, say) restyles itself on its next redraw.

Two more properties change what is drawn, in the same opt-in way:

| Property | Effect |
|---|---|
| `--chart-axis-values: show` | axes set to *Line only* show their values too |
| `--chart-area-background` | colour filled behind the plotting area |

So a chart can stay minimal in a small card and gain its values and a shaded
background inside a larger popup, from CSS alone.

`chart-init.js` also sets `--chart-area-left` on each chart's wrapper: the
distance, in pixels, from the canvas content edge to where the plotting area
starts (the y-axis line). Site CSS can use it to decorate around the axis, such
as shading the label column:

```scss
.popup .ce_bar_chart_wrapper {
    padding: 30px 30px 30px 40px;
    background: linear-gradient(#d2d3d6, #d2d3d6) no-repeat 0 30px / calc(40px + var(--chart-area-left)) calc(100% - 60px);
}
```

Put padding and borders on the wrapper, not the canvas. Chart.js sizes the
chart to the canvas's outer box, so padding on the canvas squeezes the drawing.

### Sizing

**Responsive** and **Maintain Aspect Ratio** map to the Chart.js options of the
same names. **Maximum Width/Height** accept any CSS length (`1000px`, `50%`,
`20vh`) and are applied to the wrapper.

## Templates

The elements ship modern Twig templates and can be overridden per theme:

```
templates/<theme>/content_element/chart_line.html.twig
templates/<theme>/content_element/chart_bar.html.twig
```

The wrapper keeps the `ce_line_chart_wrapper` / `ce_bar_chart_wrapper` and
`chart_desc_wrapper` classes from the previous release, so existing site CSS
continues to match. A per-record override is also available through the
**Custom template** field.

## How the JavaScript is delivered

Each chart renders its configuration beside its canvas as inert JSON:

```html
<canvas id="chart_42"></canvas>
<script type="application/json" data-bcs-chart="chart_42">{ ... }</script>
```

`chart-init.js` reads those on `DOMContentLoaded` and builds each chart. Nothing
an editor types is ever emitted as executable JavaScript.

Chart.js is loaded from jsDelivr, pinned to v4, as the **UMD build** — it
therefore exposes `Chart` as a global that any hand-written chart script on the
page can also use. Both files are registered through `$GLOBALS['TL_JAVASCRIPT']`
without a combiner flag so they keep their order in the `<head>`, which
guarantees Chart.js is defined first.

> Both files are only registered when a chart element is actually on the page.

## License

MIT — see [LICENSE](LICENSE).
