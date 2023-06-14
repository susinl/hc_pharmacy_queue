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
	// prevent dreamweaver error
if(!isset($_GET['pre_id']))$_GET['pre_id']='no input';
$pre_id=$_GET['pre_id'];
?>
<?php
	require("connection.php");
	$query="SELECT * FROM prescription WHERE pre_id='$pre_id'";
	$result=odbc_exec($db,$query);
	if($list=odbc_fetch_array($result)){
		$query="UPDATE Prescription SET s_id=0 WHERE pre_id='$pre_id' ";
		odbc_exec($db,$query);
	}
	header("refresh: 0; url=cancel_input.php");

?>




</body>



</html>