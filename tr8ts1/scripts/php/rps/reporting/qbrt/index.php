<?php
    require_once('qbrt_config.php');
    require_once('qbrt_session.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<title>Query Builder Reporting Tool</title>
</head>

<frameset cols="28%,*">
<frame marginwidth="4" marginheight="0" name="indexBrowser" src="qbrt.php?class=indexBrowser&parm_target=queryDisplay" />

  <frameset rows="*,41%">
  <frame marginwidth="5" marginheight="5" name="queryDisplay" src="qbrt.php?class=queryDisplay" />
    <frameset cols="39%,21%,*">
    <frame marginwidth="0" marginheight="0" name="productList" src="qbrt.php?class=productList&instance=products&parm_title=Products" />
    <frame marginwidth="0" marginheight="0" name="assetTypeList" src="qbrt.php?class=assetTypeList&instance=assets&parm_title=Asset%20types" />
    <frame marginwidth="0" marginheight="0" name="controlPanel" src="qbrt.php?class=controlPanel" />
    </frameset>
  </frameset>
</frameset>

</html>


<?php
    require_once('qbrt_end_session.php');
?>

