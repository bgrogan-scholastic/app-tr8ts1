
<?php

/** 
 * Controls the name of the unqiue file to be generated for a particular
 * feature.  A feature is defined by the template that it uses.
 *
 * If there is no definition in this file for a specific template
 * then the default will be used.
 * 
 * @author      : Lori Hongach lhongach@scholasticlibrary.com 
 * @version     : V 1.0 4/22/2004 
 */ 

$uniqueNamingConvention = array("default" => array(GI_TEMPLATENAME,
						   GI_ASSETID,
						   GI_ASSETTYPE),
				"/article/student/recipe.php" => array(GI_ASSETID,
								     'MYTESTVAR'),
				"/teachers/activity_list.html" => array (GI_TEMPLATENAME,
				                    'category', 'subcategory'),
				"/recipes/recipes.html" => array(GI_TEMPLATENAME),
				"/timelines/home.html" => array(GI_TEMPLATENAME),
				"/timelines/timelines.html" => array(GI_TEMPLATENAME, GI_ASSETID),
				"/events/events.html" => array(GI_TEMPLATENAME),
				"/events/calendar.html" => array(GI_TEMPLATENAME, 'year', 'month'),
				"/grammar/grammar.html" => array(GI_TEMPLATENAME),
				"/browse/browse_cumbre.html" => array(GI_TEMPLATENAME, 'sb_child_id'),
				"/browse/browse_student.html" => array(GI_TEMPLATENAME, 'sb_child_id')
			       );

?>
				
