<br>
<label for="quicksearch"></label><input type="radio" id="quicksearch" value="cumbre" name="<?php echo $productGroup ?>" checked>La&nbsp;Nueva&nbsp;Encic.&nbsp;Cumbre&nbsp;Only<br>
<label for="quicksearch"></label><input type="radio" id="quicksearch" value="student" name="<?php echo $productGroup ?>">Aula de espa&ntilde;ol&nbsp;Only</p></td>
<input type="hidden" name="setchoice1" value="">
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
			document.searchForm.setchoice1.value = "c";
			document.searchForm.action = "<?php echo $searchBaseHref ?>/<?php echo $curr_product_id_ver ?>/cumbre/results.jsp";
			document.searchForm.target = "mainframe";
			return true;
		}
		else if (document.searchForm.<?php echo $productGroup ?>[2].checked) {
			document.searchForm.setchoice1.value = "s";
			document.searchForm.action = "<?php echo $searchBaseHref ?>/<?php echo $curr_product_id_ver ?>/student/results.jsp";
			document.searchForm.target = "mainframe";
			return true;
		}
		else {
			return false;
		}
		
	} 
   </script>
