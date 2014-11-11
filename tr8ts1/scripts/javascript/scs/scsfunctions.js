/**
This function makes the ajax request.

PARAMS - requestUrl - the variables that you want to pass the PHP to make the http request url to SCS.
			one variable must be called 'method' and must contain the method you want to call for SCS.  For example, 
			"ScsBrowse".  All the other variables should be the other variables you need to make the SCS call.  Make sure
			the variable names are the same as Scs.
			
		handleFunction - the function you want to be called after the xml is returned.  This function will handle the results.	 

It takes in the requestUrl... passes it to the PHP page using AJAX.  then it grabs the result that is returned, turns it into
XML and passes the XML to the function you passed in "handleFunction" which will handle the xml results.
*/
function ajaxRequest(requestUrl, handleFunction, topic_id){
	
	

	var request_o; //declare the variable to hold the object.
	var browser = navigator.appName; //find the browser name
	if(browser == "Microsoft Internet Explorer"){
		/* Create the object using MSIE's method */
		request_o = new ActiveXObject("Microsoft.XMLHTTP");
	}else{
		/* Create the object using other browser's method */
		request_o = new XMLHttpRequest();
	}
	/* The variable http will hold our new XMLHttpRequest object. */
	var http = request_o; //return the object

	//open the php page..and send it the request variables
//alert(requestUrl);
	http.open("GET", "phpHttpRequest.php?"+requestUrl);

//alert(requestUrl);

	/* Define a function to call once a response has been received. This will be our
		handleProductCategories function that we define below. */
	http.onreadystatechange = function () {
		
		if(http.readyState == 4){//Finished loading the response

			//grab the response in XML
			var response = http.responseXML;
			var response1 = http.responseText;
			//alert(response1);

			//send it to the function you want to handle the request.
			handleFunction(response, topic_id);
			
		}//end if

	
	}//end function
	
	/* Send the data. We use something other than null when we are sending using the POST
		method. */
	http.send(null);
	
	
	
}//end function ajaxRequest
