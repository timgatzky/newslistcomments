-- **********************************************************
-- *                                                        *
-- * IMPORTANT NOTE                                         *
-- *                                                        *
-- * Do not import this file manually but use the TYPOlight *
-- * install tool to create and maintain database tables!   *
-- *                                                        *
-- **********************************************************


-- --------------------------------------------------------

-- 
-- Table `tl_module`
-- 

CREATE TABLE `tl_module` (
  	`addNewslistComments` char(1) NOT NULL default '',
	`newslist_comments_limit` int(10) NOT NULL default '3',
	`newslist_comments_maxLimit` int(10) NOT NULL default '0',
	`newslist_comments_aliveTime` int(10) NOT NULL default '15',
	`newslist_comments_annonymus` varchar(255) NOT NULL default '',
	`newslist_comments_alwaysShowDelete` char(1) NOT NULL default '',
	`newslist_comments_allowAll` char(1) NOT NULL default '',
	`newslist_comments_messagebox` char(1) NOT NULL default '',
	`newslist_comments_messagebox_template` varchar(255) NOT NULL default '',
	`newslist_comments_dateFormat` varchar(255) NOT NULL default '',
	`newslist_comments_timeFormat` varchar(255) NOT NULL default '',
	`newslist_comments_sortBy` varchar(255) NOT NULL default '',
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

