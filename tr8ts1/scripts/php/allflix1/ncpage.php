<?php

/**
 * Non-caching page app
 *
 * This is intended to be a drop-in replacement for the old caching page application
 * it should provide any needed set-up, includes, etc. to support the template files
 * that it wraps.
 *
 * @author  R.E. Dye
 * @date    11/3/2009
 */

    // Get required files.
    require_once($_SERVER['PHP_INCLUDE_HOME'].'common/GI_Constants.php');
    require_once($_SERVER['PHP_INCLUDE_HOME'].'common/GI_Base/package.php');
    require_once($_SERVER['PHP_INCLUDE_HOME'].'common/utils/GI_getVariable.php');

    // Set up and populate the error manager object.
    $em =& GI_ErrorManager::getInstance();

    // Drop in the requested template

    require_once($_SERVER['TEMPLATE_HOME'] . GI_getVariable(GI_TEMPLATENAME));


?>
