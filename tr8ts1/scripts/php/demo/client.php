<?php

require_once($_SERVER['SCRIPTS_PHP'] . '/common/cs/client/CS_Client.php');

$cs = new CS_Client();

?>

<html>
<head><title>Content Server Test Page</title>
<link rel="stylesheet" type="text/css" href="main.css">
<body>
<h2>Content Server Test Page</h2>
<p>
This is a test page for the content server. It's essential job is to create a connection between a CS_Server object and 
a CS_Client object, and allow a client program (this page) to use the connection. The CS_Server object lives on 
http://linuxdev.grolier.com:4000, so this communication is happening over the HTTP protocol, even though it's on the same machine.
</p>
<p>
In order to use this page you need to enter an assetid for an asset you wish to retrieve and then select the type of asset it is.
For text asset select the 'text asset' radio button. The 'by filename' checkbox allows you to retrieve text assets that aren't in the 
Content Server's database, like captions. To get an asset 'by filename' you must enter the full filename of the asset. For instance
'7000092-c.html' would retrieve the caption file for assetid 7000092.
</p>
<p>
To retrieve a binary asset enter the assetid into the text box and select the 
'binary asset' radio button. Like text assets, the 'by filename' checkbox allows you to get binary assets that aren't in 
the database, like thumbnails. To get an asset 'by filename' you must enter the full filename of the asset. For instance
'101366t.jpg' would retrieve the caption file for assetid 101366.
</p>
<p>
Please keep in mind that this page expects that all binary assets are pictures, and is going to try and display them as such. So if 
you request a movie or sound, you'll get unexpected results. Currently the Content Server is loaded with assets from Cumbre. 
Below is a list of assets from Cumbre you could try out.
</p>
<table width="70%">
  <tr>
    <td width="50%">
      <table>
        <tr>
          <td>
            Here is a list of Cumbre text assets I know work.
          </td>
        </tr>
        <tr>
          <td>
            <ul>
              <li>7000092</li>
              <li>7000091</li>
              <li>7000001</li>
              <li>7000002</li>
              <li>7000003</li>
              <li>7000004</li>
              <li>7000005</li>
            </ul>
          </td>
        </tr>
      </table>
    </td>
    <td width="50%">
      <table>
        <tr>
          <td>
            Here is a list of Cumbre binary (picture) assets I know work.
          </td>
        </tr>
        <tr>
          <td>
            <ul>
              <li>101366</li>
              <li>101367</li>
              <li>101368</li>
              <li>101368</li>
              <li>101369</li>
              <li>101370</li>
              <li>101371</li>
            </ul>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>
<hr>
<form name="test" action="/scripts/client.php" method="post">
  <input type="text" name="assetid" size="20">
  <input type="submit" name="submit" value="Get Asset"><br>

  <input type="radio" name="assettype" value="text" CHECKED>text asset
  <input type="checkbox" name="textfile" value="textfile">by filename<br>
  <input type="radio" name="assettype" value="binary">binary asset
  <input type="checkbox" name="binaryfile" value="binaryfile">by filename<br>
</form>

<?php

if ($_POST[CS_ASSETID] != "") {
  
  // get a text based assset by assetid
  if ($_POST['assettype'] == "text") {

    // should we get asset via assetid
    if (!$_POST['textfile'] == "textfile") {
      $asset = $cs->getText(array(CS_PRODUCTID => 'nec', CS_ASSETID => $_POST[CS_ASSETID]));

      // did we return successfully?
      if (isOk($asset)) {
	$samplecall = sprintf('$asset = $cs->getText(array(CS_PRODUCTID => \'nec\', CS_ASSETID => \'%s\'));', $_POST[CS_ASSETID]);
	stats($asset, $samplecall);
      }
    // otherwise, get asset by filename
    } else {
      $asset = $cs->getText(array(CS_PRODUCTID => 'nec', CS_FILENAME => $_POST[CS_ASSETID]));
      
      // did we return successfully?
      if (isOk($asset)) {
	$samplecall = sprintf('$asset = $cs->getText(array(CS_PRODUCTID => \'nec\', CS_FILENAME => \'%s\'));', $_POST[CS_ASSETID]);
	stats($asset, $samplecall);
      }
    }
  }
  // get a binary based assset by assetid
  else if ($_POST['assettype'] == "binary") {

    // should we get asset via assetid
    if (!$_POST['binaryfile'] == "binaryfile") {
      $asset = $cs->getBinary(array(CS_PRODUCTID => 'nec', CS_ASSETID => $_POST[CS_ASSETID]));

      // did we return successfully?
      if (isOk($asset)) {
	$samplecall = sprintf('$asset = $cs->getBinary(array(CS_PRODUCTID => \'nec\', CS_ASSETID => \'%s\'));', $_POST[CS_ASSETID]);
	stats($asset, $samplecall);
      }
    // otherwise, get asset by filename
    } else {
      $asset = $cs->getBinary(array(CS_PRODUCTID => 'nec', CS_FILENAME => $_POST[CS_ASSETID]));
      // did we return successfully?
      if (isOk($asset)) {
	$samplecall = sprintf('$asset = $cs->getBinary(array(CS_PRODUCTID => \'nec\', CS_FILENAME => \'%s\'));', $_POST[CS_ASSETID]);
	stats($asset, $samplecall);
      }
    }
  }
} else {
  echo "No assetid or filename provided<br>\n";
}

function isOk($data) {

  $retval = Null;
  if (PEAR::isError($data)) {
    echo "<b>** ERROR **</b><br>";
    echo "error code = " . $data->getCode() . "<br>";
    echo "error message = " . $data->getMessage() . "<br>";
    $retval = false;
  } else {
    $retval = true;
  }
  return $retval;
}

function stats($asset, $samplecall) {

  echo "Sample php code to get this asset :<br>\n";
  echo "<p class='code'>\n";
  echo "require_once(\$_SERVER['SCRIPTS_PHP'] . '/common/cs/client/CS_Client.php');<br>\n";
  echo "\$cs = new CS_Client();<br>\n";
  echo $samplecall . "<br>\n";
  echo "</p>\n";

  // do we have a text asset?
  if (get_class($asset) == "cs_text") {
    printf("assetid = %s<br>", $asset->getAssetid());
    printf("filename = %s<br><br>", $asset->getFilename());
    print($asset->getText());
  
  // otherwise, we have a binary asset
  } else {
    printf("filename = %s<br><br>\n", $asset->getFilename());
    $asset->write("/data/csclient/docs/images");
    printf('<img src="/images/%s">', $asset->getFilename());
  }
}
?>

</body>
</html>

