<?php
	require_once('EbParseAndFormat.inc');
	require_once('EbscoNumResults.inc');
	require_once($_SERVER['PHP_INCLUDE_HOME'] . '/common/utils/GI_SubTemplate.php');

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
#					10/14/2003: R.E. Dye - Added support for the 'editfield1'
#					additional search parameter.
#
#					3/10/2005: Todd A. Reisel - added header keys to support the
#					starting and ending document number that go2 wants to display.
#					This also required a change to _parseXMLDcoument so that the
#					first / last record number could be determined
#
#					3/10/2005 : Todd A. Reisel - added more footer_keys to support
#					the building of a dynamic footer in GetPrevNext() for go2, so 
#					that the previous / next buttons could be subtemplates 
#					with substitued keys.

# *****************************************************************-*/
   class IndexParseAndFormat extends EbParseAndFormat
   {
   	// Basic information about the index page, passed in from
   	// the caller in the constructor.
		var $assetID = "";
		var $editfield1 = "";

		// Some count and id information, extracted from the Ebsco XML,
		// and used to control the prev|next links.
		var $totalhits;
		var $firstdoc = 100000;
		var $lastdoc = 0;

		// templates for constructing the HTML output
		var $entrytemplate;
		var $pdftemplate;
		var $headertemplate;
		var $footertemplate;

		// For matching special XML elements
		var $enumfield = array('name' => 'enum');
		var $authorfield = array('name' => 'author');
		var $abstractfield = array('name' => 'abstract');

		// arrays for display templates
		var $entry_templates = array(
			'ada' 		=> 'indexentry_ada.tmpl',
			'graphical'	=>	'indexentry_graphical.tmpl',
			'ea'			=>	'indexentry_ea_graphical.tmpl',
			'ea-ada'		=>	'indexentry_ea_ada.tmpl',
			'nbk'			=>	'indexentry_nbk.tmpl',
			'nbk3'		=>	'indexentry_nbk3.tmpl',
			'nbk3-ada'	=>	'indexentry_nbk3_ada.tmpl',
			'go2-kids'	=>	'indexentry_go2-kids.tmpl',
			'go2-passport'	=>	'indexentry_go2-passport.tmpl'
			);

		// 12/3/2003: array for pdf entry templates
		var $pdf_templates = array(
			'ada' 		=> 'pdf_ada.tmpl',
			'graphical'	=>	'pdf_graphical.tmpl',
			'ea'			=>	'pdf_ea_graphical.tmpl',
			'ea-ada'		=>	'pdf_ea_ada.tmpl',
			'nbk'			=>	'pdf_nbk.tmpl',
			'nbk3'		=>	'pdf_nbk3.tmpl',
			'nbk3-ada'	=>	'pdf_nbk3_ada.tmpl',
			'go2-kids'	=>	'pdf_go2-kids.tmpl',
			'go2-passport'	=>	'pdf_go2-passport.tmpl'
			);

		var $header_templates = array(
			'ada' 		=>	'indexheader_ada.tmpl',
			'graphical'	=>	'indexheader_graphical.tmpl',
			'ea'			=>	'indexheader_ea_graphical.tmpl',
			'ea-ada'		=>	'indexheader_ea_ada.tmpl',
			'nbk'			=>	'indexheader_nbk.tmpl',
			'nbk3'		=>	'indexheader_nbk3.tmpl',
			'nbk3-ada'	=>	'indexheader_nbk3_ada.tmpl',
			'go2-kids'	=>	'indexheader_go2-kids.tmpl',
			'go2-passport'	=>	'indexheader_go2-passport.tmpl'
			);

		var $footer_templates = array(
			'ada'			=>	'indexfooter_ada.tmpl',
			'graphical'	=>	'indexfooter_graphical.tmpl',
			'ea'			=>	'indexfooter_ea_graphical.tmpl',
			'ea-ada'		=>	'indexfooter_ea_ada.tmpl',
			'nbk'			=>	'indexfooter_nbk.tmpl',
			'nbk3'		=>	'indexfooter_nbk3.tmpl',
			'nbk3-ada'	=>	'indexfooter_nbk3_ada.tmpl',
			'go2-kids'	=>	'indexfooter_go2-kids.tmpl',
			'go2-passport'	=>	'indexfooter_go2-passport.tmpl'
			);

		// array of template keys, or macros, to replace.
		// Please note that the order must correspond to the
		// order in the template values array for the
		// substitutions to be correct.
		var $template_keys = array(
			'<!-- %%ASSETID%% -->',
			'<!-- %%PRODUCT%% -->',
			'<!-- %%RECORDID%% -->',
			'<!-- %%AUTHOR%% -->',
			'<!-- %%ENTRYTITLE%% -->',
			'<!-- %%JOURNALTITLE%% -->',
			'<!-- %%ENUM%% -->',
			'<!-- %%ABSTRACT%% -->',
			'<!-- %%EDITFIELD1%% -->',
			'<!-- %%PDF%% -->',
			'<!-- %%PDFLINK%% -->',
			'<!-- %%EBSCO_SERVER%% -->'
			);

		// Array of keys to replace in the prev|next footer
		var $footer_keys = array(
			'<!-- %%PREV%% -->',
			'<!-- %%SPACER%% -->',
			'<!-- %%NEXT%% -->',
			'<!-- %%PGO%% -->',
			'<!-- %%NGO%% -->'
				);

		// Array of keys to replace in the header
		var $header_keys = array(
			'<!-- %%TOTALHITS%% -->',
			'<!-- %%STARTINGDOCNUMBER%% -->',
			'<!-- %%ENDINGDOCNUMBER%% -->'
			);

		// The values array.  This must be filled fresh for each
		// index record.
		var $template_values = array();


#+******************************************************************
# Class      : IndexParseAndFormat
# Method     : IndexParseAndFormat
# Created    : Richard E. Dye
# Date       : 10/3/2003
#
# Comment    : Constructor.  The index page needs to know the assetid
#					of the encyclopedia article, and the id of the calling
#					encyclopedia
#
# visibility :	public
#
# Parameters :
# string			$inassetID			The encyclopedia article's asset ID
# string			$inproduct			The encyclopedia's ID
# string			$editfield1			'additional query' term.
#
# Returns    : none
#
# Revisions  :
#					10/14/2003: R.E. Dye - Added support for the 'editfield1'
#					additional search parameter.
#
# *****************************************************************-*/
		function IndexParseAndFormat($inassetID, $inproduct, $editfield1="")
		{
			$this->assetID = $inassetID;
			$this->product = $inproduct;
			$this->editfield1 = urlencode($editfield1);

			$this->GetTemplates($inproduct);
		}


#+******************************************************************
# Class      : IndexParseAndFormat
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
# string			&$inXMLdocument		The XML document to parse
#
# Returns    :
# string									The formatted HTML
#
# Revisions  :
#					10/21/2003: R.E. Dye - modified to include the
#					Previous | Next links, if needed.
#
# *****************************************************************-*/
      function _parseXMLDocument(&$inXMLdocument)
      {
      	$records = $this->GetAttributesByName($inXMLdocument, 'records');
			if($records === false)
			{
				echo "\n\n<!--\$inXMLdocument= $inXMLdocument -->\n\n";
				echo "<!-- ";
				print_r($inXMLdocument);
				echo " -->\n\n";
				return "<p>Unable to read records attributes</p>\n";
			}

			$this->totalhits = $this->GetElementByName($inXMLdocument, 'totalHits');

			if($this->totalhits > 50) $this->totalhits = 50;

			$header_values = array($this->totalhits, 0, 0);

			$numrecs = $records['count'];
			if($numrecs < 1) {
				$outstring .= str_replace($this->header_keys, $header_values, $this->headertemplate);
				return $outstring;
			}

			$this->template_values[0] = $this->assetID;
			$this->template_values[1] = $this->product;

			if ($_SERVER["SERVER_PORT"] != "80") {
				$this->template_values[11] = "http://" . $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"];
			}
			else {
				/* default port 80 */
				$this->template_values[11] = "http://" . $_SERVER["SERVER_NAME"];
			}

			for($recnum=1; $recnum<=$numrecs; $recnum++)
			{
				$result = $this->GetAttributesByName($inXMLdocument, 'rec', $recnum);
				if($result)
				{
					$recordID = $result['recordID'];
					$this->template_values[2] = $recordID;
					if($recordID > $this->lastdoc) {
						$this->lastdoc = $recordID;
						$header_values[2] = $this->lastdoc;
					}
					if($recordID < $this->firstdoc) {
						$this->firstdoc = $recordID;
						$header_values[1] = $this->firstdoc;
					}

					$node = $this->GetElementByName($inXMLdocument, 'rec', $recnum);
					if($node)
					{
						// ParseRecord returns a boolean value indicating if the entry has a text version
						if($this->ParseRecord($node))
							$content_outstring .= str_replace($this->template_keys, $this->template_values, $this->entrytemplate);
						else
							$content_outstring .= str_replace($this->template_keys, $this->template_values, $this->pdftemplate);

						 // $content_outstring .= "<p>$node</p>\n\n";
					}
				}
			}

			$outstring = "";
			$outstring .= str_replace($this->header_keys, $header_values, $this->headertemplate);
			$outstring .= $content_outstring;
			$outstring .= $this->PrevNext();
			return $outstring;
      }

#+******************************************************************
# Class      : IndexParseAndFormat
# Method     : GetTemplates
# Created    : Richard E. Dye
# Date       : 10/3/2003
#
# Comment    : Fetch the template for an index record, based on product.
#					For now, it just needs to distinguish graphical from
#					ADA, but here is where additional formats could
#					easily be wedged in.
#
#					10/13/2003: modified to fetch all templates needed to
#					construct the final page.
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

			$filename = $this->GetTemplateFilename($inproduct, $this->entry_templates);
			$this->entrytemplate = $this->ReadFile($_SERVER["PHP_INCLUDE_HOME"].'/ebsco/templates/'.$filename);

			$filename = $this->GetTemplateFilename($inproduct, $this->pdf_templates);
			$this->pdftemplate = $this->ReadFile($_SERVER["PHP_INCLUDE_HOME"].'/ebsco/templates/'.$filename);

			$filename = $this->GetTemplateFilename($inproduct, $this->header_templates);
			$this->headertemplate = $this->ReadFile($_SERVER["PHP_INCLUDE_HOME"].'/ebsco/templates/'.$filename);

			$filename = $this->GetTemplateFilename($inproduct, $this->footer_templates);
			$this->footertemplate = $this->ReadFile($_SERVER["PHP_INCLUDE_HOME"].'/ebsco/templates/'.$filename);
			
		}


