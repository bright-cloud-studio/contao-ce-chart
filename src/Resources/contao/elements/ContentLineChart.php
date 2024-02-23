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
		//$rows = \StringUtil::deserialize($this->tableitems, true);
		
		//echo "<pre>";
		//print_r($rows);
		//echo "</pre>";
		//die();
	}

    /**
	 * Initialize the object
	 *
	 * @param ContentModel $objElement
	 * @param string       $strColumn
	 */
	public function __construct($objElement, $strColumn='main')
	{
	    // Run the original construct function
        parent::__construct($objElement, $strColumn='main');
        
        
        // Assemble our table data into usable formats
        $rows = \StringUtil::deserialize($this->tableitems, true);
		
		//echo "<pre>";
		//print_r($rows);
		//echo "</pre>";
		//die();
        
        
        // Include Chart.js and our configuration script
        $GLOBALS['TL_JAVASCRIPT']['chart_cdn'] = 'https://cdn.jsdelivr.net/npm/chart.js';
        //$GLOBALS['TL_JAVASCRIPT']['chart_script'] = 'bundles/bcschart/scripts/contao_ce_chart.js';
        
        
        
        
        
        
        
        $config = '
            document.addEventListener("DOMContentLoaded", function () {

                const ctx_'.$this->id.' = document.getElementById("chart_'.$this->id.'")
            
                const line_chart__'.$this->id.' = new Chart(ctx_'.$this->id.', {
                    type: "line",
                    data: {
                        labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
                        datasets: [
                            {
                                label: "# of Votes",
                                data: [, 19, 3, 5, 2, 3],
                                backgroundColor: [
                                    "rgba(255, 99, 132, 0.2)",
                                    "rgba(54, 162, 235, 0.2)",
                                    "rgba(255, 206, 86, 0.2)",
                                    "rgba(75, 192, 192, 0.2)",
                                    "rgba(153, 102, 255, 0.2)",
                                    "rgba(255, 159, 64, 0.2)",
                                ],
                                borderColor: [
                                    "rgba(255, 99, 132, 1)",
                                    "rgba(54, 162, 235, 1)",
                                    "rgba(255, 206, 86, 1)",
                                    "rgba(75, 192, 192, 1)",
                                    "rgba(153, 102, 255, 1)",
                                    "rgba(255, 159, 64, 1)",
                                ],
                                borderWidth: 1,
                            },
                        ],
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                            },
                        },
                    },
                });
            });
        ';

        $GLOBALS['TL_BODY'][] = '<script>' . $config . '</script>';
        
        
        
        
        
        
        
        
        
        
	}   
}

class_alias(ContentLineChart::class, 'ContentLineChart');
