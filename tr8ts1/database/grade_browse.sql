DROP TABLE IF EXISTS `grade_browse`;
CREATE TABLE `grade_browse` (
	`id` int(11) NOT NULL auto_increment,  
	`grade_title` varchar(128) default NULL,
  	`grade_short_title` varchar(128) default NULL,
   PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

INSERT INTO `grade_browse` VALUES ('1','Kindergarten','K'),('2','Grade 1','1'),('3','Grade 2','2'),('4','Grade 3','3'),('5','Grade 4','4'),('6','Grade 5','5'),('7','Grade 6','6'),('8','Grade 7','7'),('9','Grade 8','8');