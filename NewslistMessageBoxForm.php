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
 * @package    newslistcomments
 * @license    LGPL 
 * @filesource
 */


class NewslistMessageBoxForm extends Backend
{
	/**
	 * @vars
	 */
	protected $strTemplate = 'form_messagebox';

	public function __construct($objModuleNewslist)
	{
		if($objModuleNewslist->type != 'newslist' || !is_object($objModuleNewslist) ) 
		{
			throw new Exception('illegal call!');
		}
	
		$this->import('Database');
		
		// set Template
		if($this->strTemplate != $objModuleNewslist->newslist_comments_messagebox_template)
		{
			$this->strTemplate = $objModuleNewslist->newslist_comments_messagebox_template;
		}
		
		$this->objNewslist = $objModuleNewslist;
	
	}

	/**
	 * generate
	 */
	public function generate()
	{
		// set template
		$this->Template = new FrontendTemplate($this->strTemplate);
		$this->Template->id = $this->objNewslist->id;
		$this->Template->pid = $this->objNewslist->pid;
		$this->Template->archives = implode(',', deserialize($this->objNewslist->news_archives));
		
		return $this->Template->parse();
		
	}
	
}

?>