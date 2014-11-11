<?php

/**
* Parse a template which includes database query objects
*
* A template name is passed as a variable, typically in a
* query string.  This template contains control blocks for
* database query objects, icluding nested list queries and
* queries to retrieve information about a single database row.
* This program includes the classes needed to actually implement
* these database objects.
* @package  list
* @author   Richard E. Dye
* @param    string  GI_TEMPLATENAME the template pathname
*/

require_once($_SERVER["PHP_INCLUDE_HOME"].'nec2/common/GI_Constants.php');
require_once($_SERVER["PHP_INCLUDE_HOME"].'nec2/common/utils/GI_getVariable.php');
require_once($_SERVER["PHP_INCLUDE_HOME"].'nec2/common/utils/GI_include.php');
require_once($_SERVER["PHP_INCLUDE_HOME"].'nec2/common/database/GI_List.php');
require_once($_SERVER["PHP_INCLUDE_HOME"].'nec2/common/database/GI_DBRecord.php');

PEAR::setErrorHandling(PEAR_ERROR_RETURN);

require_once($_SERVER["TEMPLATE_HOME"].GI_getVariable(GI_TEMPLATENAME));

?>
