
function collectStat(service,product,feature,id)
{
	if(typeof(id) == "undefined") { id = ""; }
	
	var info = { service: service, product: product, feature: feature };	
	
	if(id != "") {
		info.id = id;
	}
	
	$.ajax({
		type: "GET",
		url: "/statrecorder",
		async: true, 
		dataType: "text",
		data: info
	});
}

function session_stat()
{	
	$.ajax({
		type: "GET",
		url: "/sessionrecorder",
		async: true
	});
}