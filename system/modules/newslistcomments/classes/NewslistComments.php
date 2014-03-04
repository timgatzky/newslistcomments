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
 * NewslistComments
 */
class NewslistComments extends \Frontend
{
	/**
	 * @var
	 */
	protected $arrSettings = array();
	protected $strUnknownUser = '';
	protected $intAliveTime;
	protected $intLimit;
	protected $intAlwaysShowDelete;
	protected $intMessageBox;
	protected $intAllowAll;
	protected $intMaxLimit;
	protected $strDateFormat;
	protected $strTimeFormat;
	protected $intAvatar;
	protected $strTemplateComments 	= 'newslist_comments';
	protected $strTemplateForm 		= 'form_newslistcomments';
	protected $bolAjax = true;
	
	/**
	 * Add comments to the newslist template 
	 * @param object
	 * @param array
	 * @return array
	 */
	public function addCommentsToTemplate($objTemplate, $arrArticle, $objModule)
	{
		if(!in_array('comments', \Config::getInstance()->getActiveModules()))
		{
			return $arrArticle;
		}
		
		$objSession = \Session::getInstance();
		$objDatabase = \Database::getInstance();
		$objInput = \Input::getInstance();
		
		// Check if comments are allowed
		$objArchive = $objDatabase->prepare("SELECT * FROM tl_news_archive WHERE id=?")->limit(1)->execute( $arrArticle['pid'] );
		if($objArchive->numRows < 1 || !$objArchive->allowComments)
		{
			$objTemplate->allowComments = false;
			return $arrArticle;
		}
		
		$this->addComments = $objModule->addNewslistComments;
		$this->intLimit = $objModule->newslist_comments_limit;
		$this->intMaxLimit = $objModule->newslist_comments_maxLimit;
		$this->intAliveTime = $objModule->newslist_comments_aliveTime;
		$this->intAlwaysShowDelete = $objModule->newslist_comments_alwaysShowDelete;
		$this->intMessageBox = $objModule->newslist_comments_messagebox;
		$this->intAllowAll = $objModule->newslist_comments_allowAll;
		$this->strUnknownUser = $objModule->newslist_comments_annonymus ? $objModule->newslist_comments_annonymus : $GLOBALS['TL_LANG']['newslistcomments']['anonymous'];
		$this->strDateFormat = $objModule->newslist_comments_dateFormat ? $objModule->newslist_comments_dateFormat : $GLOBALS['TL_CONFIG']['dateFormat'];
		$this->strTimeFormat = $objModule->newslist_comments_timeFormat ? $objModule->newslist_comments_timeFormat : $GLOBALS['TL_CONFIG']['timeFormat'];
		$this->sortBy = $objModule->newslist_comments_sortBy;
		$this->avatar =  $objModule->newslist_comments_avatar;
		$this->avatarSize =  $objModule->newslist_comments_avatarSize;
		$this->defaultAvatar = $objModule->newslist_comments_singleSRC;
		$this->avatarJumpTo = $objModule->newslist_comments_jumpTo;
		$this->strTemplateComments = $objModule->newslist_comments_template;
		
		// build a session array
		$arrSession = $objSession->get('newslistcomments');
		if(!$arrSession)
		{
			$arrSession = array();
		}
		
		// reset limit on ajax request
		if(\Input::post('cmd_loadNews') > 0)
		{
			$arrSession[$arrArticle['id']] = array('limit'=>$this->intMaxLimit);
			$objSession->set('newslistcomments',$arrSession);
		}
		
		// check if a limit is set for this news entry in the session
		if($arrSession[$arrArticle['id']])
		{
			$this->intLimit = $arrSession[$arrArticle['id']]['limit'];
		}
		
		// fetch comments
		$arrComments = $this->getComments($arrArticle['id'], $this->intLimit);
		
		// remove comment from comments array on ajax request
		if(!empty($arrComments) && $objInput->post('cmd_remove_comment') && $objInput->post('parent'))
		{
			foreach($arrComments as $i => $comment)
			{
				if($comment['id'] == $objInput->post('cmd_remove_comment'))
				{
					unset($arrComments[$i]);
				}
			}
		}
		
		// comments list template
		$objCommentsTemplate = new \FrontendTemplate($this->strTemplateComments);
		$objCommentsTemplate->setData($arrArticle);
		$objCommentsTemplate->limit = $this->intLimit;
		$objCommentsTemplate->total = count($arrComments);
		
		if(FE_USER_LOGGED_IN || $this->intAllowAll)
		{
			$objCommentsTemplate->allowComments = true;
			$objTemplate->allowComments = true;
		}
		else
		{
			$objTemplate->allowComments = false;
			$objCommentsTemplate->allowComments = false;
		}
		
		// Avatar
		if( count($arrComments) > 0 && $this->avatar && in_array('avatar', $this->Config->getActiveModules() ) )
		{
			foreach($arrComments as $i => $comment)
			{
				$strAvatarUrl = $this->getAvatar($comment['name'], 'tl_member');
				$arrComments[$i]['avatar'] = $strAvatarUrl;
			}
		}
		
		$objCommentsTemplate->comments = $arrComments;
		
		// load more link
		if($this->intLimit > $this->intMaxLimit)
		{
			$objCommentsTemplate->more = '<a href="'.\Environment::get('request').'#" onclick="NewslistComments.load(this,'.$arrArticle['id'].');return this;">'.$GLOBALS['TL_LANG']['newslistcomments']['loadMore'].'</a>';
		}
		
		// comment form
		$objCommentsForm = new \FrontendTemplate($this->strTemplateForm);
		$objCommentsForm->id = $arrArticle['id'];
		$objCommentsForm->formName = 'com_form_newscomment_'.$arrArticle['id'];
		$objCommentsForm->action = \Environment::get('request');
		$objCommentsForm->module = $objModule->id;
		
		$objCommentsTemplate->commentForm = $objCommentsForm->parse();
		
		// add comments to template
		$objTemplate->comments = trim($objCommentsTemplate->parse());
		
		$GLOBALS['TL_JAVASCRIPT'][] = 'system/modules/newslistcomments/assets/js/NewslistComments.js';
					
		return $arrArticles;
	}
	
		
	/**
	 * Get Avatars
	 * @param string
	 * @param string
	 * @return string
	 */
	public function getAvatar($username, $strTable='')
	{
		$objDatabase = \Database::getInstance();
		$strImage = '';
		$strAvatar = '';
		$strRealName = '';
		$strUrl = '';
		$size = deserialize($this->avatarSize);
		
		// use default avatar
		if($username == $this->strUnknownUser && strlen($this->defaultAvatar) )
		{
			$strAvatar = $this->defaultAvatar;
		}
		else
		{
			$objUser = $objDatabase->prepare("SELECT id,firstname,lastname,avatar FROM ". $strTable ." WHERE username=?")->limit(1)->execute($username);
			
			if($objUser->numRows)
			{
				$strAvatar = $objUser->avatar;
				$strRealName = $objUser->firstname . ' ' . $objUser->lastname;
				
				if(!$objUser->avatar)
				{
					$strAvatar = $this->defaultAvatar;
				}
			}
			else
			{
				$strAvatar = $this->defaultAvatar;
			}
			
			if($this->avatarJumpTo)
			{
				$objJumpTo = $objDatabase->prepare("SELECT id, alias FROM tl_page WHERE id=?")->limit(1)->execute($this->avatarJumpTo);
				if($objJumpTo->numRows)
				{
					$strUrl = ampersand( $this->generateFrontendUrl( $objJumpTo->row()) ) . '?show='.$objUser->id;
				}
			}
		}
	
		$strImage = $this->replaceInsertTags('{{image::'.$strAvatar.'?width='.$size[0].'&height='.$size[1].'&crop='.$size[2].'&title='.$username.'&alt='.$username);
		
		// anchor
		if(strlen($strUrl))
		{
			if(strlen($strRealName))
			{	
				$title = sprintf($GLOBALS['TL_LANG']['newslistcomments']['jumpTo'], $strRealName);
			}
			
			//$strAnchor = sprintf('<a href="%s" title="%s">' . $strImage . '</a>', $strUrl, $title);
			$strAnchor = '<a href="' . $strUrl . '" title="'. $title .'">' . $strImage . '</a>';
			$strReturn = $strAnchor;
		}
		else
		{
			$strReturn = $strImage;
		}
		
		
		return $strReturn;
	}
	
