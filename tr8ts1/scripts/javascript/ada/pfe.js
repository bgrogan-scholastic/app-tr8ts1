<!-- pfe.js begin (ada version) -->

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
		document.printForm.submit();
		return;
	}

		this.resetForm = function() {
			document.printForm.reset();
			return;
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
