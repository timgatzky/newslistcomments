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
 * @copyright  Tim Gatzky 2011-2012 
 * @author     Tim Gatzky <info@tim-gatzky.de> <www.tim-gatzky.de>
 * @package    newslistcomments
 * @license    LGPL 
 * @filesource
 */


class NewslistComments extends Frontend
{
	/**
	 * @var
	 */
	protected $strSession = 'newslistcomments';
	protected $strUnknownUser = '';
	protected $intAliveTime;
	protected $intLimit;
	protected $intAlwaysShowDelete;
	protected $intMessageBox;
	protected $intAllowAll;
	protected $intMaxLimit;
	protected $strDateFormat;
	protected $strTimeFormat;
	
	
	
	/**
	 * Allows modification for each news entry and for the newslist template
	 * Generates the articles and displays related comments
	 * @return array
	 */
	public function parseArticlesHook($objTemplate, $arrArticle)
	{
		
		// check if user wants to remove its comment
		if(isset($_GET['remove']) || strlen($_GET['remove']) )
		{
			$id = $_GET['remove'];
			$pid = $_GET['parent'];
			$this->removeComment($id, $pid);
		}
		
		// Get Module settings
		$objModuleNewslists = $this->Database->execute("SELECT * FROM tl_module WHERE addNewslistComments=1 AND type='newslist' ");
		if($objModuleNewslists->numRows < 1) return $arrArticle;
		
		$arrSettings = array();
		while( $objModuleNewslists->next() )
		{
			$arrArchives = deserialize($objModuleNewslists->news_archives);
			if( in_array( $arrArticle['pid'], $arrArchives ) )
			{
				#$arrSettings[] = array
				#(
				#	'id' => $objModuleNewslists->id,
				#	'pid' => $arrArticle['pid'],
				#	'addNewslistComments'				=> 	$objModuleNewslists->addNewslistComments,			
				#	'newslist_comments_limit' 			=>	$objModuleNewslists->newslist_comments_limit,	
				#	'newslist_comments_maxLimit' 		=>	$objModuleNewslists->newslist_comments_maxLimit,		
				#	'newslist_comments_annonymus' 		=>	$objModuleNewslists->newslist_comments_annonymus,	
				#	'newslist_comments_aliveTime' 		=>	$objModuleNewslists->newslist_comments_aliveTime,	
				#	'newslist_comments_alwaysShowDelete' =>	$objModuleNewslists->newslist_comments_alwaysShowDelete,		
				#	'newslist_comments_allowAll' 		=>	$objModuleNewslists->newslist_comments_allowAll,		
				#	'newslist_comments_limit' 			=>	$objModuleNewslists->newslist_comments_limit,	
				#	'newslist_comments_messageBox' 		=>	$objModuleNewslists->newslist_comments_messageBox,	
				#);
				$this->addComments = $objModuleNewslists->addNewslistComments;
				$this->intLimit = $objModuleNewslists->newslist_comments_limit;
				$this->intMaxLimit = $objModuleNewslists->newslist_comments_maxLimit;
				$this->intAliveTime = $objModuleNewslists->newslist_comments_aliveTime;
				$this->intAlwaysShowDelete = $objModuleNewslists->newslist_comments_alwaysShowDelete;
				$this->intMessageBox = $objModuleNewslists->newslist_comments_messagebox;
				$this->intAllowAll = $objModuleNewslists->newslist_comments_allowAll;
				$this->strUnknownUser = $objModuleNewslists->newslist_comments_annonymus;
				$this->strDateFormat = $objModuleNewslists->newslist_comments_dateFormat;
				$this->strTimeFormat = $objModuleNewslists->newslist_comments_timeFormat;
			}
		}
		
		// Check if comments are allowed
		$objArchive = $this->Database->prepare("SELECT * FROM tl_news_archive WHERE id=?")
									 ->limit(1)
									 ->execute( $arrArticle['pid'] );
		if ($objArchive->numRows < 1 || !$objArchive->allowComments || !in_array('comments', $this->Config->getActiveModules()))
		{
			$objTemplate->allowComments = false;
			return $arrArticles;
		}
		$objTemplate->allowComments = true;
		
		$objTemplate->limit = $this->intLimit;
		
		// add comments to template
		$arrComments = $this->getComments($arrArticle['id'], $this->intMaxLimit);
		$objTemplate->comments = $arrComments;
		
		if($this->intMaxLimit != 0)
		{
			$objTemplate->total = $this->intMaxLimit; //$arrComments['total'];
		}
		else
		{
			$objTemplate->total = $arrComments['total'];
		}
		
		// Check publishing status
		$username = $this->replaceInsertTags('{{user::username}}');
		strlen($username) ?  $objTemplate->loggedIn = true :  $objTemplate->loggedIn = false;
		// Allow all users
		$objTemplate->allowAll = $this->intAllowAll;
		
		// Start process when there is POST information submitted by a form
		if(strlen($_POST['FORM_SUBMIT']))
		{
			$this->processForm();
		}
					
		return $arrArticles;
		
	}
	
