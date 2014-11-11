<!-- pfe.js begin -->

function pfe() {
	
	this.emailArticle = function() {
		var addr = prompt("Please enter an e-mail address and click OK.", "");
		var error = false;
		
		if (addr != null) {
			if (addr == "") {
				error = true;
			} else {
				<!-- Check for the general format of user@domain.com -->
				var at = addr.indexOf("@");
				var period = addr.lastIndexOf(".");

				if ((at == -1 || period == -1) || period < at) {
					error = true;
				}
			}
  
			if (error) {
				alert("You did not specify a valid e-mail address!  Please use the format of 'user@domain.com'.");
			}
			else {
				document.emailForm.recipient.value = addr;
				document.emailForm.submit();
			}
		}
	}


		this.submitForm = function() {
			var ppWindowName = "friendlyprint";
			OpenPFBlurbWindow(520, 450, ppWindowName);
			document.printForm.target = ppWindowName;
			document.printForm.submit();
			return;
		}

		this.resetForm = function() {
			document.printForm.reset();
			return;
		}


		//I think we'd be better off including the popup code here instead of calling a seperate function.
		this.OpenPFBlurbWindow = function(inWidth, inHeight, inWindowName) {
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
		
		this.selectAll = function() {
			var selectForm = document.printForm;
			for (i = 0; i < selectForm.elements.length; i++) {
				if (selectForm.elements[i].type == "checkbox") {
					selectForm.elements[i].checked = true;
				}
			}
		}

		this.goToArticle = function() {
			//var assetid = getQueryParameterValue("assetid");
			var assetid = theQueryString.value("assetid");
			window.location = '/cgi-bin/article?assetid=' + assetid; 
		}

		thisPFE = new pfe();

}

<!-- pfe.js end -->
