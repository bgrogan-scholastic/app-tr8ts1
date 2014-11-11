<?php
require_once($_SERVER["PHP_INCLUDE_HOME"].'common/search/package_GI.php');
require_once('DB.php');
require_once($_SERVER['PHP_INCLUDE_HOME']."common/auth/cookie_reader.php");

/**
* startSoapClient()
*
* This function establishes a connection to the SOAP client.  
*
* @author  Diane Palmer
* @access  public 
* 
* @return  SOAP client
*/
function startSoapClient(){

	$wsdlURL = $_SERVER['SEARCH_WSDL_URL'];
	$authReq = array(
	                "username" => $_SERVER['SEARCH_USERNAME'],
	                "password" => $_SERVER['SEARCH_PASSWORD']
	                );
	
	$SOAPClient = new Search_SOAPClient_GI($wsdlURL, $authReq);
	
	//if there is an error connecting to the SOAP client, then display an error
	if (Search_SOAPClient_GI::isError($SOAPClient)) {
	
	    print "<p>Error creating Search_SOAPClient_GI: " . $SOAPClient->getMessage() . "</p>\n";
	//if it was successful then return the soapclient. 
	}
	else {
			
		return $SOAPClient;
	}

}//end function 

/**
* getXSpaceReq()
*
* This function returns an array of search requirements for the expert space search.  
*
* @author  Diane Palmer
* @access  public 
* 
* @return  array of search requirements. 
* 
* @param 	string $searchterm
* @param 	string $searchtype
* 
*/
function getXSpaceReq($searchterm, $searchtype){
	
    $QueryParser = "Grolier_En";
    $authpcode = $_SERVER['AUTH_PCODE'];
    
    $valuesArray = array("0c");
    $indexArray = array('ngo1');
    
    if($authpcode=="eto"){
    	$valuesArray = array("0c", "0cw");
    	$indexArray = array('ngo1', 'eto1');
    }
	                        
    //make the search filter array.  This one is filtering by asset type..and only grabbing the asset types that are "0c"'s.. which are expert spaces.  
    //field = the field you want to filter by
    //filterType =
    //values = the only values you want for the field specified
    //valuesType = 
    //key = 
    //nextSearchFiler = if you had another filter then put the php variable there of that array.  If there are no other filters then type "null"
	$searchFilter = array(
	                        'nextSearchFilter'  =>  null,
		                    'key'               =>  'GlobalSearchAssets',
		                    'valuesType'        =>  0,
		                    'values'            =>  $valuesArray,
		                    'filterType'        =>  0,
		                    'field'             =>  'Asset Type'

		                    );
	//the search requirements array.  
	//numResults = the number of results that you want returned.
	//query = the search term the user typed in. 
	//startingPosition = what search result you want to start on.  For this it will always start on 1.
	//displayFields = the fields that you want to be returned from the search.  
	//indexes = which indexes to do your search on. 
	//queryParser = 
	//firstSearchFilter = the PHP variable of the first search filter.  In this case its the only search filter. 		                    
	$searchReq = array(
	                    'numResults'        =>  4,
		                'query'             =>  $searchterm,
		                'startingPosition'  =>  1,
		                'displayFields'     =>  array('assetid', 'type', 'title', 'product_id'),
		                'indexes'           =>  $indexArray,
		                'queryParser'       =>  "Grolier_En",
			            'firstSearchFilter' =>  $searchFilter
	    	            );
	$searchReqs = $searchReq;   

	return $searchReqs;
	
	
}

function getArticleReq($searchterm, $startPosition, $UsersProducts, $sort, $VdkVgwKey, $searchtype, $lexileArray){

	$authpcode = $_SERVER['AUTH_PCODE'];
	
   	//make the search filters and requirements for articles...
   	//if we r sorting by level, then change it to lexile
    $sortArray = explode(" ",$sort);
    $sortCol = $sortArray[0];
    
    if($sortCol=="level"){
    	
    	$sort = "lexile " . $sortArray[1];
    	
    }
    
    $QueryParser = "Grolier_En";
    
    if($searchtype=="advanced"){
    	
    	$QueryParser = "Simple";
    	
    }
    
    //if this is a more like this search...change the search term
    if($VdkVgwKey){
    	$VdkVgwKey = base64_decode($VdkVgwKey);

    	$searchterm = "<LIKE>('{posex=vdkvgwkey:\"".$VdkVgwKey."\"}')";
    	$QueryParser = "Simple";
    }
    
    $valuesType = 0;
    
    //if the user type in a lexile range.. 
    if(count($lexileArray) <= 2){
    	
    	$lexilebegin = $lexileArray[0];
    	$lexileend = $lexileArray[1];

	    if($lexileend && $lexileend != 0){
	    	
	    	$lexileend = $lexileend + 1;
	    	
	    	
	    }

	    //if the user types in both a start and end value then...
	    if(($lexilebegin !="" && $lexilebegin!="undefined" && $lexilebegin >= 0) && ($lexileend !=""  && $lexileend!="undefined" && $lexileend >= 0)){

	    	$valuesType = 1;
	    	$values = array($lexilebegin, $lexileend);
	    	
	    	   
	    }else if ($lexilebegin >= 0 && !$lexileend){

	    	$values = array($lexilebegin);
	    	
	    	
	    }else if (!$lexilebegin && $lexileend >= 0){

	    	$values = array($lexileend);
	    
	    }
	    
    }else{
    	
    	$values = $lexileArray;
	    $valuesType = 1;
    }//end if

    //print_r($values);
	$searchFilterViewB = array(
	                        'nextSearchFilter'  =>  null,
	                        'key'               =>  'GlobalSearchAssets',
		                    'valuesType'        =>  $valuesType,
		                    'values'            =>  $values,
		                    'filterType'        =>  0,
		                    'field'             =>  'lexile'
	                        );     
               
    $nextSearchFilter = null;
    
   // print_r($searchFilterViewB);
	//echo count($lexileArray);
    if(count($lexileArray) > 0){

    	$nextSearchFilter = $searchFilterViewB;
    	
    	
    }	
    
    $AssetTypeArray = array("0ta", "b", "h", "t", "0tat", "0taf", "0tas", "0tasp", "0tap", "0taz");
    $indexArray = array('go2', 'ngo1');
	if($authpcode=="eto"){   

		$AssetTypeArray = array("0ta", "b", "h", "t", "0tat", "0taf", "0tas", "0tasp", "0tap", "0taz", "0tw");
		$indexArray = array('go2', 'ngo1', 'eto1');
		
	} 
                        	
	$searchFilterViewA = array(
	                        'nextSearchFilter'  =>  $nextSearchFilter,
	                        'key'               =>  'GlobalSearchAssets',
		                    'valuesType'        =>  0,
		                    'values'            =>  $UsersProducts,
		                    'filterType'        =>  0,
		                    'field'             =>  'product_id'
	                        ); 
	                        
	$searchFilter = array(
	                        'nextSearchFilter'  =>  $searchFilterViewA,
		                    'key'               =>  'GlobalSearchAssets',
		                    'valuesType'        =>  0,
		                    'values'            =>  $AssetTypeArray,
		                    'filterType'        =>  0,
		                    'field'             =>  'Asset Type'
			                );
	$searchReq = array(
	                    'numResults'        =>  25,
		                'query'             =>  $searchterm,
		                'startingPosition'  =>  $startPosition,
		                'displayFields'     =>  array('assetid', 'type', 'title', 'first','lexile','score','VdkVgwKey','link','product_id', 'byline'),
		                'sortBy'            =>  $sort,
		                'indexes'           =>  $indexArray,
		                'queryParser'       =>  $QueryParser,
			            'firstSearchFilter' =>  $searchFilter
	    	            );
	$searchReqs = $searchReq;   	
	//print_r($searchReqs);
	return $searchReqs;
	
	
}

