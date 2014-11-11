<?php

define("H", "localhost");
define("U", "atb");
define("P", "atb");
define("DB", "atb");

$mysqli = new mysqli(H,U,P,DB);

// table formats for DataGrid
define(NO_FORMAT, 0);
define(TD_ONLY_FORMAT, 1);
define(TD_TR_FORMAT, 2);
define(TABLE_FORMAT, 3);

?>