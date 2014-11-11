<?php
putenv('PHP_SCRIPTS_HOME=/data/rps/scripts/php');

/* get the common report compnonents */
require_once('includes/common-reports.php');

$myProductQueryObject = new GI_DBQuery('select * from products order by DESCRIPTION ASC', $myDatabase);
$myProductQueryObject->ExecuteQuery();

$myProducts = array();

/* get the list of all the products from the database */
while($myProduct = $myProductQueryObject->NextRow()) {		
	$productID = $myProduct['PRODUCT_ID'];
	$productDescription = $myProduct['DESCRIPTION'];

	$myProducts[$productID] = $productDescription;
}
?>

<html>

<head>
<title>Classification Tool Monthly Statistics Report By Index</title>
</head>

<body>

<!-- the heading of the page -->
<h1 align="center"><font face="Arial">Classification Tool Monthly Statistics Report By Index</font></h1>

<?php

/* this counts by index then asset type - used to summarize what was changed in an index.  Example:
   How many articles were revised or newly classified within the subject index for all products? */
$counterIndexData = array();

/* this counts by index, by product, by asset type - used to summarize the counts of changed assets within a product by index. 
   Example: How many articles were newly classified or revised classified within the subject index, for the gme product? */
$counterProductData = array();

/* what indexes should be displayed? */
$indexesToDisplay = array();

/*should all indexes be displayed? */
if($_GET['displayindex'][0] == 'all') {
	$indexesToDisplay = $indexOrder;
}
else {
	$indexesToDisplay = $_GET['displayindex'];
}

//~CM bug check
//var_dump($indexesToDisplay);
//echo "</pre>\n";			
//echo "<hr>";


