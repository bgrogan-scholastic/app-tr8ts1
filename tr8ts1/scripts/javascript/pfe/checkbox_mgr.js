//js functions to manage groups of checkboxes on a form
// - how would these work with radio buttons, etc if mixed on a page?


//checks or unchecks all subitems in a hierarchical tree of checkboxes on a form

function checkbox_checkAllChildren(parent) {

var checkbox_array = document.getElementsByTagName("input")
	//alert('parent id: ' + parent.id)
	for (var i=0; i < checkbox_array.length; i++ ) 	{ 
	str_search = new String(parent.id)
	search_for = 'z' + str_search + '_'
	str_item = new String(checkbox_array[i].name)
	search_item = 'z' + str_item
	//if (i < 5) 	{ alert(search_for + ' ' + search_item)	}
	result = search_item.search(search_for)
	//if (i < 5) 	{ alert(search_for + ' ' + search_item + ': ' + result)	}
	if ( result > -1) {
	//alert(checkbox_array[i].name) 
	document.getElementById(str_item).checked = parent.checked
	} 	
	  }
	}

//check or uncheck all checkbox items on page. 
function checkboxes(flag) {

	var checkbox_names = document.getElementsByTagName("input")
	for (var i=0; i < checkbox_names.length; i++ ) 	{ 
		document.getElementById(checkbox_names[i].name).checked = flag 
	}
}

