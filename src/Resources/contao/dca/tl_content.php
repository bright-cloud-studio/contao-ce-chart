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
$GLOBALS['TL_DCA']['tl_content']['palettes']['chart'] = '{type_legend},type,headline;{text_legend},text,buttonLink;{image_legend},addImage;{template_legend:hide},customTpl;{protected_legend:hide},protected;{expert_legend:hide},cssID;{invisible_legend:hide},invisible,start,stop';
