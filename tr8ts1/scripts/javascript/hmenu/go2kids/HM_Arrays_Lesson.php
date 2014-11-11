
<?php
    require_once($_SERVER["PHP_INCLUDE_HOME"].'common/database/GI_List.php');
    require_once($_SERVER["PHP_INCLUDE_HOME"].'common/GI_Constants.php');
    require_once($_SERVER['PHP_INCLUDE_HOME'] . 'common/utils/GI_getVariable.php'); 

    define('MENU_ITEM_PREFIX', "[\"<img src='/images/shim.gif' width='1' height='1' alt='check' ");  // if checked imaged used, height and width would both be value of 12
    define('MENU_ITEM_FEATURE_SUFFIX', ' ##TITLE##</a>", "javascript:thePopup.newWindow(\"/page?tn=/news/large_text_popup.html&id=##ID##&type=##TYPE##\",popupWidth,popupHeight,\"largeTextPop\",\"yes\",\"no\",\"yes\",\"yes\" )",1,0,0]');
    define('MENU_ITEM_MEDIA_SUFFIX', ' ##TITLE##</a>", "javascript:thePopup.newWindow(\"/page?tn=/news/small_text_popup.html&id=##ID##&type=##TYPE##\",popupWidth,popupHeight,\"smallTextPop\",\"yes\",\"no\",\"yes\",\"yes\" )",1,0,0]');
    define('CHECKED_IMAGE', '/images/newsnow/shim.gif');  //no checked image for now - just use placeholder
 
    $worksheet = array(
        array(
            'query' => "select * from k_nassets a, k_nrelations r, k_narchive s where r.n_pid='" . GI_getVariable(GI_ASSETID) . "' and n_cid=a.id and a.type = '0trw' and a.id = s.n_artid and s.usedingo = 'yes' ORDER BY r.n_priority ASC, a.sort_title ASC",
            'format' => MENU_ITEM_PREFIX . "id='lesson1' name='lesson1' /><a onMouseover='document.lesson1.src=\\\"" . CHECKED_IMAGE  . "\\\"' onMouseOut='document.lesson1.src=\\\"/images/shim.gif\\\"'>" . MENU_ITEM_FEATURE_SUFFIX
        )
    );
    $worksheetList = new GI_List($worksheet);
    $worksheetList->create();


    $talkAbout = array(
        array(
            'query' => "select * from k_nassets a, k_nrelations r, k_narchive s where r.n_pid='" . GI_getVariable(GI_ASSETID) . "' and n_cid=a.id and a.type = '0trq' and a.id = s.n_artid and s.usedingo = 'yes' ORDER BY r.n_priority ASC, a.sort_title ASC",
            'format' => MENU_ITEM_PREFIX . "id='lesson2' name='lesson2' /><a onMouseover='document.lesson2.src=\\\"" . CHECKED_IMAGE  . "\\\"' onMouseOut='document.lesson2.src=\\\"/images/shim.gif\\\"'>" . MENU_ITEM_FEATURE_SUFFIX
        )
    );
    $talkAboutList = new GI_List($talkAbout);
    $talkAboutList->create();


    $activity = array(
        array(
            'query' => "select * from k_nassets a, k_nrelations r, k_narchive s where r.n_pid='" . GI_getVariable(GI_ASSETID) . "' and n_cid=a.id and a.type = '0tra' and a.id = s.n_artid and s.usedingo = 'yes' ORDER BY r.n_priority ASC, a.sort_title ASC",
            'format' => MENU_ITEM_PREFIX . "id='lesson3' name='lesson3' /><a onMouseover='document.lesson3.src=\\\"" . CHECKED_IMAGE  . "\\\"' onMouseOut='document.lesson3.src=\\\"/images/shim.gif\\\"'>" . MENU_ITEM_FEATURE_SUFFIX
        )
    );
    $activityList = new GI_List($activity);
    $activityList->create();


    $activityAnswers = array(
        array(
            'query' => "select * from k_nassets a, k_nrelations r, k_narchive s where r.n_pid='" . GI_getVariable(GI_ASSETID) . "' and n_cid=a.id and a.type = '0trn' and a.id = s.n_artid and s.usedingo = 'yes' ORDER BY r.n_priority ASC, a.sort_title ASC",
            'format' => MENU_ITEM_PREFIX . "id='lesson4' name='lesson4' /><a onMouseover='document.lesson4.src=\\\"" . CHECKED_IMAGE  . "\\\"' onMouseOut='document.lesson4.src=\\\"/images/shim.gif\\\"'>" . MENU_ITEM_FEATURE_SUFFIX
   
        )
    );
    $activityAnswersList = new GI_List($activityAnswers);
    $activityAnswersList->create();
    
    
    $worksheetLength = strlen($worksheetList->output());
    $talkAboutLength = strlen($talkAboutList->output());
    $activityLength = strlen($activityList->output());
    $activityAnswersLength = strlen($activityAnswersList->output());