function getWebsiteReq($searchterm, $startPosition, $sort, $VdkVgwKey){
	
	$authpcode = $_SERVER['AUTH_PCODE'];
	
   	//make the search filters and requirements for articles...

    $QueryParser = "Grolier_En";
    
    if($searchtype=="advanced"){
    	
    	$QueryParser = "Simple";
    	
    }
    
    //if this is a more like this search...change the search term
    if($VdkVgwKey){
    	$VdkVgwKey = base64_decode($VdkVgwKey);
    	$searchterm = "<LIKE>('{posex=vdkvgwkey:\"".$VdkVgwKey."\"}')";
    	$QueryParser = "Simple";
    }
   $goversion = array("ngo");
    if($authpcode=="eto"){ 
    	$goversion = array("eto");
    }//end if	
                                                       
	$searchFilter = array(
	                        'nextSearchFilter'  =>  null,
		                    'key'               =>  'GlobalSearchAssets',
		                    'valuesType'        =>  0,
		                    'values'            =>  $goversion,
		                    'filterType'        =>  0,
		                    'field'             =>  'go_version'
			                );
	$searchReq = array(
	                    'numResults'        =>  25,
		                'query'             =>  $searchterm,
		                'startingPosition'  =>  $startPosition,
		                'displayFields'     =>  array('title', 'first','score','VdkVgwKey','link','product_id', 'url', 'url_desc'),
		                'sortBy'            =>  $sort,
		                'indexes'           =>  array('gii'),
		                'queryParser'       =>  $QueryParser,
			            'firstSearchFilter' =>  $searchFilter
	    	            );
	$searchReqs = $searchReq;   	
	
	
	return $searchReqs;
	
	
}


function getMediaReq($searchterm, $startPosition, $sort, $VdkVgwKey){
	
	
   	//make the search filters and requirements for articles...

    $QueryParser = "Grolier_En";
    
    if($searchtype=="advanced"){
    	
    	$QueryParser = "Simple";
    	
    }
    
    //if this is a more like this search...change the search term
    if($VdkVgwKey){
    	$VdkVgwKey = base64_decode($VdkVgwKey);
    	$searchterm = "<LIKE>('{posex=vdkvgwkey:\"".$VdkVgwKey."\"}')";
    	$QueryParser = "Simple";
    }
    
  
                                                       
	$searchFilter = array(
	                        'nextSearchFilter'  =>  $searchFilterViewA,
		                    'key'               =>  'GlobalSearchAssets',
		                    'valuesType'        =>  0,
		                    'values'            =>  array("0mp", "0ma", "0mf", "0mmg", "0mmh", "0mm", "0mme", "0mmt"),
		                    'filterType'        =>  0,
		                    'field'             =>  'Asset Type'
			                );
	$searchReq = array(
	                    'numResults'        =>  25,
		                'query'             =>  $searchterm,
		                'startingPosition'  =>  $startPosition,
		                'displayFields'     =>  array('title', 'first','score','VdkVgwKey','link','product_id','type', 'url', 'assetid', 'srchqual'),
		                'sortBy'            =>  $sort,
		                'indexes'           =>  array('go2media'),
		                'queryParser'       =>  $QueryParser,
			            'firstSearchFilter' =>  $searchFilter
	    	            );
	$searchReqs = $searchReq;   	
	
	
	return $searchReqs;
	
	
}


function doTheSearch($searchReq, $SOAPClient){
	
	$result = doSearch($SOAPClient, $searchReq);
	
	if ($result) {
	   echo parseResults($result);
	}else{
	
	    echo "<p>Now let's do a 'did you mean' search, just for larfs</p>\n";
	    
	    $didYouMeanReq = array(
	                    'indexes'           =>  array('go2'),
	                    'maxSuggestions'    =>  5,
	                    'query'             =>  'Alabamx'
	                    );
	
	    $didYouMeanResult = $SOAPClient->didyoumean($didYouMeanReq);
	
	    if (Search_SOAPClient_GI::isError($didYouMeanResult)) {
	        print "<p>'Did you mean' error : " . $didYouMeanResult->getMessage() . "</p>\n";
	    }
	    else {
	        echo "<pre>\n";
	        print_r($didYouMeanResult);
	        echo "\n</pre>\n";
	    }
	
	}

}//end function

function didYouMean($SOAPClient, $searchtext){
		$retVal = "";
 		$didYouMeanReq = array(
	                    'indexes'           =>  array('go2'),
	                    'maxSuggestions'    =>  5,
	                    'query'             =>  $searchtext
	                    );
	
	    $didYouMeanResult = $SOAPClient->didyoumean($didYouMeanReq);
	
	    if (Search_SOAPClient_GI::isError($didYouMeanResult)) {
	        $retVal = "<p>'Did you mean' error : " . $didYouMeanResult->getMessage() . "</p>\n";
	    }
	    else {

	        $retVal = $didYouMeanResult;

	    }	
	
	return $retVal;
}


 /* Do Search */
    function doSearch($inSOAPClient, $inSearchReqs){

        $result = $inSOAPClient->search($inSearchReqs);

        if (Search_SOAPClient_GI::isError($result)) {
            print "<p>Error performing search: " . $result->getMessage() . "</p>\n";

            /*
            if (Search_SOAPClient_GI::isError($inSOAPClient)) {
                echo "<p><b>The SOAPClient object turned itself into an error object!</b></p>\n";
            }
            else {
                echo "<p>The SOAPClient object did not turn itself into an error object.</p>\n";
            }
            */

            return NULL;
        }
        return $result;
   }


