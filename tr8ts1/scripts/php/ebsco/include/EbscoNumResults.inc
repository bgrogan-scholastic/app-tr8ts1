<?php
#+******************************************************************
# Class      : EbscoNumResults
# Method     :
# Created    : Todd A. Reisel
# Date       : 3/7/2005
#
# Comment    : Derived from the EbParseAndFormat base class, this
#					class will parse and format an Ebsco index page.
#
# Revisions  :
# *****************************************************************-*/

class EbscoNumResults {
	// the number of results to show on a page
	var $numresults = array(
		'go2-kids'	=> 10,
		'go2-passport'	=> 10
		);

	function EbscoNumResults() { }

	function getValue($product) {

		/* default to 15 results per page, if a product does not override this setting */
		if (array_key_exists($product, $this->numresults) == TRUE) {
			return $this->numresults[$product];
		}
		else {
			return 15;
		}
	}
}

?>
