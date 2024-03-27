<?php

/**
 * @copyright  Bright Cliud Studio
 * @author     Bright Cloud Studio
 * @package    Contao CE Chart
 * @license    LGPL-3.0+
 * @see	       https://github.com/bright-cloud-studio/contao-ce-chart
 */

// Get our default 'tl_content' DCA
$dc = &$GLOBALS['TL_DCA']['tl_content'];
$GLOBALS['TL_DCA']['tl_content']['palettes']['chart_line'] = '{type_legend},type,headline;{dataset_legend},tableitems,label_x,label_y,chart_desc;{chart_line_config_legend},animate,line_tension,line_border_width,line_border_dash,line_border_joint_style,line_fill;{line_border_colors_legend},line_border_colors;{line_background_colors_legend},line_background_colors;{line_point_legend},line_point_background_color,line_point_border_color,line_point_border_width,line_point_style,line_point_radius;{chart_options_legend},maintain_aspect_ratio,responsive,max_width,max_height;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['chart_bar'] = '{type_legend},type,headline;{dataset_legend},tableitems,label_x,label_y,chart_desc;{chart_bar_config_legend},bar_border_width,bar_border_skipped,bar_border_radius,bar_inflate_amount,bar_point_style;{bar_background_colors_legend},bar_background_colors;{bar_border_colors_legend},bar_border_colors;{chart_options_legend},maintain_aspect_ratio,responsive,max_width,max_height;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID;{invisible_legend:hide},invisible,start,stop';

