// text is text to be parsed
// parm is name= characters to search for
// breakChar is the character that defines the end of the value
// Example:  text="starthit=12345&state_id=0000345&query=dog"
// If you want the value portion of state_id, then this is
// how you call this function:
// extractValue(text, "state_id=", "&");
// it will return "0000345"

function extractValue(text, parm, breakChar) {
	beginSubstr = text.indexOf(parm);
	endSubstr = text.indexOf(breakChar,beginSubstr);
	if (endSubstr < beginSubstr) endSubstr = text.length;
	if ((beginSubstr >= 0) && (beginSubstr < text.length)) {
		beginSubstr += parm.length;
		return text.substr(beginSubstr,(endSubstr-beginSubstr));
	}
	else return "";
}

