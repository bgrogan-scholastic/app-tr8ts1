DROP TABLE IF EXISTS `folder_template_relation`;
CREATE TABLE `folder_template_relation` (
	`folder_id` varchar(128) NOT NULL, 
	`template_code` varchar(128) NOT NULL, 
   PRIMARY KEY  (`folder_id`, `template_code`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;