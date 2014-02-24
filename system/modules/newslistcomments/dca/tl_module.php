<?php

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2013 Leo Feyer
 * 
 * PHP version 5
 * @copyright  Tim Gatzky 2012
 * @author     Tim Gatzky <info@tim-gatzky.de>
 * @package    newslistcomments
 */

if(!in_array('comments', \Config::getInstance()->getActiveModules()))
{
	return;
}

/**
 * Selectors
 */
array_insert($GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'],1,array
(
	'addNewslistComments',
	'newslist_comments_messagebox',
	'newslist_comments_avatar',
	'newslist_comments_nested',
));


/**
 * Subpalettes
 */ 
array_insert($GLOBALS['TL_DCA']['tl_module']['subpalettes'],1,array
(
	'addNewslistComments'			=> 'newslist_comments_limit,newslist_comments_maxLimit,newslist_comments_aliveTime,newslist_comments_annonymus,newslist_comments_dateFormat,newslist_comments_timeFormat,newslist_comments_sortBy,newslist_comments_template,newslist_comments_alwaysShowDelete,newslist_comments_allowAll,newslist_comments_nested,newslist_comments_messagebox,newslist_comments_avatar',
	'newslist_comments_messagebox' 	=> 'newslist_comments_messagebox_template',
	'newslist_comments_avatar'		=> 'newslist_comments_jumpTo,newslist_comments_avatarSize,newslist_comments_singleSRC',
	'newslist_comments_nested'		=> 'newslist_comments_stoplevel'
));


/**
 * Add palettes to tl_module
 */
// Newsreader
$GLOBALS['TL_DCA']['tl_module']['palettes']['newslist'] = str_replace
(
	'{protected_legend:hide}',
	'{newslistcomments_legend:hide},addNewslistComments;{protected_legend:hide}',
	$GLOBALS['TL_DCA']['tl_module']['palettes']['newslist']	
);

	
/**
 * Add fields to tl_module
 */

$GLOBALS['TL_DCA']['tl_module']['fields']['addNewslistComments'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['addNewslistComments'],
	'exclude'           => true,
	'inputType'         => 'checkbox',
	'eval'              => array('submitOnChange'=>true, 'tl_class'=>'clr'),
	'sql'				=> "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['newslist_comments_limit'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['newslist_comments_limit'],
	'exclude'           => true,
	'inputType'         => 'text',
	'eval'              => array('rgxp'=>'digit', 'tl_class'=>'w50'),
	'sql'				=> "int(10) NOT NULL default '3'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['newslist_comments_maxLimit'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['newslist_comments_maxLimit'],
	'exclude'           => true,
	'inputType'         => 'text',
	'eval'              => array('rgxp'=>'digit', 'tl_class'=>'w50'),
	'sql'				=> "int(10) NOT NULL default '0'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['newslist_comments_aliveTime'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['newslist_comments_aliveTime'],
	'exclude'           => true,
	'inputType'         => 'text',
	'eval'              => array('rgxp'=>'digit', 'tl_class'=>'w50'),
	'sql'				=> "int(10) NOT NULL default '15'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['newslist_comments_annonymus'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['newslist_comments_annonymus'],
	'default'			=> 'Unbekannt',
	'exclude'           => true,
	'inputType'         => 'text',
	'eval'              => array('tl_class'=>'w50'),
	'sql'				=> "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['newslist_comments_alwaysShowDelete'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['newslist_comments_alwaysShowDelete'],
	'exclude'           => true,
	'inputType'         => 'checkbox',
	'eval'              => array('tl_class'=>'clr'),
	'sql'				=> "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['newslist_comments_allowAll'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['newslist_comments_allowAll'],
	'exclude'           => true,
	'inputType'         => 'checkbox',
	'eval'              => array('tl_class'=>'clr'),
	'sql'				=> "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['newslist_comments_messagebox'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['newslist_comments_messagebox'],
	'exclude'           => true,
	'inputType'         => 'checkbox',
	'eval'              => array('submitOnChange'=>true, 'tl_class'=>'clr'),
	'sql'				=> "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['newslist_comments_messagebox_template'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['newslist_comments_messagebox_template'],
	'exclude'           => true,
	'default'           => 'form_messagebox',
	'inputType'         => 'select',
	'options'           => $this->getTemplateGroup('form_messagebox'),
	'eval'              => array('tl_class'=>'clr'),
	'sql'				=> "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['newslist_comments_dateFormat'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['newslist_comments_dateFormat'],
	'default'			=> $GLOBALS['TL_CONFIG']['datimFormat'],
	'exclude'           => true,
	'inputType'         => 'text',
	'eval'              => array('tl_class'=>'w50'),
	'sql'				=> "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['newslist_comments_timeFormat'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['newslist_comments_timeFormat'],
	'default'			=> $GLOBALS['TL_CONFIG']['timeFormat'],
	'exclude'           => true,
	'inputType'         => 'text',
	'eval'              => array('tl_class'=>'w50'),
	'sql'				=> "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['newslist_comments_sortBy'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['newslist_comments_sortBy'],
	'inputType' 		=> 'select',
	'default'   		=> 'DESC',
	'options'			=> array('DESC', 'ASC'),
	'reference' 		=> &$GLOBALS['TL_LANG']['tl_module']['newslist_comments_sortBy'],
	'eval'				=> array('tl_class'=>'w50'),
	'sql'				=> "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['newslist_comments_avatar'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['newslist_comments_avatar'],
	'exclude'           => true,
	'inputType'         => 'checkbox',
	'eval'              => array('submitOnChange'=>true, 'tl_class'=>'clr'),
	'sql'				=> "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['newslist_comments_avatarSize'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_content']['size'],
	'exclude'			=> true,
	'inputType'			=> 'imageSize',
	'options'			=> $GLOBALS['TL_CROP'],
	'reference'			=> &$GLOBALS['TL_LANG']['MSC'],
	'eval'				=> array('rgxp'=>'digit', 'nospace'=>true, 'helpwizard'=>true, 'tl_class'=>'w50'),
	'sql'				=> "varchar(255) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['newslist_comments_template'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['newslist_comments_template'],
	'exclude'           => true,
	'default'           => 'newslist_comments',
	'inputType'         => 'select',
	'options'           => $this->getTemplateGroup('newslist'),
	'eval'              => array('tl_class'=>'clr'),
	'sql'				=> "varchar(64) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['newslist_comments_nested'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['newslist_comments_nested'],
	'exclude'           => true,
	'inputType'         => 'checkbox',
	'eval'              => array('tl_class'=>'clr w50','submitOnChange'=>true),
	'sql'				=> "char(1) NOT NULL default ''"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['newslist_comments_stoplevel'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['newslist_comments_stoplevel'],
	'exclude'           => true,
	'inputType'         => 'text',
	'default'			=> 1,
	'eval'              => array('tl_class'=>'clr w50'),
	'sql'				=> "int(3) NOT NULL default '1'"
);

$GLOBALS['TL_DCA']['tl_module']['fields']['newslist_comments_jumpTo'] = $GLOBALS['TL_DCA']['tl_module']['fields']['jumpTo'];
$GLOBALS['TL_DCA']['tl_module']['fields']['newslist_comments_singleSRC'] = $GLOBALS['TL_DCA']['tl_module']['fields']['singleSRC'];
$GLOBALS['TL_DCA']['tl_module']['fields']['newslist_comments_singleSRC']['eval']['mandatory'] = false;
