<?php

putenv('PHP_SCRIPTS_HOME=/data/rps/scripts/php');

/* get the common report compnonents */
require_once('includes/common-reports.php');

/* the user has selected all products , which is the first choice */
if($_GET['product'][0] == 'all') {
	/* the query to the database should get a list of all products, ordered by their description A-Z */
	$myProductQuery = "select * from classdbm.products order by description ASC";
}
else {
	/* the user has made one or more product selections on the selector page 
		build a sql query to get those products and their descriptions
		from the database */
	$theProducts = $_GET['product'];
	$myProductQuery = "select * from classdbm.products where product_id in (";
	for($i=0; $i < count($theProducts); $i++) {
		/* build the product list as ('product1', 'product2') */
		$myProductQuery .= "'" . $theProducts[$i] . "'"; 
		if($i != count($theProducts)-1) {
			$myProductQuery .= ",";
		}
	}
	
	$myProductQuery .= ") order by description ASC";
}

/* get the list of products from the database, based on the selections the user made */
$myProductQueryObject = new GI_DBQuery($myProductQuery, $myDatabase);
$myProductQueryObject->ExecuteQuery();
	
?>

<html>

<head>
<title>Classification Tool Monthly Statistics Report By Product</title>
</head>

<body>

<!-- the heading of the page -->
<h1 align="center"><font face="Arial">Classification Tool Monthly Statistics
Report By Product</font></h1>

<?php

$counterIndexData = array();
$counterProductData = array();