#+******************************************************************
# Class      : IndexParseAndFormat
# Method     : ParseRecord
# Created    : Richard E. Dye
# Date       : 10/3/2003
#
# Comment    : Parse the XML for a specific index entry, extracting
#					the data needed for a listing.
#					The data is stored in the template_values array, for
#					substitution.  Note that the order of entries in this
#					array must match that of the template_keys array
#					for the substitution to work correctly.
#
#					IMPORTANT: Use ksort() to get the correct order!
#					The str_replace() function does not look at the indexes,
#					but just steps through the arrays!
#
# visibility :	private
#
# Parameters :
# string			&$inRecord			The XML for a given index entry (reference!)
#
# Returns    : none
#
# Revisions  : 12/2/2003: Determine if the record has text, or if it's 'PDF only'.
#					12/3/2003: Return value of $hastextflag
#
# *****************************************************************-*/
		function ParseRecord(&$inRecord)
		{
			$hastextflag = false;

			# pdf indicator
			$this->template_values[9] = '';

			# pdf link
			$this->template_values[10] = '';

			$this->template_values[4] = $this->GetElementByName($inRecord, 'atl');
			$this->template_values[5] = $this->GetElementByName($inRecord, 'jtl');
			$node=$this->GetElementByName($inRecord, 'displayInfo');
			if($node)
			{
				$this->template_values[3] = $this->GetElementByNameAndAttributes($inRecord, 'field', $this->authorfield);
				$this->template_values[6] = $this->GetElementByNameAndAttributes($inRecord, 'field', $this->enumfield);
				$abstract = $this->GetElementByNameAndAttributes($inRecord, 'field', $this->abstractfield);
				if(substr($abstract,0,1) == ';')
					$abstract = substr($abstract,1);
				$this->template_values[7] = $this->Transform($abstract);
			} else {
				$this->template_values[3] = "";
				$this->template_values[6] = "";
				$this->template_values[7] = "";
			}

			if($this->template_values[3] != "")
				$this->template_values[3] .= ', ';

			// Check for the existance of text
			$node=$this->GetElementByName($inRecord, 'formats');
			if($node)
			{
				$counter = 1;
				while(1)
				{
					$fmt_array=$this->GetAttributesByName($node, 'fmt', $counter++);
					if(!$fmt_array)
						break;
					if($fmt_array['type'] == 'T' || $fmt_array['type'] == 'C')
					{
						$hastextflag = true;
						break;
					}
				}
			}


			// We are only interested in PDF stuff if there is no HTML version...
			if(!$hastextflag)
			{
				$node=$this->GetElementByName($inRecord, 'externalLinkInfo');
				if($node)
				{
					$counter = 1;
					while(1)
					{
						$el_array=$this->GetAttributesByName($node, 'externalLink', $counter++);
						if(!$el_array)
							break;
						if($el_array['type'] == 'pdfLink')
						{
							$this->template_values[10] = $el_array['URL'];
							break;
						}
					}
				}
				$this->template_values[9]= '[PDF format]';
			}



			$this->template_values[8] = $this->editfield1;

			ksort($this->template_values);

			return $hastextflag;
		}


