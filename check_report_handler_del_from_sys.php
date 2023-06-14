<?php 
require("connection.php");
session_start();
if(!isset($_GET['pre_id']))$_GET['pre_id']='';

// Get input
$pre_id=$_GET['pre_id'];
$s_id = $_GET['s_id'];
$x = array(101, 201, 301, 401);


if( !in_array($s_id,$x)){
	$query = "DELETE FROM psrel WHERE pre_id='$pre_id';";
	odbc_exec($db, $query);

	$query = "DELETE FROM oprel WHERE pre_id='$pre_id';";
	odbc_exec($db, $query);

	$query = "DELETE FROM prescription WHERE pre_id='$pre_id';";
	odbc_exec($db, $query);
	// Find from table
	// $s_previous = $s_id;
	// 	//หา ID ที่มาก่อนหน้าอันเดิม
	// $query ="SELECT s_id FROM status WHERE next_id='$s_id';";
	// $result = odbc_exec($db, $query);
	// if($list=odbc_fetch_array($result)){
	// 	$s_previous=$list['s_id'];
	// }

	// Find form psrel
}

header("refresh: 0; url=check_input.php");


?>