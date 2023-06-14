<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php 
	require("connection.php");
	require("function_stat.php");
	session_start();
	if(!isset($_GET['Username']))$_GET['Username']='';
	$Username=$_GET['Username'];
	if(!isset($_GET['Password']))$_GET['Password']='';
	$Password=$_GET['Password'];
	

/*
	date_default_timezone_set("Etc/GMT-7");
	$timestamp = date("Y-m-d H:i:s");
	$_SESSION['timestamp']= $timestamp;
	$d=strtotime("-2 days");
	$ref=date("Y-m-d H:i:s",$d);
	$d=strtotime("-4 hours");
	$ref2=date("Y-m-d H:i:s",$d);
*/

	
	$query="SELECT * FROM equation_user";
	$result=odbc_exec($db,$query);
	if($list = odbc_fetch_array($result)){
	$Username_fixed = $list['Username'];
	$Password_fixed = $list['Password'];
	}
	
	
	/*
	if($Username=odbc_fetch_array($result)['Username'] and $Password=odbc_fetch_array($result)['Password']) //เช็คuserกับpassword
	{
		header("refresh: 0; url=edit_prediction_main.php?Username=$Username&Password=$Password");
	}
	*/
	
	
	

		if($Username == $Username_fixed and $Password == $Password_fixed)
		{
			header("refresh: 0; url=edit_prediction_show.php?Username=$Username&Password=$Password");
		}
		
		else{//U op P ผิด
		$_SESSION['c']=99;
		header("refresh: 0; url=edit_prediction.php");
		}
	
	

	
	



?>

</body>
</html>