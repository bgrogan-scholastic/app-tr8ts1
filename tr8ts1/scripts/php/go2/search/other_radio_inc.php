</p>
</td>
</tr>
</table>
</form>
</div>

    <Script language="javascript">
    	function doSearch() {
		document.searchForm.action = "<?php echo $searchBaseHref ?>/go2-<?php echo FRAME_TYPE ?>/results_articles.jsp";
		document.searchForm.target = "mainframe";
		return true;
	} 
   </script>
