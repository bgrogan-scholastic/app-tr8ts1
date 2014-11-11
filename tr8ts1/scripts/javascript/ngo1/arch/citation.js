/** 
	@file: arch/citation.js
	@description: the function that calls the update of the citation count
	
	function displayCitationCount
	updates the citation count on the digital locker pages
	Params - 
		count - the citation count
	returns nothing
*/

function displayCitationCount(count) {
	$(function() {
		$('.sources_cited_count').html(count);	
	});
}