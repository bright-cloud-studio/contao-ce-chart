<?php

/**
 * @copyright  Bright Cliud Studio
 * @author     Bright Cloud Studio
 * @package    Contao CE Chart
 * @license    LGPL-3.0+
 * @see	       https://github.com/bright-cloud-studio/contao-ce-chart
 */

use Contao;
namespace Bcs\ChartBundle;

class ContentLineChart extends ContentTable
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'ce_chart_line';


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
        parent::__construct($objElement, $strColumn='main');
        $GLOBALS['TL_JAVASCRIPT']['chart_cdn'] = 'https://cdn.jsdelivr.net/npm/chart.js';
        $GLOBALS['TL_JAVASCRIPT']['chart_script'] = 'bundles/bcschart/scripts/contao_ce_chart.js';
	}   
}

class_alias(ContentLineChart::class, 'ContentLineChart');
