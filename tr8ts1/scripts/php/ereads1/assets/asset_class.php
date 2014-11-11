<?php
/**
 * PHP4
 * @package    articleContent
 * @author     Peter K <Pkujawa-Consultant@scholastic.com>
 * @date	   Oct, 2010
 * @version  
 *
 *
 * a small PHP 4.0 class the outputs dynamic Elements like
 *hoveroverinlinewords and hoveroversilverbutton
 *
 *ex Uses:
 *$article = new articleContent();  //instatiate
 *echo $article->hoveroverinlinewords($word);  //pass a word to be higlighted and have a speech bubble
 *DUMP ALL DYNAMIC CODE AFTER TEMPLATE BUILD
 *echo $article->dumpallwords();
 *
 */
 
class articleContent {


function articleContent(){
	//PROOF OF CONCEPT
	//fire off code for MP3 playback 
	//(TEMP POSITION n CODE till a permanent solution is found either in header.php which will load on
	//all pages or somewhere else....)
	echo ' 
	<script type="text/javascript">
 function fireMP3(){
	 alert("fire MP3");
	 }
 </script>';
	
	}
function hoveroverinlinewords($word) {
	//keep a count so multiple words can be used
	$wordid=$word.$this->_count;
	$this->_count++;
	
	$wordhtml.="<!-- display highlight ".$word."-->";
	$wordhtml.="<span id='".$wordid."' class='hoveroverinlinewords' >";
	$wordhtml.= $word;
	$wordhtml.= "</span>"; 
	$wordhtml.="<!-- end highlight-->";

$this->allhtml.="<!-- BEGIN Inline ".$word." SPEECH BUBBLE CONTENT--> "; 
$this->allhtml.= "<div id='".$wordid."_speechbubble' class='speechbubble'>  "; 
//heading
$this->allhtml.= "<div class='speechbubble_heading'>";
$this->allhtml.= "<div class='languagetype'>".$word."<i>(noun)</i></div>";
$this->allhtml.= "<img src='images/speaker.png' width='25' height='20' onclick='javascript:fireMP3();' class='speakerimg' alt='Speaker Image' />";
$this->allhtml.= "</div><!-- speechbubble_heading -->";
//close button
$this->allhtml.= "<div class='speechbubble_close'>CLOSE</div> "; 
//content
$this->allhtml.= "<div class='speechbubble_content'>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation  "; 
$this->allhtml.= "</div>"; 
$this->allhtml.= "</div><!--speechbubble-->"; 
$this->allhtml.= "<!-- END Inline ".$word." SPEECH BUBBLE CONTENT--> ";

return $wordhtml;


	}//hoveroverinlinewords


//silver button
function hoveroversilverbutton($word) {
	//keep a count so multiple buttons can be used
	$wordid=$word.$this->_count;
	$this->_count++;
    //prepare button
	$wordhtml.="<!-- display silverbutton ".$word."-->";
	$wordhtml.="<span id='".$wordid."' class='spacing silverbutton' >";
	$wordhtml.= "<span>".$word."</span>";
	$wordhtml.= "</span>"; 
	$wordhtml.="<!-- end silverbutton-->";
 
//prepare content 
$this->allhtml.="<!-- START silverbutton '".$word."' content -->"; 
$this->allhtml.= "<div id='".$wordid."_speechbubble' class='speechbubble'>  "; 
//heading
$this->allhtml.= "<div class='speechbubble_heading'>";
$this->allhtml.= $word;
$this->allhtml.= "</div><!-- speechbubble_heading -->";
//close button
$this->allhtml.= "<div class='speechbubble_close'>CLOSE</div> "; 
//content
$this->allhtml.= "<div class='speechbubble_content'>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation  "; 
$this->allhtml.= "</div>"; 
$this->allhtml.= "</div><!--speechbubble-->"; 
$this->allhtml.="<!-- END silverbutton '".$word."' content -->";

return $wordhtml;


	}//hoveroversilverbutton
	
	
function dumpallwords() {
	
	 echo $this->allhtml;
	
	}//dumpallwords

}//end articleContent
 	
 
?>