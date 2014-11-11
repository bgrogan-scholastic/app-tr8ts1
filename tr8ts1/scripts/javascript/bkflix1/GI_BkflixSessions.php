// Set the Bookflix session cookie
function setBookflixSessionCookie(){
    var cookie_date = new Date( );  // current date & time
    cookie_date.setTime(cookie_date.getTime() + (1000*60*5));    // five minutes
    document.cookie = "BFSESS=Y; expires=" + cookie_date.toGMTString() + "; path=/; domain=<?php echo $_SERVER[SERVER_NAME]; ?>";
}
