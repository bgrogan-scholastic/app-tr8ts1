<!-- begin: rollovers.js -->

var featureNames   = new Array("feat", "int", "desk", "world", "ap", "help");
var rolloverHome   = "/images/newsnow/btn_student_news_"; 
var numFeatures    = featureNames.length;

var offImgArray    = new Array(numFeatures);  
var onImgArray     = new Array(numFeatures);  
var activeImgArray = new Array(numFeatures); 
var imagesLoaded   = "no";

function loadImages() {
  for (var i=0; i < numFeatures; i++) {
    offImgArray[i]        = new Image();
    offImgArray[i].src    = rolloverHome + featureNames[i]+"_off.gif";
    onImgArray[i]         = new Image();
    onImgArray[i].src     = rolloverHome + featureNames[i]+"_on.gif";
    activeImgArray[i]     = new Image();
    activeImgArray[i].src = rolloverHome + featureNames[i]+"_sel.gif";
  }
}

// Display a different image for a mouseover event
function doMouseOverButton(theName){
  thisIndex = getIndexFor(theName);

  if (thisIndex == topLevelIndex) {
    document.images[theName].src = activeImgArray[thisIndex].src
      }
  else {
    document.images[theName].src = onImgArray[thisIndex].src
      }
}

function doMouseOutButton(theName){
  thisIndex = getIndexFor(theName);
  if (thisIndex == topLevelIndex) {
    document.images[theName].src = activeImgArray[thisIndex].src
      }
  else {
    document.images[theName].src = offImgArray[thisIndex].src
      }
}

function doActiveImage() {

  if (Feature == "") return;
  loadImages(); 
  topLevelIndex = getIndexFor(Feature);
  //alert("Feature " + Feature + "\ntopLevelIndex " + topLevelIndex);

  theName = featureNames[topLevelIndex];
  document.images[theName].src = activeImgArray[topLevelIndex].src;
}

function getIndexFor(item) {
  
  for (var i=0; i < numFeatures; i++) {
    if (item == featureNames [i]) return i;
  }
  return -1;//not found

}

<!-- end: rollovers.js -->
