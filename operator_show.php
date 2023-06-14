<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE>รายชื่อพนักงาน </TITLE>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="w3.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
</HEAD>

<BODY>

<?php 
	//connect to database
	require("connection.php");

	//clear $_GET Error
	if(!isset($_GET['time']))$_GET['time']=3;
	$time=$_GET['time'];
	if(!isset($_GET['o_id']))$_GET['o_id']=3;
	$o_id=$_GET['o_id'];
	/*
	if(!isset($_POST['cat']))$_POST['cat']='';
	$cat = $_POST['cat'];
	if(!isset($_POST['action']))$_POST['action']='';
	$action = $_POST['action'];
	*/
	
	//display header	
	require("header.html");
	$query="UPDATE operator
			SET hide=0
			WHERE o_id='$o_id'";
	odbc_exec($db,$query);
	header("refresh: 0; url=operator.php?time=$time");
?>




</body>
</html>