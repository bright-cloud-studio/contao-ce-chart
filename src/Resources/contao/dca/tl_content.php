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
$GLOBALS['TL_DCA']['tl_content']['palettes']['chart_bar'] = '{type_legend},type,headline;{dataset_legend},tableitems;{dataset_config_legend},summary;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID;{invisible_legend:hide},invisible,start,stop';
$GLOBALS['TL_DCA']['tl_content']['palettes']['chart_line'] = '{type_legend},type,headline;{dataset_legend},tableitems;{dataset_config_legend},summary;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},guests,cssID;{invisible_legend:hide},invisible,start,stop';

$arrFields = array(
    'glide_type'                => array(
        'label'                    => &$GLOBALS['TL_LANG']['tl_content']['glide_type'],
        'inputType'                => 'select',
		'options'                  => array('slider' => 'Slider', 'carousel' => 'Carousel'),
		'eval'                     => array('mandatory'=>true, 'tl_class'=>'w50'),
		'sql'                      => "varchar(32) NOT NULL default 'slider'"
    ),
);

//$dc['fields'] = array_merge($dc['fields'], $arrFields);
