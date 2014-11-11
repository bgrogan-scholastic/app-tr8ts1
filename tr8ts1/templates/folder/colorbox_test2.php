<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset=utf-8 />
	<title>ColorBox Examples</title>
	<style type="text/css">
		body{font:12px/1.2 Verdana, sans-serif; padding:0 10px;}
		a:link, a:visited{text-decoration:none; color:#416CE5; border-bottom:1px solid #416CE5;}
		h2{font-size:13px; margin:15px 0 0 0;}
	</style>
	<link media="screen" rel="stylesheet" href="/css/colorbox.css" />
	<script src="/javascript/tr8ts1/colorbox/jquery.min.js"></script>
	<script src="/javascript/tr8ts1/colorbox/jquery.colorbox.js"></script>
	<script>
		$(document).ready(function(){
			//Examples of how to assign the ColorBox event to elements
			$(".example6").colorbox({iframe:true, innerWidth:425, innerHeight:344});
			$(".example9").colorbox({iframe:true, innerWidth:808, innerHeight:630});
			
		});
	</script>
</head>
<body>
		<h2>Demonstration of using callbacks</h2>
		<p><a class='example9' href="http://traitspace-dev.grolier.com/folder/popup_video.php?filename=vtsk_u1w2_mv_crews&title=1">Example popup_video</a></p>
				
		<p><a class='example6' href="http://www.youtube.com/embed/617ANIA5Rqs?rel=0&amp;wmode=transparent" title="The Knife: We Share Our Mother's Health">Flash / Video (Iframe/Direct Link To YouTube)</a></p> 
		
		
</body>
</html>