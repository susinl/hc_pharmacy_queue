<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Update Report with operator</title>
<link rel="stylesheet" type="text/css" href="w3.css">
<link rel="stylesheet" type="text/css" href="source/progress_bar.css">
<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div id="demo">
	<?php 
	
		require('connection.php');
		date_default_timezone_set("Etc/GMT-7");
		header('refresh: 5; url=edit_prediction_main.php');
		if(!isset($_GET['t_id']))$_GET['t_id']='no input';
		$t_id=$_GET['t_id'];
		if(!isset($_GET['Zvalue']))$_GET['Zvalue']='no input';
		$Zvalue=$_GET['Zvalue'];
		if(!isset($_GET['Tune']))$_GET['Tune']='no input';
		$Tune=$_GET['Tune'];
		$timestamp = date("Y-m-d H:i:s");
		
		$query="SELECT * 
					FROM equation WHERE t_id='$t_id' AND Version IN
					( SELECT MAX(Version)
						FROM equation WHERE t_id='$t_id'
					)";
					$result=odbc_exec($db,$query);
					if($list=odbc_fetch_array($result))
						{
							$Version=$list['Version'];
							$Intercept=$list['Intercept'];
							$Coef1=$list['Coef1'];
							$Coef2=$list['Coef2'];
							$Coef3=$list['Coef3'];
							$Coef4=$list['Coef4'];
							$Coef5=$list['Coef5'];
							$Coef6=$list['Coef6'];
							$Coef7=$list['Coef7'];
							$Coef8=$list['Coef8'];
							$Coef9=$list['Coef9'];
							$Coef10=$list['Coef10'];
							$Coef11=$list['Coef11'];
							$Coef12=$list['Coef12'];
							$Coef13=$list['Coef13'];
							$Coef14=$list['Coef14'];
							$Coef15=$list['Coef15'];
							$Coef16=$list['Coef16'];
							$Coef17=$list['Coef17'];
							$Coef18=$list['Coef18'];
							$Coef19=$list['Coef19'];
							$Coef20=$list['Coef20'];
							$Coef21=$list['Coef21'];
							$Coef22=$list['Coef22'];
							$Coef23=$list['Coef23'];
							$Coef24=$list['Coef24'];
						}

		$query="INSERT INTO equation VALUES		($Version+1,'$t_id','$timestamp','$Intercept','$Coef1','$Coef2','$Coef3','$Coef4','$Coef5','$Coef6','$Coef7','$Coef8','$Coef9','$Coef10','$Coef11','$Coef12','$Coef13','$Coef14','$Coef15','$Coef16','$Coef17','$Coef18','$Coef19','$Coef20','$Coef21','$Coef22','$Coef23','$Coef24','$Zvalue','$Tune')";
		odbc_exec($db,$query);

		//refresh
	?>