//	This global variable is used to avoid issuing repeated Ajax requests with the same parameters.

		var lastAjaxUrl = ''

		//	********************************************************************************************
		//	*   ajaxRequest()                                                                          *
		//	*                                                                                          *
		//	*   This function handles an Ajax request by appending input values from a form object to  *
		//	*   a specified URL (to construct the request), executing the request, and then using one  *
		//	*   of two supplied functions to handle the response (one for a valid response, one for    *
		//	*   an error response.                                                                     *
		//	*                                                                                          *
		//	********************************************************************************************

		function ajaxRequest(baseUrl, form, ajaxOkay, ajaxFailed, callId) {

	        //      Construct the URL for the asynch call

			url = baseUrl
			for (i = 0; i < form.length; i++) {
				formfield = form.elements[i]
				//	Only use named form fields
				if (formfield.name.length == 0)
					continue
				if (url.indexOf('?') < 0)
					url += '?'
				else
					url += '&'
				parmval = formfield.value
				//	Have to encode + as %2B manually
				while (parmval.indexOf('+') >= 0)
					parmval = parmval.replace('+','%2B')
				url += formfield.name + '=' + parmval
			}
			// Do not ever execute the exact same call twice in a row; to force this, set lastDynamicGrabURL before calling dynamicHTMLGrabber

			if (url == lastAjaxUrl)
				return
			lastAjaxUrl = url

			// Get the request object

			req = false;
			if (window.XMLHttpRequest) {
				try {
					req = new XMLHttpRequest()
				} catch (e) {
					req = false
				}
			} else if (window.ActiveXObject) {
				try {
					req = new ActiveXObject("Msxml2.XMLHTTP")
				} catch(e) {
					try {
						req = new ActiveXObject("Microsoft.XMLHTTP")
					} catch(e) {
						req = false
					}
				}
			}

	        //	Abort if this isn't going to work

			if (!req) {
				ajaxFailed('This browser is not compatible.', callId)
				return
			}

			// Execute the asynch call with defined the callback function

		//	setAjaxInProgress()	-- for any slow running process, use this to display an animated "processing" type GIF.

			try {
				req.open('GET', url, true);
				req.onreadystatechange = function () {
					if (req.readyState == 4) {
						if(req.status == 200) {
							if (req.responseText == '')
								ajaxFailed('No response', callId)
							else {
								if (req.responseXML != null)
									ajaxOkay(req.responseXML, callId)
								else
									ajaxFailed("Non-XML response recieved: " + req.responseText, callId)
							}
						} else {
							ajaxFailed('Error in ' + url + ': ' + req.status, callId)
						}
					}
				}
				req.send(null)
			} catch (e) {
				ajaxFailed(e, callId)
			}
		}