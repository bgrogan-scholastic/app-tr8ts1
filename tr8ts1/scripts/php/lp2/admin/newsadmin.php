<?php 

require_once('DB.php');
require_once($_SERVER['PHP_INCLUDE_HOME'] . 'common/utils/GI_BrowserDetect.php');
//require_once($_SERVER['PHP_INCLUDE_HOME'] . 'common/utils/GI_Hash.php');

$dbConn = DB::Connect( $_SERVER['DB_CONNECT_STRING'] );
if (PEAR::isError($dbConn)) {
	echo 'Database Connection Error on lp_picture.php';
} else {}

$year = date("Y");

//change year here if get year is set
if (!isset($_GET['year'])) { $select_year = $year; } 
else { $select_year = $_GET['year']; } 

	$sql = 'SELECT * from nassets where type <> "0tc" AND type <> "0mm" 
	AND YEAR(ndate) = "'.$select_year.'" ORDER BY ndate ASC';

/* $sql_first = 'SELECT n.*, p.id picture, p.status pstatus from nassets n, nassets p, nrelations r 
where n.type = "0tdn" and r.n_pid = n.id and p.id = r.n_cid and p.type = "0tc" and 
YEAR(n.ndate) > "'.$year.'"';
*/

$result = $dbConn->getAll($sql, DB_FETCHMODE_ASSOC);

function year_select ($year) {
	
	$year_select = 2000;
	
	?> 	<b><select name="years" onchange="go_menu(this)">
		<option value="">Year></option> <?php
	
	do {
		
		?>
	
	<option value="http://linuxdev.grolier.com:1104/newsadmin.php?year=<?php echo $year_select ?>"><?php echo $year_select ?></option>
	
	<?php $year_select++; 
	
	} while ($year_select < ($year + 1));
	
	?> </select><br><br> <?php	
	
	//return $loop;
	
}


if (isset($_POST['update'])) {
	
	global $dbConn;
	$no_output = true;
	
	//assemble the update query for ncontrol table
	$ncc = $_POST['nc_cy'].'-'.$_POST['nc_cm'].'-'.$_POST['nc_cd'];
	$ncp = $_POST['nc_py'].'-'.$_POST['nc_pm'].'-'.$_POST['nc_pd'];
	$ncd = $_POST['nc_desc'];
	
	$sql_udnc = sprintf('UPDATE ncontrol SET n_cur_date = "%s", n_prev_date = "%s", n_desc = "%s"', $ncc, $ncp, $ncd);
	//echo 'n control update: <br>'.$sql_udnc.'<br><br>';
	$dbConn->query($sql_udnc);

	//print_r($_POST['status']['article']);
	$article_status = $_POST['status']['article'];
	$article_ostatus = $_POST['ostatus']['article'];
	$picture_status = $_POST['status']['picture'];
	$picture_ostatus = $_POST['ostatus']['picture'];
	
	//print 'article assets (if any) that have been updated: <br><br>';

	foreach ($article_status as $key=>$value) {
		if ($article_status[$key] != $article_ostatus[$key]) {
			//print $key.': '.$article_ostatus[$key].': '.$article_status[$key].'<br>';
			$updarts = 'UPDATE nassets SET status = "'.$value.'" WHERE id = "'.$key.'" LIMIT 1';
			$dbConn->query($updarts);
		} 
	} 
	
	//print '<br><br>picture assets (if any) that have been updated: <br><br>';
	
	foreach ($picture_status as $key=>$value) {
		if ($picture_status[$key] != $picture_ostatus[$key]) {
			//print $key.': '.$picture_ostatus[$key].': '.$picture_status[$key].'<br>';
			$udpics = 'UPDATE nassets SET status = "'.$value.'" WHERE id = "'.$key.'" LIMIT 1';
			$dbConn->query($udpics);
		} 
	} 
	
	?> Your News Items have been updated.<br><a href="newsadmin.php">Click Here to Return</a> <?php
	
}

function mark_radio($status) {
	    //this was a failed attempt to mark the radio button arrays dynamicly.
	    //i went with dropdowns
		/*if ($state == 0) {
			if ( (stristr($status, "arch")) || (stristr($status, "inact")) ) {
				$value = "checked";
			} else $value = "";
		} else*/
		
		if (!stristr($status, "active")) {
				$value = "";
				} else $value = "checked";
				

	return $value;

}

