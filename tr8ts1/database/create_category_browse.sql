DROP TABLE IF EXISTS `category_browse`;
CREATE TABLE `category_browse` (
  `pid` varchar(128) NOT NULL,
  `cid` varchar(128) NOT NULL,
  `node_type` varchar(16) default NULL,
  `node_title` varchar(128) default NULL,
  `seq` int(11) default NULL,
  PRIMARY KEY  (`pid`,`cid`),
  KEY `cat_browse_cid` (`cid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

