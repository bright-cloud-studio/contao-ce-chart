<?php

/**
 * @copyright  Bright Cloud Studio
 * @author     Bright Cloud Studio
 * @package    Contao CE Chart
 * @license    MIT
 * @see        https://github.com/bright-cloud-studio/contao-ce-chart
 */

namespace Bcs\ChartBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class BcsChartBundle extends Bundle
{
    /**
     * Point the bundle at the package root so contao/ and public/ are found
     * next to src/ rather than inside it. config/services.yaml is loaded by
     * DependencyInjection\BcsChartExtension instead.
     */
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