function article_status($id, $status) {

	?> <select name="status[article][<?php echo $id ?>]">
	<option <?php if (stristr($status, 'arch')) { echo 'selected'; } ?> value="archived" >archived</option>
	<option <?php if (stristr($status, 'act')) { echo 'selected'; } ?> value="active">active</option>
	</select>
	<?php
}


function picture_status($id, $status) {

	?> <select name="status[picture][<?php echo $id ?>]">
	<option <?php if (stristr($status, 'act')) { echo 'selected'; } ?> value="active">active</option>
	<option <?php if (stristr($status, 'inact')) { echo 'selected'; } ?> value="inactive">inactive</option>
	</select>
	<?php
}

function gen_ncontrol() {
	
	global $dbConn;
	$sql = 'select DATE_FORMAT(n_cur_date, "%m") cm, DATE_FORMAT(n_cur_date, "%d") cd, YEAR(n_cur_date) cy, DATE_FORMAT(n_prev_date, "%m") pm, DATE_FORMAT(n_prev_date, "%d") pd, YEAR(n_prev_date) py, n_desc from ncontrol';
	$result = $dbConn->getAll($sql, DB_FETCHMODE_ASSOC);
	$nc = $result[0];
	
?>

<table border="1" width="90%" align="center">
<tr>
<td><b>Type:</b></td><td><b>Current Date:</b></td><td><b>Previous Date:</b></td><td><b>Description:</b></td>
</tr>
<tr>
<td>News Article</td><td>Month: <input type="text" name="nc_cm" value="<?php echo $nc['cm'] ?>" size="2" maxlength="2" >
 Day: <input type="text" name="nc_cd" value="<?php echo $nc['cd'] ?>" size="2" maxlength="2"> 
 Year: <input type="text" name="nc_cy" value="<?php echo $nc['cy'] ?>" size="4" maxlength="4"></td>
 <td>Month: <input type="text" name="nc_pm" value="<?php echo $nc['pm'] ?>" size="2" maxlength="2">
 Day: <input type="text" name="nc_pd" value="<?php echo $nc['pd'] ?>" size="2" maxlength="2">
 Year: <input type="text" name="nc_py" value="<?php echo $nc['py'] ?>" size="4" maxlength="4"></td>
<td><input type="text" name="nc_desc" value="<?php echo $nc['n_desc'] ?>" size="30"></td>
</tr>
</table>

<?php
	
}

function gen_news($record) { 

	$id = $record['id'];
	$title = $record['title'];
	$status = $record['status'];
	//$article_status[$id] = $status;
	
?>
<tr>
   <td><?php echo $record['id'] ?></td>

   <td><a target="_blank" href="http://linuxdev.grolier.com:1104/cgi-bin/dated_article?assetid=<?php echo $record['id'] ?>&assettype=n&templatename=/news/newsarchived.html"><?php echo $record['title'] ?></a></td>
   <td>&nbsp;<?php echo $record['teaser'] ?></td>
   <td width="225">
   Status: <?php article_status($id, $status) ?></td>
   <input type="hidden" name="ostatus[article][<?php echo $id ?>]" value="<?php echo $status ?>">
</tr>	
	
<?php
	if ($record['type'] == '0tdn') { 
		get_pic($record['id']);
	}	
	
}