	/**
	 * Removes a comment by its id
	 * @param integer
	 */
	public function removeComment($intId)
	{
		\Database::getInstance()->prepare("DELETE FROM tl_comments WHERE id=?")->execute($intId);
	}
	
	/**
	 * Validates the form and creates comments, news etc. depending on form properties and reloads the page
	 * called from generatePage HOOK
	 */
	public function processForm()
	{
		$objInput = \Input::getInstance();
		
		// Create a new comment and write to session
		if(strlen($objInput->post('FORM_SUBMIT')) > 0 && strlen($objInput->post('NEW_COMMENT')) > 0 && standardize($objInput->post('NEW_COMMENT')) != standardize($GLOBALS['TL_LANG']['newslistcomments']['comment_default']) )
		{
			$intModule = $objInput->post('NEWSLIST_ID');
			$objModule = \Database::getInstance()->prepare("SELECT * FROM tl_module WHERE id=?")->limit(1)->execute($intModule);
			
			$this->strUnknownUser = $objModule->newslist_comments_annonymus ? $objModule->newslist_comments_annonymus : $GLOBALS['TL_LANG']['newslistcomments']['anonymous'];
			$this->createComment($objInput->post('NEW_COMMENT'), 'tl_news', $objInput->post('NEWS_ID'));
			
			$this->_reload();			
		}
		
		// remove a comment by GET
		if($objInput->get('cmd_remove_comment') && $objInput->get('parent'))
		{
			$this->removeComment($objInput->get('cmd_remove_comment'), $objInput->get('parent'));
			
			global $objPage;
			$url = $this->generateFrontendUrl($objPage->row());
			
			$this->redirect($url);
		}
		
		// remove a comment by POST
		if($objInput->post('cmd_remove_comment') && $objInput->post('parent'))
		{
			$this->removeComment($objInput->post('cmd_remove_comment'), $objInput->post('parent'));
			
			global $objPage;
			$url = $this->generateFrontendUrl($objPage->row());
		}
	}
	
	
	/**
	 * Create a new comment to the database
	 * @param string -> source table
	 */
	public function createComment($strComment,$strSource,$intParent)
	{
		$objDatabase = \Database::getInstance();
		$objInput = \Input::getInstance();
		$objUser = \FrontendUser::getInstance();
		
		$time = time();
		
		$arrSet = array(
			'tstamp'	=> $time,
			'date'		=> $time,
			'source'	=> strlen($strSource) > 0 ? $strSource : 'tl_news', 
			'parent'	=> $intParent, 
			'name'		=> (FE_USER_LOGGED_IN ? $objUser->username : $this->strUnknownUser), 
			'comment'	=> $strComment, 
			'ip'		=> \Environment::get('ip'),
			'published'	=> 1,
		);
		
		// insert new comment			
		$objInsert = $objDatabase->prepare("INSERT INTO tl_comments %s")->set($arrSet);
		$objInsert->execute();
		
	#	// get id of current post
	#	$objField = $this->Database->prepare("SELECT id FROM tl_comments WHERE tstamp=? AND source=? AND parent=? AND name=?")
	#					->limit(1)
	#					->execute($tstamp, $source, $parent, $username);
	#	if(!$objField->numRows) return '';
	#				
	#	// write information to session
	#	$arrData = array(
	#		'tstamp'	=> $tstamp, 
	#		'id'		=> $objField->id,
	#		'source'	=> 'tl_news', 
	#		'pid'		=> $parent, 
	#		'user'		=> $username, 
	#		'comment'	=> $comment, 
	#		'ip'		=> $this->Environment->ip,
	#		'raw'		=> array('tstamp'=>$tstamp),
	#	);
		
	}
	
