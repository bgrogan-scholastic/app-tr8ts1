function submitForm() {
  var ppWindowName = "friendlyprint";
  OpenPFBlurbWindow(520, 450, ppWindowName);
  document.printForm.target = ppWindowName;
  document.printForm.submit();
  return;
}

function resetForm() {
  document.printForm.reset();
  return;
}

function OpenPFBlurbWindow(inWidth, inHeight, inWindowName) {
  gBlurbWindow = window.open("",inWindowName,"height="+inHeight+",width="+inWidth+",scrollbars=yes,menubar=yes,resizable=yes");


  //MSIE 4.0(1) in particular doesn't like the focus call.
  if (navigator.userAgent.indexOf("MSIE 4.0") != -1) {
    return;
  }
  if (navigator.userAgent.indexOf("MSIE 4.01") != -1) {
    return;
  }

  gBlurbWindow.focus();
}

function selectAll() {
  var selectForm = document.printForm;
  for (i = 0; i < selectForm.elements.length; i++) {
    if (selectForm.elements[i].type == "checkbox") {
      selectForm.elements[i].checked = true;
    }
  }
}

function selectNone() {
  var selectForm = document.printForm;
  for (i = 0; i < selectForm.elements.length; i++) {
    if (selectForm.elements[i].type == "checkbox") {
      selectForm.elements[i].checked = false;
    }
  }
}

function changeAll(inState) {
   if (inState) {
      selectAll();
   } else {
      selectNone();
   }
}

function goToArticle() {
  var assetid = getQueryParameterValue("assetid");
  window.location = '/cgi-bin/article?assetid=' + assetid; 
}
