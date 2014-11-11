<?php

    require_once($_SERVER["PHP_INCLUDE_HOME"].'common/database/GI_List.php');

    $categories = array(
        array(
            'query' => "select * from subject_browse where sb_parent_id='0'and sb_heir_id='0ta' order by sb_seq, sb_thing asc",
            'format' => '["##SB_THING##", "/page?tn=/browse/browse_cumbre.html&sb_child_id=##SB_CHILD_ID##&type=0ta",1,0,1]',
            'separator' =>  ",\n"
        )
    );

    $topics = array(
        array(
            'query' =>  "select * from subject_browse where sb_parent_id='0'and sb_heir_id='0tas' order by sb_seq, sb_thing asc",
            'format' => '["##SB_THING##", "/page?tn=/browse/browse_student.html&sb_child_id=##SB_CHILD_ID##&type=0tas#browse_##SB_CHILD_ID##",1,0,1]',
            'separator' =>  ",\n"
        )
    );

	$categoryList = new GI_List($categories);
	$topicList = new GI_List($topics);

	$categoryList->create();
	$topicList->create();
?>

/* Top Menu */

/* This is the cumbre Splash Page category menu */
	HM_Array1 = [	
	[200,      // menu width (was 200)
	157,       // left_position
	99,       // top_position
	"#000000",   // font_color
	"#000000",   // mouseover_font_color
	"#9ebc69",   // background_color
	"#c0dd8c",   // mouseover_background_color
	"#c0dd8c",   // border_color
	"#9ebc69",    // separator_color
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

<?php echo $categoryList->output(); ?>

	];
		
/* This is the Splash Page student 'Temas' menu */
	HM_Array2 = [	
	[131,      // menu width (was 200)
	7,       // left_position
	65,    // top_position
	"#ffffff",   // font_color
	"#ffffff",   // mouseover_font_color
	"#401b67",   // background_color
	"#5c57bf",   // mouseover_background_color
	"#e13e1a",   // border_color
	"#401b67",    // separator_color
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

<?php echo $topicList->output(); ?>

	];