function get_pic($record) { 
	
	global $dbConn;
	
	$sql_picture = 'SELECT p.* from nassets p, nrelations r 
					where r.n_pid = "'.$record.'" 
					and p.id = r.n_cid and p.type = "0tc"';
	
	
	$picture = $dbConn->getAll($sql_picture, DB_FETCHMODE_ASSOC);
	//$picture = query($sql_picture);
	//$pic = rset($picture);
	$pic = $picture[0];
	//$picname = $pic['id'].'.jpg';
	
	//$ploc = 'news/media/';
	
	//$myHash = new GI_Hash($_SERVER['DOCUMENT_ROOT'] . '/news/media');
	//$ploc .= $myHash->hval($picname).'/'.$picname;
	
	?>
	<!-- picture query debug 
	<?php //print_r($record); echo '<br><br>'.$sql_picture; ?> 
	-->
<tr>
   <td>&nbsp;</td>

   <td valign="top">Photo: <?php echo $pic['id'] ?></td>
   <td><a href="javascript:OpenBlurbWindow('http://linuxdev.grolier.com:1104/cgi-bin/media?templatename=/news/news_media.html&assetid=<?php echo $pic['id'] ?>', 700, 550, 'media', 'on');">
   <!--
	<img src="<?php /* echo $ploc ?>" alt="<?php echo $pic['title'] ?>" height="<?php echo $pic['theight'] ?>" width="<?php echo $pic['twidth'] */ ?>" border="0">
	-->
   view photo</a></td>
   <td valign="middle" width="250">
   Status:<?php picture_status($pic['id'], $pic['status'])  ?>
   </td>
   <input type="hidden" name="ostatus[picture][<?php echo $pic['id'] ?>]" value="<?php echo $pic['status'] ?>">
</tr>	
	
	<?php	
}

?>

<html>
<html>
<head>
<script language="javascript">
<?php echo output_js(); ?>


function go_menu(obj){
	window.location=obj.options[obj.selectedIndex].value;
}

var gBlurbWindow;
var SearchWindow;

function OpenBlurbWindow(inContentURL, inWidth, inHeight, inWindowName, inResize)
{
    if ((inResize == "on") || (inResize == "yes"))
	gBlurbWindow = window.open(inContentURL,inWindowName,"height="+inHeight+",width="+inWidth+",scrollbars=yes,menubar=yes,resizable=yes,status=yes");
    else
        gBlurbWindow = window.open(inContentURL, inWindowName, "height="+inHeight+",width="+inWidth+",scrollbars=yes,menubar=yes");

    gBlurbWindow.opener = window;

    //alert(navigator.userAgent);
    //MSIE 4.0(1) in particular doesn't like the focus call.
    if (navigator.userAgent.indexOf("MSIE 4.0") != -1) {
      return;
      }
    if (navigator.userAgent.indexOf("MSIE 4.01") != -1) {
      return;
    }
     
    gBlurbWindow.focus();
}


</script>

<title>News - Administrative Control Feature</title>
</head>

<body>
<?php if ($no_output != true) { ?>
<center><b>Administrative Control Feature for L&P 2.0 News</b></center><br>

<pre>
Welcome to the News Control Application for Lands and Peoples.
Here are some simple instructions to perform common operations:

Clicking on the links provided below will open those assets in a new window allowing you
    to look at an asset even if it is marked inactive.   If an asset was marked as inactive
    it is never displayed in the product.

	<b>***</b> So if an asset has a problem and you are working on fixing it, marking an
	asset inactive allows you to pull that asset out of the product, but clicking on the
	link allows you to view that asset internally.

1) Changing the current/previous news weeks.
	- You will notice that there is a section called Newsbytes Control with some edit fields.  
		By changing the current date you will be making any news stories that match that date
		    active.
		By changing the previous date you will be making any news stories that match that date 
			viewed as last week's news on the news homepage.
	- You will notice as well a edit box under description, whatever value is typed in here is
	    what will appear for current news stories such as: (Week of February 12, 2002 or
	    Summer 2002).

2) Changing Newsbytes Status:
	- Any news asset (current story, last week story, archived story, or lesson plan) can be
	    disabled in the event of a problem or if that asset is no longer desirable.  To do so,
	    just click on the radio button marked inactive and that asset will no longer show up
	    in the product.


<b>Once you are done making changes , click on the "Update News" button at the top or bottom
    of the page and the changed items will take effect.</b>
</pre>
<b>News Assets:</b><br><br>
<?php echo year_select($year); ?>
<form action="" id="newsadmin" method="POST">
<input type="submit" name="submit" value="Update News">
<br><br>
<?php gen_ncontrol(); ?>
<br>
<table border="1" width="100%">
<?php array_walk($result, 'gen_news'); ?>
<input type="hidden" name="update" value="go">
</table>
<br><input type="submit" name="submit" value="Update News">
</form>
<?php } ?>
</body>
</html>