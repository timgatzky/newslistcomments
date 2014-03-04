<?php

/**
 * Contao Open Source CMS
 *
 * Copyright (c) 2005-2014 Leo Feyer
 *
 * @package Newslistcomments
 * @link    https://contao.org
 * @license http://www.gnu.org/licenses/lgpl-3.0.html LGPL
 */


/**
 * Register the classes
 */
ClassLoader::addClasses(array
(
	// Classes
	'NewslistComments'       => 'system/modules/newslistcomments/classes/NewslistComments.php',
	'NewslistMessageBoxForm' => 'system/modules/newslistcomments/classes/NewslistMessageBoxForm.php',
));


/**
 * Register the templates
 */
TemplateLoader::addFiles(array
(
	'form_messagebox'       => 'system/modules/newslistcomments/templates',
	'form_newslistcomments' => 'system/modules/newslistcomments/templates',
	'moo_newslistcomments'  => 'system/modules/newslistcomments/templates',
	'news_latest_comments'  => 'system/modules/newslistcomments/templates',
	'newslist_comments'		=> 'system/modules/newslistcomments/templates',
));
