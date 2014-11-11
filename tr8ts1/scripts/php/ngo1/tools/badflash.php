<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Expert Space -- Flash not detected</title>
<link href="css/bkflix.css" rel="stylesheet" type="text/css">
<meta http-equiv=Content-Type content="text/html; charset=UTF-8">
<meta http-equiv="Content-Script-Type" Content="text/javascript">

<script>

var flashURL = 'http://get.adobe.com/flashplayer';

function continueToExpertSpace(){
    window.close();
    window.opener.window.focus();
}

function gotoURL(inURL){
    window.opener.location = inURL;
    window.close();
    window.opener.window.focus();
}

 
 

</script>
 <style type="text/css">
 
body {
background-image: url(/images/silver_bkgd_sliver.jpg);
}
 
</style>
</head>
<body>
<div id="content">

<table id="splashflashtable" class="bg7" border="0">
<tr><td width="800" height="60" colspan="2">&nbsp;</td><tr>
<tr>
<td width="130" height="540">&nbsp;</td>
<td width="670" style="text-align: left; vertical-align: top;">

    <table border="0" width="540">
    <tr>
        <td style="text-align: center;">&nbsp;</td>
    </tr>
    <tr>
        <td height="10">&nbsp;</td>
    </tr>
    <tr>
        <td height="319" class="text16" style="vertical-align: top;">
            <p id="flashmessage">This browser does not appear to have the required Flash plugin installed, or does not
            have the correct version of the plugin.</p>
            <p>Expert Space will not work properly without the correct version of the Flash plugin. &nbsp;Please ask
            your system administrator or technician to install the Flash plugin (version <?php echo $_SERVER["MIN_FLASH_VERSION"]; ?> or higher)
            on this machine.<p>
            <p>To download the Flash plugin, free of charge, go to: <a href="javascript:gotoURL('http://get.adobe.com/flashplayer/');">http://get.adobe.com/flashplayer/</a>.</p>
            



        </td>
    </tr>
    <tr>
        <td class="text15" style="text-align: center;">To continue to Expert Space, <a href="javascript:continueToExpertSpace();">click here</a>.</td>
    </tr>


    </table>

</td>
</tr>

</table>

</div>

 
</body>
</html>
