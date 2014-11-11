var overImgArray         = new Array();
overImgArray['encyc']    = new Image();
overImgArray['journ']    = new Image();
overImgArray['profiles'] = new Image();
overImgArray['editor']   = new Image();
overImgArray['help']     = new Image();
overImgArray['about']    = new Image();
overImgArray['encyc'].src    = "/images/ea3/nav-encycl-over.gif";
overImgArray['journ'].src    = "/images/ea3/nav-jour-over.gif";
overImgArray['profiles'].src = "/images/ea3/nav-profiles-over.gif";
overImgArray['editor'].src   = "/images/ea3/nav-editor-over.gif";
overImgArray['help'].src     = "/images/ea3/nav-help-over.gif";
overImgArray['about'].src    = "/images/ea3/nav-about-over.gif";

var offImgArray         = new Array();
offImgArray['encyc']    = new Image();
offImgArray['journ']    = new Image();
offImgArray['profiles'] = new Image();
offImgArray['editor']   = new Image();
offImgArray['help']     = new Image();
offImgArray['about']    = new Image();
offImgArray['encyc'].src    = "/images/ea3/nav-encycl-off.gif";
offImgArray['journ'].src    = "/images/ea3/nav-jour-off.gif";
offImgArray['profiles'].src = "/images/ea3/nav-profiles-off.gif";
offImgArray['editor'].src   = "/images/ea3/nav-editor-off.gif";
offImgArray['help'].src     = "/images/ea3/nav-help-off.gif";
offImgArray['about'].src    = "/images/ea3/nav-about-off.gif";

function imageOver(name) {
  document.images[name].src = overImgArray[name].src;
  return true;
}

function imageOff(name) {
  document.images[name].src = offImgArray[name].src;
  return true;
}
