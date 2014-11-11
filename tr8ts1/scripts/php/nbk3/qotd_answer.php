<?php

 



 /**********************************************************





    **********************************************************/


  class Qotd{
    var $data = Array();
    var $qdata = Array();
    var $template;
 
 /**********************************************************





    **********************************************************/




    function qotd()  {
      
      // Get the qotd id of the day

      $fp = fopen("/data/nbk3/config/qotd_id.txt", 'r');
      $theID = fgets($fp, 999);
      fclose($fp);

      // Get the record for that ID
      $records = file("/data/nbk3/docs/games/qotd/qotd.txt");
      $count_records = count($records);
      
      for ($i = 0; $i<$count_records; $i++)
	{
	   $one_record = explode("\t", $records[$i]);

	   if (strcmp($one_record[0],trim($theID))==0)
	     $this->data = $one_record;
	}
                 
      

       }



 /**********************************************************



    **********************************************************/


    function build() {
     require_once($_SERVER["TEMPLATE_HOME"].'/games/qotd_answer.html');
    }


 /**********************************************************

    Function: create()
    Purpose:  Read in a template and substitute in values 



  **********************************************************/

      
    function create() {

          $this->html = implode("",(file('/data/nbk3-ada/templates/games/answer.html')));

       
	  foreach($this->qdata as $key => $value) {  	   
	    $template_name = '<!--{'. $key . '}-->';
	    $this->html = str_replace($template_name, $value, $this->html);
           }
           return $this->html;
    }


    function output() {

      
      $this->collect_data($this->data);      
      echo($this->create());
    }
 

    /**********************************************************





    **********************************************************/




   function collect_data($data)  {
    
       $this->qdata["TEASER"] =  $data[2];
       $this->qdata["TITLE"] =  $data[3];
       $this->qdata["QUESTION"] =  $data[4];
       $this->qdata["CHOICE1"] = $data[5];
       $this->qdata["VALUE1"] = $data[6];
       $this->qdata["CHOICE2"] = $data[7];
       $this->qdata["VALUE2"] = $data[8];
       $this->qdata["CHOICE3"] = $data[9];
       $this->qdata["VALUE3"] = $data[10];
       $this->qdata["TEXT"]=$data[11];
       $this->qdata["ARTICLE_ID"] = $data[12];
       $this->qdata["ARTICLE_TITLE"] = $data[13];
       $this->qdata["GAME_TYPE"] = $data[14];
       
       if (strcmp($this->qdata["VALUE1"],"TRUE")==1){
	 $this->qdata["ANSWER"]=$data[5];
	 $this->qdata["CORRECT_CHOICE"]=1;
       }
       else if (strcmp($this->qdata["VALUE2"],"TRUE")==1){
	 $this->qdata["ANSWER"]=$data[7];
	 $this->qdata["CORRECT_CHOICE"]=2;
       }
       else if (strcmp($this->qdata["VALUE3"],"TRUE")==1){
	 $this->qdata["ANSWER"]=$data[9];
	 $this->qdata["CORRECT_CHOICE"]=3;
       }
      
   
      if ($_POST["choice"]==$this->qdata["CORRECT_CHOICE"])
	 $this->qdata["MESSAGE"]="<p class=\"ibrowse\">Congratulations--you're right!</p>";
       else
	 $this->qdata["MESSAGE"]="<p class=\"ibrowsewrong\">Sorry--that's not the right answer.</p><p>The correct answer is ".$this->qdata["ANSWER"].".</p>";
      
   


  }
  }

$qotd = new Qotd();
$qotd->build($this);


?>
