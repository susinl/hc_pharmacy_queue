<!DOCTYPE html>
<HTML>
<HEAD>
<TITLE> Working Record - Individual </TITLE>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="../w3.css">
<link rel="stylesheet" type="text/css" href="../source/progress_bar.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../font-awesome-4.7.0/css/font-awesome.min.css">

<link rel="stylesheet" href="../source/timepicker/1.3.5/jquery.timepicker.min.css">
<!-- http://timepicker.co/ -->
</HEAD>




<BODY>
<script src="../jquery-3.1.1.js"></script>
<script src="../source/timepicker/1.3.5/jquery.timepicker.min.js"></script>

<script>
//AJAX
	function showRecord(o_id, fromDt, toDt) {
	//fromDt and toDt are a datetime (inform of datenumber not a string)
	    if (o_id == "") {
	        document.getElementById("report").innerHTML = "";
	        return;
	    } 
		else { 
	        if (window.XMLHttpRequest) {
	            // code for IE7+, Firefox, Chrome, Opera, Safari
	            xmlhttp = new XMLHttpRequest();
	        } else {
	            // code for IE6, IE5
	            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	        }
	        xmlhttp.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {
	                document.getElementById("report").innerHTML = this.responseText;
	            }
	    };
	        xmlhttp.open("GET","../source/AJAX/oRecord.php?o_id="+o_id+"&from_dt="+fromDt+"&to_dt="+toDt,true);
	        xmlhttp.send();
    	}
	}
</script>


<script>
//Time picker
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
	require "../connection.php";
	date_default_timezone_set("Etc/GMT-7");

	//Query time parameter from form
	//from
	if(!isset($_GET['from_date'])) 
		$_GET['from_date'] = date("Y-m-d");
	$from_date=$_GET['from_date'];
	if(!isset($_GET['from_time'])) 
		$_GET['from_time'] = "08:00:00";
	$from_time=$_GET['from_time'];

	//to
	if(!isset($_GET['to_date'])) 
		$_GET['to_date'] = date("Y-m-d");
	$to_date=$_GET['to_date'];
	if(!isset($_GET['to_time'])) 
		$_GET['to_time'] = "18:00:00";
	$to_time=$_GET['to_time'];

	$from_dt = $from_date." ".$from_time;
	$to_dt = $to_date." ".$to_time;

	//Query operator
	if(!isset($_GET['o_id'])) 
		$_GET['o_id'] = "";
	$o_id = $_GET['o_id'];
?>

