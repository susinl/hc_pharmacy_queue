<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Home Page</title>
<link rel="stylesheet" type="text/css" href="w3.css">
<link rel="stylesheet" type="text/css" href="source/progress_bar.css">
<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
<?php
	require("header.html");
?>
	<div class="w3-container w3-section" style="width: 75%; margin: auto;">
		<div class="w3-container w3-border_bottom w3-center">
			<h1><i class="fa fa-home" aria-hidden="true"></i>&nbsp;หน้าหลัก</h1>
		</div>
		<div class="w3-contaner">
			<a class="w3-btn-block w3-leftbar w3-xlarge w3-light-grey w3-margin-bottom w3-margin-top w3-padding-12 w3-left" HREF="manager_page.php">
				<i class="fa fa-user-md" aria-hidden="true"></i>&nbsp;ผู้จัดการ
			</a>
			<a class="w3-btn-block w3-leftbar w3-xlarge w3-light-grey w3-margin-bottom w3-padding-12 w3-left" HREF="pre_id_input.php">
				<i class="fa fa-barcode" aria-hidden="true"></i>&nbsp;เปลี่ยนสถานะใบยา
			</a>
			<a class="w3-btn-block w3-leftbar w3-xlarge w3-light-grey w3-margin-bottom w3-padding-12 w3-left" HREF="out_input.php">
				<i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp;จ่ายยา
			</a>
			<a class="w3-btn-block w3-leftbar w3-xlarge w3-light-grey w3-margin-bottom w3-padding-12 w3-left" HREF="check_input.php">
				<i class="fa fa-search" aria-hidden="true"></i>&nbsp;ตรวจสอบสถานะใบยา
			</a>
			<a class="w3-btn-block w3-leftbar w3-xlarge w3-light-grey w3-margin-bottom w3-padding-12 w3-left" HREF="NextDay_input.php">
				<i class="fa fa-calendar-check-o" aria-hidden="true"></i>&nbsp;จัดยาวันอื่น
			</a>
			<a class="w3-btn-block w3-leftbar w3-xlarge w3-light-grey w3-margin-bottom w3-padding-12 w3-left" HREF="display.php">
				<i class="fa fa-television" aria-hidden="true"></i>&nbsp;หน้าจอแสดงคิว
			</a>
			<a class="w3-btn-block w3-leftbar w3-xlarge w3-light-grey w3-margin-bottom w3-padding-12 w3-left" HREF="clear_queue_input.php">
				<i class="fa fa-tags" aria-hidden="true"></i>&nbsp;จัดการคิว
			</a>
	</div>
</body>
