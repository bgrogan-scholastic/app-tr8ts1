function toArticle(viewname,dbname,query,docid,assetid) { 
	vv = "&viewname=";
	dv = "&dbname=";
	qv = "&query=";
	div = "&docid=";
	av = "assetid=";
	hv = "<!-- ##INCLUDE#TemplateName=/basehref_article.html&ALT_INCLUDE_HOME=EA3_CONFIG# -->"
	locationStr = ""
	
	if (query.indexOf("TEXT") >= 0) {
		//this is a fulltext search.  Must send hitword highlighting data
		locationStr = hv+av+assetid+div+docid+qv+query+dv+dbname+vv+viewname;
		locationStr = urlEncode(locationStr);
	}
	else {
		locationStr = hv+av+assetid;
	}
	
	document.location = locationStr;

}
