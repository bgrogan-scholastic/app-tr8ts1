<?php
	require($_SERVER["SCRIPTS_HOME"] . '/imagesizing/common/utils/GI_Directory.php');
	$dirObj = new GI_Directory();

	$pcode = $_GET['pcode'];
	$upcode = strtoupper($pcode);
	
	$directoryListing = $dirObj->GetFileListing($_SERVER['IMAGESIZING_CONFIG'] . "/$pcode/");
?>

<HTML>

<HEAD>
<TITLE>NBK3 Assets</TITLE>

<script language="javascript">
function OpenBlurbWindow(inContentURL, inWidth, inHeight, inWindowName, inResize)
{
    if ((inResize == "on") || (inResize == "yes"))
	gBlurbWindow = window.open(inContentURL,inWindowName,"height="+inHeight+",width="+inWidth+",scrollbars=yes,menubar=yes,resizable=yes,status=yes")
    else
        gBlurbWindow = window.open(inContentURL, inWindowName, "height="+inHeight+",width="+inWidth+",scrollbars=yes,menubar=yes")
    gBlurbWindow.opener = window
}
</script>

</HEAD>

<BODY>

<form name="sizes"

  <DIV ALIGN="center">
    <CENTER>
    <TABLE BORDER="0" WIDTH="35%">
      <TR>
        <TD WIDTH="100%">
          <P ALIGN="center"><B><?php echo $upcode;?> Media Assets</B></TD>
      </TR>
      <TR>
        <TD WIDTH="100%">
          <P ALIGN="center">- Click on the RDB File to Build.</TD>
      </TR>
      <TR>
        <TD WIDTH="33%">&nbsp;</TD>
      </TR>
<TR>
<TD align="center">
<?php
foreach ($directoryListing as $x) {
?>
	<a href="javascript:OpenBlurbWindow('/imagesizing/createrdb.php?pcode=<?php echo $pcode;?>&filename=<?php echo $x;?>', 650, 425, 'sizing', 'off');"><?php echo $x;?></a><br>
<?php
}

?>
</TD>
</TR>


    </TABLE>
    </CENTER>
  </DIV>
</BODY>

</HTML>
