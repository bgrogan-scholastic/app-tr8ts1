<br>
<label for="quicksearch"></label><input type="radio" id="quicksearch" value="<?php echo $curr_product_id_ver ?>" name="<?php echo $productGroup ?>" checked>Encyclopedia&nbsp;Americana&nbsp;Only</p>

</td>
</tr>
</table>
</form>
</div>

    <Script language="javascript">
	function doSearch() {
		if (document.searchForm.<?php echo $productGroup ?>[0].checked) {
			document.searchForm.action = "<?php echo $searchBaseHref ?>/go2-<?php echo FRAME_TYPE ?>/results_articles.jsp";
			document.searchForm.target = "mainframe";
			return true;
		}
		else if (document.searchForm.<?php echo $productGroup ?>[1].checked) {
			document.searchForm.action = "<?php echo $searchBaseHref ?>/<?php echo $curr_product_id_ver ?>/results.jsp";
			document.searchForm.target = "mainframe";
			return true;
		}
		else {
			return false;
		}		
	} 
   </script>
