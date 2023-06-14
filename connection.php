<?php
$u = "projectc";
$p = "projectc";
$constr = "DRIVER={SQL Server};SERVER=localhost;DATABASE=ieproject";
$db = odbc_connect($constr, $u,$p);
odbc_exec($db, "SET NAMES 'utf8' COLLATE 'utf8_general_ci';");
//odbc_exec($db, "SET NAMES 'utf8' COLLATE 'THAI_CI_AS';");

//for using get_preinfo or get_cusinfo
$u2 = "operator";
$p2 = "operator";
$constr2 = "DRIVER={SQL Server};SERVER=localhost;DATABASE=hospital";
$db2 = odbc_connect($constr2, $u2,$p2);
odbc_exec($db2, "SET NAMES 'utf8' COLLATE 'utf8_general_ci';");
//odbc_exec($db2, "SET NAMES 'utf8' COLLATE 'THAI_CI_AS';");
?>