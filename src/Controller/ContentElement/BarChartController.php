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
use Contao\StringUtil;

#[AsContentElement(type: 'chart_bar', category: 'datasets', template: 'content_element/chart_bar')]
class BarChartController extends AbstractChartController
{
    /**
     * Assemble the Chart.js bar configuration
     *
     * Every bar shares one styling block, so the colour wizards feed the
     * elements option directly rather than being split across the datasets.
     * A gradient can't be expressed as JSON, so its two colours are handed to
     * the bcsGradient plugin in chart-init.js, which paints each bar.
     */
    protected function getConfig(ContentModel $model, array $rows): array
    {
        $options = $this->getOptions($model, $rows);
        $backgrounds = $this->getColors($model->bar_background_colors, 'b_bg');

        if ($model->bar_horizontal) {
            $options['indexAxis'] = 'y';
        }

        if ($model->bar_gradient) {
            $options['plugins']['bcsGradient'] = [
                'from' => $backgrounds[0] ?? null,
                'to' => $backgrounds[1] ?? $backgrounds[0] ?? null,
            ];
        }

        $labels = $this->getLabels($rows);

        // Two-line labels: capitals, broken before the last word, which the
        // bcsSplitLabels plugin in chart-init.js draws in bold
        if ($model->bar_split_labels) {
            $labels = array_map(
                static function ($label): array {
                    $label = mb_strtoupper(StringUtil::decodeEntities((string) $label));
                    $break = strrpos($label, ' ');

                    return false === $break ? [$label] : [substr($label, 0, $break), substr($label, $break + 1)];
                },
                $labels
            );

            $options['plugins']['bcsSplitLabels'] = ['axis' => $model->bar_horizontal ? 'y' : 'x'];
        }

        $options['elements'] = [
            'bar' => [
                'backgroundColor' => $backgrounds,
                'borderWidth' => (float) $model->bar_border_width,
                'borderColor' => $this->getColors($model->bar_border_colors, 'b_bd'),
                'borderRadius' => (float) $model->bar_border_radius,
                'borderSkipped' => 'false' === $model->bar_border_skipped ? false : $model->bar_border_skipped,
                'inflateAmount' => 'auto' === $model->bar_inflate_amount ? 'auto' : (float) $model->bar_inflate_amount,
                'pointStyle' => 'false' === $model->bar_point_style ? false : $model->bar_point_style,
            ],
        ];

        return [
            'type' => 'bar',
            'data' => ['labels' => $labels, 'datasets' => $this->getSeries($rows)],
            'options' => $options,
        ];
    }
}