	/**
	 * Removes a comment by its id
	 */
	public function removeComment($id, $pid)
	{
		$this->Database->prepare("DELETE FROM tl_comments WHERE id=? AND parent=?")
					->execute($id, $pid);
		#$this->reload;
	}
	
	/**
	 * Validates the form and creates comments, news etc. depending on form properties and reloads the page
	 * @param string
	 */
	public function processForm()
	{
		
		// Create a new comment and write to session
		if(strlen($_POST['FORM_SUBMIT']) && standardize($_POST['NEW_COMMENT']) != standardize($GLOBALS['TL_LANG']['newslistcomments']['comment_default']) && strlen($_POST['NEW_COMMENT']))
		{
			$this->createComment('tl_news');
			
			// delete POST			
			unset($_POST['FORM_SUBMIT']);
			
			$this->_reload();			
		}
		// Create a new news entry and write to session
		else if(strlen($_POST['FORM_SUBMIT']) && standardize($_POST['NEW_NEWS']) != standardize($GLOBALS['TL_LANG']['newslistcomments']['news_default']) && strlen($_POST['NEW_NEWS']))
		{
			$intModule = $_POST['NEWSLIST_ID'];
			$strArchives = $_POST['NEWS_ARCHIVES'];
			
			$arrArchives = explode(',', $strArchives);
			foreach($arrArchives as $archive)
			{
				$this->createNews( (int)$archive, $_POST['NEW_NEWS']);
			}
			
			// delete POST			
			unset($_POST['FORM_SUBMIT']);
			
			$this->_reload();	
		}
		// delete the session, just for debug
		else if(strlen($_POST['FORM_SUBMIT']) && $_POST['FORM_SUBMIT'] == 'com_form_deleteSession')
		{
			$this->import('Session');
			$this->Session->set('newslistcomments', '');
			$_POST['FORM_SUBMIT'] = "";
		}
		else 
		{
			// nothing here
		}
	}
	
	/**
	 * Create a news entry
	 */
	public function createNews($intArchive, $strText='')
	{
		$pid = $intArchive;
		$tstamp = time();
		$headline = $strText;
		$alias = $this->generateAlias($strText);
		$date = time();
		$time = time();
		$text = $strText;
		$published = 1;
		
		$this->Database->prepare("INSERT INTO tl_news (pid, tstamp, headline, alias, date, time, text, published) VALUES (?, ?, ?, ?, ?, ?, ?, ?) ")
						->execute($pid, $tstamp, $headline, $alias, $date, $time, $text, $published);
	
	}
	
	
	
	
	/**
	 * Create a new comment to the database
	 * @param string -> source table
	 */
	public function createComment($strSource)
	{
		$tstamp = time();
		$date = time();
		$source = $strSource;
		$username = $this->replaceInsertTags('{{user::username}}');
		if(!strlen($username)) $username = $this->strUnknownUser;
		
		$parent = str_replace('com_form_newscomment', '', $_POST['FORM_SUBMIT']);
		$comment = $_POST['NEW_COMMENT'];
		
		// insert new comment			
		$this->Database->prepare("INSERT INTO tl_comments (tstamp, source, parent, name, comment, published, date, ip) VALUES (?, ?, ?, ?, ?, ?, ?, ?) ")
						->execute($tstamp, $source, $parent, $username, $comment, 1, $date, $this->Environment->ip);
		//--
		
		// get id of current post
		$objField = $this->Database->prepare("SELECT id FROM tl_comments WHERE tstamp=? AND source=? AND parent=? AND name=?")
						->limit(1)
						->execute($time, $source, $parent, $username);
		if(!$objField->numRows) return '';
					
		// write information to session
		$arrData = array(
			'tstamp'	=> $time, 
			'id'		=> $objField->id,
			'source'	=> 'tl_news', 
			'pid'		=> $parent, 
			'user'		=> $username, 
			'comment'	=> $comment, 
			'ip'		=> $this->Environment->ip
		);
		$this->setSessionData($arrData);
	}
	
	
	
	
	/**
	 * Session data
	 */
	public function setSessionData($arrData)
	{
		$sessionName = $this->strSession;
		
		$this->import('Session');
		$session = $this->Session->getData();
		
		$username = $this->replaceInsertTags('{{user::username}}');
		if(!strlen($username)) $username = $this-strUnknownUser;
		
		if(!$session[$sessionName] || !count($session[$sessionName])) 
		{
			// create new session array if empty
			$newsession = array(0 => $arrData);
			$this->Session->set($sessionName, $newsession);
		}
		else
		{
			$current = $session[$sessionName];
			$current[] = $arrData;			
			$newsession = $current;
			
			$this->Session->set($sessionName, $newsession);
		}
	 	
	}
	
	
	/**
	 * Collect the first n Comments of the corresponding news
	 * @return array
	 */
	public function getComments($id, $limit)
	{
		$this->import('Database');
				
		$arrComments = array();
		$objComments = $this->Database->prepare("SELECT * FROM tl_comments WHERE parent=? AND published=1 AND source='tl_news' ORDER BY tstamp ASC")
						->limit($limit)
						->execute($id);
		
		if(!$objComments->numRows) return;
		
		$i = 0;		
		while( $objComments->next() )
		{
			$arrComments[$objComments->parent][] = array(
				'id'		=> $objComments->id,
				'name'		=> $objComments->name,
				'email'		=> $objComments->email,
				'website'	=> $objComments->website,
				'comment'	=> $objComments->comment,
				'tstamp'	=> $objComments->tstamp,
				'time'		=> $this->generateTimestamp($objComments->tstamp),
				'time_elapsed'	=> $this->getTimeElapsed($objComments->tstamp),
			);
			
			// only show remove link if the comment is not too old
			$leaseTime = 60 * $this->intAliveTime;
			if( ($objComments->tstamp + $leaseTime) > time() )
			{
				$arrComments[$objComments->parent][$i]['remove_link'] = $this->generateRemoveLink($objComments->id, $objComments->parent);
				$arrComments[$objComments->parent][$i]['time_remaining'] = $this->getRemainingTime($objComments->tstamp) . ' min';
			} 
			if ($this->intAlwaysShowDelete)
			{
				$arrComments[$objComments->parent][$i]['remove_link'] = $this->generateRemoveLink($objComments->id, $objComments->parent);
			}
						
			$i++;
		}
		
		// Count all comments in database
		$objCommentsCount = $this->Database->prepare("SELECT COUNT(*) ". 'total' . " FROM tl_comments WHERE parent=? AND published=1 AND source='tl_news' ORDER BY tstamp ASC")
						->execute($id);
				
		$arrComments[$objComments->parent]['total'] = $objCommentsCount->total;
		
		return $arrComments[$objComments->parent];
		
	}
	