function parseXSpaceResults($inResults){

		$authpcode = $_SERVER['AUTH_PCODE'];
		
		$db = DB::connect($_SERVER['DB_CONNECT_STRING']);
		if (DB::isError($db)) {
			print "connection to {$_SERVER['DB_CONNECT_STRING']} failed ";
		}
		
		//Connect to the eto database
		$appdb = DB::connect($_SERVER['APPENV_CONNECT_STRING']);
		if (DB::isError($appdb)) {
			echo "Error:  Could not retrieve mysql connect string for eto DB";
		}
		else {
			$sql = sprintf("select value from appenv where app='eto' and key_name='product_db';");
			$result = $appdb->query($sql)->fetchrow();
			$appdb->disconnect ();
		
			$db_eto=$result[0];
		}			

		$db_eto = DB::connect($db_eto);
		if (DB::isError($db_eto)) {
			//$this->_raiseError('No database connection', 8, 1);
			//return;
			echo "Error:  Could not connect to DB ETO1";
			exit;
			
		}		
		
		
		$searchResponse = $inResults[0];

    	$godb = DB::connect($_SERVER['GO2_CONNECT_STRING']);
		if (DB::isError($godb)) {
			print "connection to {$_SERVER['GO2_CONNECT_STRING']} failed ";
		}		

		if($authpcode=='xs'){
			$urlsql = sprintf("select url from product_urls WHERE type='0c' AND product_version='ngo1'");
		}else if($authpcode=='eto'){
			$urlsql = sprintf("select url from product_urls WHERE type='0cw' AND product_version='eto1'");
		}
		
		$urlresult = $godb->query($urlsql)->fetchrow();	
	
		//get the number of results
		$numHits = $searchResponse->getNumHits();

		$retVal = "";
		if($numHits){
	
		  	// Ok... Here's the place where we can apply simplexml...
		    $xml = simplexml_load_string($searchResponse->getResultsXML(), 'simpleXmlElement', LIBXML_NOCDATA);
		
		    $resultsNode = $xml->results;
	
	
		 	foreach ($resultsNode->result as $result){
	
				$product_id = $result->product_id;
		 		$theurl = str_replace("##ASSET_ID##", $result->assetid, $urlresult[0]);
		 		$theurl = str_replace("##PRODUCT_ID##", $product_id, $theurl);
		 		

				$theurl = str_replace("&uid=##UID##", "", $theurl);	
							 		
		 		
		 		$title = htmlspecialchars($result->title);
		 		$sql;
		 		
				if($product_id=='ngo'){		 		
					$sql = sprintf("select c.slp_id, c.fext from manifest c, manifest p where p.slp_id='$result->assetid' AND p.uid = c.puid and c.type = '0mip' and c.category='xs01'");
					//$resultRow = $db->query($sql)->fetchrow();
					$resultRow = & $db->getAll ($sql, DB_FETCHMODE_ASSOC );
				}else if($product_id=='eto'){
					$sql = sprintf("select c.slp_id, c.fext from manifest c, manifest p where p.slp_id='$result->assetid' AND p.uid = c.puid and c.type = '0mip' and c.category='xt01'");
					//$resultRow = $db_eto->query($sql)->fetchrow();
					$resultRow = & $db_eto->getAll ($sql, DB_FETCHMODE_ASSOC );
				
				}

				$imageAssetID = $resultRow[0]['slp_id'];	
				$ext = $resultRow[0]['fext'];	

		 		$imageURL = "/csimage?product_id=".$product_id."&id=".$imageAssetID."&ext=".$ext."&width=66&height=62";

		 		if($product_id=='ngo'){	
		 			$retVal .= '<div class="xspaceImg">';
		 			
		 		}else if($product_id=='eto'){
		 			$retVal .= '<div class="workshopImg">';
		 			
		 		}
		 	
		        $retVal .= '<a href="'.$theurl.'" title="'.$title.'"><img src="'.$imageURL.'" alt="'.$title.'" /></a>';
		    	$retVal .= '</div>'; 
		    
		        $retVal .= '<a href="'.$theurl.'" class="xspaceLink" title="'.$title.'">'.$title.'</a>';	
		 		
		    }    
			
			
		}//end if
return $retVal;
}
   
   
    function parseResults($inResults, $searchterm, $pageNum, $sort, $origsearchterm, $VdkVgwKey, $searchtype, $lexileArray, $lexilebegin, $lexileend, $readinglvl, $queryParser){


		$db = DB::connect($_SERVER['DB_CONNECT_STRING']);
		if (DB::isError($db)) {
			print "connection to {$_SERVER['DB_CONNECT_STRING']} failed ";
		}
    	
    	$retVal = "";
        $searchResponse = $inResults[1];

        $numHits = $searchResponse->getNumHits();
        $totalPages = ceil($numHits / 25);
     
        $numPages = $pageNum + 9;
        
        if($numPages > $totalPages){
        	
        	$numPages = $totalPages;
        }
        
        $lexilesearch = false;
        //figure out if this is a lexile\reading level search
        if(count($lexileArray) > 0){
        	
        	$lexilesearch = true;
        	
        }
        
        //figure out what values should be passed to the sort function
        $scoresort = 'score desc';
        $nextscoresort = 'score asc';
        if($sort == $scoresort){
        	$scoresort = 'score asc';

        	
        }
        
        $levelsort = "level desc";
        
  		if($sort == $levelsort){
        	$levelsort = 'level asc';
        	
        }        
        $lexilesort = "lexile desc";

  		if($sort == $lexilesort){
        	$lexilesort = 'lexile asc';
        	
        }         
        
        $sortArray = explode(" ",$sort);
        $sortCol = $sortArray[0];
        
        if($sortCol=="score"){
        	
        	$sortCol = "relevance";
        }
        
        $scoreClass = "relevance";
        $levelClass = "level";
        $lexileClass = "lexile";

        if($sortCol==$scoreClass){
        	if($scoresort == 'score asc'){
        		
        		$scoreClass = "first relevance";
        	}else{
        		$scoreClass = "firstasc relevance";	
        	}
        	
        	
        }else if($sortCol==$levelClass){
        	
        	
        	if($levelsort == 'level asc'){
        		
        		$levelClass = "first level";
        	}else{
        		$levelClass = "firstasc level";
        	}
        	
        	
		}else if($sortCol==$lexileClass){
        	
        	if($lexilesort == 'lexile asc'){
        		
        		$lexileClass = "first lexile";
        	}else{
        		$lexileClass = "firstasc lexile";
        	}        	
        	
        }


        $prevPage = $pageNum - 1;
        $nextPage = $pageNum + 1;
        $numResultsEnd = $pageNum * 25; 
        if($numResultsEnd > $numHits){
        	$numResultsEnd = $numHits;
        	
        }
        $numResultsStart = ($pageNum * 25) - (24);    
                
        	//if this is an advanced search then replace the "<" and ">" with html entities so they will display on the screen properly
        	$displaysearchterm = str_replace("<", "&#60;", $searchterm);
        	$displaysearchterm = str_replace("<", "&#62;", $displaysearchterm);
        	
        	//if the user did not enter in a search term, then make it a "*"
        	if(!$displaysearchterm){
        		
        		$displaysearchterm = "*";
        	}
        	
        	//if the user came from advanced search, and types in either a lexile range or clicks on reading levels
        	if(count($lexileArray) > 0){
        		
        		$displaysearchterm .= " articles with Lexile measure ";
        		
        		//if the user only entered in one lexile value... 
        		if(count($lexileArray) == 1){
        			
        			$displaysearchterm .= $lexileArray[0] . "L";
        			
        		//if he entered in more than one	
        		}else{
        			//go through all of the values..
        			for($i=0;$i<count($lexileArray); $i++){
        		
        				if ($i % 2 == 0 ){
        				
        					$displaysearchterm .= $lexileArray[$i] ."L to ";	
        				}else{
        					
        					$displaysearchterm .= $lexileArray[$i] . "L, ";
        					
        				}
        			}
        		
        		}//end if
        	//trim off the last comma
        	$displaysearchterm = substr($displaysearchterm, 0, -2);
        	}

     		$retVal .= '<div class="subSection">';
		    $retVal .='<p class="resultInfo">';
		    $retVal .='Showing '.$numResultsStart.' to '.$numResultsEnd.' of '. $numHits .' Results for:<br />';
		    $retVal .='<b>'.$displaysearchterm.'</b></p>';
		    $retVal .='<div class="pages">';
		    if($prevPage >= 1){
		    	$retVal .='<a href="/search?sort='.$sort.'&search_text='.$searchterm.'&page='.$prevPage.'&lexilebegin='. $lexilebegin.'&lexileend='.$lexileend.'&readinglvl='.$readinglvl.'&search_type='.$searchtype.'"  title="Back"><img class="back" src="images/search/arrow_left.jpg" alt="Back" /></a>';
		    }//end if 
		    
		    $retVal .='<div class="pageNumbers">';
		          $retVal .='<span>Page:</span>'; 
		         // $retVal .='<ol>';
		          
		        $newpageNum = $pageNum;

			        if($pageNum < 10){
			        	
			        
			        	$newpageNum = 1;
			       		$numPages = 10;
			        	
			        }else{	
			        
			        	$newpageNum = $pageNum - 5;
			        	$numPages = $pageNum + 4;
			        	
			        	
				        if($totalPages - $newpageNum < 10){
				        	
				        	$newpageNum = $totalPages - 9;
				        	
				        }			        	
			        }

			        
			        if($numPages > $totalPages){
			        	
			        	$numPages = $totalPages;
			        	
			        }
	        
		          for($i=$newpageNum;$i<=$numPages;$i++){
		          	
		          	$retVal .='<span style="padding-left:0px;padding-right:5px;">';
		          	if($pageNum!=$i){
		          		
		          		$retVal .='<a href="/search?sort='.$sort.'&search_text='.$searchterm.'&page='.$i.'&lexilebegin='. $lexilebegin.'&lexileend='.$lexileend.'&readinglvl='.$readinglvl.'&search_type='.$searchtype.'" title="page '.$i.'">';
		          		
		          	}
		          	$retVal .= $i;
		          	if($pageNum!=$i){
		          		$retVal .='</a>';
		          		
		          	}		          	
		          	$retVal .='</span>';
		          	
		          }
		         
		         $retVal .='</div>';        
		         
		         if($nextPage <= $totalPages){
		         	$retVal .='<a href="/search?sort='.$sort.'&search_text='.$searchterm.'&page='.$nextPage.'&lexilebegin='. $lexilebegin.'&lexileend='.$lexileend.'&readinglvl='.$readinglvl.'&search_type='.$searchtype.'" title="Next"><img class="next" src="images/search/arrow_right.jpg" alt="Next" /></a>';	
		         }
		         
		    $retVal .='</div></div>';
		    
		   

        if ($numHits) {
        	
        	$godb = DB::connect($_SERVER['GO2_CONNECT_STRING']);
			if (DB::isError($godb)) {
				print "connection to {$_SERVER['GO2_CONNECT_STRING']} failed ";
			}

            // Ok... Here's the place where we can apply simplexml...
            $xml = simplexml_load_string($searchResponse->getResultsXML(), 'simpleXmlElement', LIBXML_NOCDATA);

            
           // echo "DD " . print_r($searchResponse->getResultsXML()) . "<BR>";
            

            $resultsNode = $xml->results;
           // echo "AA " . print_r($resultsNode);

            $resultNumber = 1;
            $retVal .='<table cellpadding="0" cellspacing="0" width="100%" class="articles">';
            
				$retVal .='<tr>';
			        $retVal .='<th class="'.$scoreClass.'"><a href="/search?sort='.$scoresort.'&VdkVgwKey='.$VdkVgwKey.'&search_text='.$searchterm.'&page=1&lexilebegin='.$lexilebegin.'&lexileend='.$lexileend.'&readinglvl='.$readinglvl.'&search_type='.$searchtype.'" title="Sort by Relevance">Relevance</a></th>';
			        $retVal .='<th>Title</th>';
			        $retVal .='<th class="'.$levelClass.'"><a href="/search?sort='.$levelsort.'&VdkVgwKey='.$VdkVgwKey.'&search_text='.$searchterm.'&page=1&lexilebegin='.$lexilebegin.'&lexileend='.$lexileend.'&readinglvl='.$readinglvl.'&search_type='.$searchtype.'" title="Sort by Level">Level</a></th>';
			        $retVal .='<th class="'.$lexileClass.'</b>"><a href="/search?sort='.$lexilesort.'&VdkVgwKey='.$VdkVgwKey.'&search_text='.$searchterm.'&page=1&lexilebegin='.$lexilebegin.'&lexileend='.$lexileend.'&readinglvl='.$readinglvl.'&search_type='.$searchtype.'" title="Sort by Lexile">Lexile</a></th>';
			        
			          //COOKIE STUFF
					$cookiereader = new Cookie_Reader('xs');
			        
			        if($cookiereader->isloggedin()){
			       		$retVal .='<th class="last save"></th>';
			        }//end if
			       $retVal .='</tr>';           
			            
            foreach ($resultsNode->result as $result){

               $retVal .= parseResult($result, $resultNumber, $db, $godb, $cookiereader, $searchterm, $lexilesearch, $queryParser, $VdkVgwKey);
                $resultNumber++;
            }
            $retVal .='</table>';
        }
        
        
        $retVal .='<div class="bottomPages">';
	    if($prevPage >= 1){
	    	$retVal .='<a href="/search?sort='.$sort.'&search_text='.$searchterm.'&page='.$prevPage.'&lexilebegin='. $lexilebegin.'&lexileend='.$lexileend.'&readinglvl='.$readinglvl.'&search_type='.$searchtype.'"   title="Back"><img class="back" src="images/search/arrow_left_whtbg.jpg" alt="Back" /></a>';
	    }//end if         
        $retVal .='<div class="bottomPageNumbers">';
        $retVal .='<span>Page:</span>'; 

        
     for($i=$newpageNum;$i<=$numPages;$i++){
		          	
		          	$retVal .='<span style="padding-left:0px;padding-right:5px;">';
		          	if($pageNum!=$i){
		          		
		          		$retVal .='<a href="/search?sort='.$sort.'&search_text='.$searchterm.'&page='.$i.'&lexilebegin='. $lexilebegin.'&lexileend='.$lexileend.'&readinglvl='.$readinglvl.'&search_type='.$searchtype.'" title="page '.$i.'">';
		          		
		          	}
		          	$retVal .= $i;
		          	if($pageNum!=$i){
		          		$retVal .='</a>';
		          		
		          	}		          	
		          	$retVal .='</span>';
		          	
		          }
		         
     
		         
 	$retVal .='</div>';
		         
     if($nextPage <= $totalPages){
     	$retVal .='<a href="/search?sort='.$sort.'&search_text='.$searchterm.'&page='.$nextPage.'&lexilebegin='. $lexilebegin.'&lexileend='.$lexileend.'&readinglvl='.$readinglvl.'&search_type='.$searchtype.'" title="Next"><img class="next" src="images/search/arrow_right_whtbg.jpg" alt="Next" /></a>';	
     } 
		$retVal .='</div>';
 
		return $retVal;
    }



    function parseResult($inResult, $inResultNumber, $db, $godb, $cookiereader, $searchterm, $lexilesearch, $queryParser, $VdkVgwKey){
    
    	$rowResult = "";
    	$lexile = $inResult->lexile;
    	
		$sql = sprintf("select reading_level FROM readinglevel where $lexile >= lexile_begin AND $lexile <= lexile_end");
		$result = $db->query($sql)->fetchrow();
		$readinglevel = $result[0]['reading_level'];
		$type = $inResult->type;
		$assetid = $inResult->assetid;
		$productid = $inResult->product_id;
		$title = urlencode($inResult->title);
		$byline = $inResult->byline;
		
		if($byline !=""){
			
			$byline = " (" . $byline . ")";
		}
		 
		 $title = str_replace('+', ' ', $title);
		// $title = str_replace('.', '&#46;', $title);
		$productversion = "ngo1";
		if($productid=="eto"){
			
			$productversion = "eto1";
		}
		//echo "TYPE " . $type . " VERSION " . $productversion . "<BR>";
		$urlsql = sprintf("select url from product_urls WHERE type='$type' AND product_version='$productversion'");	

		$urlresult = $godb->query($urlsql)->fetchrow();		
		
		$urlresult = str_replace("##ASSET_ID##", $assetid, $urlresult[0]);
		$urlresult = str_replace("##PRODUCT_ID##", $productid, $urlresult);
		
		$urlresult = str_replace("&uid=##UID##", "", $urlresult);
		
		$docKey = $inResult->key;
		
		$urlresult = $urlresult . "&searchTerm=" . $searchterm . "&queryParser=" . $queryParser . "&docKey=" . $docKey;
		
    	$rowClass = "";
    	if($inResultNumber % 2){
    		$rowClass = 'class="odd"';
    		
    	}
    	
    	$rank = $inResult->score;
    	$rank = number_format($rank, 2);
    	$rank = $rank * 100.00;
    	$rank = $rank . "%";

    	if($searchterm=="" && $lexilesearch == true){
    		
    		$rank = "100%";
    		
    	}
    	
    	//find the title of the product this asset came from
		$productsql = sprintf("select description from products where product_id='$productid'");
		$data = & $db->getAll ($productsql, DB_FETCHMODE_ASSOC );
		$description = $data[0]['description'];			
    	
    	$rowResult .= '<tr '.$rowClass.'>';
	        $rowResult .= '<td class="relevance">'.$rank.'</td>';
	        $classlink = "";
	        if($productid=="eto"){
	        	$classlink = 'class="etolink"';
	        }
			ob_start();
			?>
			<td class="description"><a <?php echo $classlink;?> href="<?php echo $urlresult;?>" title="<?php echo $inResult->title;?>"><?php echo $inResult->title;?></a><br />	       	
			<?php
	        $rowResult .= ob_get_contents();

			ob_end_clean();		        
	        $rowResult .= '<span>'.$description.'</span><span>'.$byline.'</span><br />';
	        $rowResult .= $inResult->first . '<br />';
	        $rowResult .= '<a '.$classlink.' href="/search?search_text='.$searchterm.'&VdkVgwKey='.base64_encode($inResult->VdkVgwKey).'" title="More Like This">More like this</a></td>';
	        $rowResult .= '<td>';
	        
	        if($readinglevel==1){
	        	$rowResult .= '<a href="'.$urlresult.'" title="'.$inResult->title.'"><img src="images/common/level_one.png" alt="Level One" /></a>'; 
	        	
	        }else if($readinglevel==2){
	        	
	        	$rowResult .= '<a href="'.$urlresult.'" title="'.$inResult->title.'"><img src="images/search/level_two.png" alt="Level Two" /></a>'; 
	        	
	        }else if($readinglevel==3){
	        	
	       		$rowResult .= '<a href="'.$urlresult.'" title="'.$inResult->title.'"><img src="images/search/level_three.png" alt="Level Three" /></a>'; 	
	       		
	       	}else if($readinglevel==4){
	       		
	       		$rowResult .= '<a href="'.$urlresult.'" title="'.$inResult->title.'"><img src="images/common/level_four.png" alt="Level Four" /></a>'; 
	       	 	
	        }else{
	        	
	        	$rowResult .= '<a href="'.$urlresult.'" title="'.$inResult->title.'"><img src="images/common/level_na.png" alt="Level NA" /></a>'; 
	        }
	       
	        $lexile = $inResult->lexile;
	        if($lexile=="-1" || $lexile=="0"){
	        	
	        	$lexile = "N/A";
	        	
	        }
	        
	        $rowResult .= '</td>';
	        $rowResult .= '<td>'.$lexile.'</td>';
	        if($cookiereader->isloggedin()){
	        	$rowResult .= '<td><a href="#" onclick="saveAssetToDL(\''.$assetid.'\',\''.$productid.'\',\''.$type.'\',\''.$title.'\'); return false;" title="Save" class="save">Save</a></td>';
	        }//end if
	        $rowResult .= '</tr>';	       
        
        return $rowResult;

    }

 function parseWebsiteResults($inResults, $searchterm, $pageNum, $sort, $origsearchterm, $VdkVgwKey, $searchtype, $lexilebegin, $lexileend, $readinglvl){


		$db = DB::connect($_SERVER['DB_CONNECT_STRING']);
		if (DB::isError($db)) {
			print "connection to {$_SERVER['DB_CONNECT_STRING']} failed ";
		}
    	
    	$retVal = "";
        $searchResponse = $inResults[2];
		
        //find out thr number of pages
        $numHits = $searchResponse->getNumHits();
        $totalPages = ceil($numHits / 25);
     
        $numPages = $pageNum + 9;
        
        if($numPages > $totalPages){
        	
        	$numPages = $totalPages;
        }
        
        //figure out what values should be passed to the sort function
        $scoresort = 'score desc';
        if($sort == $scoresort){
        	$scoresort = 'score asc';
        	
        }
        
        $sortArray = explode(" ",$sort);
        $sortCol = $sortArray[0];
        
        if($sortCol=="score"){
        	
        	$sortCol = "relevance";
        }
        
        $scoreClass = "relevance";
        
 		if($sortCol==$scoreClass){
        	if($scoresort == 'score asc'){
        		
        		$scoreClass = "first relevance";
        	}else{
        		$scoreClass = "firstasc relevance";	
        	}
        	
        	
        }
        
        $displaysearchterm = $searchterm;
    	if(!$displaysearchterm){
    		
    		$displaysearchterm = "*";
    	}        

        $prevPage = $pageNum - 1;
        $nextPage = $pageNum + 1;
        $numResultsEnd = $pageNum * 25; 
        if($numResultsEnd > $numHits){
        	$numResultsEnd = $numHits;
        	
        }
        $numResultsStart = ($pageNum * 25) - (24);    
                
        
            $retVal .='<div class="subSection">';
		    $retVal .='<p class="resultInfo">';
		    $retVal .='Showing '.$numResultsStart.' to '.$numResultsEnd.' of '. $numHits .' Results for:<br />';
		    $retVal .='<b>'.$displaysearchterm.'</b></p>';
		    $retVal .='<div class="pages">';
		    if($prevPage >= 1){
		    	$retVal .='<a href="/search_websites?sort='.$sort.'&search_text='.$searchterm.'&page='.$prevPage.'&search_type='.$searchtype.'&lexilebegin='.$lexilebegin.'&lexileend='.$lexileend.'&readinglvl='.$readinglvl.'"  title="Back"><img class="back" src="images/search/arrow_left.jpg" alt="Back" /></a>';
		    }//end if 
		    
		    $retVal .='<div class="pageNumbers">';
		          $retVal .='<span>Page:</span>'; 

		        $newpageNum = $pageNum;
					if($pageNum < 10){
			        	
			        
			        	$newpageNum = 1;
			       		$numPages = 10;
			        	
			        }else{	
			        
			        	$newpageNum = $pageNum - 5;
			        	$numPages = $pageNum + 4;
			        	
  					if($totalPages - $newpageNum < 10){
			        	
			        	$newpageNum = $totalPages - 9;
			        	
			        }			        	
			        	
			        }
			        
			        
			        
			        if($numPages > $totalPages){
			        	
			        	$numPages = $totalPages;
			        	
			        }
			        
			        		        
 					for($i=$newpageNum;$i<=$numPages;$i++){
		          	
		          	$retVal .='<span style="padding-left:0px;padding-right:5px;">';
		          	if($pageNum!=$i){
		          		$retVal .='<a href="/search_websites?sort='.$sort.'&search_text='.$searchterm.'&page='.$i.'&search_type='.$searchtype.'&lexilebegin='.$lexilebegin.'&lexileend='.$lexileend.'&readinglvl='.$readinglvl.'" title="page '.$i.'">';
		          		
		          	}
		          	$retVal .= $i;
		          	if($numHits!=$i){
		          		$retVal .='</a>';
		          		
		          	}		          	
		          	$retVal .='</span>';
		          	
		          }
		         
		         $retVal .='</div>';        
		         
		         if($nextPage <= $totalPages){
		         	$retVal .='<a href="/search_websites?sort='.$sort.'&search_text='.$searchterm.'&page='.$nextPage.'&search_type='.$searchtype.'&lexilebegin='.$lexilebegin.'&lexileend='.$lexileend.'&readinglvl='.$readinglvl.'" title="Next"><img class="next" src="images/search/arrow_right.jpg" alt="Next" /></a>';	
		         }
		         
		    $retVal .='</div></div>';
		    
		   

        if ($numHits) {
        	
        	$godb = DB::connect($_SERVER['GO2_CONNECT_STRING']);
			if (DB::isError($godb)) {
				print "connection to {$_SERVER['GO2_CONNECT_STRING']} failed ";
			}

            // Ok... Here's the place where we can apply simplexml...
            $xml = simplexml_load_string($searchResponse->getResultsXML(), 'simpleXmlElement', LIBXML_NOCDATA);

            $resultsNode = $xml->results;

            $resultNumber = 1;
            $retVal .='<table cellpadding="0" cellspacing="0" class="articles" width="100%">';
            
			$retVal .='<tr>';
			$retVal .='<th class="'.$scoreClass.'"><a href="/search_websites?sort='.$scoresort.'&VdkVgwKey='.$VdkVgwKey.'&search_text='.$searchterm.'&page=1&lexilebegin='.$lexilebegin.'&lexileend='.$lexileend.'&readinglvl='.$readinglvl.'&search_type='.$searchtype.'" title="Sort by Relevance">Relevance</a></th>';
			$retVal .='<th>Title</th>';
			      //COOKIE STUFF
			$cookiereader = new Cookie_Reader('xs');
       
       		if($cookiereader->isloggedin()){
        		$retVal .='<th class="last save"></th>';
			}
			      
			$retVal .='</tr>';           
			            
            foreach ($resultsNode->result as $result){
               	$retVal .= parseWebsiteResult($result, $resultNumber, $db, $godb, $cookiereader);
                $resultNumber++;
            }
            $retVal .='</table>';
        }
        
        
        $retVal .='<div class="bottomPages">';
	    if($prevPage >= 1){
	    	$retVal .='<a href="/search_websites?sort='.$sort.'&search_text='.$searchterm.'&page='.$prevPage.'&search_type='.$searchtype.'&lexilebegin='.$lexilebegin.'&lexileend='.$lexileend.'&readinglvl='.$readinglvl.'"  title="Back"><img class="back" src="images/search/arrow_left_whtbg.jpg" alt="Back" /></a>';
	    }//end if         
        $retVal .='<div class="bottomPageNumbers">';
        $retVal .='<span>Page:</span>'; 
        $retVal .='<ol>';
 		
			        
		for($i=$newpageNum;$i<=$numPages;$i++){
       	
	       	$retVal .='<span style="padding-left:0px;padding-right:5px;">';
	       	if($pageNum!=$i){
	       		$retVal .='<a href="/search_websites?sort='.$sort.'&search_text='
	       				.$searchterm.'&page='.$i.'&search_type='.$searchtype.'&lexilebegin='.$lexilebegin.'&lexileend='.$lexileend.'&readinglvl='.$readinglvl.'" title="page">';
	       		
	       	}
	       	$retVal .= $i;
	       	if($numHits!=$i){
	       		$retVal .='</a>';
	       		
	       	}		          	
	       	$retVal .='</span>';
		          	
		         
      	}
		         
		$retVal .='</div>';        
		         
     if($nextPage <= $totalPages){
     	$retVal .='<a href="/search_websites?sort='.$sort.'&search_text='.$searchterm.'&page='.$nextPage.'&search_type='.$searchtype.'&lexilebegin='.$lexilebegin.'&lexileend='.$lexileend.'&readinglvl='.$readinglvl.'" title="Next"><img class="next" src="images/search/arrow_right_whtbg.jpg" alt="Next" /></a>';	
     } 
		$retVal .='</div>';
 
		return $retVal;
    }
    
 function parseWebsiteResult($inResult, $inResultNumber, $db, $godb, $cookiereader){
    	$rowResult = "";
    
		$title = addslashes(htmlspecialchars($inResult->title));
		$url = $inResult->url;
		$url_desc = $inResult->url_desc;
		

    	$rowClass = "";
    	if($inResultNumber % 2){
    		$rowClass = 'class="odd"';
    		
    	}
    	
    	$rank = $inResult->score;
    	$rank = number_format($rank, 2);
    	$rank = $rank * 100.00;
    	
    	$rank = $rank . "%";
    	
    	$rowResult .= '<tr '.$rowClass.'>';
	    $rowResult .= '<td class="relevance">'.$rank.'</td>';

	       
			ob_start();
			?>
			<td class="description"><a href="javascript:thePopup1.blurbWindow('<?php echo $url;?>', 725, 600, 'gii', 'on');" title="<?php echo $inResult->title;?>"><?php echo $inResult->title;?></a><br />	       
	       	<?php
	        $rowResult .= ob_get_contents();

			ob_end_clean();			
			
			$rowResult .= '<span>'.$url_desc.'</span><br />';
	        $rowResult .=  '<div style="width:700px;">'.$url. '</div><br />';
		        
			if($cookiereader->isloggedin()){
				
	       	 	$rowResult .= '<td><a href="#" onclick="saveWebLinkToDL(\''.$url.'\',3,\''.$title.'\',\'internal\'); return false;" title="Save" class="save">Save</a></td>';

			}//end if
	       	$rowResult .= '</tr>';	       
        
        return $rowResult;

    }

