var hexVals = new Array("0","1","2","3","4","5","6","7","8","9","A","B","C","D","E","F");
var unsafeString = "\"<>\\^[]` ";

function urlEncode(val) {
	var state   = 'urlenc';
	var len     = val.length;
	var backlen = len;
	var i       = 0;

	var newStr  = "";
	var frag    = "";
	var encval  = "";

	for (i=0;i<len;i++) {
	// uncomment the next 7 commented lines to encode only the usual URL unsafe characters
		if (isURLok(val.substring(i,i+1))) {
			newStr = newStr + val.substring(i,i+1);
		}
		else {
			tval1=val.substring(i,i+1);
			newStr = newStr + "%" + decToHex(tval1.charCodeAt(0),16);
		}
	}
	return newStr;
}

function decToHex(num, radix) {
	var hexString = "";
	while (num >= radix){
		temp = num % radix;
		num = Math.floor(num / radix);
		hexString += hexVals[temp];
	}
	hexString += hexVals[num];
	return reversal(hexString);
}

function reversal(s) {
	var len = s.length;
	var trans = "";
	for (i=0; i<len; i++) {
		trans = trans + s.substring(len-i-1, len-i);
	}
	s = trans;
	return s;
}

function isURLok(compareChar) {
	if (unsafeString.indexOf(compareChar) == -1 && compareChar.charCodeAt(0) > 32 && compareChar.charCodeAt(0) < 123) {
		return true;
	}
	else {
		return false;
	}
}

