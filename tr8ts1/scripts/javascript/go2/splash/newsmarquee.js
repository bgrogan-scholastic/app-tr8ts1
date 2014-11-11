<!-- begin: newsmarquee.js -->
<div id="tempholder"></div>

<script language="JavaScript">

<?php require($_SERVER['INCLUDE_HOME'] . '/javascript/go2/splash/dhtmllib.js'); ?>
<?php require($_SERVER['INCLUDE_HOME'] . '/javascript/go2/splash/scroller.js'); ?>

var createdScroller = 0;

/*
Mike's DHTML scroller (By Mike Hall)
Last updated July 21st, 02' by Dynamic Drive for NS6 functionality
For this and 100's more DHTML scripts, visit http://www.dynamicdrive.com
*/

//SET SCROLLER APPEARANCE AND MESSAGES
var myScroller1 = new Scroller(0, 0, 380, 32, 3, 5); //(xpos, ypos, width, height, border, padding)
myScroller1.setColors("#000000", "#FFFFFF", "#000000"); //(fgcolor, bgcolor, bdcolor)
myScroller1.setFont("Verdana,Arial,Helvetica", 2);

// Add in the AP news titles
</script>

<script language="JavaScript" src="/splashfiles/marquee.js"></script>

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
  if (is_mac && is_ie && !is_ie5_5up) {
    myScroller1.moveTo(58, 71);
    //alert('mac ie !5.5+');
  }
  else if (is_mac && is_safari) {
    myScroller1.moveTo(mikex+8, mikey+8);
    //alert('mac safari');
  }
  else if (!is_mac && is_ie5 && !is_ie5_5) {
    myScroller1.moveTo(mikex+1, mikey+17);
    //alert('!mac ie5 !ie5.5'); 
  }
  else
    myScroller1.moveTo(mikex, mikey);
  myScroller1.setzIndex(100);
  myScroller1.show();
}

window.onload=runmikescroll
</script>

<table align="center" border="0">
<tr nowrap="nowrap">
<td><a href="javascript:myScroller1.stop();"><img name="newsstop" src="/images/splash/btn_student_stop.gif" onMouseOver="javascript:imgOn('newsstop', 'btn_student_stop_on.gif')" onMouseOut="javascript:imgOff('newsstop', 'btn_student_stop.gif')" width="36" height="17" alt="Stop" title="Stop" border="0"></a></td>
<td><div id="placeholder" style="position:relative; width:380px; height:32px;"></div></td>
<!-- <td><a href="javascript:myScroller1.start();"><img src="/images/splash/btn_student_more.gif" width="36" height="17" alt="More" title="More" border="0"></a></td>-->
<td><a href="javascript:spapFirstStory();"><img name="newsmore" src="/images/splash/btn_student_more.gif" onMouseOver="javascript:imgOn('newsmore', 'btn_student_more_on.gif')" onMouseOut="javascript:imgOff('newsmore', 'btn_student_more.gif')" width="36" height="17" alt="More" title="More" border="0"></a></td>
</tr>
</table>
<!-- end: newsmarquee.js -->
