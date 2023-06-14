<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>NextDay report</title>
</head>
<link rel="stylesheet" type="text/css" href="style.css">

<body>
<p id="demo"></p>
<?php
// ยังไม่เขียน
	// prevent dreamweaver error
if(!isset($_GET['pre_id']))$_GET['pre_id']='no input';
$pre_id=$_GET['pre_id'];
?>
<?php
	require("connection.php");
	require("function.php");
	$query="SELECT * FROM prescription WHERE pre_id='$pre_id'";
	$result=odbc_exec($db,$query);
	if($list=odbc_fetch_array($result)){
		$t_id = $list['t_id'];
		$s_id = $list['s_id'];
		$NextDay_id = 103;

		//set s_id to ต้มยาวันอื่น in prescription
		$query="UPDATE prescription SET s_id='$NextDay_id' WHERE pre_id='$pre_id' ";
		odbc_exec($db,$query);

		//find time stamp
		date_default_timezone_set("Etc/GMT-7");
		$timestamp = date("Y-m-d H:i:s");

		// Don't update duration
		// $query="UPDATE psrel SET duration='$duration' WHERE pre_id='$pre_id' and s_id='$s_id'";
		// odbc_exec($db,$query);

		$NoofOper = 0;

		$query ="INSERT INTO psrel (pre_id,s_id,ps_time,duration,numberofOper)  VALUES ('$pre_id','$NextDay_id','$timestamp',0,'$NoofOper');";
		odbc_exec($db,$query);
	}
	header("refresh: 0; url=out_input.php");

?>
</body>



</html>