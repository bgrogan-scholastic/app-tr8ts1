<?php
	require_once('EbParseAndFormat.inc');


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
		// template(s) for constructing the HTML output
		var $bodytemplate;

		// arrays for display templates
		var $body_templates = array(
			'ada' 		=> 'body_ada.tmpl',
			'graphical'	=>	'body_graphical.tmpl',
			'ea'			=>	'body_ea_graphical.tmpl',
			'ea-ada'		=>	'body_ea_ada.tmpl',
			'nbk'			=>	'body_nbk.tmpl',
			'nbk3'		=> 'body_nbk3.tmpl',
			'nbk3-ada'	=>	'body_nbk3_ada.tmpl'
			);

		// array of template keys, or macros, to replace.
		// Please note that the order must correspond to the
		// order in the template values array for the
		// substitutions to be correct.
		var $body_keys = array(
			'<!-- %%ENTRYTITLE%% -->',
			'<!-- %%AUTHOR%% -->',
			'<!-- %%JOURNALTITLE%% -->',
			'<!-- %%ENUM%% -->',
			'<!-- %%BODY%% -->',
			'<!-- %%PRODUCT%% -->',
			'<!-- %%DISPLAYINFO%% -->'
				);


#+******************************************************************
# Class      : EntryParseAndFormat
# Method     : EntryParseAndFormat
# Created    : Richard E. Dye
# Date       : 10/23/2003
#
# Comment    : Constructor.
#
# visibility :	public
#
# Parameters :
# string			$inproductid		Product ID
#
# Returns    : none
#
# Revisions  :
#
# *****************************************************************-*/
		function EntryParseAndFormat($inproductid)
		{
			$this->product = $inproductid;
			$this->GetTemplates($inproductid);
		}


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
#					10/23/2003: R.E. Dye - Modified to just return the
#					<div class="EPFullText"> element in the abody element.
#
# *****************************************************************-*/
      function _parseXMLDocument(&$inXMLdocument)
      {

      	$abody = $this->GetElementByName($inXMLdocument, 'abody');

			$xmlns= $this->GetNestedElementByName($abody, 'div');

			$body_values = array(
					$this->GetElementByName($inXMLdocument, 'atl'),
					$this->GetAuthors($inXMLdocument),
					$this->GetElementByName($inXMLdocument, 'jtl'),
					$this->GetElementByName($inXMLdocument, 'enum'),
					$this->Transform($this->GetNestedElementByName($xmlns, 'div')),
					$this->product,
					$this->GetElementByName($inXMLdocument, 'displayInfo')
				);

			return str_replace($this->body_keys, $body_values, $this->bodytemplate);
			
      }

#+******************************************************************
# Class      : EntryParseAndFormat
# Method     : GetAuthors
# Created    : Richard E. Dye
# Date       : 10/23/2003
#
# Comment    : Extract all the authors from an XML document, and
#					return a formatted 'authors' string for display
#
# visibility :	private
#
# Parameters :
# string			$inXML				The XML document to parse (reference)
#
# Returns    :
# string									The formatted authors string
#
# Revisions  :
#
# *****************************************************************-*/
		function GetAuthors(&$inXML)
		{
			$outString = "";

			$authors = $this->GetElementByName($inXML, 'aug');

			if($authors)
			{
				$reccount = 1;

				// Again, a 'do until' construct would be nice...
				while($reccount)
				{
					$author = $this->GetElementByName($authors, 'au', $reccount);
					$reccount++;

					if($author)
					{
						if($outString != "")
							$outString .= '; ';
						$outString .= $author;
					} else {
						$reccount = 0;
					}
				}
				if($outString != "")
					$outString .= ", ";
			}

			return $outString;
		}


#+******************************************************************
# Class      : EntryParseAndFormat
# Method     : GetTemplates
# Created    : Richard E. Dye
# Date       : 10/23/2003
#
# Comment    : Fetch the template(s) for formatting the output
#
# visibility :	private
#
# Parameters :
# string			$inproduct			The product ID
#
# Returns    : none
#
# Revisions  :
#
# *****************************************************************-*/
		function GetTemplates($inproduct)
		{

			$filename = $this->GetTemplateFilename($inproduct, $this->body_templates);
			$this->bodytemplate = $this->ReadFile($_SERVER["PHP_INCLUDE_HOME"].'/ebsco/templates/'.$filename);

		}

	}

?>
