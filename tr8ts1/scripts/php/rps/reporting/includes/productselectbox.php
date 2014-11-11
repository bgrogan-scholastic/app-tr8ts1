			<p><b>3) Please Select a Product</b></p>

			<select name="product[]" size="12" multiple>
				<option selected value="all">All Products</option>
				<?php
					/* get the products list from the database */
					$myQueryObject = new GI_DBquery("select * from classdbm.products order by DESCRIPTION", $myDatabase);	
					$myQueryObject->ExecuteQuery();
					
					/* loop through the result set and output each product and its description */
					while($productRow = $myQueryObject->NextRow()) {
						?>
							<option value="<?php echo $productRow['PRODUCT_ID'];?>"><?php echo $productRow['DESCRIPTION'];?></option>
						<?php	      		
					}	
				?>
			</select>