	/**
	 * Creates an individual remove url for each comment
	 */
	public function generateRemoveLink($commentId, $pid)
	{
		global $objPage;
		
		$this->import('Session');
		$session = $this->Session->get('newslistcomments');
		if(!is_array($session)) return '';
		
		// generate delete button action
		$strUrl = $this->generateFrontendUrl($objPage->row());
		$linkUrl = ampersand($strUrl . ($GLOBALS['TL_CONFIG']['disableAlias'] ? '&' : '?') . 'remove='.$commentId. '&parent='.$pid .'&referer='.base64_encode($this->Environment->request));
		
		return $linkUrl;
	}
	
	/**
	 * Generate Time
	 */
	public function generateTimestamp($tstamp)
	{
		return date($this->strDateFormat, $tstamp);;
	}
	
	/**
	 * Get time left
	 */
	public function getTimeElapsed($tstamp)
	{
		$time = time();
		$elapsed = time() - $tstamp;
		
		$strTime = date($this->strTimeFormat, $elapsed);
		return $strTime;
	}
	
	/**
	 * Get the remaining time before a comment is not deleteable anymore 
	 */
	public function getRemainingTime($tstamp)
	{
		$leaseTime = 60 * $this->intAliveTime;
		$time = round($tstamp + $leaseTime - time() )/60; 
		$remaining = floor($this->round_up($time, 0) ); // rounds down
		return $remaining;
	}
	
	/**
	 * Reloads the page and adds an anchor if set
	 */
	private function _reload($strAnchor='')
	{
		$page = $this->Environment->request;
		if(strlen($strAnchor))
		{ 
			$page .= '#' . $strAnchor;
		}
		header('Location: ' . $page . ''); // avoid false repost
	}
	
	
	/**
	 * Round a number
	 */
	private function round_up($value, $precision)
	{
		$pow = pow ( 10, $precision );
		return ( ceil ( $pow * $value ) + ceil ( $pow * $value - ceil ( $pow * $value ) ) ) / $pow;
	}
	
	
	/**
	 * Auto-generate the news alias if it has not been set yet
	 * @param mixed
	 * @param DataContainer
	 * @return string
	 */
	public function generateAlias($varValue)
	{
		$autoAlias = false;
		$varValue = standardize($varValue);
		$objAlias = $this->Database->prepare("SELECT id FROM tl_news WHERE alias=?")
								   ->execute($varValue);

		// Check whether the news alias exists
		if ($objAlias->numRows > 1 && !$autoAlias)
		{
			throw new Exception(sprintf($GLOBALS['TL_LANG']['ERR']['aliasExists'], $varValue));
		}

		// Add ID to alias
		if ($objAlias->numRows && $autoAlias)
		{
			$varValue .= '-' . $dc->id;
		}

		return $varValue;
	}
	

}


?>