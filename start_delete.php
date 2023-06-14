<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>input_operator</title>
</head>
<link rel="stylesheet" type="text/css" href="style.css">

<body>
<p id="demo"></p>
<?php

require('header.html');
require("connection.php");
	// prevent dreamweaver error
if(!isset($_GET['pre_id']))$_GET['pre_id']='no input';
$pre_id=$_GET['pre_id'];
$query ="Select q_id FROM prescription where pre_id='$pre_id'";
$result=odbc_exec($db,$query);
if($list=odbc_fetch_array($result)){
	$q_id=$list['q_id'];
}
$query ="DELETE FROM Prescription where pre_id='$pre_id'";
odbc_exec($db,$query);
$query ="DELETE FROM queue where q_id='$q_id'";
odbc_exec($db,$query);
header("refresh: 0; url=pre_id_input.php");


?>


</body>



</html>