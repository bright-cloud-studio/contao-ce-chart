<?php

    /**
    * @copyright  Bright Cliud Studio
    * @author     Bright Cloud Studio
    * @package    Contao CE Chart
    * @license    LGPL-3.0+
    * @see	       https://github.com/bright-cloud-studio/contao-ce-chart
    */
    
    array_insert($GLOBALS['TL_CTE']['datasets'], 10, array
    (
        'chart_line' => 'Bcs\ChartBundle\ContentLineChart',
        'chart_bar' => 'Bcs\ChartBundle\ContentBarChart'
    ));

?>
