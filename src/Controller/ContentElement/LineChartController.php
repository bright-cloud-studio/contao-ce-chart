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
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;

#[AsContentElement(type: 'chart_line', category: 'datasets', template: 'content_element/chart_line')]
class LineChartController extends AbstractChartController
{
    /**
     * Assemble the Chart.js line configuration
     *
     * Flow:
     *  1. Read the per-series colours from the two colour wizards
     *  2. Give each dataset the colour sitting at its own position
     *  3. Apply the shared line and point styling through the elements option
     */
    protected function getConfig(ContentModel $model, array $rows): array
    {
        $backgrounds = $this->getColors($model->line_background_colors, 'bg');
        $borders = $this->getColors($model->line_border_colors, 'bd');

        $datasets = [];

        foreach ($this->getSeries($rows) as $index => $series) {
            $datasets[] = [
                'label' => $series['label'],
                'data' => $series['data'],
                'pointBackgroundColor' => [$backgrounds[$index] ?? null],
                'pointBorderColor' => [$borders[$index] ?? null],
                'pointBorderWidth' => (float) $model->line_point_border_width,
            ];
        }

        $options = $this->getOptions($model, $rows);

        $options['elements'] = [
            'line' => [
                'tension' => (float) $model->line_tension,
                'borderWidth' => (float) $model->line_border_width,
                'borderDash' => $this->getBorderDash($model->line_border_dash),
                'borderJoinStyle' => $model->line_border_joint_style,
                'borderColor' => $borders,
                'backgroundColor' => $backgrounds,
                'fill' => 'true' === $model->line_fill,
            ],
            'point' => [
                'radius' => (float) $model->line_point_radius,
                'pointStyle' => 'false' === $model->line_point_style ? false : $model->line_point_style,
                'backgroundColor' => [$this->getHexColor($model->line_point_background_color)],
                'borderWidth' => (float) $model->line_point_border_width,
                'borderColor' => [$this->getHexColor($model->line_point_border_color)],
            ],
        ];

        return [
            'type' => 'line',
            'data' => ['labels' => $this->getLabels($rows), 'datasets' => $datasets],
            'options' => $options,
        ];
    }

    /**
     * Pull the dash lengths out of the stored "[5, 3]" notation
     *
     * The field is free text, so read the numbers rather than trusting the
     * value to be valid JavaScript the way the old inline script did.
     */
    private function getBorderDash($value): array
    {
        preg_match_all('/\d+(?:\.\d+)?/', (string) $value, $matches);

        return array_map('floatval', $matches[0]);
    }

    /**
     * Normalise a stored colour, which may or may not already carry its hash
     */
    private function getHexColor($value): string
    {
        return '#' . ltrim((string) $value, '#');
    }
}
