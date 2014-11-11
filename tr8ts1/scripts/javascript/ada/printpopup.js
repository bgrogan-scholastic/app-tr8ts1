var gBlurbWindow;

function OpenPrintWindow(inContentURL, inWidth, inHeight) {
  gBlurbWindow = window.open(inContentURL,"Print","height="+inHeight+",width="+inWidth+",status=yes,scrollbars=yes,menubar=yes,resizable=yes")
  gBlurbWindow.opener = window
  //MSIE 4.0(1) in particular doesn't like the focus call.
  if (navigator.userAgent.indexOf("MSIE 4.0") != -1) {
    return;
  }
  if (navigator.userAgent.indexOf("MSIE 4.01") != -1) {
    return;
  }
  gBlurbWindow.focus();
}
