function OpenMultimediaWindow(link, width, height) {

	var gBlurbWindow = window.open(link, 'mmedia_popup',"height="+height+",width="+width+",scrollbars=yes,menubar=yes,status=yes,resizable=yes");

	gBlurbWindow.opener = window;

	//alert(navigator.userAgent);
    	//MSIE 4.0(1) in particular doesn't like the focus call.
	if (navigator.userAgent.indexOf("MSIE 4.0") != -1) {
      		return;
        }
        if (navigator.userAgent.indexOf("MSIE 4.01") != -1) {
                return;
        }
     
        gBlurbWindow.focus();
}

function loadArticleAndCloseMultimedia(newLocation) {  
        window.opener.location = newLocation;  
        popupwindow.close();  
        window.close();  
}  
 
function loadRelatedArticleAndClose(newLocation) { 
        window.opener.location = newLocation; 
        window.close(); 
} 
 
