<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <title>manager_page</title>
  <link rel="stylesheet" type="text/css" href="w3.css">
  <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
 </head>
 <body>
	 <?php 
		require('header.html');
	 ?>
	<div class="w3-container">
		<div class="w3-card-2 w3-section" style="width:75%; margin:auto">
				<div class="w3-container w3-border-bottom">
					<h1 class="w3-center">
						ผู้จัดการ
					</h1>
				</div>
			<div class="w3-container">
<!-- 					<a class="w3-btn-block w3-leftbar w3-xlarge w3-light-grey w3-margin-bottom w3-margin-top w3-padding-12" HREF="cancel_input.php">
						<i class="fa fa-window-close" aria-hidden="true"></i>&nbsp;ยกเลิกใบยา
					</a> -->
					<a class="w3-btn-block w3-leftbar w3-xlarge w3-light-grey w3-margin-top w3-margin-bottom w3-padding-12" HREF="prescription.php">
						<i class="fa fa-clone" aria-hidden="true"></i>&nbsp;ดูใบยาในระบบ
					</a>
						
					<a class="w3-btn-block w3-leftbar w3-xlarge w3-light-grey w3-margin-bottom w3-padding-12" HREF="manage_people.php">
						<i class="fa fa-users" aria-hidden="true"></i>&nbsp;ข้อมูลพนักงาน
					</a>
 					<a class="w3-btn-block w3-leftbar w3-xlarge w3-light-grey w3-margin-bottom w3-padding-12" HREF="record/working_record_home.php"> 
					<!--<a class="w3-btn-block w3-leftbar w3-xlarge w3-white w3-margin-bottom w3-padding-12" HREF="#">-->
						<i class="fa fa-bar-chart" aria-hidden="true"></i>&nbsp;ประวัติการทำงาน (อยู่ระหว่างพัฒนา)
					</a>
					<a class="w3-btn-block w3-leftbar w3-xlarge w3-light-grey w3-margin-top w3-margin-bottom w3-padding-12" HREF="summaryday.php">
						<i class="fa fa-bar-chart" aria-hidden="true"></i>&nbsp;สรุปข้อมูลรายวัน (อยู่ระหว่างพัฒนา)
					</a>
					<a class="w3-btn-block w3-leftbar w3-xlarge w3-light-grey w3-margin-top w3-margin-bottom w3-padding-12" HREF="summarymonth.php">
						<i class="fa fa-bar-chart" aria-hidden="true"></i>&nbsp;สรุปข้อมูลรายเดือน (อยู่ระหว่างพัฒนา)
					</a>
				   <a class="w3-btn-block w3-leftbar w3-xlarge w3-light-grey w3-margin-top w3-margin-bottom w3-padding-12" HREF="data_report.php">
				<i class="fa fa-file-excel-o" aria-hidden="true"></i>&nbsp;ดาวน์โหลดข้อมูลใบยา
				</a>
				

					<a class="w3-btn-block w3-leftbar w3-xlarge w3-light-grey w3-margin-bottom w3-padding-12" HREF="index.php">
						<i class="fa fa-reply" aria-hidden="true"></i>&nbsp;กลับหน้าหลัก
					</a>
					
			</div>
		</div>
	 </div>
			
 </body>
</html>
