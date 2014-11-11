<!-- begin: common.php -->
//var top_dd = document.domain;
	    //document.domain = "grolier.com";
var myDomain = ".grolier.com";
<?php require_once($_SERVER['JAVASCRIPT_INCLUDE_HOME'] . 'common/sniffer.js'); ?>
<?php require_once($_SERVER['JAVASCRIPT_INCLUDE_HOME'] . 'common/cookies.js'); ?>
<?php require_once($_SERVER['JAVASCRIPT_INCLUDE_HOME'] . 'common/browsercheck.js'); ?>
<?php require_once($_SERVER['JAVASCRIPT_INCLUDE_HOME'] . 'graphical/popup.js'); ?>
<?php require_once($_SERVER['JAVASCRIPT_INCLUDE_HOME'] . 'common/back.js'); ?>

if (!is_mac) {
  if (typeof(disableFocusFlag) == "undefined" || (!disableFocusFlag) ) {
    window.focus();
  }
}

//alert("In common.php\nwindow.name = " + window.name + "\ndocument.domain = " + document.domain);

<!-- end: common.php -->
