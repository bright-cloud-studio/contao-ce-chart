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
		// Run the initial compile function just to be cool like that
        //parent::compile();
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
        
        if($rows != null) {
        
            // Assemble our label data as a string
            $labels = '';
            for ($x = 1; $x < count($rows[0]); $x++) {
                $labels .= '"'.$rows[0][$x].'"';
                if($x != count($rows[0])-1) { $labels .= ', '; }
            }
        
            // Assemble our datasets
            $datasets = array();
            foreach($rows as $index=>$row) {
                
                $datasets[$index]['label'] = $row[0];
                $datasets[$index]['data_string'] = '';
                
                for($x = 1; $x < count($row); $x++) {
    
                    $datasets[$index]['data'] .= '"' . $row[$x] . '"';
                    if($x != count($row)-1) { $datasets[$index]['data'] .= ', '; }
                    
                }
                
                $datasets[$index]['dataset'] = "
                {
                    label: '".$datasets[$index]['label']."',
                    data: [".$datasets[$index]['data']."],
                },
                ";
                
            }
            
            // Include Chart.js and our configuration script
            $GLOBALS['TL_JAVASCRIPT']['chart_cdn'] = 'https://cdn.jsdelivr.net/npm/chart.js';
    
            // Start our config script
            $config = '
                document.addEventListener("DOMContentLoaded", function () {
                    const ctx_'.$this->id.' = document.getElementById("chart_'.$this->id.'")
                    const line_chart__'.$this->id.' = new Chart(ctx_'.$this->id.', {
                        type: "bar",
                        data: {
                            labels: ['.$labels.'],
                            datasets: [';
    
            // Add in our datasets
            foreach($datasets as $index=>$dataset) {
                if($index > 0)
                    $config .= $dataset['dataset'];
            }
    
            // End our config script
            $config .=  '
                            ],
                        },
                        options: {';

            if($this->animate == 'yes') {

                $config .= '
                            responsive: '.$this->responsive.',
                            maintainAspectRatio: '.$this->maintain_aspect_ratio.',
                            transitions: {
                              show: {
                                animations: {
                                  x: {
                                    from: 0
                                  },
                                  y: {
                                    from: 0
                                  }
                                }
                              },
                              hide: {
                                animations: {
                                  x: {
                                    to: 0
                                  },
                                  y: {
                                    to: 0
                                  }
                                }
                              }
                            },
                ';
            }


            if('yes' == 'yes') {

                // Format background colors as datastring
                $bg_color_array = unserialize($this->bar_background_colors);
                $bg_colors = '';
                for($x = 0; $x < count($bg_color_array); $x++) {
                    
                    $bg_colors .= "'rgba(".$bg_color_array[$x]['b_bg_r'].", ".$bg_color_array[$x]['b_bg_g'].", ".$bg_color_array[$x]['b_bg_b'].", ".$bg_color_array[$x]['b_bg_a'].")'";
                    if($x != (count($bg_color_array) -1))
                        $bg_colors .= ', ';
                }
                
                // Format border colors as datastring
                $bd_color_array = unserialize($this->bar_border_colors);
                $bd_colors = '';
                for($x = 0; $x < count($bd_color_array); $x++) {
                    
                    $bd_colors .= "'rgba(".$bd_color_array[$x]['b_bd_r'].", ".$bd_color_array[$x]['b_bd_g'].", ".$bd_color_array[$x]['b_bd_b'].", ".$bd_color_array[$x]['b_bd_a'].")'";
                    if($x != (count($bd_color_array) -1))
                        $bd_colors .= ', ';
                }

                
                $config .= "
                            elements: {
                              bar: {
                                    backgroundColor: [".$bg_colors."],
                                    borderWidth: ".$this->bar_border_width.",
                                    borderColor: [".$bd_colors."],
                                    borderRadius: ".$this->bar_border_radius.",
                                    inflateAmount: ".$this->bar_inflate_amount.",
                                    pointStyle: '".$this->bar_point_style."',
                                    
                                    
                                }
                              },
                ";
            }

            $show_y = 'false';
            if($this->label_y != null) { $show_y = 'true'; }
            
            $show_x = 'false';
            if($this->label_x != null) { $show_x = 'true'; }
            
            $config .= '   scales: {
                                y: {
                                    beginAtZero: false,
                                    title: {
                                        display: '.$show_y.',
                                        text: "'.$this->label_y.'"
                                    }
                                },
                                x: {
                                    beginAtZero: false,
                                    title: {
                                        display: '.$show_x.',
                                        text: "'.$this->label_x.'"
                                    }
                                },
                            },
                            plugins: {
                              legend: {
                                position: "top",
                              },
                              title: {
                                display: true,
                                text: "'.$datasets[0]['label'].'"
                              }
                            }
                        },
                    });
                });
            ';
    
            // Add our config script to the bottom of the <body> tag
            $GLOBALS['TL_BODY'][] = '<script>' . $config . '</script>';
        }
        
	}
}

class_alias(ContentBarChart::class, 'ContentBarChart');