	/**
	 * Collect the first n Comments of the corresponding news
	 * @param integer
	 * @param integer
	 * @return array
	 */
	public function getComments($intParent, $limit=10)
	{
		$arrComments = array();
		$objComments = \Database::getInstance()->prepare("SELECT * FROM tl_comments WHERE parent=? AND published=1 AND source='tl_news' ORDER BY tstamp " . $this->sortBy)
						->limit($limit)
						->execute($intParent);
		if($objComments->numRows < 1) 
		{
			return array();
		}
		
		$i = 0;		
		while( $objComments->next() )
		{
			$arrClass = array('comment');
			if($i == 0) {$arrClass[] = 'first';}
			if($i >= $objComments->numRows-1) {$arrClass[] = 'last';}
			$i%2 == 0 ? $arrClass[] = 'even' : $arrClass[] = 'odd';
			// add time based classes
			$arrClass[] = $this->getClass($objComments->tstamp);
			
			$arrComments[$i] = array
			(
				'id'			=> $objComments->id,
				'name'			=> $objComments->name,
				'parent'		=> $objComments->parent,
				'email'			=> $objComments->email,
				'website'		=> $objComments->website,
				'comment'		=> $objComments->comment,
				'tstamp'		=> $objComments->tstamp,
				'class'			=> trim(implode(' ', $arrClass)),
				'time'			=> date($this->strDateFormat, $objComments->tstamp),
				'time_elapsed'	=> $this->getTimeElapsed($objComments->tstamp),
				'raw'			=> array('tstamp' => $objComments->tstamp)
			);
		
			// only show remove link if the comment is not too old
			$leaseTime = 60 * $this->intAliveTime;
			if( ($objComments->tstamp + $leaseTime) > time() )
			{
				$arrComments[$i]['remove_link'] = $this->generateRemoveLink($objComments->id, $intParent);
				$arrComments[$i]['time_remaining'] = $this->getRemainingTime($objComments->tstamp) . ' min';
			} 
			if ($this->intAlwaysShowDelete)
			{
				$arrComments[$i]['remove_link'] = $this->generateRemoveLink($objComments->id, $intParent);
			}
						
			$i++;
		}
		
		return $arrComments;
	}
	
