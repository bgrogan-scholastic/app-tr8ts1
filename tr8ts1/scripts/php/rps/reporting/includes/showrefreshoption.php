<p align="center"><input type="checkbox" value="yes" name="refreshdata"><b>Refresh Report Data?</b><br>
<?php 
	$myRefreshQueryObject = new GI_DBQuery("select to_char(LAST_DDL_TIME, 'DD/MON/YYYY') LAST_DDL_DATE, to_char(LAST_DDL_TIME, 'HH24:MI:SS') LAST_DDL_TIME from obj where object_name='REPORTS_MV' and object_type='TABLE'", $myDatabase);
	$myRefreshQueryObject->ExecuteQuery();
	if($myRefreshQueryObject->GetQueryCount() > 0) {
		$myObjRow = $myRefreshQueryObject->NextRow();
		$lastModified_Date = $myObjRow['LAST_DDL_DATE'];
		$lastModified_Time = $myObjRow['LAST_DDL_TIME'];
		?>
		(Report data last refreshed on: <u><?php echo $lastModified_Date;?> @ <?php echo $lastModified_Time;?></u>)
	<?php
	}
?>
</p><br>