?>
//alert(" Worksheet: <?php echo $worksheetLength ?>\n Talk About: <?php echo $talkAboutLength ?>\n Activity: <?php echo $activityLength ?>\n Answers: <?php echo $activityAnswersLength ?>");

/* standard popup height and width */
//alert(typeof popupWidth);
if (typeof popupWidth == "undefined") {
    popupWidth = "<?php echo $_SERVER['DEFAULT_POPUP_WIDTH'] ?>";
}
if (typeof popupHeight == "undefined") {
    popupHeight = "<?php echo $_SERVER['DEFAULT_POPUP_HEIGHT'] ?>";
}
		
/* functions */

 function parseInt2(sInt) {
	var i = parseInt(sInt);
    	if(isNaN(i)) return 0;
	    else return i;
 }

 // function to determine the offsetLeft of an element that is passed in
 function fnGetOffsetLeft (pElement) { 
     var lsLeftOffset = pElement.offsetLeft; 
     while ((pElement = pElement.offsetParent) != null) 
         lsLeftOffset  += pElement.offsetLeft; 
     return lsLeftOffset; 
 } 
 // function to determine the offsetTop of an element that is passed in 
 function fnGetOffsetTop (pElement) { 
     var lsTopOffset = pElement.offsetTop; 
     while ((pElement = pElement.offsetParent) != null) 
         lsTopOffset +=pElement.offsetTop; 
     return lsTopOffset; 
 }

var offsetLeft = fnGetOffsetLeft(document.getElementById('LessonPlans'));


// This menu belongs on the Go Kids feature (and archive) article page (by lesson plan)
	HM_Array1 = [	
	[150,      // menu width (was 200)
	offsetLeft,       // left_position
	106,       // top_position
	"#FFFFFF",   // font_color
	"#FFFFFF",   // mouseover_font_color
	"#9f4f9c",   // background_color
	"#bf4f9c",   // mouseover_background_color
	"#bf4f9c",   // border_color
	"#9f8f9c",    // separator_color
	0,         // top_is_permanent (was 1)
	0,         // top_is_horizontal
	0,         // tree_is_horizontal
	1,         // position_under (was 1)
	1,         // top_more_images_visible (was 1)
	1,         // tree_more_images_visible (was 1)
	"",    // evaluate_upon_tree_show (was "null")
	"",    // evaluate_upon_tree_hide (was "null")
	,          // right_to_left
	],     // display_on_click
<?php
  if ($worksheetLength > 0) {
?>
	<?php echo $worksheetList->output(); ?>,
<?php
  }
  if ($talkAboutLength > 0) {
?>
	<?php echo $talkAboutList->output(); ?>,
<?php
  }
  if ($activityLength > 0) {
?>
	<?php echo $activityList->output(); ?>,
<?php
  }
  if ($activityAnswersLength > 0) {
?>
	<?php echo $activityAnswersList->output(); ?>,
<?php
  }
?>
	];
		

