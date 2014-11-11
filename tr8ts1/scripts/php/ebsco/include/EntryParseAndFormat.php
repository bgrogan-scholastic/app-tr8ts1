<?php
	require_once('EbParseAndFormat.php');


#+******************************************************************
# Class      : EntryParseAndFormat
# Method     :
# Created    : Richard E. Dye
# Date       : 9/26/2003
#
# Comment    : Derived from the EbParseAndFormat base class, this
#					class will parse and format a journal entry.
#
# Revisions  :
#
# *****************************************************************-*/
   class EntryParseAndFormat extends EbParseAndFormat
   {


#+******************************************************************
# Class      : EntryParseAndFormat
# Method     : _parseXMLDocument
# Created    : Richard E. Dye
# Date       : 9/26/2003
#
# Comment    : An implementation of the Template or 'Hollywood' pattern,
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
			return $this->GetElementByName($inXMLdocument, 'abody');
      }

	}

?>
