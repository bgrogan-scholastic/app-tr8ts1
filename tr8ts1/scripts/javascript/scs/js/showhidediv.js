
function showAndHide(id1, id2){
	if (document.getElementById){
		obj1 = document.getElementById(id1)
		obj2 = document.getElementById(id2)
		obj1.style.display = ""
		obj2.style.display = "none"
	}
}

function showhide(id){
	if (document.getElementById){
		obj = document.getElementById(id)
		if (obj.style.display == "none") {
			obj.style.display = ""
		} else {
			obj.style.display = "none"
		}
	}
} 

function showdiv(id){
	if (document.getElementById) {
			obj = document.getElementById(id)
			obj.style.display = ""
	}
} 

function hidediv(id){
	if (document.getElementById){
		obj = document.getElementById(id)
		obj.style.display = "none"
	}
} 