<!-- begin: newsmarquee.js -->
<div id="tempholder"></div>

<script language="JavaScript" src="/newsnow/dhtmllib.js"></script>
<script language="JavaScript" src="/newsnow/scroller.js"></script>
<script language="JavaScript">

var createdScroller = 0;

/*
Mike's DHTML scroller (By Mike Hall)
Last updated July 21st, 02' by Dynamic Drive for NS6 functionality
For this and 100's more DHTML scripts, visit http://www.dynamicdrive.com
*/

//SET SCROLLER APPEARANCE AND MESSAGES
var myScroller1 = new Scroller(0, 0, 480, 32, 3, 5); //(xpos, ypos, width, height, border, padding)
myScroller1.setColors("#000000", "#FFFFFF", "#000000"); //(fgcolor, bgcolor, bdcolor)
myScroller1.setFont("Verdana,Arial,Helvetica", 2);

// Add in the AP news titles
</script>

<script language="JavaScript" src="/newsnow/marquee.js"></script>

<script language="Javascript">
//SET SCROLLER PAUSE
myScroller1.setPause(2500); //set pause beteen msgs, in milliseconds

function runmikescroll() {
  var layer;
  var mikex, mikey;

  // Locate placeholder layer so we can use it to position the scrollers.

  layer = getLayer("placeholder");
  mikex = getPageLeft(layer);
  mikey = getPageTop(layer);

  // Create the first scroller and position it.
  myScroller1.create();
  myScroller1.hide();
  myScroller1.moveTo(mikex, mikey);
  myScroller1.setzIndex(100);
  myScroller1.show();
}

window.onload=runmikescroll
</script>

<table align="center" border="0"><tr nowrap="nowrap"><td><div id="placeholder" style="position:relative; width:480px; height:32px;"></div></td><td><a href="javascript:myScroller1.stop();"><img src="/images/newsnow/btn_student_news_stop.gif" alt="STOP" title="STOP" class="stopmarquee" width="36" height="18" border="0"></a></td></tr></table>
<!-- end: newsmarquee.js -->
