var theCookie2; 
var theCookie1;

function Cookie() {
	this.getCookieVal = function(offset) {
		var endstr = document.cookie.indexOf (";", offset);
		if (endstr == -1) {
			endstr = document.cookie.length;
		}
		return unescape(document.cookie.substring(offset, endstr));
	}
	this.GetCookie = function(name) {
		var arg = name + "=";
		var alen = arg.length;
		var clen = document.cookie.length;
		var i = 0;
		while (i < clen) {
			var j = i + alen;
			if (document.cookie.substring(i, j) == arg) {
				return this.getCookieVal (j);
			}
		        i = document.cookie.indexOf(" ", i) + 1;
			if (i == 0) break; 
		}
		return null;
	}
	this.SetCookie = function(name,value,expires,path,domain,secure) {
			document.cookie = name + "=" + escape (value) +
			((expires) ? "; expires=" + expires.toGMTString() : "") +
			((path) ? "; path=" + path : "") +
			((domain) ? "; domain=" + domain : "") +
			((secure) ? "; secure" : "");
	}
	this.SetCookieNoEscape = function(name,value,expires,path,domain,secure) {
		document.cookie = name + "=" + value +
			((expires) ? "; expires=" + expires.toGMTString() : "") +
			((path) ? "; path=" + path : "") +
			((domain) ? "; domain=" + domain : "") +
			((secure) ? "; secure" : "");
	}
	this.DeleteCookie = function(name,path,domain) {
		if (this.GetCookie(name)) {
			document.cookie = name + "=" +
				((path) ? "; path=" + path : "") +
				((domain) ? "; domain=" + domain : "") +
				"; expires=Thu, 01-Jan-70 00:00:01 GMT";
		}
	}
}


//creates a cookie
var theCookie = new Cookie();

function cookie_reader(productid) 
{

	var cookiename = 'prof_values_' + productid;

	//gets the 2 cookies
	theCookie2 = new cookiemanager('prof_values');
	theCookie1 = new cookiemanager(cookiename);

	//get the profile id
	this.getprofileid = function() 
	{
		return theCookie2.getSingleValue('profileid');
	}
	
	this.isloggedin = function()
	{
		
		var profileid = theCookie2.getSingleValue('profileid');
		if(profileid)
		{
			return true;
		}
		else
		{	
			return false;	
		}	
	}
	
	//update cookie
	this.updateSubCookie = function(key, value)
	{
		
		if(key=="readlvl"||key=="currassgn" || key=="bibliographyid" || key=="outlineid")
		{
			theCookie1.set(key, value);
		}
		else
		{
			theCookie2.set(key, value);		
		}
	}
	
	//gets stages
	this.getstages = function() 
	{
		return theCookie1.getSingleValue('stages');
	}
	
	//gets topics
	this.gettopics = function() 
	{
		return theCookie1.getSingleValue('topics');
	}
	
	//gets profile type
	this.getproftype = function() 
	{
		return theCookie2.getSingleValue('proftype');
	}
	
	//gets name
	this.getname = function() 
	{
		return theCookie2.getSingleValue('name');
	}
	
	//gets current entitlements
	this.getentitlements = function() 
	{
		return theCookie1.getSingleValue('entitlements');	
	}
	
	//gets current isstudent
	this.getisstudent = function() 
	{
		return theCookie1.getSingleValue('isstudent');	
	}
		
	//gets reading level
	this.getreadlvl = function() 
	{
		return theCookie1.getSingleValue('readlvl');	
	}	
}