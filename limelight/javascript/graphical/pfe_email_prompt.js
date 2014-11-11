function emailArticle() {
  var addr = prompt("Please enter an e-mail address and click OK.", "");
  var error = false;

  if (addr != null) {
    if (addr == "") {
      error = true;
    } else {
      <!-- Check for the general format of user@domain.com -->
      var at = addr.indexOf("@");
      var period = addr.lastIndexOf(".");

      if ((at == -1 || period == -1) || period < at) 
        error = true;
    }
  
    if (error)
      alert("You did not specify a valid e-mail address!  Please use the format of 'user@domain.com'.");
    else {
      document.emailForm.recipient.value = addr;
      document.emailForm.submit();
    }
  }
}
