<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Contao Open Source CMS
 * Copyright (C) 2005-2010 Leo Feyer
 *
 * Formerly known as TYPOlight Open Source CMS.
 *
 * This program is free software: you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation, either
 * version 3 of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 * 
 * You should have received a copy of the GNU Lesser General Public
 * License along with this program. If not, please visit the Free
 * Software Foundation website at <http://www.gnu.org/licenses/>.
 *
 * PHP version 5
 * @copyright  Tim Gatzky 2012
 * @author     Tim Gatzky <info@tim-gatzky.de>
 * @package    readerpaginations
 * @license    LGPL 
 * @filesource
 */


/**
 * Selectors
 */
array_insert($GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'],1,array
(
	'addNewslistComments',
	'newslist_comments_messagebox'
));


/**
 * Subpalettes
 */ 
array_insert($GLOBALS['TL_DCA']['tl_module']['subpalettes'],1,array
(
	'addNewslistComments'	=> 'newslist_comments_limit,newslist_comments_maxLimit,newslist_comments_aliveTime,newslist_comments_annonymus,newslist_comments_dateFormat,newslist_comments_timeFormat,newslist_comments_alwaysShowDelete,newslist_comments_allowAll,newslist_comments_messagebox',
	'newslist_comments_messagebox' => 'newslist_comments_messagebox_template',
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
);

$GLOBALS['TL_DCA']['tl_module']['fields']['newslist_comments_limit'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['newslist_comments_limit'],
	'exclude'           => true,
	'inputType'         => 'text',
	'eval'              => array('rgxp'=>'digit', 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['newslist_comments_maxLimit'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['newslist_comments_maxLimit'],
	'exclude'           => true,
	'inputType'         => 'text',
	'eval'              => array('rgxp'=>'digit', 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['newslist_comments_aliveTime'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['newslist_comments_aliveTime'],
	'exclude'           => true,
	'inputType'         => 'text',
	'eval'              => array('rgxp'=>'digit', 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['newslist_comments_annonymus'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['newslist_comments_annonymus'],
	'default'			=> 'Unbekannt',
	'exclude'           => true,
	'inputType'         => 'text',
	'eval'              => array('tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['newslist_comments_alwaysShowDelete'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['newslist_comments_alwaysShowDelete'],
	'exclude'           => true,
	'inputType'         => 'checkbox',
	'eval'              => array('tl_class'=>'clr'),
);

$GLOBALS['TL_DCA']['tl_module']['fields']['newslist_comments_allowAll'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['newslist_comments_allowAll'],
	'exclude'           => true,
	'inputType'         => 'checkbox',
	'eval'              => array('tl_class'=>'clr'),
);

$GLOBALS['TL_DCA']['tl_module']['fields']['newslist_comments_messagebox'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['newslist_comments_messagebox'],
	'exclude'           => true,
	'inputType'         => 'checkbox',
	'eval'              => array('submitOnChange'=>true, 'tl_class'=>'clr'),
);

$GLOBALS['TL_DCA']['tl_module']['fields']['newslist_comments_messagebox_template'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['newslist_comments_messagebox_template'],
	'exclude'           => true,
	'default'           => 'form_messagebox',
	'inputType'         => 'select',
	'options'           => $this->getTemplateGroup('form_messagebox'),
	'eval'              => array('tl_class'=>'clr')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['newslist_comments_dateFormat'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['newslist_comments_dateFormat'],
	'default'			=> $GLOBALS['TL_CONFIG']['datimFormat'],
	'exclude'           => true,
	'inputType'         => 'text',
	'eval'              => array('tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['newslist_comments_timeFormat'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['newslist_comments_timeFormat'],
	'default'			=> $GLOBALS['TL_CONFIG']['timeFormat'],
	'exclude'           => true,
	'inputType'         => 'text',
	'eval'              => array('tl_class'=>'w50')
);


class tl_module_newslistcomments extends Backend 
{
	
}
?>