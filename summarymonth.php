<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE> New Document </TITLE>
<META NAME="Generator" CONTENT="EditPlus">
<META NAME="Author" CONTENT="">
<META NAME="Keywords" CONTENT="">
<META NAME="Description" CONTENT="">
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="w3.css">
<link rel="stylesheet" type="text/css" href="source/progress_bar.css">
<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script>
function che(pre_id){
	var test = confirm("คุณกำลังไปหน้าเช็คสถานะใบยาของใบยาหมายเลข"+pre_id);
	if(test){
		window.open('check_report.php?pre_id='+pre_id,'_self');
		}
	}
</script>
</HEAD>
<BODY>
<?php 
	 require('header.html');	 
?>
      <div class="w3-row-padding w3-section w3-container">

			<div class="w3-row w3-border-bottom">
				<div class="w3-third">
					<a class="w3-btn w3-white w3-xlarge" href="manager_page.php"> &laquo; กลับ</a>
				</div>
				<div class="w3-third w3-center w3-center w3-xxlarge">
					<i class="fa fa-bar-chart" aria-hidden="true"></i>&nbsp;สรุปข้อมูลรายเดือน
				</div>
				<div class="w3-third">
				</div>
			</div>
			<div class="w3-quarter w3-container w3-margin-bottom w3-section w3-card-2">
	

				<h2 class="w3-center"></h2>
				
						<div class="w3-container">
							<A class="w3-btn-block w3-leftbar w3-small w3-pale-green  w3-margin-top w3-padding-12" HREF="summarymonthpatient.php">จำนวนคนไข้</A><br>
					  		<A class="w3-btn-block w3-leftbar w3-small w3-pale-green  w3-margin-top w3-padding-12" HREF="summarymonthtime.php">เวลารอยา</A><br>
					  		<A class="w3-btn-block w3-leftbar w3-small w3-pale-green  w3-margin-top w3-padding-12" HREF="summarymonthtype1.php">เวลารอยาแยกขั้นตอน - ยาต้ม</A><br>
					  		<A class="w3-btn-block w3-leftbar w3-small w3-pale-green w3-margin-bottom w3-margin-top w3-padding-12" HREF="summarymonthtype2.php">เวลารอยาแยกขั้นตอน - ยาจัด</A><br>
			       </div>
			

			</div>	
				
			<div class="w3-container w3-rest w3-margin-bottom">
				<div class="w3-container w3-center w3-card-2 w3-section">	
					<form method=get name=f1 action='prescription.php'>	
						<h2><i class="fa fa-search" aria-hidden="true"></i> &nbsp;เดือนที่</h2>
					
						<input class="w3-input w3-large w3-border w3-margin-top w3-margin-bottom" type="date" name="c_date" required value=<?php echo date("Y-m-d"); ?> style="margin: auto; max-width: 400px;" >
						<input class="w3-btn w3-blue" type="submit" value="ตกลง">
					</form>
				</div>
				
			</div>
				
		
			
					
         	
	</div>




</BODY>
</HTML>
