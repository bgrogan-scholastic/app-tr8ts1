<?php

#+******************************************************************
# Class      :
# Method     : FetchQuery
# Created    : Richard E. Dye
# Date       : 10/8/2003
#
# Comment    : Given an assetID, fetch the appropriate Boolean query
#					from the database and massage it into the correct
#					format for SOAP
#
#					Returns as boolean false if the query cannot be found
#						(use '=== false' to check)
#
# visibility :	public
#
# Parameters :
# string			$inAssetID			The AssetID to fetch the query for
#
# Returns    :
# array									The Query and database code, or false.
#
# Revisions  :
#					10/9/2003: R.E. Dye - I want to retrieve the database
#					as well, so the function has been modified to return an
#					array with the keys 'db' and 'query'.
#
#					12/3/2003: R.E. Dye - I also need to retrieve the 'searchtext'
#					field, if there is one.
#
# *****************************************************************-*/
	function FetchQuery($inAssetID)
	{
		// We need to connect to the mysql server
	   if (!$dbh=mysql_connect("localhost", 'ebsco', 'ebsco'))
   		return false;

		// We need to connect to the ebsco database
		if(!mysql_select_db('ebsco'))
			return false;

	   $Qstring = "select query from el_queries where id = '$inAssetID'";

		$result=mysql_query($Qstring);
		if(!$result)
			return false;

		$row = mysql_fetch_array($result);
		if(!$row)
			return false;

		$query = $row['query'];

		if(!$query)
			return false;

		$outarray = array();
		
		$url_array = explode('&', $query);

		foreach($url_array as $key => $value)
		{
			$parmarray = explode('=', $value);
			if($parmarray[0] == 'db')
			{
				$outarray['db']=$parmarray[1];
			}
			elseif($parmarray[0] == 'searchtext')
			{
				$outarray['searchtext'] = $parmarray[1];
			}
		}

		$query_array = explode('=', $url_array[0]);

		$outarray['query'] = $query_array[1];

		return $outarray;
   }

?>
