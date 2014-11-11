
function loadPopup(uniqueid)
{	
	$('#'+uniqueid).popup();
}

function loadPopupLink(uniqueid, href)
{
	$.get(href, function(data){
		$('#'+uniqueid).popup();
		$('#'+uniqueid+' .content').html(data);
	});
}

function loadMediaPopup(uniqueid, mediaid)
{
	
	$("#"+uniqueid).popup();

	var videoFile = mediaid+".swf";
	vdo = AC_FL_CreateRunContent(
		'codebase', 'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0',
		'width', '<?php echo $defaultwidth; ?>',
		'height', '<?php echo $defaultheight; ?>',
		'src', mediaid,
		'quality', 'high',
		'pluginspage', 'http://www.macromedia.com/go/getflashplayer',
		'align', 'middle',
		'play', 'true',
		'loop', 'true',
		'scale', 'showall',
		'wmode', 'window',
		'devicefont', 'false',
		'id', mediaid,
		'bgcolor', '#666666',
		'name', '',
		'menu', 'true',
		'allowFullScreen', 'true',
		'allowScriptAccess','always', 
		'movie', '/limelight/'+mediaid+'?&flvfilename=rtmp://scholastic.fcod.llnwd.net/a1122/o16/ngo/dev/'+videoFile+'&baseurl=/limelight/',
		'salign', ''
	); //end AC code

	$("#"+uniqueid+" .content").html(vdo).append('<p align="left" ><a href="#" class="showcredit" style="text-weight: none; font-size: 10px; padding-top: 10px; margin-left: 5px;" onClick="return false">Credits</a></p>' +
			'<div align="center" class="assetcredit" style="width: <?php echo $defaultwidth ; ?>px; height: 55px; display: none; overflow: auto; text-align: left; margin-left: 5px;">'+credit+'</div>');
}