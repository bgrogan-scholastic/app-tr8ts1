<!-- begin: common.php -->
//var top_dd = document.domain;
	    //document.domain = "grolier.com";
var myDomain = ".grolier.com";
<?php require_once($_SERVER['INCLUDE_HOME'] . '/javascript/common/sniffer.js'); ?>
<?php require_once($_SERVER['INCLUDE_HOME'] . '/javascript/common/cookies.js'); ?>
<?php require_once($_SERVER['INCLUDE_HOME'] . '/javascript/common/browsercheck.js'); ?>
<?php require_once($_SERVER['INCLUDE_HOME'] . '/javascript/graphical/popup.js'); ?>
<?php require_once($_SERVER['INCLUDE_HOME'] . '/javascript/common/back.js'); ?>

if (!is_mac) {
  if (typeof(disableFocusFlag) == "undefined" || (!disableFocusFlag) ) {
    window.focus();
  }
}

//alert("In common.php\nwindow.name = " + window.name + "\ndocument.domain = " + document.domain);

<!-- end: common.php -->
