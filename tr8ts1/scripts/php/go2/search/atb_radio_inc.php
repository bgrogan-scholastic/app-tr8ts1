<?php

/* extract value from atb state cookie - which is set in main frame on any ATB page (right Chuck?) */

$stateCookieVal = "";
$atbOptions = $_COOKIE["atbOptions"];
$atbPairs = explode('|', $atbOptions);
if (count($atbPairs) >= 2) {
	foreach ($atbPairs as $myCookiePair) {
		/* split stateId>Y into 'stateId' => Y */
		$myCookiePieces = explode('>', $myCookiePair);
		if (count($myCookiePieces) == 2) {
			if ($myCookiePieces[0] == "stateId") {
				$stateCookieVal = $myCookiePieces[1];
				break;
			}
		}
	}
}

/* split current location href on "?" first, then "&", then "=" 
   (TB - 5/17/2005: this is no longer used since we get clhref from Javascript
                    to fix Mac bug) */

	$stateIdParameterPair = "";
	$stateIdParameterName = "";
	$stateIdParameterValue = "";
	$clhref = $auth_preferences->getPreference(GI_AUTH_USER_CURRENTHREF);
	$urlSplit = explode('?', $clhref);
	if (count($urlSplit) == 2) {
		$parameterPairs = explode('&', $urlSplit[1]);
		foreach ($parameterPairs as $myParameterPair) {
			/* split name=value into 'name' => value */
			$nameValuePair = explode('=', $myParameterPair);
			
			if ($nameValuePair[0] == "stateid" && count($nameValuePair) == 2) {
				$stateIdParameterPair = $myParameterPair;
				$stateIdParameterName = $nameValuePair[0];
				$stateIdParameterValue = $nameValuePair[1];
			}
		}
	}

?>
<br>
<?php if ($stateCookieVal == "Y") {  ?>
<label for="quicksearch"></label><input type="radio" id="quicksearch" value="<?php echo $curr_product_id_ver ?>" name="<?php echo $productGroup ?>" checked>America&nbsp;The&nbsp;Beautiful&nbsp;Only<br>
<label for="quicksearch"></label><input type="radio" id="quicksearch" value="<?php echo $stateIdParameterName ?>" name="<?php echo $productGroup ?>">Search&nbsp;This&nbsp;State&nbsp;Only</p>
<?php } else { ?>
<label for="quicksearch"></label><input type="radio" id="quicksearch" value="<?php echo $curr_product_id_ver ?>" name="<?php echo $productGroup ?>" checked>America&nbsp;The&nbsp;Beautiful&nbsp;Only</p>
<?php } ?>
<input type="hidden" name="state" value=""/>
</td>
</tr>
</table>
</form>
</div>

    <Script language="javascript">
    
    	var phpInitState = "<?php echo $stateCookieVal ?>";
	if (phpInitState.length == 0) {
		// 2365: if at first you don't succeed getting state cookie value, try, try again
		for (var i=0; i<1000; i++) {
		} // delay loop to let main frame finish loading ATB page and set cookie
		document.location.href = window.location;  // reload search frame again with same URL
	}

	function doSearch() {
		if (document.searchForm.<?php echo $productGroup ?>[0].checked) {
			document.searchForm.action = "<?php echo $searchBaseHref ?>/go2-<?php echo FRAME_TYPE ?>/results_articles.jsp";
			document.searchForm.target = "mainframe";
			return true;
		}
		else if (document.searchForm.<?php echo $productGroup ?>[1].checked) {
			document.searchForm.state.value = "";
			document.searchForm.action = "<?php echo $searchBaseHref ?>/<?php echo $curr_product_id_ver ?>/results.jsp";
			document.searchForm.target = "mainframe";
			return true;
		}
<?php if ($stateCookieVal == "Y") {  ?>
		else if (document.searchForm.<?php echo $productGroup ?>[2].checked) {
			document.searchForm.state.value = getStateIdInHref(initLHref);
			document.searchForm.action = "<?php echo $searchBaseHref ?>/<?php echo $curr_product_id_ver ?>/results.jsp";
			document.searchForm.target = "mainframe";
			return true;
		}
<?php } ?>
		else {
			return false;
		}
	}

	//alert(theCookie.GetCookie("atbOptions"));
	atbStateCookie = new cookiemanager("atbOptions");
	initState = atbStateCookie.getSingleValue(kCurrState);

	//Debug alerts
	//alert("After Initialization\n Previous state = " + initState + "\nCurrent state = " + atbStateCookie.getSingleValue(kCurrState));
	//alert("Cookie\nPrevious = " + theCookie.GetCookie(kPreviousProduct) + ", Current = " + theCookie.GetCookie(kCurrentProduct));
	
	//alert("JavaScript StateId: " + getStateIdInHref(initLHref));
	//alert("PHP StateId: " + getStateIdInHref('<?php echo $clhref ?>'));	
	//alert("PHP State Cookie Value at load: " + phpInitState);
	//alert("JS State Cookie Value at load: " + initState);
	
   </script>
