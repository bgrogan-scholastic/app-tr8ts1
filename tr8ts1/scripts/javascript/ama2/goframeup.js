// begin ama2/goframeup.js
// Note: This version depends on a mod_rewrite redirect for
// the virtual url '/go', which redirects to the go server
// for the current environment.

var noFrameFlag = 0;
var i=0;
while (i < document.cookie.length) {
   if (document.cookie.substring(i, i+3) == "nf=") {
      noFrameFlag = 1;
      break;
   } else {
      i = document.cookie.indexOf(" ",i)+1;
      if (i == 0) break;
   }
}

if (!self.parent.frames.length && !noFrameFlag) {
    // Set the go wrapper cookie
    var targUrl = document.location.href;
    targUrl = targUrl.replace(/http:\/\//, '');
    document.cookie = "rap=" + targUrl + "; path=/; domain=.grolier.com";

    // go to the go frame
    if (is_ie) {
	    top.location.replace('/go');
    }
    else {
        top.window.location='/go';
    }
}
                                                                                
// end ama1/goframeup.js

