/** 
	@file: arch/bibliography.js
	@description: the function that calls the update of the cookie for the bibliography id
	
	function updatebibliograpy
	updates the bibliography id in the cookie
	Params - 
		assignmentid - the current assignment id
	returns nothing
*/

function updatebibliography(assignmentid) {	

	cookiereader.updateSubCookie("bibliographyid", assignmentid);
	
	bibliographyid = cookiereader.getbibliographyid();
	
}