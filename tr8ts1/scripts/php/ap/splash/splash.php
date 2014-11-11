<?php

include_once($_SERVER["PHP_INCLUDE_HOME"].'/ap/common/listobject.inc');

// create list objects
$newsListObject = new listobject();
$scholasticnewsListObject = new listobject();

// Create the lists
$query = "select * from nassets where type='0tdnp' order by seq";
$template = "splashnews.tmpl";
$newsListObject->create($query, $template);

$query = "select * from nassets where type='0tdnc' order by seq";
$template = "splashscholasticnews.tmpl";
$scholasticnewsListObject->create($query, $template);


require_once($_SERVER["TEMPLATE_HOME"].'/splash/splash.tmpl')

?>
