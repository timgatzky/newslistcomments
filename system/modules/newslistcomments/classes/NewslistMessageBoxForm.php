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
 * Class file
 */
class NewslistMessageBoxForm extends \Widget
{
	/**
	 * Tempalte 
	 * @var string
	 */
	protected $strTemplate = 'form_messagebox';
	
	/**
	 * Module object
	 * @var object
	 */
	protected $objModule = null;

	/**
	 * Init
	 */
	public function __construct($objModuleNewslist)
	{
		if($objModuleNewslist->type != 'newslist' || !is_object($objModuleNewslist) ) 
		{
			throw new Exception('illegal call!');
		}
	
		// set Template
		if($this->strTemplate != $objModuleNewslist->newslist_comments_messagebox_template)
		{
			$this->strTemplate = $objModuleNewslist->newslist_comments_messagebox_template;
		}
		
		$this->objModule = $objModuleNewslist;
	}

	/**
	 * generate
	 */
	public function generate()
	{
		$this->Template = new \FrontendTemplate($this->strTemplate);
		$this->Template->id = $this->objModule->id;
		$this->Template->pid = $this->objModule->pid;
		$this->Template->archives = implode(',', deserialize($this->objModule->news_archives));
		
		return $this->Template->parse();
	}

	public function validate()
	{
		$objInput = \Input::getInstance();
		
		if(strlen($objInput->post('NEW_NEWS')) < 1 || standardize($objInput->post('NEW_NEWS')) != standardize($GLOBALS['TL_LANG']['newslistcomments']['news_default']) )
		{
			return false;
		}
		
		// Create a new news entry
		$intModule = $objInput->post('NEWSLIST_ID');
		$objModule = \Database::getInstance()->prepare("SELECT * FROM tl_module WHERE id=?")->limit(1)->execute($intModule);
		
		$arrArchives = deserialize($objModules->news_archives);
		foreach($arrArchives as $archive)
		{
			$this->createNews( $archive, $objInput->post('NEW_NEWS') );
		}
		
	}

	
	/**
	 * Create a news entry
	 * @param integer
	 * @param string
	 */
	public function createNews($intArchive, $strText='')
	{
		$time = time();
		$arrSet = array
		(
			'pid'		=> $intArchive,
			'tstamp'	=> time(),
			'alias'		=> $this->generateNewsAlias( \String::substr($strText,128), $intArchive),
			'headline'	=> \String::substrHtml($strText,120),
			'date'		=> $time,
			'time'		=> $time,
			'text'		=> $strText,
			'published'	=> 1
		);
		
		\Database::getInstance()->execute("INSERT INTO tl_news %s")->set($arrSet);
	}
	
	/**
	 * Auto-generate the news alias if it has not been set yet
	 * @param mixed
	 * @param DataContainer
	 * @return string
	 */
	public function generateNewsAlias($varValue, $intArchive=0)
	{
		$varValue = standardize($varValue);
		$objAlias = $this->Database->prepare("SELECT id FROM tl_news WHERE alias=?")
								   ->execute($varValue);

		// Add ID to alias
		if ($objAlias->numRows)
		{
			$varValue .= '-' . $intArchive;
		}

		return $varValue;
	}
	
}

?>