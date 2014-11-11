<?php

#+******************************************************************
# Class      : EbParseAndFormat
# Method     :
# Created    : Richard E. Dye
# Date       : 9/25/2003
#
# Comment    : A control base class for parsing an XML document retrieved
#					from Ebsco.  Actual parsing would be done by derived
#					index and entry parsing derived classes, but the base
#					class will contain common code and class data.
#
# Revisions  :
#
# *****************************************************************-*/
   class EbParseAndFormat
   {


#+******************************************************************
# Class      : EbParseAndFormat
# Method     : parseXMLDocument
# Created    : Richard E. Dye
# Date       : 9/25/2003
#
# Comment    : This uses the template, or 'Hollywood' pattern.
#					It checks for an error tag before calling the
#					derived class's _parseXMLDocument method.
#
# visibility :	public
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
      function parseXMLDocument($inXMLdocument)
      {
      	$error = $this->GetElementByName($inXMLdocument, 'errors');
      	if($error)
				return "<p>Error!</p>\n<p>$error</p>\n";

			return $this->_parseXMLDocument($inXMLdocument);
      }


#+******************************************************************
# Class      : EbParseAndFormat
# Method     : GetElementByName
# Created    : Richard E. Dye
# Date       : 9/25/2003
#
# Comment    : Given an XML tag, find the contents of passed XML
#					between the open and close of this tag, not including
#					the tag itself.
#					If the tag occurs more than once in the document, only
#					the contents of the first one will be returned.
#					example: $tagcontents = GetElementByName($myXML, 'tagname');
#
#					Returns 'false' if the tag is not found.
#						use   if($returnvalue === false)'   to check.
#
# visibility :	private
#
# Parameters :
# string			$inxml				The XML to parse
# string			$intag				the tag to look for (with no angle brackets!)
# number			$incount				Which occurance to retrieve.
#
# Returns    :
# string									contents of the tag, or boolean false
#
# Revisions  : 9/29/2003: R.E. Dye - Made the opening tag match a little more
# particular, so it wouldn't match '<record' when it was looking for '<rec'.
#
# *****************************************************************-*/
		function GetElementByName ($inxml, $intag, $incount=1)
		{
			if($inxml == "" || $intag == "" || $incount < 1)
				return false;

			$startpos=0;

			while($incount)
			{
				$startpos = strpos($inxml, '<'.$intag, $startpos);
				if ($startpos === false)
					return false;

				$testchar = substr($inxml, $startpos+strlen($intag)+1, 1);
				if($testchar != ' ' && $testchar != '>')
				{
					$startpos++;
					continue;
				}

				$startpos = strpos($inxml, '>', $startpos)+1;

				$incount --;
			}

				return substr($inxml, $startpos, strpos($inxml, '</'.$intag.'>', $startpos)-$startpos);
		}





#+******************************************************************
# Class      : EbParseAndFormat
# Method     : GetAttributesByName
# Created    : Richard E. Dye
# Date       : 9/26/2003
#
# Comment    : Given an XML tag, find the attributes of this tag in
#					the passed XML document, returning them as an
#					associative array.
#
#					Returns 'false' if the tag is not found.
#						use   if($returnvalue === false)'   to check.
#
# visibility :	private
#
# Parameters :
# string			$inxml				The XML to parse
# string			$intag				the tag to look for (with no angle brackets!)
# number			$incount				Which occurance to retrieve.
#
# Returns    :
# array									attributes of the tag, or boolean false
#
# Revisions  : 9/29/2003: R.E. Dye - Modified to have a count, and to make
# sure it matches only the exact tag (ie 'rec' and not 'record').
#
# *****************************************************************-*/
		function GetAttributesByName ($inxml, $intag, $incount=1)
		{
			$startstr = '<'.$intag;
			$startpos = 0;

			while($incount)
			{
				$startpos = strpos($inxml, $startstr, $startpos);
				if ($startpos === false)
					return false;

				$testchar = substr($inxml, $startpos+strlen($intag)+1, 1);
				if($testchar != ' ' && $testchar != '>')
				{
					$startpos++;
					continue;
				}

				$incount--;
				if($incount > 0)
					$startpos++;
			}

			$return = array();

			$startpos += strlen($startstr);

			$endpos = strpos($inxml, '>', $startpos);

			$attr = trim(substr($inxml, $startpos, $endpos-$startpos));

			$attributes = split(' ', $attr);

			while ($attr = each($attributes))
			{
				$snap = split('=', $attr[value]);
				$return[$snap[0]] = substr($snap[1],1, strlen($snap[1])-2);
			}

			return $return;
		}

 
#+******************************************************************
# Class      : EbParseAndFormat
# Method     : XPathValue
# Created    : Richard E. Dye
# Date       : 9/25/2003
#
# Comment    : Given an XML path, retrieve the contents of that node.
#
# visibility :	private
#
# Parameters :
# string			$XPath				The XML path.  eg: 'root/node/tag1/subtag'
# string			$xml					XML document to parse
#
# Returns    :
# string									contents of the node, or boolean false
#
# Revisions  :
#
# *****************************************************************-*/
		function XPathValue($XPath,$xml) {
			$XPathArray = explode("/",$XPath);
			$node = $xml;
			while (list($key,$value) = each($XPathArray)) {
				$node = $this->GetElementByName($node, $value); 
			}
			return $node;
 		}

	}

?>
