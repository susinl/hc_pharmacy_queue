<!doctype html>
<html>
<head>

<title>Data report</title>
<meta charset="utf-8">
<link rel="stylesheet" type="text/css" href="w3.css">
<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="timepicker/1.3.5/jquery.timepicker.min.css">

</head>

<body style="background-color:whitesmoke;" >
<?php
	require("header.html");
?>
<script src="jquery-3.1.1.js"></script>
<script src="timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script>
	$(document).ready(function(){
    	$('input.timepickerfrom').timepicker({
		    timeFormat: 'HH:mm:ss',
		    interval: 60,
		    minTime: '08:00:00',
		    maxTime: '18:00:00',
		    defaultTime: '08:00:00',
		    startTime: '08:00:00',
		    dynamic: false,
		    dropdown: true,
		    scrollbar: true
		});
	});

	$(document).ready(function(){

	$('input.timepickerto').timepicker({
	    timeFormat: 'HH:mm:ss',
	    interval: 60,
	    minTime: '08:00:00',
	    maxTime: '18:00:00',
	    defaultTime: '18:00:00',
	    startTime: '08:00:00',
	    dynamic: false,
	    dropdown: true,
	    scrollbar: true
		});
	});
</script>

<?php 
	error_reporting(E_ERROR | E_PARSE);
	require "connection.php";
	date_default_timezone_set("Etc/GMT-7");

	//Query time parameter from form
		//from
		if(!isset($_POST['from_date'])) 
			$_POST['from_date'] = date("Y-m-d");
		$from_date=$_POST['from_date'];
		if(!isset($_POST['from_time'])) 
			$_POST['from_time'] = "08:00:00";
		$from_time=$_POST['from_time'];

		//to
		if(!isset($_POST['to_date'])) 
			$_POST['to_date'] = date("Y-m-d");
		$to_date=$_POST['to_date'];
		if(!isset($_POST['to_time'])) 
			$_POST['to_time'] = "18:00:00";
		$to_time=$_POST['to_time'];
	    if(!isset($_POST['decoct'])) 
			$_POST['decoct'] = "0";
     	$decoct=$_POST['decoct'];
		if(!isset($_POST['selfdecoct'])) 
	    	$_POST['selfdecoct'] = "0";
		$selfdecoct=$_POST['selfdecoct'];
		if(!isset($_POST['keli'])) 
	    	$_POST['keli'] = "0";
    	$keli=$_POST['keli'];
		$from_dt = $from_date." ".$from_time;
		$to_dt = $to_date." ".$to_time;
?>
<div class="w3-row-padding   ">
		<div class="w3-content" style="max-width:400px;background-color:white">
			<div class="w3-container w3-margin-bottom w3-section w3-card-2">
				<h2 class="w3-center">วันเวลาที่ต้องการดูข้อมูล</h2>
				<form method="post" class="w3-margin-bottom" action="printreport.php" style="max-width: 1000px; margin: auto;">
					<label>ตั้งแต่</label><br>
					<input class="w3-input w3-large w3-border w3-margin-top" type="date" name="from_date" value=<?php echo $from_date; ?> style="max-width: 400px;">
					<input class="w3-input w3-large w3-border w3-margin-top timepickerfrom" type="text" name="from_time" value=<?php echo $from_time; ?> style="max-width: 400px;"> <br>
					<label>ถึง</label><br>
					<input class="w3-input w3-large w3-border w3-margin-top w3-margin-bottom" type="date" name="to_date" value=<?php echo $to_dt; ?> style="max-width: 400px;">
					<input class="w3-input w3-large w3-border w3-margin-top w3-margin-bottom timepickerto" type="text" name="to_time" value=<?php echo $to_time; ?> style="max-width: 400px;"> 
					<label>ประเภทยา</label><br>
 					<input checked="checked" type="checkbox" id="decoct" name="decoct" value="1">
 					<label for="decoct"> ยาต้ม</label><br>
 					<input type="checkbox" id="selfdecoct" name="selfdecoct" value="2">
 					<label for="selfdecoct"> ยาจัด</label><br>
 					<input type="checkbox" id="keli" name="keli" value="3">
 					<label for="keli">ยาเคอลี่</label><br>
					<input type="checkbox" id="readymade" name="readymade" value="4">
 					<label for="readymade">ยาสำเร็จรูป</label><br><br>
					<input class="w3-btn w3-block w3-blue" type="submit" value="ตกลง">
				</form>
														    																	
</body>
</html>