function parseMediaResults($inResults, $searchterm, $pageNum, $sort, $origsearchterm, $VdkVgwKey, $searchtype, $lexilebegin, $lexileend, $readinglvl){


		$db = DB::connect($_SERVER['DB_CONNECT_STRING']);
		if (DB::isError($db)) {
			print "connection to {$_SERVER['DB_CONNECT_STRING']} failed ";
		}
    	
    	$retVal = "";
        $searchResponse = $inResults[3];
		
        //find out thr number of pages
        $numHits = $searchResponse->getNumHits();
        $totalPages = ceil($numHits / 25);
     
        $numPages = $pageNum + 9;
        
        if($numPages > $totalPages){
        	
        	$numPages = $totalPages;
        }
        
        //figure out what values should be passed to the sort function
        $scoresort = 'score desc';
        if($sort == $scoresort){
        	$scoresort = 'score asc';
        	
        }
        
        $sortArray = explode(" ",$sort);
        $sortCol = $sortArray[0];
        
        if($sortCol=="score"){
        	
        	$sortCol = "relevance";
        }
        
        $scoreClass = "relevance";

 		if($sortCol==$scoreClass){
        	if($scoresort == 'score asc'){
        		
        		$scoreClass = "first relevance";
        	}else{
        		$scoreClass = "firstasc relevance";	
        	}
        	
        	
        }
        
        $displaysearchterm = $searchterm;
    	if(!$displaysearchterm){
    		
    		$displaysearchterm = "*";
    	}         

        $prevPage = $pageNum - 1;
        $nextPage = $pageNum + 1;
        $numResultsEnd = $pageNum * 25; 
        if($numResultsEnd > $numHits){
        	$numResultsEnd = $numHits;
        	
        }
        $numResultsStart = ($pageNum * 25) - (24);    
                
        
            $retVal .='<div class="subSection">';
		    $retVal .='<p class="resultInfo">';
		    $retVal .='Showing '.$numResultsStart.' to '.$numResultsEnd.' of '. $numHits .' Results for:<br />';
		    $retVal .='<b>'.$displaysearchterm.'</b></p>';
		    $retVal .='<div class="pages">';
		    if($prevPage >= 1){
		    	$retVal .='<a href="/search_media?sort='.$sort.'&search_text='.$searchterm.'&page='.$prevPage.'&search_type='.$searchtype.'&lexilebegin='.$lexilebegin.'&lexileend='.$lexileend.'&readinglvl='.$readinglvl.'" title="Back"><img class="back" src="images/search/arrow_left.jpg" alt="Back" /></a>';
		    }//end if 
		    
		    $retVal .='<div class="pageNumbers">';
		          $retVal .='<span>Page:</span>'; 

		          
		        $newpageNum = $pageNum;
					if($pageNum < 10){
			      
			        	$newpageNum = 1;
			       		$numPages = 10;
			        	
			        }else{	
			        
			        	$newpageNum = $pageNum - 5;
			        	$numPages = $pageNum + 4;

	  					if($totalPages - $newpageNum < 10){
				        	
				        	$newpageNum = $totalPages - 9;
				        	
				        }				        	
			        }
			        

			        			        
			        if($numPages > $totalPages){
			        	
			        	$numPages = $totalPages;
			        	
			        }  
		          for($i=$newpageNum;$i<=$numPages;$i++){
		          	
		          	$retVal .='<span style="padding-left:0px;padding-right:5px;">';
		          	if($pageNum!=$i){
		          		$retVal .='<a href="/search_media?sort='.$sort.'&search_text='.$searchterm.'&page='.$i.'&search_type='.$searchtype.'&lexilebegin='.$lexilebegin.'&lexileend='.$lexileend.'&readinglvl='.$readinglvl.'" title="page '.$i.'">';
		          		
		          	}
		          	$retVal .= $i;
		          	if($numHits!=$i){
		          		$retVal .='</a>';
		          		
		          	}		          	
		          	$retVal .='</span>';
		          	
		          }
		         
		         $retVal .='</div>';        
		         
		         if($nextPage <= $totalPages){
		         	$retVal .='<a href="/search_media?sort='.$sort.'&search_text='.$searchterm.'&page='.$nextPage.'&search_type='.$searchtype.'&lexilebegin='.$lexilebegin.'&lexileend='.$lexileend.'&readinglvl='.$readinglvl.'" title="Next"><img class="next" src="images/search/arrow_right.jpg" alt="Next" /></a>';	
		         }
		         
		    $retVal .='</div></div>';
		    
		   

        if ($numHits) {
        	
        	$godb = DB::connect($_SERVER['GO2_CONNECT_STRING']);
			if (DB::isError($godb)) {
				print "connection to {$_SERVER['GO2_CONNECT_STRING']} failed ";
			}

            // Ok... Here's the place where we can apply simplexml...
            $xml = simplexml_load_string($searchResponse->getResultsXML(), 'simpleXmlElement', LIBXML_NOCDATA);

            $resultsNode = $xml->results;

            $resultNumber = 1;
            $retVal .='<table cellpadding="0" cellspacing="0" width="100%" class="articles">';
            
				$retVal .='<tr>';
			        $retVal .='<th class="'.$scoreClass.'"><a href="/search_media?sort='.$scoresort.'&VdkVgwKey='.$VdkVgwKey.'&search_text='.$searchterm.'&page=1&lexilebegin='.$lexilebegin.'&lexileend='.$lexileend.'&readinglvl='.$readinglvl.'&search_type='.$searchtype.'" title="Sort by Relevance">Relevance</a></th>';
			        $retVal .='<th>Title</th>';
			        $retVal .='<th>Type</th>';
			        //COOKIE STUFF
					$cookiereader = new Cookie_Reader('xs');
			        
			        if($cookiereader->isloggedin()){
			        	$retVal .='<th class="last save"></th>';
			        }
			      $retVal .='</tr>';           
			            
            foreach ($resultsNode->result as $result){
               $retVal .= parseMediaResult($result, $resultNumber, $db, $godb, $cookiereader);
                $resultNumber++;
            }
            $retVal .='</table>';
        }
        
        
        $retVal .='<div class="bottomPages">';
	    if($prevPage >= 1){
	    	$retVal .='<a href="/search_media?sort='.$sort.'&search_text='.$searchterm.'&page='.$prevPage.'&search_type='.$searchtype.'&lexilebegin='.$lexilebegin.'&lexileend='.$lexileend.'&readinglvl='.$readinglvl.'"  title="Back"><img class="back" src="images/search/arrow_left_whtbg.jpg" alt="Back" /></a>';
	    }//end if         
        $retVal .='<div class="bottomPageNumbers">';
        $retVal .='<span>Page:</span>'; 

 		
			        
      for($i=$newpageNum;$i<=$numPages;$i++){
      	
      	$retVal .='<span style="padding-left:0px;padding-right:5px;">';
      	if($pageNum!=$i){
      		$retVal .='<a href="/search_media?sort='.$sort.'&search_text='.$searchterm.'&page='.$i.'&search_type='.$searchtype.'&lexilebegin='.$lexilebegin.'&lexileend='.$lexileend.'&readinglvl='.$readinglvl.'">';
      		
      	}
      	$retVal .= $i;
      	if($numHits!=$i){
      		$retVal .='</a>';
      		
      	}		          	
      	$retVal .='</span>';
      	
      }
		         
		$retVal .='</div>';        
		         
     if($nextPage <= $totalPages){
     	$retVal .='<a href="/search_media?sort='.$sort.'&search_text='.$searchterm.'&page='.$nextPage.'&search_type='.$searchtype.'&lexilebegin='.$lexilebegin.'&lexileend='.$lexileend.'&readinglvl='.$readinglvl.'" title="Next"><img class="next" src="images/search/arrow_right_whtbg.jpg" alt="Next" /></a>';	
     } 
		$retVal .='</div>';
 
		return $retVal;
    }    
    
