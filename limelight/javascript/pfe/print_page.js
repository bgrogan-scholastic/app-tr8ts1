function print_page() {

    var agt=navigator.userAgent.toLowerCase();
    var appVer = navigator.appVersion.toLowerCase();
	var is_mac = (agt.indexOf("mac")!=-1);
    var iePos = agt.indexOf('msie');

	if (iePos !=-1) {
       if(is_mac) {alert('You appear to be running\nInternet Explorer for Macintosh.\n\nPlease Click the Print icon\non your browser to \nPrint this page.'); }
} else print();
}