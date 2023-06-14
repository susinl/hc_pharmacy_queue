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
		if(!isset($_GET['Zvalue']))$_GET['Zvalue']='no input';
		$Zvalue=$_GET['Zvalue'];
		if(!isset($_GET['TuneA']))$_GET['TuneA']='no input';
		$TuneA=$_GET['TuneA'];
		if(!isset($_GET['TuneB']))$_GET['TuneB']='no input';
		$TuneB=$_GET['TuneB'];
		$timestamp = date("Y-m-d H:i:s");
		
		$query="SELECT * 
						FROM equation WHERE Version IN 
						( SELECT MAX(Version)
							FROM equation
						)";
		$result=odbc_exec($db,$query);
				if($list=odbc_fetch_array($result))
					{
						$Version=$list['Version'];
					}
					echo($timestamp);
		$query="INSERT INTO equation VALUES ($Version+1,'$timestamp',171.2342,-92.7361,0.9548,-2.2134,-8.7434,-0.9973,9.3376,0.8482,-13.7664,1.0215,-3.1304,0.05,0.0519,-11.2817,7.352,$Zvalue,$TuneA,$TuneB)";
		odbc_exec($db,$query);

		//refresh
	?>