// 3/28/2005: R.E. Dye
//
// Some JavaScript snippets needed by the Feature Showcase.

window.name = "showcase";
var FSDomain = "<?php echo $_SERVER['SERVER_NAME']; ?>";
var FSV=theCookie.GetCookie('FSV');

// Set the Feature Showcase Cookie to a new value.
function setFSVCookie(inCookieValue) {
   FSV = inCookieValue;
   document.cookie = "FSV="+FSV+"; path=/; domain="+FSDomain;
}

// Load a Quicktime version of the video playing html
function FSVPlayQuicktime(inMediaName) {
   setFSVCookie('Q');
   window.location.href='/showcase?tn=picpop/sl_<?php echo $FSVersion; ?>_media_quick_'+inMediaName+'.html';
}

// Load a Windows Media File version of the video playing html
function FSVPlayWindows(inMediaName) {
   setFSVCookie('W');
   window.location.href='/showcase?tn=picpop/sl_<?php echo $FSVersion; ?>_media_wmv_'+inMediaName+'.html';
}

