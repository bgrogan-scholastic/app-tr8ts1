<?php

$file = $_SERVER['CS_DOCS_ROOT'].'/media/056/tsk_adl_ltrfnt.pdf';

$newfile = 'test.pdf';

//$filecontents = fread($file);

header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="'.$newfile.'"');
//readfile($file);
//header("Content-Disposition:  attachment; filename=\"" . $newfile . "\";" );
header('Content-Transfer-Encoding: binary');

readfile($file);



//phpinfo();

?>