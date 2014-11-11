<?php
	//$curr_product_id is set in /go2/frame/searchframe.php
    $productFile = $_SERVER["PHP_INCLUDE_HOME"] . "go2/search/" . $curr_product_id . "_radio_inc.php";
    $otherProductFile = $_SERVER["PHP_INCLUDE_HOME"] . "go2/search/other_radio_inc.php";
    $productGroup = $curr_product_id . "Group";
    $otherGroup = "otherGroup";
    $spanPrefix = "<p class=\"search\"><label for=\"quicksearch\"></label><input type=\"radio\" id=\"quicksearch\" value=\"all\" name=\"";
    $spanSuffix = "\" checked=\"checked\">All&nbsp;Grolier&nbsp;Online";
    
    if (file_exists($productFile)) {
    	echo $spanPrefix . $productGroup . $spanSuffix;
    	include_once($productFile); 
    }
    else {
    	echo $spanPrefix . $otherGroup . $spanSuffix;
    	include_once($otherProductFile);
    }
?>