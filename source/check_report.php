<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE> Status Report </TITLE>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="w3.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script>
	function del(pre_id,s_id,s_name){
		var test = confirm("ยืนยันที่จะลบสถานะ\'" + s_name +"\'?" );
		if (test) {
			window.open('check_report_handler.php?pre_id='+pre_id+'&s_id='+s_id, '_self');
		}
	}
</script>
</HEAD>

<BODY>

<?php 
require("connection.php");
require('header.html');
if(!isset($_GET['pre_id']))$_GET['pre_id']='';
$pre_id=$_GET['pre_id'];
?>

<?php 
//$query="SELECT * FROM prescription WHERE pre_id='$pre_id'";
//$result=odbc_exec($db,$query);
//
//if($list=odbc_fetch_array($result))
//{
//$query="SELECT * FROM prescription WHERE pre_id='$pre_id'";
//$result=odbc_exec($db,$query);
//
	
//$query="SELECT * FROM customer WHERE c_id='$c_id'";
//$result=odbc_exec($db,$query);
//if($list=odbc_fetch_array($result)){
//	$c_name=$list['c_name'];
//	$tel=$list['tel'];
//}
//$query="SELECT * FROM status WHERE s_id='$s_id'";
//$result=odbc_exec($db,$query);
//if($list=odbc_fetch_array($result)){
//	$s_name=$list['s_name'];
//	$t_id=$list['t_id'];
//}
//$query="SELECT * FROM queue WHERE q_id='$q_id'";
//$result=odbc_exec($db,$query);
//if($list=odbc_fetch_array($result)){
//	$q_name=$list['q_name'];
//}
//$query="SELECT * FROM type WHERE t_id='$t_id'";
//$result=odbc_exec($db,$query);
//if($list=odbc_fetch_array($result)){
//	$t_name=$list['t_name'];
//}
//	}else
//{
//	session_start();
//	$_SESSION['c']=1;
//	header("refresh: 0; url=check_input.php");
//}
?>

<?php
	$query = "
	SELECT prescription.pre_id, prescription.c_id,  prescription.q_id, queue.q_name,  prescription.s_id, status.s_name, status.t_id, type.t_name
	FROM prescription, type, status, queue
	WHERE 
	prescription.s_id=status.s_id AND
	queue.q_id = prescription.q_id AND status.t_id=type.t_id AND prescription.pre_id = '$pre_id';";
	$result=odbc_exec($db,$query);
	if($list=odbc_fetch_array($result)){
		$c_id=$list['c_id'];
		$c_name="";
		//c_name ต้องเปลี่ยนอีกทีใช้ function
		$s_id=$list['s_id'];
		$s_name=$list['s_name'];
		$q_id=$list['q_id'];
		$q_name=$list['q_name'];
		$t_id=$list['t_id'];
		$t_name=$list['t_name'];
	}
	else{
		session_start();
		$_SESSION['c']=1;
		header("refresh: 0; url=check_input.php");
	}
	
?>
	<div class="w3-row-padding w3-container w3-section"  style="width: 80%; margin: auto;">
		<div class="w3-container">
			<h1 class="w3-center">สถานะใบยา<//h1>
		</div>
		<div class="w3-row-padding">
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
						<td><?php echo $c_id;?></td>
					</tr>
					<tr class="w3-text-red">
						<th>สถานะ</th>
						<td><?php echo $s_name;?></td>
					</tr>
				</table>
			</div>
			<div class="w3-rest w3-container w3-card-2">
				<div class="w3-container w3-border-bottom">
					<h2>ประวัติสถานะ</h2>
				</div>
				<table class="w3-table w3-margin-bottom">
					<tr>
						<th>เวลา</th>
						<th>สถานะ</th>
						<th>พนักงาน</th>
					</tr>
					<?php 
						$query1 = "
							SELECT psrel.ps_time ,psrel.pre_id, psrel.s_id, status.s_name
							FROM psrel 
							INNER JOIN status on psrel.s_id = status.s_id
							WHERE psrel.pre_id='$pre_id' 
							
							";
						$result1=odbc_exec($db,$query1);
						while($list1=odbc_fetch_array($result1)){
							$ps_time = $list1['ps_time'];
							$s_id = $list1['s_id'];
							$s_name = $list1['s_name'];
							$o_name = '-';
							$query2 = "SELECT oprel.pre_id, oprel.s_id, oprel.o_id, operator.o_name 
							FROM oprel
							INNER JOIN operator on oprel.o_id=operator.o_id
							WHERE oprel.pre_id ='$pre_id' ";
							$result2=odbc_exec($db,$query2);
							if($list2=odbc_fetch_array($result2)){
								$o_name = $list2['o_name'];
								echo 
									('<tr>
										<td>'.$ps_time.'</td>
										<td>'.$s_name.'</td>
										<td>'.$o_name.'</td>
									</tr>');
								//เช็คว่ามีอีกคนไหม,  ORDER BY psrel.ps_time  ASC;
								if($list2=odbc_fetch_array($result2)){
									$o_name = $list2['o_name'];
									echo 
										('<tr>
											<td>'.$ps_time.'</td>
											<td>'.$s_name.'</td>
											<td>'.$o_name.'</td>
										</tr>');
								}
							}
							else{ //if there is no operator
								echo 
									('<tr>
										<td>'.$ps_time.'</td>
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
	<div class="w3-row w3-container w3-card-2 w3-section"  style="width: 80%; margin: auto;">
		<div>
			
		</div>
	</div>

</body>
</html>