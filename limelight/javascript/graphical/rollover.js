<!-- rollover.js:begin -->

//--------------------------------------------------------------------
// These are the necessary rollover functions common to any
// javascript rollover, not page dependent.
//--------------------------------------------------------------------


// **************************************************************
// Object       : Rollover
// Author       : Doug Farrell
// Comments     : This is a Javascript 'object' that handles html
// image rollovers.
// Parameters   :
//   srcImage   : name of html image that is the rollover
//   ovImage    : filepath to use for over image
//   upImage    : filepath to use for up image
//   dnImage    : filepath to use for down image
// **************************************************************
function Rollover(srcImage, ovImage, upImage, dnImage) {
	// initialize our member variables
	if (document.images) {
		this._ovImage = new Image();
		this._dnImage = new Image();
		this._upImage = new Image();

		this._srcImage     = document.images[srcImage];
		this._ovImage.src  = ovImage;
		this._upImage.src  = upImage;
		this._dnImage.src  = dnImage;
	}

	// create our methods
	this.mouseOut = function() {
		if (document.images) {
			this._srcImage.src = this._upImage.src;
		}
	}

	this.mouseOver = function() {
		if (document.images) {
			this._srcImage.src = this._ovImage.src;
		}
	}

	this.mouseDown = function() {
		if (document.images) {
			this._srcImage.src = this._dnImage.src;
		}
	}

	this.mouseUp = function() {
		if (document.images) {
			this._srcImage.src = this._upImage.src;
		}
	}

}

//you might have to instantiate your own object here, bieng 
//that you'll have to pass it parameters not otherwise available. 

<!-- rollover.js:end -->
