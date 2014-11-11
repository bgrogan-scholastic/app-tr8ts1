
<!-- sound.js:begin -->

<!-- Initialize browser variables -->
var browser = '';
var isNS = false;
var isIE = false; 

<!-- Determine the type of browser the user is running -->
if (navigator.userAgent.indexOf("MSIE") == -1) {
  isNS = true;
} else {
  isIE = true;
}

function soundError() { 
  location.href = mysound; 
  return true; 
} 

<!-- Determine what version browser the user is using -->
if (isNS) {
  if (navigator.appVersion.indexOf("5.") == 0) {
    browser = 'ns5';	
  }
  if (navigator.appVersion.indexOf("4.") == 0) {
    browser = 'ns4';
  }
  if (navigator.appVersion.indexOf("3.") == 0) {
    browser = 'ns3';
  }
} else if (isIE) {
  if (navigator.appVersion.indexOf("MSIE 4") >= 0) {
    browser = 'ie4';
  } else {
    browser = 'ie5';
  }
}

if (browser == '') 
  browser = 'default';

document.write("<SCR" + "IPT LANGUAGE='JavaScript1.2' SRC='/gme-ol/multimedia/sounds/includes/sound_" + browser + ".js' TYPE='text/javascript'><\/SCR" + "IPT>");

<!-- sound.js:end -->