#+******************************************************************
# Class      : IndexParseAndFormat
# Method     : PrevNext
# Created    : Richard E. Dye
# Date       : 10/21/2003
#
# Comment    : Format the correct Previous | Next links, if needed.
#
# visibility :	private
#
# Parameters : none
#
# Returns    :
# string									Formatted Previous | Next links, or empty string.
#
# Revisions  :
#
# *****************************************************************-*/
		function PrevNext()
		{
			$newPrevSTStartTag = "<!-- %%PREV%";
			$newPrevSTEndTag = "% -->";

			$newNextSTStartTag = "<!-- %%NEXT%";
			$newNextSTEndTag = "% -->";

			$prevSTText = '';
			$nextSTText = '';

			$nextfirst = '';
			$prevfirst = '';

			$footer_values = array("", "", "", "", "");

			/* determine the number of results per page */
			$numResults = new EbscoNumResults();
			$numperpage = $numResults->getValue($this->product);

			// Should there be a previous link?
			if($this->firstdoc > 1)
			{
				if($this->firstdoc < ($numperpage + 1) )
					$prevfirst = 1;
				else
					$prevfirst = $this->firstdoc - ($numperpage);
			}

			// Should there be a next link?
			if($this->lastdoc < $this->totalhits)
			{
				$nextfirst = $this->firstdoc + ($numperpage);
			}


			/* look for the old style link first */
			$prevSTStartPos = strpos($this->footertemplate, $this->footer_keys[0]);
			if ($prevSTStartPos > 0) {
				if ($prevfirst != '') {
					$footer_values[0] = "<a href=\"/cgi-bin/doebsco?assetid=".$this->assetID."&StartRecNo=$prevfirst&editfield1=".$this->editfield1."\">Previous</a>";
				}
			}
			else {
				$prevSTStartPos = strpos($this->footertemplate, $newPrevSTStartTag);
				if ( ($prevSTStartPos !== FALSE)  && ($prevfirst != '') ) {
					$prevSTStartPos = $prevSTStartPos + strlen($newPrevSTStartTag);
					$prevSTEndPos = strpos($this->footertemplate, $newPrevSTEndTag, $prevSTStartPos);
					$previousSTText = substr($this->footertemplate, $prevSTStartPos, $prevSTEndPos - $prevSTStartPos);
	
					$subT = new GI_SubTemplate($previousSTText);
					$subTKeys = $subT->getKeys();
					$subTKeys['ASSET_ID'] = $this->assetID;
					$subTKeys['EDITFIELD1'] = $this->editfield1;
					$subTKeys['P_STARTRECNO'] = $prevfirst;
					$subTKeys['EXTRAPARAMS'] = '##EXTRAPARAMS##';

					$footer_values[3] = $subT->toString($subTKeys);				
				}
			}

			/* look for the old style link first */
			$nextSTStartPos = strpos($this->footertemplate, $this->footer_keys[2]);
			if ($nextSTStartPos > 0) {
				if ($nextfirst != '') {
					$footer_values[2] = "<a href=\"/cgi-bin/doebsco?assetid=".$this->assetID."&StartRecNo=$nextfirst&editfield1=".$this->editfield1."\">Next</a>";
				}
			}
			else {
				$nextSTStartPos = strpos($this->footertemplate, $newNextSTStartTag);
				if ( ($nextSTStartPos !== FALSE) && ($nextfirst != '') ) {
					$nextSTStartPos = $nextSTStartPos + strlen($newNextSTStartTag);
					$nextSTEndPos = strpos($this->footertemplate, $newNextSTEndTag, $nextSTStartPos);
					$nextSTText = substr($this->footertemplate, $nextSTStartPos, $nextSTEndPos - $nextSTStartPos);

					$subT = new GI_SubTemplate($nextSTText);
					$subTKeys = $subT->getKeys();
					$subTKeys['ASSET_ID'] = $this->assetID;
					$subTKeys['EDITFIELD1'] = $this->editfield1;
					$subTKeys['N_STARTRECNO'] = $nextfirst;
					$subTKeys['EXTRAPARAMS'] = '##EXTRAPARAMS##';
					$footer_values[4] = $subT->toString($subTKeys);				
				}
			}

			/* determine whether or not to add a spacer */
			if ( (strlen($footer_values[0]) > 0 ) && (strlen($footer_values[2]) > 0) ) {
				$footer_values[1] = "&nbsp;&nbsp;|&nbsp;&nbsp;";
			}
			else if ( (strlen($footer_values[3]) > 0 ) && (strlen($footer_values[4]) > 0) ) {
				$footer_values[1] = "&nbsp;&nbsp;|&nbsp;&nbsp;";
			}				

			return str_replace($this->footer_keys, $footer_values, $this->footertemplate);
		}
	}
?>













