<?php

/**
 * @copyright  Bright Cloud Studio
 * @author     Bright Cloud Studio
 * @package    Contao CE Chart
 * @license    MIT
 * @see        https://github.com/bright-cloud-studio/contao-ce-chart
 */

/* Legends */
$GLOBALS['TL_LANG']['tl_content']['dataset_legend']                 = 'Dataset Details';
$GLOBALS['TL_LANG']['tl_content']['chart_line_config_legend']       = 'Chart - Line Configuration';
$GLOBALS['TL_LANG']['tl_content']['chart_bar_config_legend']        = 'Chart - Bar Configuration';
$GLOBALS['TL_LANG']['tl_content']['line_border_colors_legend']      = 'Chart - Line Border Colors';
$GLOBALS['TL_LANG']['tl_content']['line_background_colors_legend']  = 'Chart - Line Background Colors';
$GLOBALS['TL_LANG']['tl_content']['line_point_legend']              = 'Chart - Point Settings';
$GLOBALS['TL_LANG']['tl_content']['bar_background_colors_legend']   = 'Chart - Bar Background Colors';
$GLOBALS['TL_LANG']['tl_content']['bar_border_colors_legend']       = 'Chart - Bar Border Colors';
$GLOBALS['TL_LANG']['tl_content']['chart_options_legend']           = 'Chart - Options';

/* Dataset fields */
$GLOBALS['TL_LANG']['tl_content']['label_x']                        = array('X-Axis Label', 'Enter the label to show on the x-axis');
$GLOBALS['TL_LANG']['tl_content']['label_y']                        = array('Y-Axis Label', 'Enter the label to show on the y-axis');
$GLOBALS['TL_LANG']['tl_content']['chart_desc']                     = array('Chart Description', 'Enter a description that will be shown alongside this chart');

/* Line fields */
$GLOBALS['TL_LANG']['tl_content']['animate']                        = array('Show/Hide Animation', 'Choose if the lines should animate when showing or hiding');
$GLOBALS['TL_LANG']['tl_content']['line_tension']                   = array('Line Tension', 'Lower tension makes lines rigid, higher makes them smoother');
$GLOBALS['TL_LANG']['tl_content']['line_border_width']              = array('Line Stroke Width', 'Changes the thickness of the line stroke');
$GLOBALS['TL_LANG']['tl_content']['line_border_dash']               = array('Line Border Dash', 'First number is the width of the dash, second number is the space between the dashes');
$GLOBALS['TL_LANG']['tl_content']['line_border_joint_style']        = array('Line Stroke Joint Style', 'Choose from different styles for the joint styles');
$GLOBALS['TL_LANG']['tl_content']['line_fill']                      = array('Line Fill', 'Choose if the lines should fill the background to the bottom of the chart');

/* Bar fields */
$GLOBALS['TL_LANG']['tl_content']['bar_border_width']               = array('Bar Stroke Width', 'The thickness of the bar stroke');
$GLOBALS['TL_LANG']['tl_content']['bar_border_skipped']             = array('Bar Stroke Skipped', 'Choose which edge of the bar leaves its stroke off');
$GLOBALS['TL_LANG']['tl_content']['bar_border_radius']              = array('Bar Stroke Radius', 'Enter the bar radius');
$GLOBALS['TL_LANG']['tl_content']['bar_inflate_amount']             = array('Bar Inflate Amount', 'Enter how much the bars should inflate, or "auto"');
$GLOBALS['TL_LANG']['tl_content']['bar_point_style']                = array('Point Style', 'Select the point style for the bar, or if there should be none at all');

/* Line point fields */
$GLOBALS['TL_LANG']['tl_content']['line_point_radius']              = array('Point Radius', 'Enter the radius value for the line points');
$GLOBALS['TL_LANG']['tl_content']['line_point_style']               = array('Point Style', 'Select the style the line points should use');
$GLOBALS['TL_LANG']['tl_content']['line_point_background_color']    = array('Point Background Color', 'Enter an HTML color for the point background');
$GLOBALS['TL_LANG']['tl_content']['line_point_border_width']        = array('Point Border Width', 'Enter the point border width');
$GLOBALS['TL_LANG']['tl_content']['line_point_border_color']        = array('Point Border Color', 'Enter an HTML color for the point border color');

/* Line colors */
$GLOBALS['TL_LANG']['tl_content']['line_background_colors']         = array('Line Background Colors', 'Enter the RGBA values for the individual line background colors');
$GLOBALS['TL_LANG']['tl_content']['bg_r']                           = array('Red', 'Red Value');
$GLOBALS['TL_LANG']['tl_content']['bg_g']                           = array('Green', 'Green Value');
$GLOBALS['TL_LANG']['tl_content']['bg_b']                           = array('Blue', 'Blue Value');
$GLOBALS['TL_LANG']['tl_content']['bg_a']                           = array('Alpha', 'Alpha Value');

$GLOBALS['TL_LANG']['tl_content']['line_border_colors']             = array('Line Border Colors', 'Enter the RGBA values for the individual line border colors');
$GLOBALS['TL_LANG']['tl_content']['bd_r']                           = array('Red', 'Red Value');
$GLOBALS['TL_LANG']['tl_content']['bd_g']                           = array('Green', 'Green Value');
$GLOBALS['TL_LANG']['tl_content']['bd_b']                           = array('Blue', 'Blue Value');
$GLOBALS['TL_LANG']['tl_content']['bd_a']                           = array('Alpha', 'Alpha Value');

/* Bar colors */
$GLOBALS['TL_LANG']['tl_content']['bar_background_colors']          = array('Bar Background Colors', 'Enter the RGBA values for the individual bar background colors');
$GLOBALS['TL_LANG']['tl_content']['b_bg_r']                         = array('Red', 'Red Value');
$GLOBALS['TL_LANG']['tl_content']['b_bg_g']                         = array('Green', 'Green Value');
$GLOBALS['TL_LANG']['tl_content']['b_bg_b']                         = array('Blue', 'Blue Value');
$GLOBALS['TL_LANG']['tl_content']['b_bg_a']                         = array('Alpha', 'Alpha Value');

$GLOBALS['TL_LANG']['tl_content']['bar_border_colors']              = array('Bar Border Colors', 'Enter the RGBA values for the individual bar border colors');
$GLOBALS['TL_LANG']['tl_content']['b_bd_r']                         = array('Red', 'Red Value');
$GLOBALS['TL_LANG']['tl_content']['b_bd_g']                         = array('Green', 'Green Value');
$GLOBALS['TL_LANG']['tl_content']['b_bd_b']                         = array('Blue', 'Blue Value');
$GLOBALS['TL_LANG']['tl_content']['b_bd_a']                         = array('Alpha', 'Alpha Value');

/* Chart options */
$GLOBALS['TL_LANG']['tl_content']['responsive']                     = array('Responsive', 'Select if this chart should be responsive or not');
$GLOBALS['TL_LANG']['tl_content']['maintain_aspect_ratio']          = array('Maintain Aspect Ratio', 'Select if this chart should try and maintain the initial aspect ratio');
$GLOBALS['TL_LANG']['tl_content']['max_width']                      = array('Maximum Width', 'Enter this chart\'s maximum width ("1000px", "20vh", "50%", etc)');
$GLOBALS['TL_LANG']['tl_content']['max_height']                     = array('Maximum Height', 'Enter this chart\'s maximum height ("1000px", "20vh", "50%", etc)');
