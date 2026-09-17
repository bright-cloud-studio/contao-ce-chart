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

#[AsContentElement(type: 'chart_bar', category: 'datasets', template: 'content_element/chart_bar')]
class BarChartController extends AbstractChartController
{
    /**
     * Assemble the Chart.js bar configuration
     *
     * Every bar shares one styling block, so the colour wizards feed the
     * elements option directly rather than being split across the datasets.
     */
    protected function getConfig(ContentModel $model, array $rows): array
    {
        $options = $this->getOptions($model, $rows);

        $options['elements'] = [
            'bar' => [
                'backgroundColor' => $this->getColors($model->bar_background_colors, 'b_bg'),
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
            'data' => ['labels' => $this->getLabels($rows), 'datasets' => $this->getSeries($rows)],
            'options' => $options,
        ];
    }
}
