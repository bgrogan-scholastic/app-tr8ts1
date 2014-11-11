/***********************************************
* Fixed ToolTip script- ? Dynamic Drive (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit http://www.dynamicdrive.com/ for full source code
***********************************************/
		
var tipwidth='350px' //default tooltip width
var tipbgcolor='#F5F5F5'  //tooltip bgcolor
var disappeardelay=250  //tooltip disappear speed onMouseout (in miliseconds)
var vertical_offset="10px" //horizontal offset of tooltip from anchor link
var horizontal_offset="0px" //horizontal offset of tooltip from anchor link

/////No further editting needed

var ie4=document.all
var ns6=document.getElementById&&!document.all

function getposOffset(what, offsettype){
	var totaloffset=(offsettype=="left")? what.offsetLeft : what.offsetTop;
	var parentEl=what.offsetParent;
	while (parentEl!=null){
		totaloffset=(offsettype=="left")? totaloffset+parentEl.offsetLeft : totaloffset+parentEl.offsetTop;
		parentEl=parentEl.offsetParent;
	}
	return totaloffset;
	}


function tipshowhide(obj, e, tipwidth){
	if (ie4||ns6)
		dropmenuobj.style.left=dropmenuobj.style.top=-500
	if (tipwidth!=""){
		dropmenuobj.widthobj=dropmenuobj.style
		dropmenuobj.widthobj.width=tipwidth
	}
	if (e.type=="click" && obj.display=="none" || e.type=="mouseover")
		obj.display=""
	else if (e.type=="click")
		obj.display="none"
}

function iecompattest(){
	return (document.compatMode && document.compatMode!="BackCompat")? document.documentElement : document.body
}

function clearbrowseredge(obj, whichedge){
	var edgeoffset=(whichedge=="rightedge")? parseInt(horizontal_offset)*-1 : parseInt(vertical_offset)*-1
	if (whichedge=="rightedge"){
		var windowedge=ie4 && !window.opera? iecompattest().scrollLeft+iecompattest().clientWidth-15 : window.pageXOffset+window.innerWidth-15
		dropmenuobj.contentmeasure=dropmenuobj.offsetWidth
		if (windowedge-dropmenuobj.x < dropmenuobj.contentmeasure)
			edgeoffset=dropmenuobj.contentmeasure-obj.offsetWidth
	}
	else{
		var windowedge=ie4 && !window.opera? iecompattest().scrollTop+iecompattest().clientHeight-15 : window.pageYOffset+window.innerHeight-18
		dropmenuobj.contentmeasure=dropmenuobj.offsetHeight
		if (windowedge-dropmenuobj.y < dropmenuobj.contentmeasure)
			edgeoffset=dropmenuobj.contentmeasure+obj.offsetHeight
	}
	return edgeoffset
}

function showtooltip(divname, obj, e, tipwidth){
	if (window.event) event.cancelBubble=true
	else if (e.stopPropagation) e.stopPropagation()
	hidetip()
	clearhidetip()
	dropmenuobj=document.getElementById? document.getElementById(divname) : fixedtipdiv
	
	if (ie4||ns6){
		if (tipwidth == "") tipwidth=dropmenuobj.style.width
		tipshowhide(dropmenuobj.style, e, tipwidth)
		dropmenuobj.x=getposOffset(obj, "left")
		dropmenuobj.y=getposOffset(obj, "top")
		dropmenuobj.style.left=dropmenuobj.x-clearbrowseredge(obj, "rightedge")+"px"
		dropmenuobj.style.top=dropmenuobj.y-clearbrowseredge(obj, "bottomedge")+obj.offsetHeight+"px"
	}
}

function hidetip(e){
	if (typeof dropmenuobj!="undefined"){
		if (ie4||ns6)
			dropmenuobj.style.display="none"
	}
}

function delayhidetip(){
	if (ie4||ns6)
		delayhide=setTimeout("hidetip()",disappeardelay)
}

function clearhidetip(){
	if (typeof delayhide!="undefined")
		clearTimeout(delayhide)
}
