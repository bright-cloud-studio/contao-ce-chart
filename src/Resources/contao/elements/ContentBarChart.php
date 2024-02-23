<?php

/**
 * @copyright  Bright Cliud Studio
 * @author     Bright Cloud Studio
 * @package    Contao CE Chart
 * @license    LGPL-3.0+
 * @see	       https://github.com/bright-cloud-studio/contao-ce-chart
 */

namespace Bcs\ChartBundle;

use Contao\ContentTable;

class ContentBarChart extends ContentTable
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'ce_chart_bar';


	/**
	 * Generate the content element
	 */
	public function compile()
	{
		parent::compile();
	}

    /**
	 * Initialize the object
	 *
	 * @param ContentModel $objElement
	 * @param string       $strColumn
	 */
	public function __construct($objElement, $strColumn='main')
	{
        // Run the originally construct function, if there is one
        parent::__construct($objElement, $strColumn='main');

        // Link script files in the <header>
        $GLOBALS['TL_JAVASCRIPT']['chart_cdn'] = 'https://cdn.jsdelivr.net/npm/chart.js';
        $GLOBALS['TL_JAVASCRIPT']['chart_script'] = 'bundles/bcschart/scripts/contao_ce_chart.js';

        // Inline script in the <header>
        //$GLOBALS['TL_HEAD']['chart_injection'] = '<script>alert("ding");</script>';

        // Inline script in the <body> at the bottom
        //$GLOBALS['TL_BODY']['chart_injection'] = '<script>alert("bing bong noise");</script>';
	}
}

class_alias(ContentBarChart::class, 'ContentBarChart');
