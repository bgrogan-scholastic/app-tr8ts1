<?php

require_once('DB.php');

$db = DB::connect($_SERVER['DB_CONNECT_STRING']);
                                if (DB::isError($db)) {
                                        $this->_raiseError('No database connection', 8, 1);
                                return;
                                }

$proj_id=$_REQUEST['id'];


$query = "select uid from manifest where slp_id='$proj_id';";

$rslt =  &$db->query($query);

while($row = $rslt->fetchRow(DB_FETCHMODE_ASSOC))

{

  $uid = $row['uid'];


}
 
echo $uid;
//echo "help_feature:".$help_feature."<BR>";

//echo "description:".$description."<BR>";
 


 
?>


