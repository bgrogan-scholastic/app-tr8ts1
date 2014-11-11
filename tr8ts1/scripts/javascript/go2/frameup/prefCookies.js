// BEGIN prefCookies.JS

	var kPreferenceEmail = "EM";
	var kPreferencePlugins = "PL";
	var kPreferenceCustomLogo = "CL";
	var kPreferenceAudio = "AU";
	var kPreferenceFrameless = "FL";
	var kPreferenceAdvertising = "AD";
	var kPreferenceToggle = "TO";
	var kPreferenceCurrentHome = "GH";

	var kPreferenceAppCurrentHome = "AGH";
	var kPreferenceAppToggle = "ATO";

	var kPREFSCookie = "prefs";
	var nameValueSeparator = ">";
	var CookieSeparator = "|";
	var MAX_COOKIE_LENGTH  = "3950";
	
	var kPreferenceValueKids = "K";
	var kPreferenceValueClassic = "C";
	var kPreferenceValuePassport = "P";
	var kPreferenceValueYes = "Y";
	var kPreferenceValueNo = "N";
	
function prefCookies() {

	/* STATIC VARIABLES */

	/* Store all of the current cookies into array so we can access them. */
	var cookie        = "";
	var index         = 0;
	var tmpcookie     = "";
	var kPrefsPath ="/";

	this.deletePrefCookies = function() {
		DeleteCookie(kPREFSCookie, kPrefsPath, kGOLDomain);	
	}

	this.stripTrailingPipe = function(cookieString) {
		if (cookieString.charAt(cookieString.length - 1) == CookieSeparator) {
			cookieString = cookieString.substr(0, cookieString.length - 1);
		}	
		return cookieString;
	}	

this.getSinglePrefValue = function(prefName) {
	/* Specify a single preference and I shall return you null or a value. */
	nullPrefValue = null;
	var existingPrefsCookieString = GetCookie(kPREFSCookie);
	
	if (existingPrefsCookieString == null || prefName == null) {
		return nullPrefValue;	
	}	
	
	existingPrefsCookieString = this.stripTrailingPipe(existingPrefsCookieString);
	/* Get the entire preferences array and split them by individual pref, then key/val */
	prefsArray = existingPrefsCookieString.split(CookieSeparator);
	var prefSize = prefsArray.length;
	for (index = 0; index< prefSize; index++) {
		pref = prefsArray[index].split(nameValueSeparator);
		if (pref[0] == prefName) {
			return pref[1];	
		}
	}
	return nullPrefValue;
}	

this.setPrefCookies = function(preferenceName, value)
{

	if (preferenceName != kPreferenceCustomLogo) {
		value = value.toUpperCase();
	}
	concatString = preferenceName + nameValueSeparator + value + CookieSeparator;
	
	var existingPrefsCookieString = GetCookie(kPREFSCookie);
	
	var cookieToSet = "";
	var prefSize;
	var index = 0;
	
	if (existingPrefsCookieString != null)
	{
		/* Get the string passed in, look for the key */
		prefToSet = concatString.substr(0, concatString.indexOf(nameValueSeparator));
		
		existingPrefsCookieString = this.stripTrailingPipe(existingPrefsCookieString);
		/* Get the entire preferences array and split them by individual pref, then key/val */
		prefsArray = existingPrefsCookieString.split(CookieSeparator);
		
		prefSize = prefsArray.length;
		var prefFound = -1;
		for (index = 0; index< prefSize && prefFound == -1; index++) {
			/* split to look for this pref's key/value */
			pref = prefsArray[index].split(nameValueSeparator);
			
			if(pref[0] != null) {
				/* if this preference is the one we're looking to set, discard the old value */
				if (pref[0] == prefToSet) {
					prefFound = index;
				}			
			}
			
		}
		
		if (prefFound == -1) {
			cookieToSet = existingPrefsCookieString + CookieSeparator + concatString;	
		}
		else {
			for (index = 0; index < prefSize; index ++) {
				if (index == prefFound) {
					cookieToSet = cookieToSet + concatString;	
				}	
				else {
					cookieToSet = cookieToSet + prefsArray[index] + CookieSeparator;
				}	
			}
		}
		SetCookie(kPREFSCookie, cookieToSet, null, kPrefsPath, kGOLDomain);			
		
	}
	else
	{
		SetCookie(kPREFSCookie, concatString, null, kPrefsPath, kGOLDomain);	
	}
		
	
}

this.convertPrefCookies = function() {
	emailValue = GetCookie("Email");	
	pluginValue = GetCookie("Plugins");
	logoValue = GetCookie("CustomLogo");
	audioValue = GetCookie("Audio");
	framelessValue = GetCookie("Frameless");

	setPrefCookies(kPreferenceEmail + nameValueSeparator+emailValue+CookieSeparator);
	setPrefCookies(kPreferencePlugins + nameValueSeparator+pluginValue+CookieSeparator);
	setPrefCookies(kPreferenceCustomLogo + nameValueSeparator+logoValue+CookieSeparator);		
	setPrefCookies(kPreferenceAudio + nameValueSeparator+audioValue+CookieSeparator);	
	setPrefCookies(kPreferenceFrameless + nameValueSeparator+framelessValue+CookieSeparator);
}
}

theprefCookie = new prefCookies();
// END prefCookies.js
