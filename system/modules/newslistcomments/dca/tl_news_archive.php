<?php

/**
 * Contao Open Source CMS
 * 
 * Copyright (C) 2005-2013 Leo Feyer
 * 
 * @copyright	Tim Gatzky 2014
 * @author		Tim Gatzky <info@tim-gatzky.de>
 * @package		newslistcomments
 * @link		http://contao.org
 * @license		http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */

if(!in_array('comments', \Config::getInstance()->getActiveModules()))
{
	return;
}

/**
 * Palettes
 */
$GLOBALS['TL_DCA']['tl_news_archive']['subpalettes']['allowComments'] .= ',allowListComments';

/**
 * Fields
 */
array_insert($GLOBALS['TL_DCA']['tl_news_archive']['fields'], 0, array
(
	'allowListComments' => array
	(
		'label'                   => &$GLOBALS['TL_LANG']['tl_news_archive']['allowListComments'],
		'exclude'                 => true,
		'inputType'               => 'checkbox',
		'eval'                    => array('tl_class'=>'w50'),
		'sql'					  => "char(1) NOT NULL default ''",
	),
));