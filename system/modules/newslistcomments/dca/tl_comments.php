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
 * Fields
 */
$GLOBALS['TL_DCA']['tl_comments']['fields']['parentComment'] = array
(
	'sql' => "int(10) NOT NULL default '0'"
);