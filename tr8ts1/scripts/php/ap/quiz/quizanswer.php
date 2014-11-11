<?php
require_once('DB.php');

function getms() {
  list($msec, $sec) = explode(" ", microtime());
  return intval($msec * 1000);
}

 /**********************************************************





    **********************************************************/


  class QuizAnswer{
    var $data1;    
    var $data2;
    var $data3;
    var $data4;
    var $data5;
    var $data6;
    var $data7;

    var $qdata = array();

    var $template;
 
 /**********************************************************





    **********************************************************/




    function quizanswer()  {
     $db = DB::connect('mysql://ap:ap@localhost/ap');

     // Get question 1

     $_query="select * from quizzes where question_id='" . $_POST['ID1'] . "'";
     if (!DB::isError($db)) {
	$sql = $_query;
        }

     $this->data1 = $db->getAll($sql, DB_FETCHMODE_ASSOC);
    
     
     if (dB::isError($db)) {
      	echo $this->servers->getDebugInfo() . "<br>";
     }

     // Get question 2

     $_query="select * from quizzes where question_id='" . $_POST['ID2'] . "'";
     if (!DB::isError($db)){
             $sql = $_query;
     	}
     
     
    $this->data2 = $db->getAll($sql, DB_FETCHMODE_ASSOC);
	
      if (dB::isError($db)) {
         	echo $this->servers->getDebugInfo() . "<br>";
         }


      // Get question 3
    
     $_query="select * from quizzes where question_id='" . $_POST['ID3'] . "'";
     if (!DB::isError($db)){
             $sql = $_query;
     	}
      
    $this->data3 = $db->getAll($sql, DB_FETCHMODE_ASSOC);
	
      if (dB::isError($db)) {
         	echo $this->servers->getDebugInfo() . "<br>";
         }
     $this->data4 = $db->getAll($sql, DB_FETCHMODE_ASSOC);
   
     // Get question 4

     $_query="select * from quizzes where question_id='" . $_POST['ID4'] . "'";
     if (!DB::isError($db)){
             $sql = $_query;
     	}
          
    $this->data4 = $db->getAll($sql, DB_FETCHMODE_ASSOC);
	
      if (dB::isError($db)) {
         	echo $this->servers->getDebugInfo() . "<br>";
         }

      // Get question 5

     $_query="select * from quizzes where question_id='" . $_POST['ID5'] . "'";
     if (!DB::isError($db)){
             $sql = $_query;
     	}
     
     
    $this->data5 = $db->getAll($sql, DB_FETCHMODE_ASSOC);
	
      if (dB::isError($db)) {
         	echo $this->servers->getDebugInfo() . "<br>";
         }

     
      // Get question 6

     $_query="select * from quizzes where question_id='" . $_POST['ID6'] . "'";
     if (!DB::isError($db)){
             $sql = $_query;
     	}
     
     
    $this->data6 = $db->getAll($sql, DB_FETCHMODE_ASSOC);
	
      if (dB::isError($db)) {
         	echo $this->servers->getDebugInfo() . "<br>";
         }

       // Get question 7

     $_query="select * from quizzes where question_id='" . $_POST['ID7'] . "'";
     if (!DB::isError($db)){
             $sql = $_query;
     	}
     
     
    $this->data7 = $db->getAll($sql, DB_FETCHMODE_ASSOC);
	
      if (dB::isError($db)) {
         	echo $this->servers->getDebugInfo() . "<br>";
         }
        
     


 $db->disconnect();
}



 /**********************************************************





    **********************************************************/


    function build() {
     require_once($_SERVER["TEMPLATE_HOME"].'/quiz/quizanswer.html');
    }


 /**********************************************************

    Function: create()
    Purpose:  Read in a template and substitute in values 



  **********************************************************/

      
    function create() {

          $this->html = implode("",(file('/data/ap/templates/quiz/answer.html')));


	  foreach($this->qdata as $key => $value) { 	 
	    $template_name = '<!--{'. $key . '}-->';
	    $this->html = str_replace($template_name, $value, $this->html);
           }
       
           return $this->html;
    }


    function output() {
 
      $this->collect_data();    
      return $this->create();

    }
 

    /**********************************************************





    **********************************************************/




   function collect_data()  {
	 
     $index = 0;
     
   foreach($this->data1 as $data1){
      $this->qdata["QUESTION1"] = $data1['question_text'];
      
      if ($data1['ans_1_code'] == 1)
	$this->qdata["ANSWER1"] = $data1['ans_1_text'];
      else if ($data1['ans_2_code'] == 1)
        $this->qdata["ANSWER1"] = $data1['ans_2_text'];
      else if ($data1['ans_3_code'] == 1)
	$this->qdata["ANSWER1"] = $data1['ans_3_text'];
     
    if ($_POST["PICK1"] == "1")
	$this->qdata["UANSWER1"] = $data1['ans_1_text'];
      else if ($_POST["PICK1"] == "2")
        $this->qdata["UANSWER1"] = $data1['ans_2_text'];
      else if ($_POST["PICK1"] == "3")
	$this->qdata["UANSWER1"] = $data1['ans_3_text'];
      else if(!$_POST["PICK1"]) $this->qdata["UANSWER1"] = " "; 
      }      

  foreach($this->data2 as $data2){
      $this->qdata["QUESTION2"] = $data2['question_text'];
     if ($data2['ans_1_code'] == 1)
	$this->qdata["ANSWER2"] = $data2['ans_1_text'];
      else if ($data2['ans_2_code'] == 1)
        $this->qdata["ANSWER2"] = $data2['ans_2_text'];
      else if ($data2['ans_3_code'] == 1)
	$this->qdata["ANSWER2"] = $data2['ans_3_text'];

   if ($_POST["PICK2"] == "1")
	$this->qdata["UANSWER2"] = $data2['ans_1_text'];
      else if ($_POST["PICK2"] == "2")
        $this->qdata["UANSWER2"] = $data2['ans_2_text'];
      else if ($_POST["PICK2"] == '3')
	$this->qdata["UANSWER2"] = $data2['ans_3_text'];
   else if(!$_POST["PICK2"]) $this->qdata["UANSWER2"] = " ";
     
  
      }      

   foreach($this->data3 as $data3){
      $this->qdata["QUESTION3"] = $data3['question_text'];
     if ($data3['ans_1_code'] == 1)
	$this->qdata["ANSWER3"] = $data3['ans_1_text'];
      else if ($data3['ans_2_code'] == 1)
        $this->qdata["ANSWER3"] = $data3['ans_2_text'];
      else if ($data3['ans_3_code'] == 1)
	$this->qdata["ANSWER3"] = $data3['ans_3_text'];     
     
   if ($_POST["PICK3"] == "1")
	$this->qdata["UANSWER3"] = $data3['ans_1_text'];
      else if ($_POST["PICK3"] == "2")
        $this->qdata["UANSWER3"] = $data3['ans_2_text'];
      else if ($_POST["PICK3"] == "3")
	$this->qdata["UANSWER3"] = $data3['ans_3_text'];
     else if (!$_POST["PICK3"]) $this->qdata["UANSWER3"] = " ";
   }


    foreach($this->data4 as $data4){
      $this->qdata["QUESTION4"] = $data4['question_text'];
           if ($data4['ans_1_code'] == 1)
	$this->qdata["ANSWER4"] = $data4['ans_1_text'];
      else if ($data4['ans_2_code'] == 1)
        $this->qdata["ANSWER4"] = $data4['ans_2_text'];
      else if ($data4['ans_3_code'] == 1)
	$this->qdata["ANSWER4"] = $data4['ans_3_text'];
      
     
   if ($_POST["PICK4"] == "1")
	$this->qdata["UANSWER4"] = $data4['ans_1_text'];
      else if ($_POST["PICK4"] == "2")
        $this->qdata["UANSWER4"] = $data4['ans_2_text'];
      else if ($_POST["PICK4"] == "3")
	$this->qdata["UANSWER4"] = $data4['ans_3_text'];
     else if(!$_POST["PICK4"]) $this->qdata["UANSWER4"] = " ";
    }

  
  foreach($this->data5 as $data5){
      $this->qdata["QUESTION5"] = $data5['question_text'];
           if ($data5['ans_1_code'] == 1)
	$this->qdata["ANSWER5"] = $data5['ans_1_text'];
      else if ($data5['ans_2_code'] == 1)
        $this->qdata["ANSWER5"] = $data5['ans_2_text'];
      else if ($data5['ans_3_code'] == 1)
	$this->qdata["ANSWER5"] = $data5['ans_3_text'];
     
     
      
   if ($_POST["PICK5"] == "1")
	$this->qdata["UANSWER5"] = $data5['ans_1_text'];
      else if ($_POST["PICK5"] == "2")
        $this->qdata["UANSWER5"] = $data5['ans_2_text'];
      else if ($_POST["PICK5"] == "3")
	$this->qdata["UANSWER5"] = $data5['ans_3_text'];
     else if(!$_POST["PICK5"]) $this->qdata["UANSWER5"] = " ";
  }
  foreach($this->data6 as $data6){
      $this->qdata["QUESTION6"] = $data6['question_text'];
          if ($data6['ans_1_code'] == 1)
	$this->qdata["ANSWER6"] = $data6['ans_1_text'];
      else if ($data6['ans_2_code'] == 1)
        $this->qdata["ANSWER6"] = $data6['ans_2_text'];
      else if ($data6['ans_3_code'] == 1)
	$this->qdata["ANSWER6"] = $data6['ans_3_text'];
      
      
   if ($_POST["PICK6"] == "1")
	$this->qdata["UANSWER6"] = $data6['ans_1_text'];
      else if ($_POST["PICK6"] == "2")
        $this->qdata["UANSWER6"] = $data6['ans_2_text'];
      else if ($_POST["PICK6"] == "3")
	$this->qdata["UANSWER6"] = $data6['ans_3_text'];
     else if(!$_POST["PICK6"]) $this->qdata["UANSWER6"] = " ";
  }
 foreach($this->data7 as $data7){
      $this->qdata["QUESTION7"] = $data7['question_text'];
           if ($data7['ans_1_code'] == 1)
	$this->qdata["ANSWER7"] = $data7['ans_1_text'];
      else if ($data7['ans_2_code'] == 1)
        $this->qdata["ANSWER7"] = $data7['ans_2_text'];
      else if ($data7['ans_3_code'] == 1)
	$this->qdata["ANSWER7"] = $data7['ans_3_text'];
         

	   if ($_POST["PICK7"] == "1")
	$this->qdata["UANSWER7"] = $data7['ans_1_text'];
	   else if ($_POST["PICK7"] == "2")
        $this->qdata["UANSWER7"] = $data7['ans_2_text'];
      else if ($_POST["PICK7"] == "3")
	$this->qdata["UANSWER7"] = $data7['ans_3_text'];
      else if (!$_POST["PICK7"])   $this->qdata["UANSWER7"] = " ";
   }

}

  }
$quiz= new QuizAnswer();

$quiz->build($this);

?>
