<?php

/**
 * @copyright  Bright Cliud Studio
 * @author     Bright Cloud Studio
 * @package    Contao CE Chart
 * @license    LGPL-3.0+
 * @see	       https://github.com/bright-cloud-studio/contao-ce-chart
 */

namespace Bcs\ChartBundle;

class ContentChart extends \ContentText
{

	/**
	 * Template
	 * @var string
	 */
	protected $strTemplate = 'ce_chart';


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
        $GLOBALS['TL_JAVASCRIPT'][] = 'https://cdn.jsdelivr.net/npm/chart.js';
        $GLOBALS['TL_JAVASCRIPT'][] = 'bundles/bcschart/scripts/contao_ce_chart.js';
	}


    
}