function getproductDB($productid){
	
		$db = DB::connect($_SERVER['APPENV_CONNECT_STRING']);
		if (DB::isError($db)) {
			echo "Error: Could not retrieve mysql connect string for $productid";
		}
		$sql = sprintf("select value from appenv where app='$productid' and key_name='product_db';");
		$productDB = $db->getOne($sql);

	
		return $productDB;
	
}

 function parseMediaResult($inResult, $inResultNumber, $db, $godb, $cookiereader){
    	$rowResult = "";
    
		$title = addslashes($inResult->title);
		$type = $inResult->type;
		$srchqual = $inResult->srchqual;
		$assetid = $inResult->assetid;
		$productid = $inResult->product_id;
		

		//$url = $inResult->url;
		//$url_desc = $inResult->url_desc;
		
		if($productid=="(Unknown)"){

			$productid = "go";
		}

    	$rowClass = "";
    	if($inResultNumber % 2){
    		$rowClass = 'class="odd"';
    		
    	}
    	
    	$rank = $inResult->score;
    	$rank = number_format($rank, 2);
    	$rank = $rank * 100.00;
    	
    	$rank = $rank . "%";
    	$imgname = "map";
    	if($type=="0mp" || $type == "0ma"){
    		$imgname = "illustration";
    	}else if($type=="0mf"){
    		
    		$imgname = "flag";
    	}
    	
    //	$productDB = getproductDB($productid);
    	
		//$db = DB::connect($productDB);
		//if (DB::isError($db)) {
			//echo "Error: Could not retrieve mysql connect string for $productid $assetid $title";
		//}
		
		/**
		//find out if this is an rps product.
		$ngodb = DB::connect($_SERVER['DB_CONNECT_STRING']);
		if (DB::isError($ngodb)) {
			print "connection to {$_SERVER['DB_CONNECT_STRING']} failed ";
		}
		
		$sql = sprintf("Select isRPS from product_map where productid='{$productid}';");
		$result = $ngodb->query($sql)->fetchrow();
		$dataSource = ($result[0]==1) ? "RPS" : "LEGACY";
		
		if($productid=="go"){
			
			$assetsql = sprintf("select asset_id as id, fext from assets where asset_id='$assetid';"); 
			

		}else{
			if($dataSource=="RPS"){
				$assetsql = sprintf("select uid, slp_id as id, fext from manifest where slp_id='$assetid';"); 	
				
			}else{
				
				$assetsql = sprintf("select id, fext from assets where id='$assetid';"); 
	
			}
		}

		
		$assetArray = $db->getall($assetsql, DB_FETCHMODE_ASSOC);   	
		
		$newtitle = str_replace(" ", "%20", htmlspecialchars($title));
		$uid = $assetArray[0]['uid'];
		/**
		if(!$uid){
			
			$uid = $assetid;
			
			
		}
		*/
		
    	$godb = DB::connect($_SERVER['GO2_CONNECT_STRING']);
		if (DB::isError($godb)) {
			print "connection to {$_SERVER['GO2_CONNECT_STRING']} failed ";
		}		

		$assetsql = sprintf("select slp_id as id, fext, uid, product_id from manifest where slp_id='$assetid';");
		$assetresult = $godb->getall($assetsql, DB_FETCHMODE_ASSOC);   

		//$newtitle = str_replace(" ", "%20", $title);
		$uid = $assetresult[0]['uid'];
		$productid= $assetresult[0]['product_id'];

		$id = $assetresult[0]['id'];
		
		//$newtitle = addslashes($newtitle);
		
    	$rowResult .= '<tr '.$rowClass.'>';
	        $rowResult .= '<td class="relevance">'.$rank.'</td>';
	        if($type=="0mmg" || $type=="0mm" || $type=="0mmh" || $type=="0mme" || $type=="0mmt"){
	        	
	        	$atlasUrl = '\'atlas?id='.$assetid .'\',720,650, \'atlas\', \'no\', \'no\', \'no\', \'yes\', \'no\', \'no\',400,200';
	        
	        	$rowResult .= '<td class="description"><a href="#" onclick="thePopup1.newWindow('.$atlasUrl.');">'.$title.'</a> <span class="type">'.$srchqual.'</span></td>';
	        
	        }else{

			//ob_start();
			$title = str_replace('"',"%22", $title);
	       	$rowResult .= '<td class="description"><a href="#" onClick="showPopup(\''. $type .'\',\''.$title .'\',\''.$id.'\',\''.$productid.'\',\''.$assetresult[0]['fext'].'\',\'' . $uid.'\'); return false;">'.$inResult->title.'</a> <span class="type">'.$srchqual.'</span></td>';
	        	//$rowResult .= ob_get_contents();

				//ob_end_clean();

			}
	        
	        $rowResult .= '<td class="media"><img src="images/search/'.$imgname.'.jpg" alt="'.$imgname.'" /></td>';
		        
			if($cookiereader->isloggedin()){
				$title = str_replace('"',"%22", $title);
	       	 	$rowResult .= '<td><a href="#" onclick="saveAssetToDL(\''.$assetid.'\',\''.$productid.'\',\''.$type.'\',\''.$title.'\'); return false;" title="Save" class="save">Save</a></td>';

			}//end if
	       	$rowResult .= '</tr>';	       
        
        return $rowResult;

    }    
    
?>
