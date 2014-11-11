<?php

require_once($_SERVER['PHP_INCLUDE_HOME'].'common/database/GI_List.php');
$GLOBALS['recipeHref'] = '/page?tn=/article/student/recipepage.html&type=0tk&id=';

function displayAppetizers()
{
  global $recipeHref;
  $arySQL = array(array(
	'query'	=> "SELECT * FROM assets WHERE category='entrantes' ORDER BY priority",
	'format'=> "<p class=\"irecipecountry\"><a href=\"$recipeHref##ID##\" class=\"irecipelink\">##TITLE##</a><br>(##SUBCATEGORY##)</p>\n"
  ));
  $listRecipe = new GI_List($arySQL);
  $totRows = $listRecipe->create();
  print $listRecipe->output(); 
}

function displaySauceCond()
{
  global $recipeHref;
  $arySQL = array(array(
	'query'	=> "SELECT * FROM assets WHERE category='salsas y condimentos' ORDER BY priority",
	'format'=> "<p class=\"irecipecountry\"><a href=\"$recipeHref##ID##\" class=\"irecipelink\">##TITLE##</a><br>(##SUBCATEGORY##)</p>\n"
  ));
  $listRecipe = new GI_List($arySQL);
  $totRows = $listRecipe->create();
  print $listRecipe->output(); 
}

function displayMainDishes()
{
  global $recipeHref;
  $arySQL = array(array(
	'query'	=> "SELECT * FROM assets WHERE category='platos principales' ORDER BY priority",
	'format'=> "<p class=\"irecipecountry\"><a href=\"$recipeHref##ID##\" class=\"irecipelink\">##TITLE##</a><br>(##SUBCATEGORY##)</p>\n"
  ));
  $listRecipe = new GI_List($arySQL);
  $totRows = $listRecipe->create();
  print $listRecipe->output(); 
}

function displayDrinks()
{
  global $recipeHref;
  $arySQL = array(array(
	'query'	=> "SELECT * FROM assets WHERE category='bebidas' ORDER BY priority",
	'format'=> "<p class=\"irecipecountry\"><a href=\"$recipeHref##ID##\" class=\"irecipelink\">##TITLE##</a><br>(##SUBCATEGORY##)</p>\n"
  ));
  $listRecipe = new GI_List($arySQL);
  $totRows = $listRecipe->create();
  print $listRecipe->output(); 
}

function displayDesserts()
{
  global $recipeHref;
  $arySQL = array(array(
	'query'	=> "SELECT * FROM assets WHERE category='postres y panes' ORDER BY priority",
	'format'=> "<p class=\"irecipecountry\"><a href=\"$recipeHref##ID##\" class=\"irecipelink\">##TITLE##</a><br>(##SUBCATEGORY##)</p>\n"
  ));
  $listRecipe = new GI_List($arySQL);
  $totRows = $listRecipe->create();
  print $listRecipe->output(); 
}

function displaySnacks()
{
  global $recipeHref;
  $arySQL = array(array(
	'query'	=> "SELECT * FROM assets WHERE category='meriendas' ORDER BY priority",
	'format'=> "<p class=\"irecipecountry\"><a href=\"$recipeHref##ID##\" class=\"irecipelink\">##TITLE##</a><br>(##SUBCATEGORY##)</p>\n"
  ));
  $listRecipe = new GI_List($arySQL);
  $totRows = $listRecipe->create();
  print $listRecipe->output(); 
}

function displaySoupsSalads()
{
  global $recipeHref;
  $arySQL = array(array(
	'query'	=> "SELECT * FROM assets WHERE category='sopas y ensaladas' ORDER BY priority",
	'format'=> "<p class=\"irecipecountry\"><a href=\"$recipeHref##ID##\" class=\"irecipelink\">##TITLE##</a><br>(##SUBCATEGORY##)</p>\n"
  ));
  $listRecipe = new GI_List($arySQL);
  $totRows = $listRecipe->create();
  print $listRecipe->output(); 
}

?>
