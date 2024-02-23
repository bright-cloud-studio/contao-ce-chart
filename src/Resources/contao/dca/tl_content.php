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
$GLOBALS['TL_DCA']['tl_content']['palettes']['chart_line'] = '{type_legend},type,headline;{dataset_legend},tableitems;{chart_line_config_legend},animate,line_tension,line_border_color,line_border_width,line_border_dash,line_border_joint_style,line_background_color,line_fill;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['chart_bar'] = '{type_legend},type,headline;{dataset_legend},tableitems;{chart_line_config_legend},animate;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID;{invisible_legend:hide},invisible,start,stop';

$arrFields = array(
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
    'line_border_color'        => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_content']['line_border_color'],
        'inputType'                => 'text',
		'eval'                     => array('tl_class'=>'w50'),
		'sql'                      => "varchar(12) NOT NULL default '#ff00ff'"
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
		'sql'                      => "varchar(12) NOT NULL default '[0, 0]'"
    ),
    'line_border_joint_style'  => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_content']['line_border_joint_style'],
        'inputType'                => 'select',
		'options'                  => array('round' => 'Round', 'bevel' => 'Bevel', 'miter' => 'Miter'),
		'eval'                     => array('mandatory'=>true, 'tl_class'=>'w50'),
		'sql'                      => "varchar(32) NOT NULL default 'round'"
    ),
    'line_background_color'    => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_content']['line_background_color'],
        'inputType'                => 'text',
		'eval'                     => array('tl_class'=>'w50'),
		'sql'                      => "varchar(12) NOT NULL default '#ff00ff'"
    ),
    'line_fill'                => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_content']['line_fill'],
        'inputType'                => 'select',
		'options'                  => array('false' => 'False', 'true' => 'True'),
		'eval'                     => array('mandatory'=>true, 'tl_class'=>'w50'),
		'sql'                      => "varchar(32) NOT NULL default 'false'"
    ),
);

$dc['fields'] = array_merge($dc['fields'], $arrFields);
