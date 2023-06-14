<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>input_operator</title>
</head>
<link rel="stylesheet" type="text/css" href="style.css">

<body>
<?php
	// prevent dreamweaver error
$c1=0;
$c2=0;
if(!isset($_GET['pre_id']))$_GET['pre_id']='no input';
$pre_id=$_GET['pre_id'];
if(!isset($_GET['s_id']))$_GET['s_id']='no input';
$s_id=$_GET['s_id'];
if(!isset($_GET['o_id1']))$_GET['o_id1']='';
$o_id1=$_GET['o_id1'];
require('header.html');
require("connection.php");
if(!isset($_GET['o_id2'])){
	$_GET['o_id2']='';
}else {
	$o_id2=$_GET['o_id2'];
	if($o_id2!=''){
		$query="SELECT * FROM operator WHERE o_id='$o_id2'";
		$result=odbc_exec($db,$query);
		if($list=odbc_fetch_array($result)){
			$c2=1;
		}
	}else{
		$c2=1;
	}
}
$query="SELECT * FROM operator WHERE o_id='$o_id1'";
$result=odbc_exec($db,$query);
if($list=odbc_fetch_array($result)){
	$c1=1;
}

if($o_id1==$o_id2){
	session_start();
	$_SESSION['c']=2;
	header("refresh: 0; url=input_operator.php?pre_id=$pre_id&s_id=$s_id");
}else{

if($c1+$c2==2)
{
	header("refresh: 0; url=update_report_op.php?pre_id=$pre_id&s_id=$s_id&o_id1=$o_id1&o_id2=$o_id2");
}else{
	session_start();
	$_SESSION['c']=1;
	header("refresh: 0; url=input_operator.php?pre_id=$pre_id&s_id=$s_id");
}

}
?>

</body>



</html>