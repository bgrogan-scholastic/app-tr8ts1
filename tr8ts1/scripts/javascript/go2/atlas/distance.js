// distance:begin
// 
//
// This module contains javascript code that determines the distance between two points on the
// face of the earth based on their latitude and longitude
// 
// displayLatsLongs
//
// This function outputs the latitue, longitude and title for a spot
// to the text object specified
//
function displayLatsLongs(title, latitude, longitude) {
	// does the object exist?
	point = new Object;
	point["latitude"]   = latitude;
	point["longitude"] = longitude;
	point = convertToDegrees(point);
	info = title + "\nLatitude = " + point.latitude + ", longitude = " + point.longitude;
	document.latslongslocaldistance.displaydata.value = info;
}

// function to clear the display area
function clearLatsLongs() {
	document.latslongslocaldistance.displaydata.value = "";
	// do this for the local distance finder
	spid1 = null;
	spid2 = null;
}

function deg2rad(degree) {
	return degree * (Math.PI / 180);
}

// 
// This function does the actual calculation of the distance between two points
// This is based on spherical geometry with a bit of compensation because the earth
// isn't really round, it's a little squashed.
//
// params    : points - array of points x1, y1, x2, y2, each point is a floating point number
// returns   : array  - distance in miles between the two points (miles, kilometers)
//
function calculateDistance(points) {
	// create return object
	retval = new Object();
	// latitude/longitude for first point
	lat1 = deg2rad(points[0]);
	long1 = deg2rad(points[1]);

	// latitude/longitude for second point
	lat2 = deg2rad(points[2]);
	long2 = deg2rad(points[3]);

	// delta between the points
	dlat = Math.abs(lat2 - lat1);
	dlong = Math.abs(long2 - long1);
  
	// do the calculation to determine the distance
	l = (lat1 + lat2) / 2;
	a = 6378;
	b = 6357;
	e = Math.sqrt(1 - (b * b)/(a * a));
  
	r1 = (a * (1 - (e * e))) / Math.pow((1 - (e * e) * (Math.sin(l) * Math.sin(l))), 3/2);
	r2 = a / Math.sqrt(1 - (e * e) * (Math.sin(l) * Math.sin(l)));
	ravg = (r1 * (dlat / (dlat + dlong))) + (r2 * (dlong / (dlat + dlong)));

	sinlat = Math.sin(dlat / 2);
	sinlon = Math.sin(dlong / 2);
	a = Math.pow(sinlat, 2) + Math.cos(lat1) * Math.cos(lat2) * Math.pow(sinlon, 2);
	c = 2 * Math.asin(Math.min(1, Math.sqrt(a)));
	d = ravg * c; 
	// save the kilometers
	retval["kilometers"] = d
	// convert to miles and save
	retval["miles"] = d * 0.62111802;
	// return the Object of values
	return retval;
}

//
// This function takes a point (object with latitude/longitude)
// and converts it to an object of degrees/minutes/seconds format
// This is for the display in longs/lats page of the atlas
// params
//		point : object with two properties, latitude/longitude
// returns
//	        : object containing two properties, latitude/longitude as a string
//
function convertToDegrees(point) {
	retval = new Object;
	// convert latitude
	latitude = point.latitude;
	deg = parseInt(latitude);
	// get minutes
	temp = (latitude - deg) * 60;
	min = parseInt(temp);
	// get seconds
	sec = (temp - min) * 60;
	sec = formatNumber(sec, 2);
	// are we in the north or south hemisphere?
	if(latitude >= 0) {
		hemisphere = " N";
	} else {
		hemisphere = " S";
	}
	// format the string
	retval["latitude"] = Math.abs(deg) + String.fromCharCode(176) + " " + Math.abs(min) + "' " + Math.abs(sec) + String.fromCharCode(34) + " " + hemisphere;

	// convert longitude
	longitude = point.longitude;
	deg = parseInt(longitude);
	// get minutes
	temp = (longitude - deg) * 60;
	min = parseInt(temp);
	// get seconds
	sec = (temp - min) * 60;
	sec = formatNumber(sec, 2);
	// are we in the north or south hemisphere?
	if(longitude >= 0) {
		hemisphere = " E";
	} else {
		hemisphere = " W";
	}
	// format the string
	retval["longitude"] = Math.abs(deg) + String.fromCharCode(176) + " " + Math.abs(min) + "' " + Math.abs(sec) + String.fromCharCode(34) + " " + hemisphere;

	// return the object
	return retval;
}

//
// This function will format a floating point number in a fixed decimal 
// format, kind of like what printf() does in C
//
// params : expr      - value to format
// params : decplaces - decimal places to use
//
function formatNumber(expr, decplaces) {
	var str = "" + Math.round(eval(expr) * Math.pow(10, decplaces));
	while (str.length <= decplaces) {
		str = "0" + str;
	}
	var decpoint = str.length - decplaces;
	return str.substring(0, decpoint) + "." + str.substring(decpoint, str.length);
}

// variables to keep track of the selected hotspot for local distance finder
var spid_one = null;
var spid_two = null;

function addSpotID(asset_id, spotid, title) {
	// starting fresh?
	if(spid_one == null) {
		spid_one = spotid;
		document.latslongslocaldistance.displaydata.value = "First city : " + title;
	// otherwise, doing the second click
	} else {
		// is the spot different than spot1?
		if(spotid != spid_one) {		
			spid_two = spotid;
			window.location.href = "/atlas?id=" + asset_id + "&op=ld&spid1=" + spid_one + "&spid2=" + spid_two;
		// otherwise, can't use the same spot again
		} else {
			alert("Please choose a different location");
		}
	}
}

// distance:end