foreach($indexesToDisplay as $indexType) {
	?>
	<!-- report for the index -->
	<p align="center"><font face="Arial" size="4">[<?php echo $indexDescriptions[$indexType];?>]</font></p>
	<p align="center"><font face="Arial"><b><u>Start Date:</u>
	<!-- the start and end dates -->
	[<?php echo $startDateDescription;?>]&nbsp;&nbsp; <u>End Date:</u> [<?php echo $endDateDescription;?>]</b></font></p>
	<?php
	foreach($myProducts as $productID => $productDescription) {
		/* get the new classfied and revised classified queries back to execute for a given index and product */
		
		$preparedIndexQueries = prepareIndexQueries($indexQueries, $productID, $indexType);
		
		/* get the newly classified query for this index and product */
		$newIndexQuery = $preparedIndexQueries['new'];
		
		/* get the revised classfied query for this index and product */
		$revisedIndexQuery = $preparedIndexQueries['revised'];
		
		/* ~CM 5/14/04	- Get the unclassified query for this index and product */
		$unclassifiedIndexQuery = $preparedIndexQueries['unclassified'];

		
		//echo "<hr>";
		//echo "<pre>\n";
		//print_r($preparedIndexQueries);
		//	echo "</pre>\n";
		
		/* get the results of the newly classified assets within this index and product.
		   The results are grouped by Username, AssetType.
		   The result set is:  Username|AssetType|Count */		   
		$myNewIndexQueryObject = new GI_DBQuery($newIndexQuery, $myDatabase);
		$myNewIndexQueryObject->ExecuteQuery();

		/* get the results of the revised classified assets within this index and product.
		   The results are grouped by Username, AssetType.
		   The result set is:  Username|AssetType|Count */
		$myRevisedIndexQueryObject = new GI_DBQuery($revisedIndexQuery, $myDatabase);
		$myRevisedIndexQueryObject->ExecuteQuery();

		/* ~CM 5/14/04	- get the results of the unclassified assets within this index and product.
		   The results are grouped by Count and AssetType.
		   The result set is:  AssetType|Count */
		$myUnclassifiedIndexQueryObject = new GI_DBQuery($unclassifiedIndexQuery, $myDatabase);
		$myUnclassifiedIndexQueryObject->ExecuteQuery();
		
		/* this is the temporary data needed for this product within the current index */
		$tempCountData = array();
		$currentUser = '';
				
		//echo "<pre>New<br>\n";
		while($myRow = $myNewIndexQueryObject->NextRow()) {				
			$userName = $myRow['LMB'];
			$assetType = $myRow['ASSET_TYPE'];
			$count = $myRow['RECORDCOUNT'];

			/* set the product summary counts by asset type */
			if(!isset($counterProductData[$productID][$indexType][$assetType])) 
			{
// ~CM 5/14/04	add unclassified member to value
//				$counterProductData[$productID][$indexType][$assetType] = array('new' => $count, 'revised' => 0);
				$counterProductData[$productID][$indexType][$assetType] = array('new' => $count, 'revised' => 0, 'unclassified' => 0);
			}
			else 
			{
				$counterProductData[$productID][$indexType][$assetType]['new'] += $count;
			}


			/* set the index summary counts by index type, by asset type */
			if(!isset($counterIndexData[$indexType][$assetType])) 
			{
// ~CM 5/14/04	add unclassified member to value
//				$counterIndexData[$indexType][$assetType] = array('new' => $count, 'revised' => 0);
				$counterIndexData[$indexType][$assetType] = array('new' => $count, 'revised' => 0, 'unclassified' => 0);
			}
			else 
			{
				$counterIndexData[$indexType][$assetType]['new'] += $count;
			}
		
		
			/* set the index counts */
			if(!isset($tempCountData[$userName][$assetType])) 
			{
				$tempCountData[$userName][$assetType] = array('new' => 0, 'revised' => 0);
			}

			/* set the index counts by user, then by type with new / revised */				
			$tempCountData[$userName][$assetType]['new'] = $count;

		}
		//echo "</pre>\n";
		
		//echo "Revised<br>\n";
		while($myRow = $myRevisedIndexQueryObject->NextRow()) {
			$userName = $myRow['LMB'];
			$assetType = $myRow['ASSET_TYPE'];
			$count = $myRow['RECORDCOUNT'];

			/* set the product summary counts by asset type */
			if(!isset($counterProductData[$productID][$indexType][$assetType])) 
			{
// ~CM 5/14/04	add unclassified member to value
//				$counterProductData[$productID][$indexType][$assetType] = array('new' => 0, 'revised' => $count);
				$counterProductData[$productID][$indexType][$assetType] = array('new' => 0, 'revised' => $count, 'unclassified' => 0);
			}
			else 
			{
				$counterProductData[$productID][$indexType][$assetType]['revised'] += $count;
			}


			/* set the index summary counts by product, by asset type */
			if(!isset($counterIndexData[$indexType][$assetType])) 
			{
// ~CM 5/14/04	add unclassified member to value
//				$counterIndexData[$indexType][$assetType] = array('revised' => $count, 'new' => 0);
				$counterIndexData[$indexType][$assetType] = array('revised' => $count, 'new' => 0, 'unclassified' => 0);
			}
			else 
			{
				$counterIndexData[$indexType][$assetType]['revised'] += $count;
			}

			/* set the index counts */
			if(!isset($tempCountData[$userName][$assetType])) 
			{
				$tempCountData[$userName][$assetType] = array('new' => 0, 'revised' => 0);
			}

			/* set the index counts by user, then by type with new / revised */
			$tempCountData[$userName][$assetType]['revised'] = $count;
		}

		/* ~CM 5/14/04	count 'em up */
		//echo "unclassified<br>\n";
		while($myRow = $myUnclassifiedIndexQueryObject->NextRow())
		{
			$assetType = $myRow['UCA_ASSET_TYPE'];
			$count = $myRow['UCA_COUNT'];

			/* set the product summary counts by asset type */
			if(!isset($counterProductData[$productID][$indexType][$assetType]))
			{
				$counterProductData[$productID][$indexType][$assetType] = array('new' => 0, 'revised' => 0, 'unclassified' => $count );
			}
			else
			{
				$counterProductData[$productID][$indexType][$assetType]['unclassified'] = $count;
			}

			/* set the index summary counts by product, by asset type */
			if(!isset($counterIndexData[$indexType][$assetType]))
			{
				$counterIndexData[$indexType][$assetType] = array( 'new' => 0, 'revised' => 0, 'unclassified' => $count);
			}
			else 
			{
				$counterIndexData[$indexType][$assetType]['unclassified'] += $count;
			}
		
		}


		//var_dump($tempCountData);
		//echo "</pre>\n";			
		//echo "<hr>";
		?>
		
		<p align="left"><u><font face="Arial"><?php echo $myProducts[$productID];?></font></u></p>
		
		
		<?php
//		var_dump($counterProductData);
//		echo "</pre>\n";			
//		echo "<hr>";

//~CM 5/20/04 need a table to display unclassifieds even though there may not be any new or revised classifieds
//		if(count($tempCountData) == 0 ) 
	if( $indexType == 'ebsco' )
	{
//		var_dump($counterProductData[$productID] );
//		echo "</pre>\n";			
//		echo "<hr>";
		
//		echo count($tempCountData);
	}
	
		$ContinueFlag = true;
		if( count($tempCountData) == 0 )
			$ContinueFlag = false;
		else if(!array_key_exists( $productID, $counterProductData )  )	
			$ContinueFlag = false;
		else if(!array_key_exists( $indexType, $counterProductData[$productID] )  )	
			$ContinueFlag = false;

		if( $ContinueFlag == false )
		{
		?>
			<center>
			<div align="left">
			<table border="0" width="55%" bordercolorlight="#FFFFFF" bordercolordark="#000000">
				<!-- no activity for this product -->
				<tr>
					<td width="100%" align="center" height="19"><b>No Activity During this Period</b>
						<hr width="60%" size="4" color="#C0C0C0" align="center">
					</td>
				</tr>
			</table>
			</div>
			
			<!-- ~CM 5/7/04 a little more of the same spacing between tables and dividers -->
			<p align="left">&nbsp;</p>

			</center>
		<?php
		}
		else 
		{					
		?>
			  <center>
			  <div align="left">
			  <table border="1" width="65%">
				    <tr>
				      <td width="20%" align="center" height="19"><b>Editor</b></td>
				      <td width="20%" align="center" height="19"><b>Asset Type</b></td>
				      <td width="20%" align="center" height="19"><b>Revised Classified</b></td>
				      <td width="20%" align="center" height="19"><b>Newly Classified</b></td>
			    <!-- ~CM 5/7/04 New 'To Be Classified' column requested by editors -   columns were previously a width of 25% -->
				      <td width="20%" align="center" height="19"><b>To Be Classified</b></td>
				    </tr>
				
				    <!-- a record for each user -->
					
				    <?php
				    $currentUserName = '';
				    
				    /* sort the output by username ASC (A to Z) */
				    ksort($tempCountData);			    
				    foreach($tempCountData as $userName => $assetData) {
				    	foreach($assetData as $assetType => $assetCounts) {
					?>			    		
						    <tr>
						      <?php
						      if($currentUserName != $userName) {
						      		$currentUserName = $userName;
						      		?><td width="20%" height="18" valign="top" rowspan="<?php echo count($assetData);?>"><b><?php echo $userName;?></b></td>
						      		
						      <?php
						      }
						      ?>
					      <!- ~CM even though no data here, we need to modify width so that '2bc' column is the same -->
						      <td width="20%" height="18"><?php echo $myAssetTypes->getLongDesc($assetType);?></td>
						      <td width="20%" height="18"><?php echo $assetCounts['revised'];?></td>
						      <td width="20%" height="18"><?php echo $assetCounts['new'];?></td>

						    </tr>
				    	<?php	
				    		
				    	}
				    }
				    ?>
				
				    </center>

				    
				<!-- SUBTOTAL of revised and new assets by grouped by asset type for the index -->
	
				    <?php
				    	foreach($counterProductData[$productID][$indexType] as $assetType => $assetCounts) 
				    	{
				    ?>
						<tr>
							<td width="40%" colspan="2" height="19">
							<p align="right"><b>Subtotal <?php echo $myAssetTypes->getLongDesc($assetType);?>:</b></td>
							<center>
							<td width="20%" height="19"><?php echo $assetCounts['revised'];?></td>
							<td width="20%" height="19"><?php echo $assetCounts['new'];?></td>
					    <!-- ~CM 5/7/04 New 'To Be Classified' column requested by editors - above col width modified appropriately  -->
							<td width="20%" height="19"><?php echo $assetCounts['unclassified'];?></td>

						</tr>
				   	<?php
						}
					?>
				    </table>
					</div>
					</center>

	<!-- ~CM 5/7/04 Added left alignment for the dividers  -->
			<div align="left">
			<table border="0" width="55%">
				 <tr>
					<td width="100%"><hr width="60%" size="4" color="#C0C0C0" align="center"></td>
				 </tr>
			</table>
			</div>
			<p align="left">&nbsp;</p>
			 <?php
		}
	}



	/* check to see if there is SUMMARY data for this index */
	if (array_key_exists($indexType, $counterIndexData)) {
	?>

		<p>&nbsp;</p>

	<!-- ~CM 5/7/04 just added a Header  -->
		<p align="center"><u><font face="Arial" size="4">Summary</font></u></p>
		
		<table border="1" width="55%" align="center">
			  <tr>
			    <td width="25%"><b><u>Totals by Asset Type</u></b></td>
			    <td width="25%"><b>Revised Classified</b></td>
			    <td width="25%"><b>Newly Classified</b></td>
	<!-- ~CM 5/7/04 New 'To Be Classified' column requested by editors - modified columns above from 33% width to 25%  -->
			    <td width="25%"><b>To Be Classified</b></td>
			  </tr>
	
			  <!-- summary for the product by asset type -->
			  <?php
  
			  foreach($counterIndexData[$indexType] as $assetType => $assetData) {
			  ?>
				  <tr>
				    <td width="25%"><b><?php echo $myAssetTypes->getLongDesc($assetType)?></b></td>
				    <td width="25%"><?php echo $assetData['revised'];?></td>
				    <td width="25%"><?php echo $assetData['new'];?></td>
	    <!-- ~CM 5/7/04 New 'To Be Classified' column requested by editors - modified columns above from 33% width to 25%  -->
				    <td width="25%"><?php echo $assetData['unclassified'];?></td>
				  </tr>
			  <?php
			  }
		  	  ?>
	  	</table>							
	  	
		<p>&nbsp;</p>

	  	<?php
	}
	?>
	<hr width="100%" size="4" color="#C0C0C0" align="center">
	<br>
	<?php
}
//echo "<pre>\n";
//var_dump($counterIndexData);
//echo "</pre>\n";
?>


</body>

</html>
	