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

/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['parseArticles'][] 	= array('NewslistComments','addCommentsToTemplate');
$GLOBALS['TL_HOOKS']['generatePage'][] 		= array('NewslistComments','processForm');

/**
 * Helper function to add a single message box for creating new posts
 */
function addMessageBox($objModuleNewslist)
{
	$objMessageBoxForm = new NewslistMessageBoxForm($objModuleNewslist);
	return $objMessageBoxForm->generate();
}