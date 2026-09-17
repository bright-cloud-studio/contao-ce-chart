<?php

/**
 * @copyright  Bright Cloud Studio
 * @author     Bright Cloud Studio
 * @package    Contao CE Chart
 * @license    MIT
 * @see        https://github.com/bright-cloud-studio/contao-ce-chart
 */

namespace Bcs\ChartBundle\Controller\ContentElement;

use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\InsertTag\InsertTagParser;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Contao\StringUtil;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractChartController extends AbstractContentElementController
{
    /**
     * Escape angle brackets and ampersands so the encoded configuration can
     * never terminate the <script> block it is rendered into
     */
    private const JSON_FLAGS = JSON_HEX_TAG | JSON_HEX_AMP | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE;

    public function __construct(private readonly InsertTagParser $insertTagParser)
    {
    }

    /**
     * Render the chart
     *
     * Flow:
     *  1. Hand the wrapper details to the template
     *  2. Read the table wizard grid and bail out of the chart itself if it is empty
     *  3. Encode the Chart.js configuration as JSON and register the assets
     *
     * Everything happens here rather than in the constructor so that Contao can
     * still suppress the element — a protected chart must not leak its data.
     */
    protected function getResponse(FragmentTemplate $template, ContentModel $model, Request $request): Response
    {
        $template->set('chart_id', 'chart_' . $model->id);
        $template->set('chart_style', $this->getStyle($model));
        $template->set('chart_desc', $this->insertTagParser->replaceInline((string) $model->chart_desc));
        $template->set('chart_config', null);

        $rows = StringUtil::deserialize($model->tableitems, true);

        if (!empty($rows)) {
            $template->set('chart_config', json_encode($this->getConfig($model, $rows), self::JSON_FLAGS));
            $this->registerAssets();
        }

        return $template->getResponse();
    }

    /**
     * Assemble the Chart.js configuration for this chart type
     */
    abstract protected function getConfig(ContentModel $model, array $rows): array;

    /**
     * Read the x-axis labels from the header row, skipping its leading title cell
     */
    protected function getLabels(array $rows): array
    {
        return array_values(array_slice($rows[0], 1));
    }

    /**
     * Turn every row below the header into a Chart.js dataset
     *
     * Blank cells become null rather than zero so that Chart.js draws a gap in
     * the series instead of dropping the line to the axis.
     */
    protected function getSeries(array $rows): array
    {
        $series = [];

        foreach (array_slice($rows, 1) as $row) {
            $values = [];

            foreach (array_slice($row, 1) as $value) {
                $values[] = is_numeric($value) ? (float) $value : null;
            }

            $series[] = ['label' => $row[0], 'data' => $values];
        }

        return $series;
    }

    /**
     * Read a multiColumnWizard colour field and format each row as an rgba() string
     *
     * The keys are missing rather than empty on records saved before a column
     * existed, so each component falls back instead of warning.
     */
    protected function getColors($value, string $prefix): array
    {
        $colors = [];

        foreach (StringUtil::deserialize($value, true) as $row) {
            $colors[] = sprintf(
                'rgba(%d, %d, %d, %s)',
                (int) ($row[$prefix . '_r'] ?? 0),
                (int) ($row[$prefix . '_g'] ?? 0),
                (int) ($row[$prefix . '_b'] ?? 0),
                (float) ($row[$prefix . '_a'] ?? 1)
            );
        }

        return $colors;
    }

    /**
     * Build the options both chart types share
     *
     * Flow:
     *  1. Apply the responsive and aspect ratio settings unconditionally
     *  2. Add the show/hide transitions only when animation is switched on
     *  3. Title each axis only where the editor supplied a label
     *  4. Take the chart title from the top-left cell of the grid
     */
    protected function getOptions(ContentModel $model, array $rows): array
    {
        $options = [
            'responsive' => 'true' === $model->responsive,
            'maintainAspectRatio' => 'true' === $model->maintain_aspect_ratio,
        ];

        if ('yes' === $model->animate) {
            $options['transitions'] = [
                'show' => ['animations' => ['x' => ['from' => 0], 'y' => ['from' => 0]]],
                'hide' => ['animations' => ['x' => ['to' => 0], 'y' => ['to' => 0]]],
            ];
        }

        $options['scales'] = [
            'y' => $this->getAxis($model->label_y),
            'x' => $this->getAxis($model->label_x),
        ];

        $options['plugins'] = [
            'legend' => ['position' => 'top'],
            'title' => ['display' => true, 'text' => $rows[0][0]],
        ];

        return $options;
    }

    /**
     * Describe a single axis, showing its title only when one was entered
     */
    private function getAxis($label): array
    {
        return [
            'beginAtZero' => false,
            'title' => ['display' => '' !== (string) $label, 'text' => (string) $label],
        ];
    }

    /**
     * Assemble the inline style from the editor's maximum width and height
     */
    private function getStyle(ContentModel $model): string
    {
        $style = [];

        if ($model->max_width) {
            $style[] = 'max-width: ' . $model->max_width . ';';
        }

        if ($model->max_height) {
            $style[] = 'max-height: ' . $model->max_height . ';';
        }

        return implode(' ', $style);
    }

    /**
     * Register Chart.js and our initialiser
     *
     * The UMD build is deliberate — it exposes Chart as a global, which
     * hand-written chart scripts elsewhere on the page may also rely on. Neither
     * file carries a combiner flag, so both keep their order in the <head> and
     * Chart.js is always defined first. The named keys collapse the duplicates
     * when several charts share a page.
     */
    private function registerAssets(): void
    {
        $GLOBALS['TL_JAVASCRIPT']['chart_cdn'] = 'https://cdn.jsdelivr.net/npm/chart.js@4/dist/chart.umd.js';
        $GLOBALS['TL_JAVASCRIPT']['chart_init'] = 'bundles/bcschart/chart-init.js';
    }
}
