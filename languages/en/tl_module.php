<?php if (!defined('TL_ROOT')) die('You cannot access this file directly!');

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
 * @copyright  Tim Gatzky 2011-2012 
 * @author     Tim Gatzky <info@tim-gatzky.de>
 * @package    newslistcomments 
 * @license    LGPL 
 * @filesource
 */


/**
 * Fields
 */
$GLOBALS['TL_LANG']['tl_module']['addNewslistComments']						= array('Add comments', 'Places a comment box to each news entry. <p style="color:gray">The template news_latest_comments must be choosen.</p>');
$GLOBALS['TL_LANG']['tl_module']['newslist_comments_limit'] 				= array('Limit', 'Number of comments to disply. 0 = all');
$GLOBALS['TL_LANG']['tl_module']['newslist_comments_maxLimit'] 				= array('Max. number of comments', 'The maximum number of comments for each entry. 0 = all');
$GLOBALS['TL_LANG']['tl_module']['newslist_comments_annonymus'] 			= array('Name for unknown user', 'Comments get this author when user is public.');
$GLOBALS['TL_LANG']['tl_module']['newslist_comments_aliveTime'] 			= array('Remove Time range', 'Time range how long a comment can be removed.');
$GLOBALS['TL_LANG']['tl_module']['newslist_comments_alwaysShowDelete'] 		= array('Always show remove', 'Always show a remove link.');
$GLOBALS['TL_LANG']['tl_module']['newslist_comments_allowAll'] 				= array('Allow public', 'This allows public users to write comments.');
$GLOBALS['TL_LANG']['tl_module']['newslist_comments_messagebox'] 			= array('Add message box', 'Inserts a message box on top of the newslist to quickly post new entries.');
$GLOBALS['TL_LANG']['tl_module']['newslist_comments_dateFormat'] 			= array('Date and time format', 'Set the time output. See php manual date()');
$GLOBALS['TL_LANG']['tl_module']['newslist_comments_timeFormat'] 			= array('Time format', 'Set the time output for the remaining time before a comment cannot be removed anymore. See php manual date()');
$GLOBALS['TL_LANG']['tl_module']['newslist_comments_messagebox_template'] 	= array('Message box template', 'Choose a template for the message box.');


/**
 * Legends
 */
$GLOBALS['TL_LANG']['tl_module']['newslistcomments_legend'] 	= 'Comments-Settings';


?>