/* loop through each product selected */
while($myProduct = $myProductQueryObject->NextRow()) {
	$productID = $myProduct['PRODUCT_ID'];
	$productDescription = $myProduct['DESCRIPTION'];
		
	?>
	<!-- report for the product -->
	<p align="center"><font face="Arial" size="4">[<?php echo $productDescription;?>]</font></p>
	<p align="center"><font face="Arial"><b><u>Start Date:</u>
	<!-- the start and end dates -->
	[<?php echo $startDateDescription;?>]&nbsp;&nbsp; <u>End Date:</u> [<?php echo $endDateDescription;?>]</b></font></p>
	
	<?php
		foreach($indexOrder as $indexType) 
		{			
//~CM 5/20/04 testing
//var_dump($indexType);
//echo "</pre>\n";			
//echo "<hr>";

			
			
			$preparedIndexQueries = prepareIndexQueries($indexQueries, $productID, $indexType);
			$newIndexQuery = $preparedIndexQueries['new'];
			$revisedIndexQuery = $preparedIndexQueries['revised'];
			/* ~CM 5/20/04	- Get the unclassified query for this index and product */
			$unclassifiedIndexQuery = $preparedIndexQueries['unclassified'];

			//echo "<hr>";
			//echo "<pre>\n";
			//print_r($preparedIndexQueries);
			//	echo "</pre>\n";
			
			$myNewIndexQueryObject = new GI_DBQuery($newIndexQuery, $myDatabase);
			$myNewIndexQueryObject->ExecuteQuery();

			$myRevisedIndexQueryObject = new GI_DBQuery($revisedIndexQuery, $myDatabase);
			$myRevisedIndexQueryObject->ExecuteQuery();
			
			/* ~CM 5/20/04	- get the results of the unclassified assets within this index and product.
			The results are grouped by Count and AssetType.
			The result set is:  AssetType|Count */
			$myUnclassifiedIndexQueryObject = new GI_DBQuery($unclassifiedIndexQuery, $myDatabase);
			$myUnclassifiedIndexQueryObject->ExecuteQuery();


			$tempCountData = array();
			$currentUser = '';
					
			//echo "<pre>New<br>\n";
			while($myRow = $myNewIndexQueryObject->NextRow()) {				
				$userName = $myRow['LMB'];
				$assetType = $myRow['ASSET_TYPE'];
				$count = $myRow['RECORDCOUNT'];

				/* set the index summary counts by asset type */
				if(!isset($counterIndexData[$productID][$indexType][$assetType]))
				{
// ~CM 5/20/04	add unclassified member to value
//					$counterIndexData[$productID][$indexType][$assetType] = array('new' => $count, 'revised' => 0);
					$counterIndexData[$productID][$indexType][$assetType] = array('new' => $count, 'revised' => 0, 'unclassified' => 0);
				}
				else {
					$counterIndexData[$productID][$indexType][$assetType]['new'] += $count;
				}


				/* set the product summary counts by product, by asset type */
				if(!isset($counterProductData[$productID][$assetType])) 
				{
// ~CM 5/20/04	add unclassified member to value
//					$counterProductData[$productID][$assetType] = array('new' => $count, 'revised' => 0);
					$counterProductData[$productID][$assetType] = array('new' => $count, 'revised' => 0, 'unclassified' => 0);
				}
				else 
				{
					$counterProductData[$productID][$assetType]['new'] += $count;
				}
			
			
				/* set the index counts */
				if(!isset($tempCountData[$userName][$assetType])) {
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

				/* set the index summary counts by asset type */
				if(!isset($counterIndexData[$productID][$indexType][$assetType]))
				{
// ~CM 5/20/04	add unclassified member to value
//					$counterIndexData[$productID][$indexType][$assetType] = array('new' => 0, 'revised' => $count);
					$counterIndexData[$productID][$indexType][$assetType] = array('new' => 0, 'revised' => $count, 'unclassified' => 0);
				}
				else
				{
					$counterIndexData[$productID][$indexType][$assetType]['revised'] += $count;
				}


				/* set the product summary counts by product, by asset type */
				if(!isset($counterProductData[$productID][$assetType])) 
				{
// ~CM 5/20/04	add unclassified member to value
//					$counterProductData[$productID][$assetType] = array('revised' => $count, 'new' => 0);
					$counterProductData[$productID][$assetType] = array('revised' => $count, 'new' => 0, 'unclassified' => 0);
				}
				else 
				{
					$counterProductData[$productID][$assetType]['revised'] += $count;
				}

			
				/* set the index counts */
				if(!isset($tempCountData[$userName][$assetType])) 
				{
					$tempCountData[$userName][$assetType] = array('new' => 0, 'revised' => 0);
				}

				/* set the index counts by user, then by type with new / revised */
				$tempCountData[$userName][$assetType]['revised'] = $count;
			}
	
			/* ~CM 5/20/04	count 'em up */
			//echo "unclassified<br>\n";
			while($myRow = $myUnclassifiedIndexQueryObject->NextRow())
			{
				$assetType = $myRow['UCA_ASSET_TYPE'];
				$count = $myRow['UCA_COUNT'];
				
				if(!isset($counterIndexData[$productID][$indexType][$assetType]))
				{
					$counterIndexData[$productID][$indexType][$assetType] = array('new' => 0, 'revised' => 0, 'unclassified' => $count);
				}
				else
				{
					$counterIndexData[$productID][$indexType][$assetType]['unclassified'] = $count;
				}


				/* set the product summary counts by product, by asset type */
				if(!isset($counterProductData[$productID][$assetType])) 
				{
					$counterProductData[$productID][$assetType] = array('revised' => 0, 'new' => 0, 'unclassified' => $count);
				}
				else 
				{
					$counterProductData[$productID][$assetType]['unclassified'] += $count;
				}
			}


			//var_dump($tempCountData);
			//echo "</pre>\n";			
			//echo "<hr>";
			?>
			
			<p align="left"><u><font face="Arial"><?php echo $indexDescriptions[$indexType];?></font></u></p>
			
			<?php
//~CM 5/20/04 need a table to display unclassifieds even though there may not be any new or revised classifieds
//			if(count($tempCountData) == 0) 
			if( count($tempCountData) == 0 && !array_key_exists( $indexType, $counterIndexData[$productID] ) ) 
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
				
			<!-- ~CM 5/14/04 a little more of the same spacing between tables and dividers -->
			<p align="left">&nbsp;</p>

				</center>
			<?php
			}
			else {					
			?>
				  <center>
				  <div align="left">
				  <table border="1" width="65%">
					    <tr>
					      <td width="20%" align="center" height="19"><b>Editor</b></td>
					      <td width="20%" align="center" height="19"><b>Asset Type</b></td>
					      <td width="20%" align="center" height="19"><b>Revised Classified</b></td>
					      <td width="20%" align="center" height="19"><b>Newly Classified</b></td>
			    <!-- ~CM 5/14/04 New 'To Be Classified' column requested by editors -   columns were previously a width of 25% -->
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
							      
							      <!- ~CM 5/14/04 even though no data here, we need to modify width so that '2bc' column is the same 25% to 20%-->
							      <?php
							      if($currentUserName != $userName) {
							      		$currentUserName = $userName;
							      		?><td width="20%" height="18" valign="top" rowspan="<?php echo count($assetData);?>"><b><?php echo $userName;?></b></td>
                                  <?php
							      }
							      ?>
					      		
					      
							      <td width="20%" height="18"><?php echo $myAssetTypes->getLongDesc($assetType);?></td>
							      <td width="20%" height="18"><?php echo $assetCounts['revised'];?></td>
							      <td width="20%" height="18"><?php echo $assetCounts['new'];?></td>
							    </tr>
					    	<?php	
					    		
					    	}
					    }
					    ?>
					
					  </center>
						<!-- subtotal of revised and new assets by grouped by asset type -->
		
					    <?php
					    	foreach($counterIndexData[$productID][$indexType] as $assetType => $assetCounts) {
					    ?>
							    <tr>
							      <td width="40%" colspan="2" height="19">
							        <p align="right"><b>Subtotal <?php echo $myAssetTypes->getLongDesc($assetType);?>:</b></td>
							  <center>
							      <td width="20%" height="19"><?php echo $assetCounts['revised'];?></td>
							      <td width="20%" height="19"><?php echo $assetCounts['new'];?></td>
						    <!-- ~CM 5/20/04 New 'To Be Classified' column requested by editors - above col width modified appropriately  -->
								  <td width="20%" height="19"><?php echo $assetCounts['unclassified'];?></td>
							      
							    </tr>
					   	<?php
						}
						?>
				  </table>
				  </div>
				  </center>
				  
		<!-- ~CM 5/14/04 Added left alignment for the dividers  -->
				  <div align="left">
				  <table border="0" width="55%">
					<tr>
						<td width="100%"><hr width="65%" size="4" color="#C0C0C0" align="center"></td>
					</tr>
				  </table>
	              </div>
				  <p align="left">&nbsp;</p>
				
				<?php
			}
		}