$arrFields = array(
    'label_x'             => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_content']['label_x'],
        'inputType'                => 'text',
		'eval'                     => array('tl_class'=>'w50'),
		'sql'                      => "mediumtext NULL"
    ),
    'label_y'             => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_content']['label_y'],
        'inputType'                => 'text',
		'eval'                     => array('tl_class'=>'w50'),
		'sql'                      => "mediumtext NULL"
    ),
    'chart_desc'             => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_content']['chart_desc'],
        'inputType'                => 'textarea',
		'eval'                     => array('tl_class'=>'clr', 'rte'=>'tinyMCE'),
		'sql'                      => "mediumtext NULL"
    ),
    'animate'                  => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_content']['animate'],
        'inputType'                => 'select',
		'options'                  => array('yes' => 'Yes', 'no' => 'No'),
		'eval'                     => array('mandatory'=>true, 'tl_class'=>'w50'),
		'sql'                      => "varchar(32) NOT NULL default 'yes'"
    ),
    'line_tension'             => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_content']['line_tension'],
        'inputType'                => 'text',
		'eval'                     => array('tl_class'=>'w50'),
		'sql'                      => "varchar(12) NOT NULL default '0'"
    ),
    'line_border_width'        => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_content']['line_border_width'],
        'inputType'                => 'text',
		'eval'                     => array('tl_class'=>'w50'),
		'sql'                      => "varchar(12) NOT NULL default '3'"
    ),
    'line_border_dash'         => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_content']['line_border_dash'],
        'inputType'                => 'text',
		'eval'                     => array('tl_class'=>'w50'),
		'sql'                      => "varchar(255) NOT NULL default '[0, 0]'"
    ),
    'line_border_joint_style'  => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_content']['line_border_joint_style'],
        'inputType'                => 'select',
		'options'                  => array('round' => 'Round', 'bevel' => 'Bevel', 'miter' => 'Miter'),
		'eval'                     => array('mandatory'=>true, 'tl_class'=>'w50'),
		'sql'                      => "varchar(32) NOT NULL default 'round'"
    ),
    'line_fill'                => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_content']['line_fill'],
        'inputType'                => 'select',
		'options'                  => array('false' => 'False', 'true' => 'True'),
		'eval'                     => array('mandatory'=>true, 'tl_class'=>'w50'),
		'sql'                      => "varchar(32) NOT NULL default 'false'"
    ),


    'bar_border_width'        => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_content']['bar_border_width'],
        'inputType'                => 'text',
		'eval'                     => array('tl_class'=>'w50'),
		'sql'                      => "varchar(12) NOT NULL default '0'"
    ),
    'bar_border_skipped'                => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_content']['bar_border_skipped'],
        'inputType'                => 'select',
		'options'                  => array('start' => 'Start', 'end' => 'End', 'middle' => 'Middle', 'bottom' => 'Bottom', 'left' => 'Left', 'top' => 'Top', 'right' => 'Right', 'false' => 'False'),
		'eval'                     => array('mandatory'=>true, 'tl_class'=>'w50'),
		'sql'                      => "varchar(32) NOT NULL default 'start'"
    ),
    'bar_border_radius'        => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_content']['bar_border_radius'],
        'inputType'                => 'text',
		'eval'                     => array('tl_class'=>'w50'),
		'sql'                      => "varchar(12) NOT NULL default '0'"
    ),
    'bar_inflate_amount'        => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_content']['bar_inflate_amount'],
        'inputType'                => 'text',
		'eval'                     => array('tl_class'=>'w50'),
		'sql'                      => "varchar(12) NOT NULL default 'auto'"
    ),
    'bar_point_style'           => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_content']['bar_point_style'],
        'inputType'                => 'select',
		'options'                  => array('circle' => 'Circle', 'cross' => 'Cross', 'crossRot' => 'Cross Rot', 'dash' => 'Dash', 'line' => 'Line', 'rect' => 'Rect', 'rectRounded' => 'Rect Rounded', 'rectRot' => 'Rect Rot', 'star' => 'Star', 'triangle' => 'Triangle', 'false' => 'False'),
		'eval'                     => array('mandatory'=>true, 'tl_class'=>'w50'),
		'sql'                      => "varchar(32) NOT NULL default 'circle'"
    ),


    'line_point_radius'         => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_content']['line_point_radius'],
        'inputType'                => 'text',
		'eval'                     => array('tl_class'=>'w50'),
		'sql'                      => "varchar(12) NOT NULL default '0'"
    ),
    'line_point_style'           => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_content']['line_point_style'],
        'inputType'                => 'select',
		'options'                  => array('circle' => 'Circle', 'cross' => 'Cross', 'crossRot' => 'Cross Rot', 'dash' => 'Dash', 'line' => 'Line', 'rect' => 'Rect', 'rectRounded' => 'Rect Rounded', 'rectRot' => 'Rect Rot', 'star' => 'Star', 'triangle' => 'Triangle', 'false' => 'False'),
		'eval'                     => array('mandatory'=>true, 'tl_class'=>'w50'),
		'sql'                      => "varchar(32) NOT NULL default 'circle'"
    ),
    'line_point_background_color'         => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_content']['line_point_background_color'],
        'inputType'                => 'text',
		'eval'                     => array('tl_class'=>'w50'),
		'sql'                      => "varchar(12) NOT NULL default '#000000'"
    ),
    'line_point_border_width'         => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_content']['line_point_border_width'],
        'inputType'                => 'text',
		'eval'                     => array('tl_class'=>'w50'),
		'sql'                      => "varchar(12) NOT NULL default '2'"
    ),
    'line_point_border_color'         => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_content']['line_point_border_color'],
        'inputType'                => 'text',
		'eval'                     => array('tl_class'=>'w50'),
		'sql'                      => "varchar(12) NOT NULL default '#000000'"
    ),



    'line_background_colors'       => array(
        'label'     => &$GLOBALS['TL_LANG']['tl_content']['line_background_colors'],
        'exclude'   => true,
        'inputType' => 'multiColumnWizard',
        'eval'      => [
            'columnFields' => [
                'bg_r' => [
                    'label'     => &$GLOBALS['TL_LANG']['tl_content']['bg_r'],
                    'exclude'   => true,
                    'inputType' => 'text',
                ],
                'bg_g' => [
                    'label'     => &$GLOBALS['TL_LANG']['tl_content']['bg_b'],
                    'exclude'   => true,
                    'inputType' => 'text',
                ],
                'bg_b' => [
                    'label'     => &$GLOBALS['TL_LANG']['tl_content']['bg_b'],
                    'exclude'   => true,
                    'inputType' => 'text',
                ],
                'bg_a' => [
                    'label'     => &$GLOBALS['TL_LANG']['tl_content']['bg_a'],
                    'exclude'   => true,
                    'inputType' => 'text',
                ],
            ],
        ],
        'sql'       => 'blob NULL',
    ),
    'line_border_colors'       => array(
        'label'     => &$GLOBALS['TL_LANG']['tl_content']['line_border_colors'],
        'exclude'   => true,
        'inputType' => 'multiColumnWizard',
        'eval'      => [
            'columnFields' => [
                'bd_r' => [
                    'label'     => &$GLOBALS['TL_LANG']['tl_content']['bg_r'],
                    'exclude'   => true,
                    'inputType' => 'text',
                ],
                'bd_g' => [
                    'label'     => &$GLOBALS['TL_LANG']['tl_content']['bg_b'],
                    'exclude'   => true,
                    'inputType' => 'text',
                ],
                'bd_b' => [
                    'label'     => &$GLOBALS['TL_LANG']['tl_content']['bg_b'],
                    'exclude'   => true,
                    'inputType' => 'text',
                ],
                'bd_a' => [
                    'label'     => &$GLOBALS['TL_LANG']['tl_content']['bg_a'],
                    'exclude'   => true,
                    'inputType' => 'text',
                ],
            ],
        ],
        'sql'       => 'blob NULL',
    ),


    
    'bar_background_colors'       => array(
        'label'     => &$GLOBALS['TL_LANG']['tl_content']['bar_background_colors'],
        'exclude'   => true,
        'inputType' => 'multiColumnWizard',
        'eval'      => [
            'columnFields' => [
                'b_bg_r' => [
                    'label'     => &$GLOBALS['TL_LANG']['tl_content']['b_bg_r'],
                    'exclude'   => true,
                    'inputType' => 'text',
                ],
                'b_bg_g' => [
                    'label'     => &$GLOBALS['TL_LANG']['tl_content']['b_bg_g'],
                    'exclude'   => true,
                    'inputType' => 'text',
                ],
                'b_bg_b' => [
                    'label'     => &$GLOBALS['TL_LANG']['tl_content']['b_bg_b'],
                    'exclude'   => true,
                    'inputType' => 'text',
                ],
                'b_bg_a' => [
                    'label'     => &$GLOBALS['TL_LANG']['tl_content']['b_bg_a'],
                    'exclude'   => true,
                    'inputType' => 'text',
                ],
            ],
        ],
        'sql'       => 'blob NULL',
    ),
    'bar_border_colors'       => array(
        'label'     => &$GLOBALS['TL_LANG']['tl_content']['bar_border_colors'],
        'exclude'   => true,
        'inputType' => 'multiColumnWizard',
        'eval'      => [
            'columnFields' => [
                'b_bd_r' => [
                    'label'     => &$GLOBALS['TL_LANG']['tl_content']['b_bd_r'],
                    'exclude'   => true,
                    'inputType' => 'text',
                ],
                'b_bd_g' => [
                    'label'     => &$GLOBALS['TL_LANG']['tl_content']['b_bd_g'],
                    'exclude'   => true,
                    'inputType' => 'text',
                ],
                'b_bd_b' => [
                    'label'     => &$GLOBALS['TL_LANG']['tl_content']['b_bd_b'],
                    'exclude'   => true,
                    'inputType' => 'text',
                ],
                'b_bd_a' => [
                    'label'     => &$GLOBALS['TL_LANG']['tl_content']['b_bd_a'],
                    'exclude'   => true,
                    'inputType' => 'text',
                ],
            ],
        ],
        'sql'       => 'blob NULL',
    ),

    
    'responsive'             => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_content']['responsive'],
        'inputType'                => 'select',
		'options'                  => array('true' => 'True', 'false' => 'False'),
		'eval'                     => array('mandatory'=>true, 'tl_class'=>'w50'),
		'sql'                      => "varchar(32) NOT NULL default 'true'"
    ),
    'maintain_aspect_ratio'             => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_content']['maintain_aspect_ratio'],
        'inputType'                => 'select',
		'options'                  => array('true' => 'True', 'false' => 'False'),
		'eval'                     => array('mandatory'=>true, 'tl_class'=>'w50'),
		'sql'                      => "varchar(32) NOT NULL default 'true'"
    ),
    'max_width'             => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_content']['max_width'],
        'inputType'                => 'text',
		'eval'                     => array('tl_class'=>'w50'),
		'sql'                      => "mediumtext NULL"
    ),
    'max_height'             => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_content']['max_height'],
        'inputType'                => 'text',
		'eval'                     => array('tl_class'=>'w50'),
		'sql'                      => "mediumtext NULL"
    ),



    
);

$dc['fields'] = array_merge($dc['fields'], $arrFields);