<div class="w3-section w3-container">
			<!-- Heading Card -->
	<div class="w3-row w3-border-bottom">
		<div class="l2 w3-col">
			<a class="w3-btn w3-white w3-xlarge" href="working_record_home.php"> &laquo; กลับ</a>
		</div>
		<div class="l8 w3-col w3-center w3-center w3-xxlarge">
			<i class="fa fa-bar-chart" aria-hidden="true"></i>&nbsp;ประวัติการทำงาน-รายบุคคล
		</div>
		<div class="l2 w3-col">
		</div>
	</div>

	<div class="w3-row-padding">
		<div class="w3-quarter">
			<!-- Date Input Card On the Left Side --> 
			<div class="w3-container w3-margin-bottom w3-section w3-card-2">
				<h2 class="w3-center">วันเวลาที่ต้องการ</h2>
				<form method="GET" class="w3-margin-bottom" action="working_record_individual.php" style="max-width: 1000px; margin: auto;"">
					<label>ตั้งแต่</label><br>
					<input class="w3-input w3-large w3-border w3-margin-top" type="date" name="from_date" value=<?php echo $from_date; ?> style="max-width: 400px;">
					<input class="w3-input w3-large w3-border w3-margin-top w3-margin-bottom timepickerfrom" type="text" name="from_time" value=<?php echo $from_time; ?> style="max-width: 400px;"> <br>


					<label>ถึง</label><br>
					<input class="w3-input w3-large w3-border w3-margin-top w3-margin-bottom" type="date" name="to_date" value=<?php echo $to_dt; ?> style="max-width: 400px;">
					<input class="w3-input w3-large w3-border w3-margin-top w3-margin-bottom timepickerto" type="text" name="to_time" value=<?php echo $to_time; ?> style="max-width: 400px;"> <br>

					<input class="w3-btn w3-block w3-blue" type="submit" value="ตกลง">
				</form>
			</div>

			<!-- Summary Report -->
			<div class="w3-container w3-margin-bottom w3-section w3-card-2">
				<h2 class="w3-crnter">สรุปของวัน</h2>
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
						while($list = odbc_fetch_array($result)){
							$t_name = iconv("TIS-620", "UTF-8", $list['t_name']);
							$count = $list['count'];
							echo 
							"<tr>
								<td>$t_name</td>
								<td>$count</td>
							</tr>";
						}
					?>
				</table>
			</div>


		</div>
		<!-- Close -->


				
		<!-- Report Column On The Right -->
		<div class="w3-margin-bottom w3-rest w3-container">

			<!-- Select Operator -->
			<div class="w3-container w3-card-2 w3-section">	
				<h2 class='w3-border-bottom'>เลือกพนักงาน</h2>
				<form>
					<select class = "w3-select w3-large" name="users" onchange="showRecord(this.value, <?php echo strtotime($from_dt); ?>, <?php echo strtotime($to_dt); ?>)">

					  <option value="">เลือกพนักงาน*</option>
					  <optgroup label="พนักงานประจำ - จัดยา">
					  	<?php
					  		$query = "SELECT * 
					  					from ieproject.dbo.operator 
					  					where parttime = 1 
					  						and o_type = 1
					  						and o_id in (SELECT o_id from ieproject.dbo.oprel where op_time > '$from_dt' and op_time <= '$to_dt');";
					  		$result = odbc_exec($db, $query);
					  		while ($list = odbc_fetch_array($result)){
					  			$o_id = $list['o_id'];
					  			$o_name = iconv('TIS-620', "UTF-8", $list['o_name']);
					  			echo "<option value='$o_id'>$o_name</option>";
					  		}
					  	?>
					  </optgroup>
					  <optgroup label="พนักงานประจำ - ต้มยา">
					  	<?php
					  		$query = "SELECT * 
					  					from ieproject.dbo.operator 
					  					where parttime = 1 
					  						and o_type = 2
					  						and o_id in (SELECT o_id from ieproject.dbo.oprel where op_time > '$from_dt' and op_time <= '$to_dt');";
					  		$result = odbc_exec($db, $query);
					  		while ($list = odbc_fetch_array($result)){
					  			$o_id = $list['o_id'];
					  			$o_name = iconv('TIS-620', "UTF-8", $list['o_name']);
					  			echo "<option value='$o_id'>$o_name</option>";
					  		}
					  	?>
					  </optgroup>
					   <optgroup label="พนักงานชั่วคราว - จัดยา">
					  	<?php
					  		$query = "SELECT * 
					  					from ieproject.dbo.operator 
					  					where parttime = 2 
					  						and o_type = 1
					  						and o_id in (SELECT o_id from ieproject.dbo.oprel where op_time > '$from_dt' and op_time <= '$to_dt');";
					  		$result = odbc_exec($db, $query);
					  		while ($list = odbc_fetch_array($result)){
					  			$o_id = $list['o_id'];
					  			$o_name = iconv('TIS-620', "UTF-8", $list['o_name']);
					  			echo "<option value='$o_id'>$o_name</option>";
					  		}
					  	?>
					  </optgroup>
					   <optgroup label="พนักงานชั่วคราว - ต้มยา">
					  	<?php
					  		$query = "SELECT * 
					  					from ieproject.dbo.operator 
					  					where parttime = 2 
					  						and o_type = 2
					  						and o_id in (SELECT o_id from ieproject.dbo.oprel where op_time > '$from_dt' and op_time <= '$to_dt');";
					  		$result = odbc_exec($db, $query);
					  		while ($list = odbc_fetch_array($result)){
					  			$o_id = $list['o_id'];
					  			$o_name = iconv('TIS-620', "UTF-8", $list['o_name']);
					  			echo "<option value='$o_id'>$o_name</option>";
					  		}
					  	?>
					  </optgroup>
					</select>
					<label>*แสดงเพียงพนักงานที่มีประวัติการทำงานในช่วงเวลาที่เลือก</label>
				</form>
			</div>

			<div class="w3-container w3-card-2 w3-section" id="report">	
				<!-- The report will generate from another file;  pharmacy_queue/source/AJAX/oRecord.php -->
			</div>
			
		</div>
	</div>
</div>
</BODY>
</HTML>
