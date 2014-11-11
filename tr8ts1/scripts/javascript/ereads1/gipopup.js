<!-- begin popup.js -->

function Popup() {
  // object variables
  this._gBlurbWindow;
  this._mainWindow = null;

  // object methods

  // set the focus after checking if the browser supports it
  this._setFocus = function() {
    //alert(navigator.userAgent);
    //MSIE 4.0(1) in particular doesn't like the focus call.
    if (navigator.userAgent.indexOf("MSIE 4.0") != -1) {
      return;
    }
    if (navigator.userAgent.indexOf("MSIE 4.01") != -1) {
      return;
    }
    this._gBlurbWindow.focus(); 
  }

  this.loadWindow = function(newLocation) {
    window.location.href = newLocation;
  }

  this.loadParent = function(newLocation) {
    this._loadBrowser(window.opener, false, newLocation);
  }
  
  // this function attempts to load an existing window by specifying its name
  this.loadWindowByName = function(newLocation, windowName) {
  	// catch exceptions, like Netscape 7.2 issues
  	try {
			var win = window.opener;
			// look through the window trail looking for who opened us
			while(win != null) {
				// did we find a window?
				if(win.name == windowName || win.name == "GOFRAME" || win.name == "goframe") {
					break;
				}
				win = win.opener;
			}
			// do we still have a valid window?
			if(win != null) {
				// did we find the requested window name?
				if(win.name == windowName) {
					win.location.href = newLocation;
					win.window.focus();
				// otherwise, nope, found the GOFRAME window, so load there in it's mainframe frame
				} else if(win.name == "GOFRAME") {
					// does it have any frames?
					if(win.frames == null) {
						win.location.href = newLocation;
						win.window.focus();
					// otherwise, yes, it has frames
					} else {
						win.frames[windowName].location.href = newLocation;
						win.frames[windowName].window.focus();
					}
				// otherwise, found the goframe nav window
				} else if(win.name == "goframe") {
					win.top.frames[windowName].location.href = newLocation;
					win.top.frames[windowName].window.focus();
				}
			// otherwise, no valid window so open a new one
			} else {
				win = this.newWindow(newLocation, windowName);
				win.window.focus();
			}
		// catch the exceptions (like access denied and win undefined) and
		// try to just open a window
		} catch(e) {
			win = window.open(newLocation, windowName);
			win.window.focus();
		}
  }

  // this function attempts to load an existing window by specifying its name
  // and close itself.
  this.loadWindowByNameAndClose = function(newLocation, windowName) {
  	// load the requested window
  	this.loadWindowByName(newLocation, windowName);
  	window.close();
  }

  this.loadGrandParent = function(newLocation) {
    this._loadBrowser(parent.window.opener.window.opener, false, newLocation);
  } 

  this.loadGrandParentAndClose = function(newLocation) {
    this._loadBrowser(parent.window.opener.window.opener, true, newLocation);
  }


  this.loadParentWindowAndClose = function(newLocation) {
    this._loadBrowser(window.opener, true, newLocation);
  }

  // this is the function that loads the appropriate window
  this._loadBrowser = function(winopener, close, newLocation) {
    // Check to see if the opener exists, else load a new window
    if (winopener == null || winopener.closed) {
      if (this._mainWindow == null)
        this._mainWindow = window.open(newLocation, 'mainframe', 'height=570,width=780,resizable=yes,menubar=yes,status=yes,scrollbars=yes,toolbar=yes,locationbar=yes');
      else
        this._mainWindow.location.href = newLocation;

      this._mainWindow.focus();

      if (close == true)
        window.close();
    } else { 	
      winopener.location = newLocation;
      winopener.focus();
      if (close == true) 
        window.close();
    }

  }


  //this function just figures out of a particular option is on or off.
  this._isAffirmative = function(option) {
    if (option == "yes" || option  == "on" || option == "true" || option == 1 || option == "1") {
      return 1;
    } else {
      return 0;
    }
  }
		

// PLEASE USE THIS FUNCTION FOR CREATING NEW POPUP WINDOWS
// 2-10-2005   Changed all the undefined things below to null
// to fix a problem in IE on the Mac    DKF
  this.newWindow = function(inContentURL, inWidth, inHeight, inWindowName, inResize, inMenubar, inStatusbars, inScrollbars, inToolbar, inLocationbar, inLeft, inTop) {

    if (inResize == null)
      inResize = "yes";

    if (inStatusbars == null)
      inStatusbars = "yes";

    if (inScrollbars == null)
      inScrollbars = "yes";

    if (inMenubar == null)
      inMenubar = "yes";

    if (inToolbar == null)
      inToolbar = "yes";

    if (inLocationbar == null)
      inLocationbar = "yes";
    
    // nabeel
    if(inLeft == null)
    	inLeft = 0;
    
    if(inTop == null)
    	inTop = 0;
		
	this._newBrowserWindow(inContentURL, inWidth, inHeight, inWindowName, 
                           inResize, inStatusbars, inScrollbars, inMenubar, 
                           inToolbar, inLocationbar, inLeft, inTop);
    this._setFocus();
	return this._gBlurbWindow;
  }
                

  // Private function for creating a new window
  this._newBrowserWindow = function(inContentURL, inWidth, inHeight, inWindowName, inResize, inStatusbars, inScrollbars, inMenubar, inToolbar, inLocationbar, inLeft, inTop) {

    options = "height=" + inHeight + ",width=" + inWidth;
                        
    //configure resizing option
    if (this._isAffirmative(inResize) == 1) {
      options = options + ",resizable=yes";
    } else {
      options = options + ",resizable=no";
    }

    //configure menubar option
    if (this._isAffirmative(inMenubar) == 1) {
      options = options + ",menubar=yes";
    } else {
      options = options + ",menubar=no";
    }

    //configure status bar option
    if (this._isAffirmative(inStatusbars) == 1) {
      options = options + ",status=yes";
    } else {
      options = options + ",status=no";
    }

    //configure scrollbars option
    if (this._isAffirmative(inScrollbars) == 1) {
      options = options + ",scrollbars=yes";
    } else {
      options = options + ",scrollbars=no";
    }

    //configure toolbar option
    if (this._isAffirmative(inToolbar) == 1) {
      options = options + ",toolbar=yes";
    } else {
      options = options + ",toolbar=no";
    }

    //configure locationbars option
    if (this._isAffirmative(inLocationbar) == 1) {
      options = options + ",locationbar=yes";
    } else {
      options = options + ",locationbar=no";
    }
    
    if(inLeft!=0)
    	options = options+",left="+inLeft;
    
    if(inTop!=0)
    	options = options+", top="+inTop;

    this._gBlurbWindow = window.open(inContentURL, inWindowName, options);
	 	this._gBlurbWindow.opener = window;
    this._setFocus();
  }




  




// ************************************************************************
// THE FUNCTIONS HERE ARE DEPRECATED.  PLEASE USE THE ABOVE FUNCTION
// FOR ANY POPUP WINDOW ACTIVITIES   
// ************************************************************************

		this._newWindow = function(inContentURL, inWidth, inHeight, inWindowName, inResize, inStatusbars, inScrollbars, inMenubar) {
			options = "height=" + inHeight + ",width=" + inWidth;
			
			//configure resizing option
			if (this._isAffirmative(inResize) == 1) {
				options = options + ",resizable=yes";
			}
			else {
				options = options + ",resizable=no";
			}

			//configure menubar option
			if (this._isAffirmative(inMenubar) == 1) {
				options = options + ",menubar=yes";
			}
			else {
				options = options + ",menubar=no";
			}

			//configure status bar option
			if (this._isAffirmative(inStatusbars) == 1) {
				options = options + ",status=yes";
			}
			else {
				options = options + ",status=no";
			}

			//configure scrollbars option
			if (this._isAffirmative(inScrollbars) == 1) {
				options = options + ",scrollbars=yes";
			}
			else {
				options = options + ",scrollbars=no";
			}

			this._gBlurbWindow = window.open(inContentURL, inWindowName, options);

			this._gBlurbWindow.opener = window;
			this._setFocus();
		}
		

		// this method opens a Blurb Window
		this.blurbWindow = function(inContentURL, inWidth, inHeight, inWindowName, inResize) {

			//order of parameters: URL, width, height, windowname, resize, statusbars, scrollbars, menubar
			this._newWindow(inContentURL, inWidth, inHeight, inWindowName, inResize, "yes", "yes", "yes");
			this._setFocus();
		}

		
		// This window doesn't have location or menu bars 
		this.boxWindow = function(inContentURL, inWidth, inHeight, inWindowName, inResize) {

			//order of parameters: URL, width, height, windowname, resize, statusbars, scrollbars, menubar
			this._newWindow(inContentURL, inWidth, inHeight, inWindowName, inResize, "yes", "yes", "no");
			this._setFocus();
		}
		

		// This window doesn't have location or menu bars or status bars
		this.boxWindowNoStatus = function(inContentURL, inWidth, inHeight, inWindowName, inResize) {

			//order of parameters: URL, width, height, windowname, resize, statusbars, scrollbars, menubar
			this._newWindow(inContentURL, inWidth, inHeight, inWindowName, inResize, "no", "yes", "no");
			this._setFocus();
		}

}

// create an instance of the Popup class
var thePopup1 = new Popup();