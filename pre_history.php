<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE> ประวัติการจัดยา </TITLE>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="w3.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
</HEAD>

<BODY>

<?php 
require("connection.php");
if(!isset($_GET['wo']))$_GET['wo']='';
$wo=$_GET['wo'];
if(!isset($_GET['date_value'])|!isset($_GET['date_valuee'])|$_GET['date_value']==''|$_GET['date_valuee']==''){
	date_default_timezone_set("Etc/GMT-7");
	$date_value=date("Y-m-d");
	$date_valuee=date("Y-m-d");
}else{
	$date_value=$_GET['date_value'];
	$date_valuee=$_GET['date_valuee'];
}
require("header.html");
require("source/maneger_side.html");
$check=0;
?>
<div class="w3-row-padding w3-container w3-section"  style="width: 73%; margin: 26%;">
		<div class="w3-container">
			<h1 class="w3-center"> ประวัติการจัดยา </h1>
		</div>
        <div class="w3-row-padding">
			<div class="w3-container w3-third w3-large w3-margin-right w3-margin-bottom">
			 	<div class="w3-card-2">
			<?php
				if($_GET['wo']!=''){
					$query = "SELECT o_id,o_name FROM operator WHERE o_id = '$wo' ";
					$result=odbc_exec($db,$query);
					if($list=odbc_fetch_array($result)){
						$o_id=$list['o_id'];
						$o_name=$list['o_name'];
						$o_name= iconv("tis-620", "utf-8", $o_name);
					}
					if($list['o_id']!='')
						echo "<div class='w3-container w3-border-bottom'>
								<h2>รายละเอียด</h2>
							</div>
							<div class='w3-container'>รหัสพนักงาน ".$o_id.'<br>ชื่อพนักงาน '.$o_name."
							</div>"; 
					else $check=1;
				}
				?>
               
					<div class="w3-container w3-border-bottom">
						<h2>ค้นหา</h2>
					</div>
                    <div class="w3-container">
                        <FORM class="w3-section" METHOD=GET  action='pre_history.php'>  
                        <label>วันที่</label> 
                        <input class='w3-input' type="date" id="dateInput"  name="date_value"  value=" <?php echo $date_value ;?> " > to 
                        <input class='w3-input' type="date" id="dateInput"  name="date_valuee"  value=" <?php echo $date_valuee ;?> " >
                        <label>รหัสพนักงาน</label>
                        <INPUT class='w3-input' TYPE="text" NAME="wo">
                        <div class="w3-margin-top w3-center"><INPUT class="w3-btn-block w3-blue" TYPE='submit' value='Search'></div>
                        </FORM>
					</div>
				</div>
              </div>

<?php 

