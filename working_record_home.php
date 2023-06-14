<!DOCTYPE html>
<HTML>
<HEAD>
<TITLE> Working Record </TITLE>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="w3.css">
<link rel="stylesheet" type="text/css" href="source/progress_bar.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">

<link rel="stylesheet" href="source/timepicker/1.3.5/jquery.timepicker.min.css">
<!-- http://timepicker.co/ -->
</HEAD>




<BODY>
<script src="jquery-3.1.1.js"></script>
<script src="source/timepicker/1.3.5/jquery.timepicker.min.js"></script>
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
	require "header.html";
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

	$from_dt = $from_date." ".$from_time;
	$to_dt = $to_date." ".$to_time;
?>

<div class="w3-section w3-container">
			<!-- Heading Card -->
	<div class="w3-row w3-border-bottom">
		<div class="w3-third">
			<a class="w3-btn w3-white w3-xlarge" href="manager_page.php"> &laquo; กลับ</a>
		</div>
		<div class="w3-third w3-center w3-center w3-xxlarge">
			<i class="fa fa-bar-chart" aria-hidden="true"></i>&nbsp;ประวัติการทำงาน
		</div>
		<div class="w3-third w3-right-align">
			<a class="w3-btn w3-white w3-xlarge" href="working_record_individual.php"> รายบุคคล &raquo;</a>
		</div>
	</div>

	<div class="w3-row-padding">
		<div class="w3-quarter">
			<!-- Date Input Card On the Left Side --> 
			<div class="w3-container w3-margin-bottom w3-section w3-card-2">
				<h2 class="w3-center">วันเวลาที่ต้องการ</h2>
				<form method="post" class="w3-margin-bottom" action="working_record_home.php" style="max-width: 1000px; margin: auto;"">
					<label>ตั้งแต่</label><br>
					<input class="w3-input w3-large w3-border w3-margin-top" type="date" name="from_date" value=<?php echo $from_date; ?> style="max-width: 400px;">
					<input class="w3-input w3-large w3-border w3-margin-top w3-margin-bottom timepickerfrom" type="text" name="from_time" value=<?php echo $from_time; ?> style="max-width: 400px;"> <br>


					<label>ถึง</label><br>
					<input class="w3-input w3-large w3-border w3-margin-top w3-margin-bottom" type="date" name="to_date" value=<?php echo $to_dt; ?> style="max-width: 400px;">
					<input class="w3-input w3-large w3-border w3-margin-top w3-margin-bottom timepickerto" type="text" name="to_time" value=<?php echo $to_time; ?> style="max-width: 400px;"> <br>

					<input class="w3-btn w3-block w3-blue" type="submit" value="ตกลง">
				</form>
				<hr>
				<?php
					// $from_dt = date('Y-m-d H:i:s', strtotime($from_dt));
					// $to_dt = date('Y-m-d H:i:s', strtotime($to_dt));
					$link = "print.php?from_dt=".strtotime($from_dt)."&to_dt=".strtotime($to_dt);
				?>
				<a class="w3-btn w3-block w3-margin-bottom w3-light-grey" href=<?php echo $link ?>>โหลดรายงานสรุป</a>
				<hr>
				<?php
					// $from_dt = date('Y-m-d H:i:s', strtotime($from_dt));
					// $to_dt = date('Y-m-d H:i:s', strtotime($to_dt));
					$link = "print_detail_record.php?from_dt=".strtotime($from_dt)."&to_dt=".strtotime($to_dt);
				?>
				<a class="w3-btn w3-block w3-margin-bottom w3-light-grey" href=<?php echo $link ?>>โหลดรายละเอียดการทำงาน</a>
			</div>

			<!-- Summary Report -->
			<div class="w3-container w3-margin-bottom w3-section w3-card-2">
				<h2 class="w3-crnter">สรุป</h2>
				<table class="w3-table-all w3-margin-top w3-margin-bottom">
					<tr>
						<th>ชนิดยา</th>
						<th>จำนวนใบยา</th>
					</tr>
					<?php
						// Find number of prescription that occure in the specified period.
						$query = "
							SELECT p.t_id, t.t_name,
								count(p.pre_id) as [count]
							 from ieproject.dbo.prescription as p inner join ieproject.dbo.[type] as t on p.t_id = t.t_id
							 WHERE p.in_datetime > '$from_dt'
									AND p.in_datetime < '$to_dt'
							 GROUP BY p.t_id,  t.t_name
							 ORDER BY p.t_id;";
						$result = odbc_exec($db, $query);
						$sum = 0;
						while($list = odbc_fetch_array($result)){
							$t_name = iconv("TIS-620", "UTF-8", $list['t_name']);
							$count = $list['count'];
							$sum += $count;
							echo 
							"<tr>
								<td>$t_name</td>
								<td>$count</td>
							</tr>";
						}
						echo 
							"<tr>
								<th>รวม</th>
								<th>$sum</th>
							</tr>";
					?>
				</table>
			</div>


		</div>
		<!-- Close -->


				
		<!-- Report Column On The Right -->
		<div class="w3-margin-bottom w3-rest w3-container">

			<!-- Fulltime Operator -->
			<div class="w3-container w3-card-2 w3-section">	
				<h2 class='w3-border-bottom'>พนักงานประจำ</h2>
				<h3>พนักงานจัดยา</h3>
				<table class="w3-table-all w3-margin-bottom">
					<tr>
						<th>รหัสพนักงาน</th>
						<th>ชื่อ</th>
						<th>ชนิด</th>
						<th>จำนวนใบสั่ง</th>
						<th>จำนวนห่อ</th>
						<th>เวลาจัดเฉลี่ย</th>
					</tr>

					<?php
						//Select summary of Fulltime Piking Operator 
						$from_dt = date('Y-m-d H:i:s', strtotime($from_dt));
						$to_dt = date('Y-m-d H:i:s', strtotime($to_dt));
						//echo $from_dt;
						$query = "SELECT 
									o_id, o_name,
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
								WHERE in_datetime > '$from_dt'
									AND in_datetime < '$to_dt'
									AND o_type = 1
									AND parttime = 1
									AND (s_id = 11 or s_id = 21 or s_id = 31)
								GROUP BY o_id, o_name;";
						//Execute Query
						$result = odbc_exec($db, $query);
						while($list = odbc_fetch_array($result)){

							//Retrieve Data from array
							$o_id = $list['o_id'];
							$o_name = iconv("TIS-620", "UTF-8", $list['o_name']);
							$DecBill = $list['DecBill'];
							$DecPack = $list['DecPack'];
							$DecTime = round($list['DecTime'],1);
							$SelfBill = $list['SelfBill'];
							$SelfPack = $list['SelfPack'];
							$SelfTime = round($list['SelfTime'],1);
							$KeliBill = $list['KeliBill'];
							$KeliPack = $list['KeliPack'];
							$KeliTime = round($list['KeliTime'],1);

							//print table
							echo "
								<tr>
									<td rowspan='3'>$o_id</td>
									<td rowspan='3'>$o_name</td>
									<th> ยาต้ม</th>
									<td>$DecBill ใบ</td>
									<td>$DecPack</td>
									<td>$DecTime นาที</td>
								</tr>
								<tr>
									<th>ยาจัด</th>
									<td>$SelfBill ใบ</td>
									<td>$SelfPack</td>
									<td>$SelfTime นาที</td>
								</tr>
								<tr>
									<th>Keli</th>
									<td>$KeliBill ใบ</td>
									<td>$KeliPack</td>
									<td>$KeliTime นาที</td>
								</tr>
							";
						}
					?>
				</table>

				<h3>พนักงานต้มยา</h3>
				<table class="w3-table-all w3-margin-bottom">
					<tr>
						<th>รหัสพนักงาน</th>
						<th>ชื่อ</th>
						<th>จำนวนใบสั่ง</th>
						<th>จำนวนห่อ</th>
						<th>เวลาต้มเฉลี่ย</th>
					</tr>

					<?php
						//Select summary of Fulltime Decoct Operator 
						$from_dt = date('Y-m-d H:i:s', strtotime($from_dt));
						$to_dt = date('Y-m-d H:i:s', strtotime($to_dt));
						//echo $from_dt;
						$query = "SELECT 
									o_id, o_name,
									SUM(CASE t_id WHEN 1 THEN 1 ELSE 0 END) AS DecBill,
									SUM(CASE t_id WHEN 1 THEN numberOfPack ELSE 0 END) AS DecPack,
									AVG(CASE t_id WHEN 1 THEN duration ELSE 0 END) AS DecTime
								FROM [ieproject].[dbo].[operator_display]
								WHERE in_datetime > '$from_dt'
									AND in_datetime < '$to_dt'
									AND o_type = 2
									AND parttime = 1
									AND (s_id = 13)
								GROUP BY o_id, o_name;";
						//Execute Query
						$result = odbc_exec($db, $query);
						while($list = odbc_fetch_array($result)){

							//Retrieve Data from array
							$o_id = $list['o_id'];
							$o_name = iconv("TIS-620", "UTF-8", $list['o_name']);
							$DecBill = $list['DecBill'];
							$DecPack = $list['DecPack'];
							$DecTime = round($list['DecTime'],1);

							//print table
							echo "
								<tr>
									<td>$o_id</td>
									<td>$o_name</td>
									<td>$DecBill ใบ</td>
									<td>$DecPack</td>
									<td>$DecTime นาที</td>
								</tr>
							";
						}
					?>
				</table>
			</div>

			<!-- Part-time Operator -->
			<div class="w3-container w3-card-2 w3-section">	
				<h2 class='w3-border-bottom'>พนักงานชั่วคราว</h2>
				<h3>พนักงานจัดยา</h3>
				<table class="w3-table-all w3-margin-bottom">
					<tr>
						<th>รหัสพนักงาน</th>
						<th>ชื่อ</th>
						<th>ชนิด</th>
						<th>จำนวนใบสั่ง</th>
						<th>จำนวนห่อ</th>
						<th>เวลาจัดเฉลี่ย</th>
					</tr>

					<?php
						//Select summary of Fulltime Piking Operator 
						$from_dt = date('Y-m-d H:i:s', strtotime($from_dt));
						$to_dt = date('Y-m-d H:i:s', strtotime($to_dt));
						//echo $from_dt;
						$query = "SELECT 
									o_id, o_name,
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
								WHERE in_datetime > '$from_dt'
									AND in_datetime < '$to_dt'
									AND o_type = 1
									AND parttime = 2
									AND (s_id = 11 or s_id = 21 or s_id = 31)
								GROUP BY o_id, o_name;";
								// parttime = 2 means he is a part-time
						//Execute Query
						$result = odbc_exec($db, $query);
						while($list = odbc_fetch_array($result)){

							//Retrieve Data from array
							$o_id = $list['o_id'];
							$o_name = iconv("TIS-620", "UTF-8", $list['o_name']);
							$DecBill = $list['DecBill'];
							$DecPack = $list['DecPack'];
							$DecTime = round($list['DecTime'],1);
							$SelfBill = $list['SelfBill'];
							$SelfPack = $list['SelfPack'];
							$SelfTime = round($list['SelfTime'],1);
							$KeliBill = $list['KeliBill'];
							$KeliPack = $list['KeliPack'];
							$KeliTime = round($list['KeliTime'],1);

							//print table
							echo "
								<tr>
									<td rowspan='3'>$o_id</td>
									<td rowspan='3'>$o_name</td>
									<th> ยาต้ม</th>
									<td>$DecBill ใบ</td>
									<td>$DecPack</td>
									<td>$DecTime นาที</td>
								</tr>
								<tr>
									<th>ยาจัด</th>
									<td>$SelfBill ใบ</td>
									<td>$SelfPack</td>
									<td>$SelfTime นาที</td>
								</tr>
								<tr>
									<th>Keli</th>
									<td>$KeliBill ใบ</td>
									<td>$KeliPack</td>
									<td>$KeliTime นาที</td>
								</tr>
							";
						}
					?>
				</table>

				<h3>พนักงานต้มยา</h3>
				<table class="w3-table-all w3-margin-bottom">
					<tr>
						<th>รหัสพนักงาน</th>
						<th>ชื่อ</th>
						<th>จำนวนใบสั่ง</th>
						<th>จำนวนห่อ</th>
						<th>เวลาต้มเฉลี่ย</th>
					</tr>

					<?php
						//Select summary of Fulltime Decoct Operator 
						$from_dt = date('Y-m-d H:i:s', strtotime($from_dt));
						$to_dt = date('Y-m-d H:i:s', strtotime($to_dt));
						//echo $from_dt;
						$query = "SELECT 
									o_id, o_name,
									SUM(CASE t_id WHEN 1 THEN 1 ELSE 0 END) AS DecBill,
									SUM(CASE t_id WHEN 1 THEN numberOfPack ELSE 0 END) AS DecPack,
									AVG(CASE t_id WHEN 1 THEN duration ELSE 0 END) AS DecTime
								FROM [ieproject].[dbo].[operator_display]
								WHERE in_datetime > '$from_dt'
									AND in_datetime < '$to_dt'
									AND o_type = 2
									AND parttime = 2
									AND (s_id = 13)
								GROUP BY o_id, o_name;";
						//Execute Query
						$result = odbc_exec($db, $query);
						while($list = odbc_fetch_array($result)){

							//Retrieve Data from array
							$o_id = $list['o_id'];
							$o_name = iconv("TIS-620", "UTF-8", $list['o_name']);
							$DecBill = $list['DecBill'];
							$DecPack = $list['DecPack'];
							$DecTime = round($list['DecTime'],1);

							//print table
							echo "
								<tr>
									<td>$o_id</td>
									<td>$o_name</td>
									<td>$DecBill ใบ</td>
									<td>$DecPack</td>
									<td>$DecTime นาที</td>
								</tr>
							";
						}
					?>
				</table>
			</div>
		</div>
	</div>
</div>
</BODY>
</HTML>
