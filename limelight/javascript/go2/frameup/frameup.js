function checkRedirect()
{

	if(redirectToAuth == true)
	{
		setTimeout("checkRedirect()", 1000);
	}
}

/* always make sure to check for redirection to the authentication server*/
checkRedirect();
	
doneLoadingFrameSet = true;

self.name = kFrameSetName;

function openAtlas()
{
	var atlas_url = "/cgi-bin/go_atlas";
	
	atlas_url += "?product=GO&assetid=mgwr016";
	
	//open the window , but be sure that the map articles target is mainframe
	
	var mywindow = window.open(atlas_url, "atlaspopup", "HEIGHT=500,WIDTH=755,scrollbars=yes,menubar=yes,toolbar=no");	

//	P3P Fix
//	mywindow.opener = top.mainframe;
        mywindow.opener = mainframe;
}