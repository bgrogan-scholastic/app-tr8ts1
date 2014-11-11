<%@ page import="com.grolier.common.AppEnvironment" %>

<%
	AppEnvironment appenv = (AppEnvironment)application.getAttribute("appenv");
	String gmeBaseHref = appenv.getValue("basehref");
%>

/* This is the one javascript settings page that the splash will respond to. (In other words, don't use HM_Arrays.js) TSM */


	HM_Array1 = [
	[225,      // menu width
	133,       // left_position (was 5)
	42,       // top_position (was 99)
	"201579",   // font_color
	"201579",   // mouseover_font_color
	"E0DD99",   // background_color
	"F8F6BE",   // mouseover_background_color
	"E0DD99",   // border_color
	"E0DD99",    // separator_color
	0,         // top_is_permanent
	0,         // top_is_horizontal
	0,         // tree_is_horizontal
	0,         // position_under
	0,         // top_more_images_visible
	0,         // tree_more_images_visible
	"",    // evaluate_upon_tree_show
	"",    // evaluate_upon_tree_hide
	,          // right_to_left
	],     // display_on_click
	["Geography","<%= gmeBaseHref %>/cgi-bin/subject_browse?templatename=/browse/browse.html&node=node-441",1,0,0],
	["History","<%= gmeBaseHref %>/cgi-bin/subject_browse?templatename=/browse/browse.html&node=node-2725",1,0,0],
	["Society and Government","<%= gmeBaseHref %>/cgi-bin/subject_browse?templatename=/browse/browse.html&node=node-13793",1,0,0],
	["Social Sciences","<%= gmeBaseHref %>/cgi-bin/subject_browse?templatename=/browse/browse.html&node=node-14455",1,0,0],
	["Language and Literature","<%= gmeBaseHref %>/cgi-bin/subject_browse?templatename=/browse/browse.html&node=node-5911",1,0,0],
	["Religion, Philosophy, Mythology","<%= gmeBaseHref %>/cgi-bin/subject_browse?templatename=/browse/browse.html&node=node-13483",1,0,0],
	["Performing Arts","<%= gmeBaseHref %>/cgi-bin/subject_browse?templatename=/browse/browse.html&node=node-7450",1,0,0],
	["Visual Arts","<%= gmeBaseHref %>/cgi-bin/subject_browse?templatename=/browse/browse.html&node=node-11333",1,0,0],
	["Life Sciences","<%= gmeBaseHref %>/cgi-bin/subject_browse?templatename=/browse/browse.html&node=node-6667",1,0,0],
	["Physical Sciences and Math","<%= gmeBaseHref %>/cgi-bin/subject_browse?templatename=/browse/browse.html&node=node-8141",1,0,0],
	["Technology","<%= gmeBaseHref %>/cgi-bin/subject_browse?templatename=/browse/browse.html&node=node-10322",1,0,0],
	["Sports, Games, Recreation","<%= gmeBaseHref %>/cgi-bin/subject_browse?templatename=/browse/browse.html&node=node-10072",1,0,0],
	]


	HM_Array2 = [
	[225,      // menu width
	133,       // left_position (was 5)
	232,       // top_position 
	"336699",   // font_color
	"336699",   // mouseover_font_color
	"C2EAF9",   // background_color
	"DFF5FD",   // mouseover_background_color
	"C2EAF9",   // border_color
	"C2EAF9",    // separator_color
	0,         // top_is_permanent
	0,         // top_is_horizontal
	0,         // tree_is_horizontal
	0,         // position_under
	0,         // top_more_images_visible
	0,         // tree_more_images_visible
	"",    // evaluate_upon_tree_show
	"",    // evaluate_upon_tree_hide
	,          // right_to_left
	],     // display_on_click
	["Car Trouble", "<%= gmeBaseHref %>/cgi-bin/games?templatename=/games/cartrouble.html&gametype=cartrouble",1,0,0],
	["Closer Look","<%= gmeBaseHref %>/cgi-bin/games?templatename=/games/closerlook.html&gametype=closerlook",1,0,0],
	["Don't Be Duped!","<%= gmeBaseHref %>/cgi-bin/games?templatename=/games/duped.html&gametype=duped",1,0,0],
	["I Know That!","<%= gmeBaseHref %>/cgi-bin/games?templatename=/games/knowthat.html&gametype=knowthat",1,0,0],
	["Out of Place","<%= gmeBaseHref %>/cgi-bin/games?templatename=/games/place.html&gametype=place",1,0,0],
	["Scatter Shot","<%= gmeBaseHref %>/cgi-bin/games?templatename=/games/scatter.html&gametype=scatter",1,0,0],
	["Think It Out","<%= gmeBaseHref %>/cgi-bin/games?templatename=/games/think.html&gametype=think",1,0,0],
	["Word Search","<%= gmeBaseHref %>/cgi-bin/games?templatename=/games/wordsearch.html&gametype=wordsearch",1,0,0],
	]
