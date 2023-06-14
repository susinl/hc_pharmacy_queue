<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>out_input_handler.php</title>
</head>

<body>
<?php 
require("connection.php");
session_start();
if(!isset($_GET['pre_id']))$_GET['pre_id']='';
$pre_id=$_GET['pre_id'];


$query="SELECT * FROM prescription WHERE pre_id='$pre_id'";
$result=odbc_exec($db,$query);

if($list=odbc_fetch_array($result))
{	
	header("refresh: 0; url=out_report.php?pre_id=$pre_id");
}
else
{
	$_SESSION['c']=1;
	header("refresh: 0; url=out_input.php");
}



?>

</body>
</html>