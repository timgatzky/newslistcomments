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

$GLOBALS['TL_DCA']['tl_module']['config']['onload_callback'][]=array('tl_module_newslistcomments', 'modifyPalette');


/**
 * Selectors
 */
array_insert($GLOBALS['TL_DCA']['tl_module']['palettes']['__selector__'],1,array
(
	'addNewslistComments',
	'newslist_comments_messagebox',
	'newslist_comments_avatar'
));


/**
 * Subpalettes
 */ 
array_insert($GLOBALS['TL_DCA']['tl_module']['subpalettes'],1,array
(
	'addNewslistComments'	=> 'newslist_comments_limit,newslist_comments_maxLimit,newslist_comments_aliveTime,newslist_comments_annonymus,newslist_comments_dateFormat,newslist_comments_timeFormat,newslist_comments_sortBy,newslist_comments_alwaysShowDelete,newslist_comments_allowAll,newslist_comments_messagebox,newslist_comments_avatar',
	'newslist_comments_messagebox' => 'newslist_comments_messagebox_template',
	'newslist_comments_avatar' => 'newslist_comments_jumpTo,newslist_comments_avatarSize,newslist_comments_singleSRC'
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

$GLOBALS['TL_DCA']['tl_module']['fields']['newslist_comments_sortBy'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['newslist_comments_sortBy'],
	'inputType' 		=> 'select',
	'default'   		=> 'DESC',
	'options'			=> array('DESC', 'ASC'),
	'reference' 		=> &$GLOBALS['TL_LANG']['tl_module']['newslist_comments_sortBy'],
	'eval'				=> array('tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['newslist_comments_avatar'] = array
(
	'label'				=> &$GLOBALS['TL_LANG']['tl_module']['newslist_comments_avatar'],
	'exclude'           => true,
	'inputType'         => 'checkbox',
	'eval'              => array('submitOnChange'=>true, 'tl_class'=>'clr'),
);

$GLOBALS['TL_DCA']['tl_module']['fields']['newslist_comments_avatarSize'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_content']['size'],
	'exclude'                 => true,
	'inputType'               => 'imageSize',
	'options'                 => $GLOBALS['TL_CROP'],
	'reference'               => &$GLOBALS['TL_LANG']['MSC'],
	'eval'                    => array('rgxp'=>'digit', 'nospace'=>true, 'helpwizard'=>true, 'tl_class'=>'w50')
);

$GLOBALS['TL_DCA']['tl_module']['fields']['newslist_comments_jumpTo'] = $GLOBALS['TL_DCA']['tl_module']['fields']['jumpTo'];
$GLOBALS['TL_DCA']['tl_module']['fields']['newslist_comments_singleSRC'] = $GLOBALS['TL_DCA']['tl_module']['fields']['singleSRC'];
$GLOBALS['TL_DCA']['tl_module']['fields']['newslist_comments_singleSRC']['eval']['mandatory'] = false;

class tl_module_newslistcomments extends Backend 
{
	public function modifyPalette()
	{
		// Version-Fallback: Check contao version to use old fashion scalemode for images
		if (version_compare(VERSION . '.' . BUILD, '2.11.0', '<'))
			{
				$GLOBALS['TL_DCA']['tl_module']['fields']['newslist_comments_avatarSize'] = array
				(
					'label'                   => &$GLOBALS['TL_LANG']['tl_content']['size'],
					'exclude'                 => false,
					'inputType'               => 'imageSize',
					'options'                 => array('crop', 'proportional', 'box'),
					'reference'               => &$GLOBALS['TL_LANG']['MSC'],
					'eval'                    => array('rgxp'=>'digit', 'nospace'=>true, 'tl_class'=>'w50')
				);
		}
	}
}
?>