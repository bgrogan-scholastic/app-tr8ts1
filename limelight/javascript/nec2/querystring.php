<!-- begin querystring.php -->
<?php
	require_once($_SERVER['PHP_INCLUDE_HOME'] . 'nec2/common/utils/GI_include.php');
?>

function QueryString() {

    var queryParams = new Array();
    var params = new Array();
    var product = "";
  
    // create an internal class called Param
    this.Param = function(name, value) {
        this._name  = name;
        this._value = value;

        this.name = function() {
            return this._name;
        }
        this.value = function() {
            return this._value;
        }
    }
  
    this.value = function(name) {
        var sRetVal = "";
        // do we have a valid query string?
        if (location.search != "" && location.search != null) {
            var index;
            for (index = 0; index < params.length; index++) {
                if (params[index].name() == name) {
                    sRetVal = params[index].value();
                    break;
                }
            }
        }
        return sRetVal;
    }
	 
    this.parseQueryString = function() {
        if (location.search != "" && location.search != null) {
            var queryString = location.search;
            var queryArray  = queryString.substring(1).split("&");
            var index;
            // build the array of Param objects
            for (index = 0; index < queryArray.length; index++) {
                var pos = queryArray[index].indexOf("=");
                params[index] = new this.Param(queryArray[index].substring(0, pos), queryArray[index].substring(pos + 1));
            }
        }
    }


    // text is text to be parsed
    // parm is name= characters to search for
    // breakChar is the character that defines the end of the value
    // Example:  text="starthit=12345&state_id=0000345&query=dog"
    // If you want the value portion of state_id, then this is
    // how you call this function:
    // extractValue(text, "state_id=", "&");
    // it will return "0000345"
    this.extractValue = function(text, parm, breakChar) {
        beginSubstr = text.indexOf(parm);
        endSubstr = text.indexOf(breakChar,beginSubstr);
        if (endSubstr < beginSubstr) endSubstr = text.length;
        if ((beginSubstr >= 0) && (beginSubstr < text.length)) {
            beginSubstr += parm.length;
            return text.substr(beginSubstr,(endSubstr-beginSubstr));
        }
        else return "";
    }


    this.toggle = function () {
        tempString = document.location.href;
        hostname   = location.hostname.split('.');
        host       = hostname[0];

        // if this is an ada product, just strip that out
        if (hostname[0].search(/-ada/) != -1) {
            host = hostname[0].replace(/-ada/, '');
        } else {
            // this is a graphical product, so we need to add in the -ada
            // check for the word 'test', as this would indicate that we need to 
            // add in the '-ada' before that word
            index = hostname[0].search(/test/);
            if (index != -1) {
                host = hostname[0].substring(0, index) + '-ada' + hostname[0].substr(index);
            } else
                host += '-ada';
        }

        newUrl = "http://" + host + '.' + this.extractValue(tempString,".","~");

        if (hostname[0].search(/-ada/) != -1) {
            //if this is an ada product, set the rap cookie, then go to GO.
            //this will put the rap cookie location in the top frame
            //I removed the http here, since it's already in the basehref go file, and added by the go frame

	    newUrl  = newUrl.replace(/http:\/\//, '');
	    //newUrl = host + '.' + this.extractValue(tempString,".","~");
            theCookie.SetCookieNoEscape("rap", newUrl, null, "/", ".grolier.com", null);
	    top.window.location="<!--php:begin-->echo GI_Include($_SERVER['PRODUCT_CONFIG'] . '/basehref_go.html');<!--php:end-->";	    
        }
        else {
            //for graphical, NS7 doesn't like window.document.location
            top.window.location = newUrl;
        }
    } 

    this.removeNvPair = function(text, parm, breakChar) {
        var newString = "";
        beginSubstr = text.indexOf(parm);
        endSubstr = beginSubstr + parm.length;
        if ((beginSubstr >= 0) && (endSubstr <= text.length)) {  //valid pointers
            newString = text.substr(0,beginSubstr);  //part before parm(remove &)
            newString = newString + text.substr(endSubstr+breakChar.length); //part after parm
            return newString;
        }
        else return text;
    }

}

var theQueryString = new QueryString();
theQueryString.parseQueryString();

<!-- end querystring.php -->

