function OpenPopup(inContentURL,windowName) 
{ 
   theURL = location.href.substring(0,location.href.lastIndexOf("/") +1) 
	    + inContentURL; 

   aPopupWindow = window.open(theURL,windowName,
	"height=400,width=430,scrollbars=yes,menubar=no");

   if (!aPopupWindow) alert("Could not create popup"); 

} 

function IsItRight(theChoice) {

   var i;

   for (i=1; i<=3; i++) {
      if (theChoice != i) {   //
         imageName = "document.result" + i;
          /*  Need to replace spacer in the 'src' to the congrats image */ 
	  eval(imageName).src ="/images/common/spacer.gif";
      }
      else { 
          if (question == theChoice) {

		 OpenBlurbWindow('/games/ww/popup/popup.php?&gameid='+gameid,450,500,'Correct','no');
		 
    }


          else {
              imageName = "document.result" + theChoice;
              /*  Need to replace spacer in the 'src' to the congrats image */
	      eval(imageName).src = "/games/ww/images/ww-tryagain.gif";
          } 
      }
   }
} 