if($date_value!=""&$date_valuee!="")
$alltotal=0;
$allmed=0;
$ref="$date_value 00:00:00";
$ref2="$date_valuee 23:59:59";
if($wo==''){
	echo"	<div class='w3-rest w3-container w3-card-2'>
		<div class='w3-container w3-border-bottom'>
			<h2>สถิติการจัดยาของแต่ละพนักงาน</h2>
			ระหว่างวันที่ ".$ref.' ถึง '.$ref2."
				</div>";
	if($ref>$ref2)
		echo '			
		<div class="w3-panel w3-orange">
		<span onclick="this.parentElement.style.display=\'none\'" class="w3-closebtn">&times;</span>
		<h3>กรอกวันที่ผิดพลาด</h3>
		<p>โปรดลองใหม่อีกครั้งหนึ่ง</p>
		</div>';
		else{
			echo"	<table class='w3-table w3-margin-bottom'>
							<TR>
								<TH>Operator ID</TH>
								<TH>Operator</TH>
								<TH>Count</TH>
							</TR>";
			$query  = "select o_id,o_name from operator where o_id<>'1' and o_id<>'2'";
			$result=odbc_exec($db,$query);
			while($list=odbc_fetch_array($result)){
				$o_id=$list['o_id'];
				$o_name=$list['o_name'];
				$o_name= iconv("tis-620", "utf-8", $o_name);
				$query  = "
			SELECT count(*) as count FROM prescription, oprel, operator WHERE oprel.op_time >'$ref' and oprel.op_time <'$ref2' and oprel.pre_id=prescription.pre_id AND operator.o_id = '$o_id' and '$o_id'=oprel.o_id and prescription.numberofmed>20 ";
				$result2=odbc_exec($db,$query);
				if($list2=odbc_fetch_array($result2)){
					$count1=2*$list2['count'];
				}
				$query  = "
			SELECT count(*) as count FROM prescription, oprel, operator WHERE oprel.op_time >'$ref' and oprel.op_time <'$ref2' and oprel.pre_id=prescription.pre_id AND operator.o_id = '$o_id' and '$o_id'=oprel.o_id and prescription.numberofmed<21 ";
				$result2=odbc_exec($db,$query);
				if($list2=odbc_fetch_array($result2)){
					$count2=$list2['count'];
				}
				$count=$count1+$count2;
				echo "<TR>
						<TD><a href='pre_history.php?wo=$o_id&date_value=$date_value&date_valuee=$date_valuee'>$o_id</a></TD>
						<TD>$o_name</TD>
						<TD>$count</TD>	
				</TR>";
				$allmed=$allmed+$numberofmed;
				$alltotal=$alltotal+$count;
			}	
			echo "<TR>
			<TD></TD>
			<TD>Total</TD>
			<TD>$alltotal</TD>
		</TR>";
	
	
		}
}else{
	echo"<div class='w3-rest w3-container w3-card-2'>
				<div class='w3-container w3-border-bottom'>
					<h2>สถิติการจัดยาของพนักงานโดยละเอียด</h2>
				</div>";
	if($check==1)
		echo '			
				<div class="w3-panel w3-orange">
				<span onclick="this.parentElement.style.display=\'none\'" class="w3-closebtn">&times;</span>
				<h3>รหัสพนักงานผิดพลาด</h3>
				<p>โปรดลองใหม่อีกครั้งหนึ่ง</p>
				</div>';
	else{
		if($ref>$ref2)
			echo '			
			<div class="w3-panel w3-orange">
			<span onclick="this.parentElement.style.display=\'none\'" class="w3-closebtn">&times;</span>
			<h3>กรอกวันที่ผิดพลาด</h3>
			<p>โปรดลองใหม่อีกครั้งหนึ่ง</p>
			</div>';
			else{
				echo"
					<table class='w3-table w3-margin-bottom'>
				<TR>
					<TH>Date</TH>
					<TH>Prescription</TH>
					<TH>Operator</TH>
					<TH>Number of Med</TH>
					<TH>Count</TH>
				</TR>
				";
				$query = "
				SELECT prescription.pre_id, prescription.numberofmed, oprel.op_time, operator.o_name, operator.o_type FROM prescription, oprel, operator WHERE oprel.pre_id=prescription.pre_id AND operator.o_id = '$wo' AND oprel.o_id = '$wo' order by op_time";
				$result=odbc_exec($db,$query);
				while($list=odbc_fetch_array($result)){
					$pre_id=$list['pre_id'];
					$date=$list['op_time'];
					$o_name=$list['o_name'];
					$o_name= iconv("tis-620", "utf-8", $o_name);
					$o_type=$list['o_type'];
					$numberofmed=$list['numberofmed'];
					if($date>=$ref&$date<$ref2){
						if($numberofmed>20){
							$count = 2;
						}else{
							$count = 1;
						}
						if($pre_id!=0){
							echo "<TR>
								<TD>$date</TD>
								<TD>$pre_id</TD>
								<TD>$o_name</TD>
								<TD>$numberofmed</TD>
								<TD>$count</TD>
			</TR>";
							$allmed=$allmed+$numberofmed;
							$alltotal=$alltotal+$count;
						}
					}
				}
				echo "<TR>
				<TD></TD>
				<TD></TD>
				<TD>Total</TD>
				<TD>$allmed</TD>
				<TD>$alltotal</TD>
			</TR>";
			}
	}
}


?>


</TABLE>


				<div class="w3-center w3-section">
				
				</div>
			 </div>
		</div>
	</div>
</BODY>
</HTML>
