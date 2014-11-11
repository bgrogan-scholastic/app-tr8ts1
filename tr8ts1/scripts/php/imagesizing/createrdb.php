<?php

/* include components of the common grolier code base for php */
require_once($_SERVER['SCRIPTS_HOME'] . '/imagesizing/common/utils/GI_Directory.php');
require_once($_SERVER['SCRIPTS_HOME'] . '/imagesizing/common/utils/GI_ParameterFile.php');
require_once($_SERVER['SCRIPTS_HOME'] . '/imagesizing/common/utils/GI_ImageDirectory.php');
require_once($_SERVER['SCRIPTS_HOME'] . '/imagesizing/common/utils/GI_ImageInformation.php');
require_once($_SERVER['SCRIPTS_HOME'] . '/imagesizing/common/network/GI_Ftp.php');
require_once($_SERVER['SCRIPTS_HOME'] . '/imagesizing/common/utils/GI_File.php');


/* version 1 of the image sizing tool */
require_once($_SERVER['SCRIPTS_HOME'] . '/imagesizing/common/utils/GI_ImagesInformationTable.php');

/* version 2 of the image sizing tool */
require_once($_SERVER['SCRIPTS_HOME'] . '/imagesizing/common/utils/GI_ImagesInformationTable_V2.php');



?>

<?php

/* this class will gather all the image sizings for the full and thumbnail images based on a product code and an output file. */

/* get the url parameters */
$pcode = $_GET['pcode'];
$filename = $_GET['filename'];

/* open up the parameter file */
$parameterFile = new GI_ParameterFile($_SERVER['IMAGESIZING_CONFIG'] . '/' . $pcode . '/' . $filename);

/* using the parameter file build a "virtual" table of assets and their dimensions */
global $imageInformationTable;

$versionNumber = $parameterFile->GetValue('version');

/* determine which version of the images information table to use.  This is used to accomadate an old and new version of the tool.
	Old Version: - assumed 1.0 although not specified, this tool allows thumbs/fulls and both to be generated.
	New Version: 2.0 - this tool will ONLY generate thumbs or fulls, to generate both the version tag must be left out of the config file.
*/

switch ($versionNumber) {
	case 2:
		global $imageInformationTable;
		$imageInformationTable = new GI_ImagesInformationTable_V2($parameterFile);
		break;
	default:
		global $imageInformationTable;
		$imageInformationTable =  new GI_ImagesInformationTable($parameterFile);
		break;
}

/* the table of image sizes */
$imageSizings = $imageInformationTable->GetInformation();

/* the destination file path */
$destFilePath = $parameterFile->GetValue('dest');

/* the delimitor that should be used for the rdb file */
$rdbDelimitor = $parameterFile->GetValue('rdbdelimitor');

/* the format of the rdb file */
$rdbFormat = $parameterFile->GetValue('rdbformat');

$myRDBContents = "";

/* loop through each image record */
foreach ($imageSizings as $k => $v) {
	$fields = explode($rdbDelimitor, $rdbFormat);

	$i = 1;
	foreach($fields as $y) {
		if ($y == "id") {
			/* the id field is the key , so output the key */
			$myRDBContents = $myRDBContents . $k;
		}
		/* if the first character is a < and the last character is a > then the field is raw text , so get the raw text and output it.*/
		else if( ($y[0] == "<") and ($y[strlen($y)-1] == ">") ) {
			$myRDBContents = $myRDBContents. substr($y, 1, strlen($y) -2);
		}
		else {
			/* output the field specified in the parameter file */
			$myRDBContents = $myRDBContents . $v[$y];
		}

		/* always perform this except at the end of the line */
		if ($i != sizeof($fields)) {
			$myRDBContents = $myRDBContents . $rdbDelimitor;
		}

		$i++;
	}

	$myRDBContents = $myRDBContents . "\n";
}
$tempFilePath = "/tmp/" . $pcode . "_" . $filename;
$myRDBFile = new GI_File($tempFilePath);
$myRDBFile->SetContents($myRDBContents);
$myRDBFile->Write();

/* ftp the file to the correct spot */
$myFtpServerFile = new GI_File("/data/loadtools/config/imagesizing-ftp.config");
$myFtpServer = trim($myFtpServerFile->GetContents());
$myftp = new GI_FTP($myFtpServer, $pcode, $pcode);
$myftp->UploadBinaryFile($tempFilePath, $destFilePath);
$myftp->Close();
?>


<HTML>

<HEAD>
<TITLE>Please Wait....Building RDB File</TITLE>
</HEAD>

<BODY>

<P ALIGN="center">Please Wait....<br><br><?php echo $_GET['filename'];?> is being
built.</P>

<p align="center">The rdb file is now built!</p>
<p align="center"> <?php echo sizeof($imageSizings);?> Assets Processed.</p>
<P ALIGN="center"><A HREF="javascript:window.close();">Close</A></P>

</BODY>

</HTML>