//echo "<pre>\n";
//var_dump($counterProductData);
//echo "</pre>\n";

		/* check to see if their is summary data for this product */
		if (array_key_exists($productID, $counterProductData)) {
	?>
			<p>&nbsp;</p>
			
	<!-- ~CM 5/14/04 just added a Header  -->
			<p align="center"><u><font face="Arial" size="4">Summary</font></u></p>
			
	<!-- ~CM 5/14/04 added center align like the Index  -->
			<table border="1" width="55%" align="center">
			  <tr>
			    <td width="25%"><b><u>Totals by Asset Type</u></b></td>
			    <td width="25%"><b>Revised Classified</b></td>
			    <td width="25%"><b>Newly Classified</b></td>
	<!-- ~CM 5/14/04 New 'To Be Classified' column requested by editors - modified columns above from 33% width to 25%  -->
			    <td width="25%"><b>To Be Classified</b></td>

			  </tr>
	
			  <!-- summary for the product by asset type -->
			  <?php
			  foreach($counterProductData[$productID] as $assetType => $assetData) {
			  ?>
				  <tr>
				    <td width="25%"><b><?php echo $myAssetTypes->getLongDesc($assetType)?></b></td>
				    <td width="25%"><?php echo $assetData['revised'];?></td>
				    <td width="25%"><?php echo $assetData['new'];?></td>
	    <!-- ~CM 5/14/04 New 'To Be Classified' column requested by editors - modified columns above from 33% width to 25%  -->
				    <td width="25%"><?php echo $assetData['unclassified'];?></td>
				  </tr>
			  <?php
			}
		  	?>
		  	</table>							
		  	<?php
		  }
		  ?>
		

<hr width="100%" size="4" color="#C0C0C0" align="center">
	
<?php
}
?>

</body>

</html>
	