	/**
	 * Creates an individual remove url for each comment
	 */
	public function generateRemoveLink($commentId, $pid)
	{
		global $objPage;
		return $this->addToUrl('cmd_remove_comment='.$commentId. '&parent='.$pid);
	}
		
	/**
	 * Get time left
	 * @param integer
	 * @return string
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
	 * @param integer
	 * @return string
	 */
	public function getRemainingTime($tstamp)
	{
		$leaseTime = 60 * $this->intAliveTime;
		$time = round($tstamp + $leaseTime - time() )/60; 
		$remaining = floor($this->round_up($time, 0) ); // rounds down
		return $remaining;
	}
	
	/**
	 * Get Class
	 * @param integer
	 * @return string
	 */
	public function getClass($tstamp)
	{
		$date = new Date($tstamp);
		$now = time();
		$arrClass = array();
		
		$thisMin = $tstamp + (60);
		$thisHour = $tstamp + (60*60);
		$lastMin -= ($thisMin * 2);
		$lastHour -= $thisHour * 2;
		$justAdded = $thisMin + ($this->intAliveTime * 60);
		
		
		if( $now >= $lastMin && $now <= $justAdded )
		{
			$arrClass[] = 'justAdded';
		}
		if( $now >= $lastMin && $now <= $thisMin )
		{
			$arrClass[] = 'lastMinute';
		}
		if( $now >= $lastHour && $now <= $thisHour )
		{
			$arrClass[] = 'lastHour';
		}
		if( $now <= $thisMin )
		{
			$arrClass[] = 'thisMinute';
		}
		if( $now <= $thisHour )
		{
			$arrClass[] = 'thisHour';
		}
		if( $now >= $date->__get('dayBegin') && $now <= $date->__get('dayEnd') )
		{
			$arrClass[] = 'today';
		}
		if( $now >= $date->__get('monthBegin') && $now <= $date->__get('monthEnd') )
		{
			$arrClass[] = 'thisMonth';
		}
		if( $now >= $date->__get('yearBegin') && $now <= $date->__get('yearEnd') )
		{
			$arrClass[] = 'thisYear';
		}
		
		$strClass = implode(' ', $arrClass);
		
		return $strClass;
	}
	
	
	/**
	 * Reloads the page and adds an anchor if set
	 */
	private function _reload($strAnchor='')
	{
		$url = $this->Environment->request;
		if(strlen($strAnchor))
		{ 
			$this->addToUrl('#' . $strAnchor);
		}
		
		$this->redirect($url);
		#header('Location: ' . $page . ''); // avoid false repost
	}
		
	
	/**
	 * Round a number
	 * @param mixed
	 * @param integer
	 * @return string
	 */
	private function round_up($value, $precision=0)
	{
		$pow = pow ( 10, $precision );
		return ( ceil ( $pow * $value ) + ceil ( $pow * $value - ceil ( $pow * $value ) ) ) / $pow;
	}

}


?>