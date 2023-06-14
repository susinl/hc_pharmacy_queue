<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE> Status Report </TITLE>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="w3.css">
<link rel="stylesheet" type="text/css" href="source/progress_bar.css">
<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script>
	function del(pre_id,s_id,s_name){
		var test = confirm("ยืนยันที่จะลบสถานะ\'" + s_name +"\'?" );
		if (test) {
			window.open('check_report_handler.php?pre_id='+pre_id+'&s_id='+s_id, '_self');
		}
	}
	function del_from_sys(pre_id,s_id,s_name){
		var test = confirm("ยืนยันที่จะลบใบยา");
		if (test) {
			window.open('check_report_handler_del_from_sys.php?pre_id='+pre_id+'&s_id='+s_id, '_self');
		}
	}
</script>
</HEAD>

<BODY>

<?php 
require("connection.php");
require('header.html');
date_default_timezone_set("Etc/GMT-7");
if(!isset($_GET['pre_id']))$_GET['pre_id']='';
$pre_id=$_GET['pre_id'];
?>

<?php
	$query = "
	SELECT prescription.pre_id, prescription.c_id,  prescription.q_id, queue.q_name,  prescription.s_id, status.s_name, status.t_id, type.t_name, prescription.finishtime
	FROM prescription, type, status, queue
	WHERE 
	prescription.s_id=status.s_id AND
	queue.q_id = prescription.q_id AND status.t_id=type.t_id AND prescription.pre_id = '$pre_id';";
	$result=odbc_exec($db,$query);
	if($list=odbc_fetch_array($result)){
		$c_id=$list['c_id'];
		$query2 ="SELECT c_name from get_cusinfo where HN='$c_id' ";
		$result2=odbc_exec($db2,$query2);
		if($list2=odbc_fetch_array($result2)){
			$c_name = iconv("TIS-620", "UTF-8", $list2['c_name']);
		}
		$s_id=iconv("TIS-620", "UTF-8",$list['s_id']);
		$s_name=iconv("TIS-620", "UTF-8",$list['s_name']);
		$q_id=iconv("TIS-620", "UTF-8",$list['q_id']);
		$q_name=iconv("TIS-620", "UTF-8",$list['q_name']);
		$t_id=iconv("TIS-620", "UTF-8",$list['t_id']);
		$t_name=iconv("TIS-620", "UTF-8",$list['t_name']);
		$finishtime=$list['finishtime'];
		$finishtime_display=round(strtotime($finishtime) / 300) * 300;
	}
	else{
		session_start();
		$_SESSION['c']=1;
		header("refresh: 0; url=check_input.php");
	}
	
?>
	<div class="w3-row-padding w3-container w3-section"  style="width: 90%; margin: auto;">
		<div class="w3-container">
			<h1 class="w3-center">สถานะใบยา</h1>
		</div>
		
		<div class="w3-row-padding">
			<div class="w3-section w3-card-2 w3-container">
				<div class="w3-section w3-large">
					<?php
						require 'pb/pb_check_translate_q.php';
					?>
				</div>
			</div>
			<div class="w3-container w3-third w3-large w3-card-2 w3-margin-right">
				<div class="w3-container w3-border-bottom">
					<h2>รายละเอียด</h2>
				</div>
				<table class="w3-table w3-margin-bottom">
					<tr>
						<th>รหัสใบยา</th>
						<td><?php echo $pre_id;?></td>
					</tr>
					<tr>
						<th>คิว</th>
						<td><?php echo $q_name;?></td>
					</tr>
					<tr>
						<th>ชนิด</th>
						<td><?php echo $t_name;?></td>
					</tr>
					<tr>
						<th>HN</th>
						<td><?php echo $c_id;?></td>
					</tr>
					<tr>
						<th>คนไข้</th>
						<td><?php echo $c_name;?></td>
					</tr>
					<tr class="w3-blue">
						<th>เสร็จประมาณ</th>
						<td ><?php echo date("H:i",$finishtime_display);?></td>
					</tr>
					<tr class="w3-text-red">
						<th>สถานะ</th>
						<td><?php echo $s_name;?></td>
					</tr>
				</table>
				<div class="w3-center w3-section">
					<button class="w3-btn-block w3-red" style="width: 60%;" onClick="del_from_sys(<?php echo $pre_id.','.$s_id.',\''.$s_name.'\''; ?>)" >
						ลบใบยาออกจากระบบ
					</button>
				</div>
			</div>
			<div class="w3-rest w3-container w3-card-2">
				<div class="w3-container w3-border-bottom">
					<h2>ประวัติสถานะ</h2>
				</div>
				<table class="w3-table w3-margin-bottom">
					<tr>
						<th>วันที่</th>
						<th>เวลา</th>
						<th>สถานะ</th>
						<th>พนักงาน</th>
					</tr>
					<?php 
						$query1 = "
							SELECT psrel.ps_time ,psrel.pre_id, psrel.s_id, status.s_name
							FROM psrel INNER JOIN status on psrel.s_id = status.s_id
							WHERE psrel.pre_id='$pre_id' 
							ORDER BY psrel.ps_time  ASC;
							
							";
						$result1=odbc_exec($db,$query1);
						while($list1=odbc_fetch_array($result1)){
							$ps_time = iconv("TIS-620", "UTF-8",$list1['ps_time']);
							$s_id = iconv("TIS-620", "UTF-8",$list1['s_id']);
							$s_name = iconv("TIS-620", "UTF-8",$list1['s_name']);
							$o_name = '-';
							$query2 = "SELECT oprel.pre_id, oprel.s_id, oprel.o_id, operator.o_name 
							FROM oprel INNER JOIN operator on oprel.o_id=operator.o_id
							WHERE oprel.pre_id ='$pre_id' AND oprel.s_id ='$s_id' ";
							$result2=odbc_exec($db,$query2);
							if($list2=odbc_fetch_array($result2)){
								$o_name = iconv("TIS-620", "UTF-8",$list2['o_name']);
								echo 
									('<tr>
										<td>'.date("Y-m-d", strtotime($ps_time)).'</td>
										<td>'.date("H:i:s", strtotime($ps_time)).'</td>
										<td>'.$s_name.'</td>
										<td>'.$o_name.'</td>
									</tr>');
								//เช็คว่ามีอีกคนไหม,  
								if($list2=odbc_fetch_array($result2)){
									$o_name = iconv("TIS-620", "UTF-8",$list2['o_name']);
									echo 
										('<tr>
											<td>'.date("Y-m-d", strtotime($ps_time)).'</td>
											<td>'.date("H:i:s", strtotime($ps_time)).'</td>
											<td>'.$s_name.'</td>
											<td>'.$o_name.'</td>
										</tr>');
								}
							}
							else{ //if there is no operator
								echo 
									('<tr>
										<td>'.date("Y-m-d", strtotime($ps_time)).'</td>
										<td>'.date("H:i:s", strtotime($ps_time)).'</td>
										<td>'.$s_name.'</td>
										<td>'.$o_name.'</td>
									</tr>'); 
							}
						}
					?>
				</table>
				<div class="w3-center w3-section">
					<button class="w3-btn-block w3-red" style="width: 60%;" onClick="del(<?php echo $pre_id.','.$s_id.',\''.$s_name.'\''; ?>)" >
						ยกเลิกสถานะสุดท้าย<br>(<?php echo($s_name); ?>)
					</button>
				</div>
			 </div>
		</div>
	</div>
</body>
</html>