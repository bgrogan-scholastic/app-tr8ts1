<!-- begin: int_dates.js -->

function setDateValue(modifiedObj, objToSet) {

  // Check the value of the second object
  var indexToSet = eval("document.eajform." + objToSet + ".selectedIndex");

  // If empty
  if (indexToSet <= 1) {

    // Get value of first object, and set second object to the same value
    var setIndex = eval("document.eajform." + modifiedObj + ".selectedIndex");

    if (setIndex > 1) 
      eval("document.eajform." + objToSet + ".options[" + setIndex + "].selected = true"); 

  }

}

<!-- end: int_dates.js -->
