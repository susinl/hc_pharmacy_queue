<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>out report</title>
</head>
<link rel="stylesheet" type="text/css" href="style.css">

<body>
<p id="demo"></p>
<?php
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

		//Find s_id that represent รับยาแล้ว
		$query2 = "SELECT * FROM status WHERE t_id = '$t_id' AND s_id < 100 ORDER BY s_id DESC";
		$result2 = odbc_exec($db,$query2);
		$list2=odbc_fetch_array($result2);

		//s_id that represent รับยาแล้ว
		$out_id = $list2['s_id'];

		//set s_id to รับยาแล้ว in prescription
		$query="UPDATE prescription SET s_id='$out_id' WHERE pre_id='$pre_id' ";
		odbc_exec($db,$query);

		//fine time stamp
		date_default_timezone_set("Etc/GMT-7");
		$timestamp = date("Y-m-d H:i:s");

		//update duration
		$query="UPDATE psrel SET duration='$duration' WHERE pre_id='$pre_id' and s_id='$s_id'";
		odbc_exec($db,$query);

		$NoofOper = 0;

		$query ="INSERT INTO psrel (pre_id,s_id,ps_time,duration,numberofOper)  VALUES ('$pre_id','$out_id','$timestamp',0,'$NoofOper');";
		odbc_exec($db,$query);
	}
	header("refresh: 0; url=out_input.php");

?>
</body>



</html>