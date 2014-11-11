<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>BookFlix -- Bad Flash</title>
<link href="css/bkflix.css" rel="stylesheet" type="text/css">
<meta http-equiv=Content-Type content="text/html; charset=UTF-8">
<meta http-equiv="Content-Script-Type" Content="text/javascript">

<script>

var flashURL = 'http://www.macromedia.com/go/getflashplayer';

function continueToBookFlix(){
    window.close();
    window.opener.window.focus();
}

function gotoURL(inURL){
    window.opener.location = inURL;
    window.close();
    window.opener.window.focus();
}

function setFlashVersion(inVersion){
    // Check that we have an adequate version.
    var minVersion = <?php echo $_SERVER['MIN_FLASH_VERSION']; ?>;

    var pattern=/(\w+) (\d+),(\d+),(\d+),(\d+)/;
    var result = inVersion.match(pattern);

    if (result != null) {
         if (result[2] < minVersion) {
            var e = document.getElementById('flashmessage');
            if (e) {
                var messageString = "";
                messageString += 'This browser does not appear to have the minimum version ';
                messageString += 'of the Flash plugin required for BookFLIX. &nbsp;In order to function ';
                messageString += 'correctly, BookFLIX requires version <?php echo $_SERVER["MIN_FLASH_VERSION"]; ?> or higher.';
                messageString += '&nbsp;The version installed on this browser is version ' + result[2] + '.';
                e.innerHTML = messageString;

            }
        }
    }
}

</script>

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
        <td style="text-align: center;"><img src="images/scholastic.gif"></td>
    </tr>
    <tr>
        <td height="10">&nbsp;</td>
    </tr>
    <tr>
        <td height="360" class="text16" style="vertical-align: top;">
            <p id="flashmessage">This browser does not appear to have the required Flash plugin installed, or does not
            have the correct version of the plugin.</p>
            <p>BookFLIX will not work properly without the correct version of the Flash plugin. &nbsp;Please ask
            your system administrator or technician to install the Flash plugin (version <?php echo $_SERVER["MIN_FLASH_VERSION"]; ?> or higher)
            on this machine.<p>
            <p>To download the Flash plugin, free of charge, go to: <a href="javascript:gotoURL('http://www.macromedia.com/go/getflashplayer');">http://www.macromedia.com/go/getflashplayer</a>.</p>
            



        </td>
    </tr>
    <tr>
        <td class="text15" style="text-align: center;">To continue to BookFLIX, <a href="javascript:continueToBookFlix();">click here</a>.</td>
    </tr>


    </table>

</td>
</tr>

</table>

</div>

<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" id="FeaturedFlashIntro" align="middle" height="0" width="0">
<param name="allowScriptAccess" value="always">
<param name="movie" value="/flash/flashrat.swf">
<param name="quality" value="high">
<param name="bgcolor" value="#ffffff">
<param name="hidden" value="true">
<embed src="/flash/flashrat.swf" hidden="true" quality="high" bgcolor="#FFFFFF" name="FeaturedFlashIntro" allowscriptaccess="always" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" align="middle" height="0" width="0">
</object>

</body>
</html>
