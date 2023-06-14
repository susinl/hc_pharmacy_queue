<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php 
require("connection.php");
require("function.php");

if(!isset($_GET['pre_id']))$_GET['pre_id']='';
$pre_id=$_GET['pre_id'];
if(!isset($_GET['s_id']))$_GET['s_id']='';
$s_id=$_GET['s_id'];
if(!isset($_GET['last_q_start_mill']))$_GET['last_q_start_mill']=0;	
$last_q_start_mill=$_GET['last_q_start_mill'];
session_start();
$timestamp = $_SESSION['timestamp'];
if(!isset($_GET['checkk']))$_GET['checkk']='';
$checkk=$_GET['checkk'];

if($checkk==1){
	$next_id = find_next_id($s_id,$db);
	$query="UPDATE prescription SET s_id='$next_id' WHERE pre_id='$pre_id' ";
	odbc_exec($db,$query);

	$duration = find_duration($pre_id,$s_id, $timestamp,$db);
	echo $duration;
	$query="UPDATE psrel SET duration='$duration' WHERE pre_id='$pre_id' and s_id='$s_id' ";
	odbc_exec($db,$query);

	$NoofOper = 0;

	$query ="INSERT INTO psrel (pre_id,s_id,ps_time,duration,numberofOper)  VALUES ('$pre_id','$next_id','$timestamp',0,'$NoofOper');";
	odbc_exec($db,$query);

	header("refresh: 0; url=pre_id_input.php?last_q_start_mill=$last_q_start_mill");
}else{
	header("refresh: 0; url=pre_id_input.php?last_q_start_mill=$last_q_start_mill");
}
?>

</body>
</html>