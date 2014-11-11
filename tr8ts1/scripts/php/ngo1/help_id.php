<?php

require_once($_SERVER['PHP_INCLUDE_HOME'].'common/database/GI_List.php');

require_once('DB.php');

$db = DB::connect($_SERVER['DB_CONNECT_STRING']);
                                if (DB::isError($db)) {
                                        $this->_raiseError('No database connection', 8, 1);
                                return;
                                }

$help_id=$_REQUEST['id'];

if ($help_id==""){print_r($_SERVER['QUERY_STRING']); exit;}

if (!preg_match("/^[help]{4}[-]{1}[0-9]{4}$/", $help_id)) die("Bad help input, please re-enter. Format is help-####");

 



$query = "select contextual_help.help_id 'help_id', contextual_help.help_feature 'help_feature', contextual_help.description 'description', contextual_help.text 'text' from contextual_help WHERE help_id = '$help_id'";

$rslt =  &$db->query($query);

 
                                                       

            while($row = $rslt->fetchRow(DB_FETCHMODE_ASSOC))

{

  $help_id = $row['help_id'];
  $help_feature = $row['help_feature'];
  $description = $row['description'];
  $text     = $row['text'];

}
 
echo $text;
//echo "help_feature:".$help_feature."<BR>";

//echo "description:".$description."<BR>";
 


 
?>


