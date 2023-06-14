<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE> Working Record </TITLE>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="../w3.css">
<link rel="stylesheet" type="text/css" href="../source/progress_bar.css">
<link rel="stylesheet" href="../font-awesome-4.7.0/css/font-awesome.min.css">
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
	require("connection.php");
	date_default_timezone_set("Etc/GMT-7");

	//set default datetime to today
	if(!isset($_GET['from_dt'])) 
		$_GET['from_dt'] = date_time_set(strtotime(date("Y-m-d"),00,00,00);
	$from_dt=$_GET['to_dt'];
	if(!isset($_GET['to_dt'])) 
		$_GET['to_dt'] = date_time_set(strtotime(date("Y-m-d"),23,59,59);
	$to_dt=$_GET['to_dt'];
?>

?>
<div class="w3-row-padding w3-section w3-container">
			<!-- Heading Card -->
			<div class="w3-row w3-border-bottom">
				<div class="w3-third">
					<a class="w3-btn w3-white w3-xlarge" href="manager_page.php"> &laquo; กลับ</a>
				</div>
				<div class="w3-third w3-center w3-center w3-xxlarge">
					<i class="fa fa-clone" aria-hidden="true"></i>&nbsp;ประวัติการทำงาน
				</div>
				<div class="w3-third">
				</div>
			</div>

			<!-- Date Input Card On the Left Side -->
			<div class="w3-quarter w3-center w3-container w3-margin-bottom w3-section w3-card-2">
				<h2 class="w3-center">วันเวลาที่ต้องการ</h2>
				<form method=get action='operator_stat.php'>
					<h2>ตั้งแต่</h2>
					<input class="w3-input w3-large w3-border w3-margin-top w3-margin-bottom" type="datetime-local" name="from_dt" value=<?php echo $from_dt; ?> style="margin: auto; max-width: 400px;">
					<h2>ถึง</h2>
					<input class="w3-input w3-large w3-border w3-margin-top w3-margin-bottom" type="datetime-local" name="t_dt" <?php echo $to_dt; ?> style="margin: auto; max-width: 400px;">
					<input type="submit" value="ตกลง">
				</form>
			</div>	


				
			<!-- Report Card On The Right -->
			<div class="w3-container w3-rest w3-margin-bottom">

				<!-- Fulltime Operator -->
				<h2 class="w3-border-top">พนักงานประจำ</h2>
				<h3>พนักงานจัดยา</h3>
				<div class="w3-container w3-center w3-card-2 w3-section">	
					<table>
						<tr>
							<th>รหัส</th>
							<th>ชื่อ</th>
							<th>รวมใบยาต้ม</th>
							<th>จำนวนห่อยาต้ม</th>
							<th>เวลาจัดเฉลี่ย</th>
							<th>รวมใบยาจัด</th>
							<th>จำนวนห่อยาจัด</th>
							<th>เวลาจัดเฉลี่ยยาจัด</th>
							<th>รวมใบยาเคอลี่</th>
							<th>จำนวนห่อยาเคอลี่</th>
							<th>เวลาจัดเฉลี่ย</th>
						</tr>
						<?php
							//Select summary of Fulltime Piking Operator 
							$query = "SELECT 
										o_name,
										SUM(CASE t_id WHEN 1 THEN 1 ELSE 0 END) AS DecBill,
										SUM(CASE t_id WHEN 1 THEN numberOfPack ELSE 0 END) AS DecPack,
										AVG(CASE t_id WHEN 1 THEN duration ELSE 0 END) AS DecTime,
										SUM(CASE t_id WHEN 2 THEN 1 ELSE 0 END) AS SelfBill,
										SUM(CASE t_id WHEN 2 THEN numberOfPack ELSE 0 END) AS SelfPack,
										AVG(CASE t_id WHEN 2 THEN duration ELSE 0 END) AS SelfTime,
										SUM(CASE t_id WHEN 3 THEN 1 ELSE 0 END) AS KeliBill,
										SUM(CASE t_id WHEN 3 THEN numberOfPack ELSE 0 END) AS KeliPack,
										AVG(CASE t_id WHEN 3 THEN duration ELSE 0 END) AS KeliTime
									FROM [ieproject].[dbo].[operator_display]
									WHERE in_datetime > '2017-06-21'
										AND o_type = 1
										AND parttime = 1
									GROUP BY o_name;";
							//Execute Query
							$result = odbc_exec($db, $query);
							//Check Error
							if(!$list=odbc_fetch_array($result)){
									echo '			
									<div class="w3-panel w3-orange">
									<span onclick="this.parentElement.style.display=\'none\'" class="w3-closebtn">&times;</span>
									<h3>ไม่พบประวัติการทำงาน!</h3>
									<p>โปรดลองใหม่อีกครั้งหนึ่ง</p>
									</div>';
								}

							$result = odbc_exec($db, $query);
							while($list = odbc_fetch_array($result)){
								//Print Row
								echo "
									<tr>
										<td>$list['o_name']</td>
										<td>$list['DecBill']</td>
										<td>$list['DecPack']</td>
										<td>$list['DecTime']</td>
										<td>$list['SelfBill']</td>
										<td>$list['SelfPack']</td>
										<td>$list['SelfTime']</td>
										<td>$list['KeliBill']</td>
										<td>$list['KeliPack']</td>
										<td>$list['KeliTime']</td>
									</tr>
								";
							}
						?>
					</table>
				</div>
			</div>
	</div>
</BODY>
</HTML>
