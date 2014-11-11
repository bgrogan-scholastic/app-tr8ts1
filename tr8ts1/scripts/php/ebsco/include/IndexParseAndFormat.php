<?php
	require_once('EbParseAndFormat.php');


#+******************************************************************
# Class      : IndexParseAndFormat
# Method     :
# Created    : Richard E. Dye
# Date       : 9/26/2003
#
# Comment    : Derived from the EbParseAndFormat base class, this
#					class will parse and format an Ebsco index page.
#
# Revisions  :
#
# *****************************************************************-*/
   class IndexParseAndFormat extends EbParseAndFormat
   {


#+******************************************************************
# Class      : IndexParseAndFormat
# Method     : _parseXMLDocument
# Created    : Richard E. Dye
# Date       : 9/26/2003
#
# Comment    : An implementation of the Template of 'Hollywood' pattern,
#					this method is called by the base class's 'parseXMLDocument'
#					method after error checking.
#					In most languages, it would have to have been declared as
#					a pure virtual method in the base class, but PHP doesn't
#					really care.
#
# visibility :	private
#
# Parameters :
# string			$inXMLdocument		The XML document to parse
#
# Returns    :
# string									The formatted HTML
#
# Revisions  :
#
# *****************************************************************-*/
      function _parseXMLDocument($inXMLdocument)
      {
      	$records = $this->GetAttributesByName($inXMLdocument, 'records');
			if($records === false)
				return "<p>Unable to read records attributes</p>\n";

			$outstring = "";

			$numrecs = $records['count'];
			if($numrecs)
			{
				for($recnum=1; $recnum<=$numrecs; $recnum++)
				{
					$node = $this->GetElementByName($inXMLdocument, 'rec', $recnum);

					if($node === false)
					{
						$outstring .= "<p>Error retrieving information about article #$recnum</p>\n\n";
					} else {
						$outstring .= "<p>$recnum) \n\n";
						$outstring .= $node;
						$outstring .= "\n\n</p>\n";
					}
				}
			}
			return $outstring;
      }





	}

?>
