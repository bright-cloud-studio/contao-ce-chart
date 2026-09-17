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
