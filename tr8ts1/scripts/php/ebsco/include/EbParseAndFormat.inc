<?php
	require_once($_SERVER["PHP_INCLUDE_HOME"].'/common/utils/XMLParser.inc');

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
#					10/15/2003: R.E. Dye - most of the generic XML parsing
#					methods were moved out into a generic XMLParser
#					base class
#
#					11/18/2003: R.E. Dye - Added the 'transform' method to
#					repair various oddities in the content delivered by
#					Ebsco.
#
# *****************************************************************-*/
   class EbParseAndFormat extends XMLParser
   {

	var $product = "";

	var $substitutions = array(
		'<p>GRAPH(.*?)<\/p>'				=>	'',
		'<p>PHOTO(.*?)<\/p>'				=>	'',
		'<p>DIAGRAM(.*?)<\/p>'			=>	'',
		'<p>MAP(.*?)<\/p>'				=>	'',
		'<p>GRAPH(.*?)<\/p>'				=>	'',
		'<p>ILLUSTRATION(.*?)<\/p>'	=>	'',
		'<p>CARTOON(.*?)<\/p>'			=>	'',
		'<reflink(.*?)>'					=>	'',
		'<\/reflink(.*?)>'				=>	'',
		'<nolink(.*?)>'					=>	'',
		'<\/ulink> logy \/OHDEC \/clinical.asp(.*?)\)'	=> 'logy/OHDEC/clinical.asp</a>)',
		'&#60;'													=>	'<',
		'&#62;'													=>	'>',
		'<hd(.*?)>'												=>	'<span class="runin">',
		'<\/hd>'													=>	'</span>',
		'<ct(.*?)>'												=>	'<br><pre>',
		'<\/ct>'													=>	'</pre>',
		'<blist(.*?)>'											=>	'<br>',
		'<sbt id(.*?)>'										=>	'<b>',
		'<\/sbt>'												=>	'</b>',
		'<bold(.*?)>'											=>	'<b>',
		'<\/bold>'												=>	'</b>',
		'<ulink'													=>	'<a',
		'<\/ulink>'												=>	'</a>',
		'<olist(.*?)>'											=>	'<ol>',
		'<ulist(.*?)>'											=>	'<ul>',
		'<item(.*?)>'											=>	'<li>',
		'<\/item>'												=>	'</li>',
		'<rj(.*?)>'												=>	'<p>',
		'<\/rj>'													=>	'</p>',
		'href=&quot;'											=>	'href="',
		'&quot;&#62;'											=>	'">',
		'&quot;>;'												=>	'"',
		'<span class="EPHighlight"'						=> ' <span class="EPHighlight"'
	);

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
# string			&$inXMLdocument		The XML document to parse (reference!)
#
# Returns    :
# string									The formatted HTML
#
# Revisions  :
#
# *****************************************************************-*/
      function parseXMLDocument(&$inXMLdocument)
      {
      	$error = $this->GetElementByName($inXMLdocument, 'errors');
      	if($error)
      	{
				$outResult = "<p><b>EBSCO, our online magazine article provider, is currently unavailable</b></p>\n";
				$outResult .= "<p><b>Please try your request again later.</b></p>\n";
				//$outResult .= "<!-- $inXMLdocument -->\n";
				return $outResult;
			}

			return $this->_parseXMLDocument($inXMLdocument);
      }


#+******************************************************************
# Class      : EbParseAndFormat
# Method     : Transform
# Created    : Richard E. Dye
# Date       : 11/18/2003
#
# Comment    :
#
# visibility :	private
#
# Parameters :
# string			&$instring			Data to transform (reference)
#
# Returns    :
# string									Transformed string
#
# Revisions  :
#
# *****************************************************************-*/
		function Transform(&$instring)
		{
			$outstring = $instring;


			// for each key => value pair in $this->substitutions.
			foreach($this->substitutions as $key => $value)
			{
				// substitute value for the regular expression contained in key.
		      // $inIP=preg_replace("/\.\*+/", "", $inIP);

		      $outstring = preg_replace("/$key/", $value, $outstring);
			}
			//return utf8_decode($outstring);
			return $outstring;
		}


#+******************************************************************
# Class      : EbParseAndFormat
# Method     : GetTemplateFilename
# Created    : Richard E. Dye
# Date       : 10/22/2003
#
# Comment    :
#
# visibility :	private
#
# Parameters :
# string			$inproduct			The product ID
# array ref		$inarray				The array to search.
#
# Returns    :
# string									Filename of template for this type.
#
# Revisions  :
#					10/23/2003: R.E. Dye - moved from the IndexParseAndFormat
#					class, because EntryParseAndFormat needs it too.
#
# *****************************************************************-*/
		function GetTemplateFilename($inproduct, &$inarray)
		{
			if($inarray[$inproduct] != "")
				return $inarray[$inproduct];

			if(substr($inproduct, -4) == '-ada')
				$key = 'ada';
			else
				$key = 'graphical';

			if($inarray[$key] != "")
				return $inarray[$key];

			return "NoTemplate";
		}


#+******************************************************************
# Class      : EbParseAndFormat
# Method     : ReadFile
# Created    : Richard E. Dye
# Date       : 10/21/2003
#
# Comment    : Attempt to read the contents of a file into a string.
#
# visibility :	private
#
# Parameters :
# string			$infile				The file to open (full or relative path)
#
# Returns    :
# string									Contents of the file, or an empty string.
#
# Revisions  :
#					10/23/2003: R.E. Dye - moved from the IndexParseAndFormat
#					class, because EntryParseAndFormat needs it too.
#
# *****************************************************************-*/
		function ReadFile($infile)
		{
			$outcontents = "";

			$filehandle = fopen($infile, 'r');

			if($filehandle)
			{
				while(!feof($filehandle))
				{
					$outcontents .= fgets($filehandle);
				}
				fclose($filehandle);
			}

			return $outcontents;
		}


	}

?>
