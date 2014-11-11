<?php
require_once('DB.php');

function getms() {
  list($msec, $sec) = explode(" ", microtime());
  return intval($msec * 1000);
}

 /**********************************************************





    **********************************************************/


  class Quiz{
    var $data;
    var $qdata = array();
    var $template;
 
 /**********************************************************





    **********************************************************/




    function quiz()  {
      
      $db = DB::connect('mysql://ap:ap@localhost/ap');

      if (!DB::isError($db)) {
	$sql = "select * from quizzes order by RAND(" . getms() . ") limit 7" ;
        }

    $this->data = $db->getAll($sql, DB_FETCHMODE_ASSOC);
    if (DB::isError($db)) {
      echo $this->servers->getDebugInfo() . "<br>";
     }
   
  $db->disconnect();
 }



 /**********************************************************





    **********************************************************/


    function build() {
     require_once($_SERVER["TEMPLATE_HOME"].'/quiz/quiz.html');
    }


 /**********************************************************

    Function: create()
    Purpose:  Read in a template and substitute in values 



  **********************************************************/

      
    function create() {

          $this->html = implode("",(file('/data/ap/templates/quiz/question.html')));


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
     foreach($this->data as $data) {
       $index = $index + 1;
       $this->qdata["ID".$index] = $data['question_id'];
       $this->qdata["QUESTION".$index] = $data['question_text'];
       $this->qdata["CHOICE".$index."_1"] =  $data['ans_1_text'];
       $this->qdata["CHOICE".$index."_2"] =  $data['ans_2_text'];
       $this->qdata["CHOICE".$index."_3"] =  $data['ans_3_text'];
      }
  }
  }

$quiz = new Quiz();

$quiz->build($this);

?>
