<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php 
	require("connection.php");
	require("function_stat.php");
	session_start();
	if(!isset($_GET['pre_id']))$_GET['pre_id']='';
	$pre_id=$_GET['pre_id'];
	if(!isset($_GET['last_q_start_mill']))$_GET['last_q_start_mill']=0;
	$last_q_start_mill=$_GET['last_q_start_mill'];

	date_default_timezone_set("Etc/GMT-7");
	$timestamp = date("Y-m-d H:i:s");
	$_SESSION['timestamp']= $timestamp;
	$d=strtotime("-2 days");
	$ref=date("Y-m-d H:i:s",$d);
	$d=strtotime("-4 hours");
	$ref2=date("Y-m-d H:i:s",$d);

	require("source/cancel_auto.php"); //ใช้เปลี่ยนทุกตัวที่ cancel แล้วให้ถูกยกเลิก
	$query="SELECT * FROM prescription WHERE pre_id='$pre_id'";
	$result=odbc_exec($db,$query);
	if($list=odbc_fetch_array($result)) //ถ้ายาอยู่ในระบบเราแล้ว
	{
		// $query="SELECT * FROM prescription WHERE pre_id='$pre_id'"; //ทำไมต้องหาอีกรอบอะ
		// $result=odbc_exec($db,$query);
		// if($list=odbc_fetch_array($result)){
		$s_id=$list['s_id'];
		$t_id=$list['t_id'];
		// }

		//Chech if the prescription is cancled
		$query="SELECT * FROM get_preinfo WHERE pre_id='$pre_id'"; // AND date>'$ref' ไม่ต้องใส่ก็ได้
		$result=odbc_exec($db2,$query);
		if($list=odbc_fetch_array($result)){
			$status=$list['Status'];
			if($status==1){ //ถ้าโดน cancel แล้ว
				if($t_id==1)$ca=101;
				if($t_id==2)$ca=201;
				if($t_id==3)$ca=301;
				if($t_id==4)$ca=401;
				if($s_id!=$ca){ //ถ้าในระบบยังไม่เคยยกเลิกไปแล้วทีนุึง ให้ใส่ยกเลิกลง psrel ด้วย
					$query ="INSERT INTO psrel (pre_id,s_id,ps_time,duration,numberOfOper) VALUES ('$pre_id','$ca','$timestamp',0,0)";
					odbc_exec($db,$query);
				}
				$query="UPDATE prescription SET s_id='$ca' WHERE pre_id='$pre_id' and s_id='$s_id' ";
				odbc_exec($db,$query);
				
				$_SESSION['c']=2;
				header("refresh: 0; url=pre_id_input.php");
			}
		}
		//Determine if there is an operator
		if($s_id==10 or $s_id==20 or $s_id==12 or $s_id==30 or $s_id==103 or $s_id==15 or $s_id==23 or $s_id==32 or $s_id==40 ){ //103 คือต้มวันอื่น ต้องส่งไปให้ลงชื่อคนที่กำลังจะต้ม
			header("refresh: 0; url=input_operator.php?pre_id=$pre_id&s_id=$s_id");
		} 
		//ไม่มี operator
		else {header("refresh: 0; url=update_report.php?pre_id=$pre_id&s_id=$s_id&last_q_start_mill=$last_q_start_mill");   
		// echo $last_q_start_mill;
		// 	echo "<script type=\"text/javascript\">
		// 	window.open('qcall.php?pre_id=$pre_id&s_id=$s_id', '_blank')
		// </script>";
		}
	}

	else{ //ถ้ายาเข้าระบบครั้งแรก
		$query="SELECT * FROM get_preinfo WHERE pre_id='$pre_id' AND date>'$ref'";
		$result=odbc_exec($db2,$query);
		if($list=odbc_fetch_array($result)){
			$c_id=$list['c_id'];
			$q_name=$list['q_name'];
			$type=$list['type'];
			$decoctingtime=$list['decoctingtime'];
			$numberofmed=$list['numberofmed'];
			$numberofpack=$list['numberofpack'];
			$status=$list['Status'];
			if($status==1){
				$_SESSION['c']=2;
				header("refresh: 0; url=pre_id_input.php");
			}
			else{
				if($type=='A') {
					$s_id=10;
					$t_id=1;
				}
				elseif($type=='B') {
					$s_id=20;
					$t_id=2;
				}
				elseif($type=='C') {
					$s_id=30;
					$t_id=3;
				}
				elseif($type=='D') {
					$s_id=40;
					$t_id=4;
				}
				else {
					$s_id=40;
					$t_id=4;
				}

				// Find if q_name is exist in this day
				$result=odbc_exec($db,"SELECT * FROM queue WHERE q_name='$q_name' AND in_datetime>'$ref2';");
				if($list = odbc_fetch_array($result)){
					$new_id = $list['q_id']; //ให้ใช้ q_id เดิม
				} 
				else{
					//add this q_name to new q_id
					$result=odbc_exec($db,"SELECT MAX(q_id)+1 AS MaxID FROM queue");
					if($list=odbc_fetch_array($result)){
						$new_id=$list['MaxID'];
					}
					$query ="INSERT INTO queue (q_id,q_name,c_id,in_datetime) VALUES ('$new_id','$q_name','$c_id','$timestamp')";
					odbc_exec($db,$query);
				}
				
				$numberOfQ1=0;
				$numberOfQ2=0;
				$numberOfQ3=0;
				$inprocessQ1=0;
				$inprocessQ2=0;
				$inprocessQ3=0;
				$numberOfB1=0;
				$query2 ="SELECT count(s_id) AS count FROM prescription WHERE s_id=10 AND in_datetime>'$ref2' ";
				$result2=odbc_exec($db,$query2);
				while($list=odbc_fetch_array($result2)){
					$count=$list['count'];
					$numberOfQ1=$numberOfQ1+$count;
				}

				$query2 ="SELECT count(s_id) AS count FROM prescription WHERE s_id=20 AND in_datetime>'$ref2'";
				$result2=odbc_exec($db,$query2);
				while($list=odbc_fetch_array($result2)){
					$count=$list['count'];
					$numberOfQ2=$numberOfQ2+$count;
				}
				
				$query2 ="SELECT count(s_id) AS count FROM prescription WHERE s_id=30 AND in_datetime>'$ref2'";
				$result2=odbc_exec($db,$query2);
				while($list=odbc_fetch_array($result2)){
					$count=$list['count'];
					$numberOfQ3=$numberOfQ3+$count;
				}

				$query2 ="SELECT count(s_id) AS count FROM prescription WHERE s_id=11 AND in_datetime>'$ref2'";
				$result2=odbc_exec($db,$query2);
				while($list=odbc_fetch_array($result2)){
					$count=$list['count'];
					$inprocessQ1=$inprocessQ1+$count;
				}
				
				$query2 ="SELECT count(s_id) AS count FROM prescription WHERE s_id=21 AND in_datetime>'$ref2'";
				$result2=odbc_exec($db,$query2);
				while($list=odbc_fetch_array($result2)){
					$count=$list['count'];
					$inprocessQ2=$inprocessQ2+$count;
				}

				$query2 ="SELECT count(s_id) AS count FROM prescription WHERE s_id=31 AND in_datetime>'$ref2'";
				$result2=odbc_exec($db,$query2);
				while($list=odbc_fetch_array($result2)){
					$count=$list['count'];
					$inprocessQ3=$inprocessQ3+$count;
				}
				$query2 ="SELECT count(s_id) AS count FROM prescription WHERE s_id=12 AND in_datetime>'$ref2'";
				$result2=odbc_exec($db,$query2);
				while($list=odbc_fetch_array($result2)){
					$count=$list['count'];
					$numberOfB1=$numberOfB1+$count;
				}



				$query2 ="SELECT id, boil FROM Qr where id='$pre_id'";
				$result2=odbc_exec($db2,$query2);
				$boilinfo = "n/a";
				while($list=odbc_fetch_array($result2)){
					if ($list['boil']==""){
						$boilinfo = "n/a";
					}else $boilinfo= $list['boil'];
				}

				$query2 ="SELECT id, count(*) AS numberOfMed FROM Di WHERE id = '$pre_id' GROUP BY id";
				$result2=odbc_exec($db2,$query2);
				while($list=odbc_fetch_array($result2)){
					$numberofmed= $list['numberOfMed'];
				}
				
				
				
				
				
				
				
				
				
					$query="SELECT * 
					FROM equation WHERE t_id='$t_id' AND Version IN
					( SELECT MAX(Version)
						FROM equation WHERE t_id='$t_id'
					)";
					$result=odbc_exec($db,$query);
					if($list=odbc_fetch_array($result))
						{
							$Version=$list['Version'];
							$datetime=$list['datetime'];
							$Intercept=$list['Intercept'];
							$Coef1=$list['Coef1'];
							$Coef2=$list['Coef2'];
							$Coef3=$list['Coef3'];
							$Coef4=$list['Coef4'];
							$Coef5=$list['Coef5'];
							$Coef6=$list['Coef6'];
							$Coef7=$list['Coef7'];
							$Coef8=$list['Coef8'];
							$Coef9=$list['Coef9'];
							$Coef10=$list['Coef10'];
							$Coef11=$list['Coef11'];
							$Coef12=$list['Coef12'];
							$Coef13=$list['Coef13'];
							$Coef14=$list['Coef14'];
							$Coef15=$list['Coef15'];
							$Coef16=$list['Coef16'];
							$Coef17=$list['Coef17'];
							$Coef18=$list['Coef18'];
							$Coef19=$list['Coef19'];
							$Coef20=$list['Coef20'];
							$Coef21=$list['Coef21'];
							$Coef22=$list['Coef22'];
							$Coef23=$list['Coef23'];
							$Coef24=$list['Coef24'];
							$Zvalue=$list['Zvalue'];
							$Tune=$list['Tune'];
						}
			
			
			
			
			
				$finish=find_finishtime($pre_id,$t_id,$numberOfQ1,$numberOfQ2,$numberOfQ3,$inprocessQ1,$inprocessQ2,$inprocessQ3,$numberOfB1,$numberofmed,$numberofpack,$Intercept,$Coef1,$Coef2,$Coef3,$Coef4,$Coef5,$Coef6,$Coef7,$Coef8,$Coef9,$Coef10,$Coef11,$Coef12,$Coef13,$Coef14,$Coef15,$Coef16,$Coef17,$Coef18,$Coef19,$Coef20,$Coef21,$Coef22,$Coef23,$Coef24,$Zvalue,$Tune);

				/**/
				// ถ้าเวลา > 16:25 ให้รับที่ 16:25
				if ($timestamp <= date("Y-m-d 14:30:59"))
				{
					if ($finish > date("Y-m-d 16:25:00"))
					{
						$finish = date("Y-m-d 16:25:00");
					}
				};
				

				//ใส่ข้อมูลลงตาราง prescription
				
				$query ="INSERT INTO prescription ( pre_id,c_id,s_id,q_id,t_id,in_datetime,decoctingtime,cc,average_weight,finishTime,numberOfMed,numberOfPack,numberOfQ1,numberOfQ2,numberOfQ3,inprocessQ1,inprocessQ2,inprocessQ3,numberOfB1, boilinfo) VALUES ('$pre_id','$c_id','$s_id','$new_id','$t_id','$timestamp','$decoctingtime',0,0,'$finish','$numberofmed','$numberofpack','$numberOfQ1','$numberOfQ2'
				,'$numberOfQ3','$inprocessQ1','$inprocessQ2','$inprocessQ3','$numberOfB1', '$boilinfo')";
				odbc_exec($db,$query);
				$query ="INSERT INTO psrel (pre_id,s_id,ps_time,duration,numberOfOper) VALUES ('$pre_id','$s_id','$timestamp',0,0)";
				odbc_exec($db,$query);
				header("refresh: 0; url=start_report.php?pre_id=$pre_id");
			}
		}else{
			//ไม่พบใบยาในระบบ
		$_SESSION['c']=1;
		header("refresh: 0; url=pre_id_input.php");
		}
	}



?>
</body>
</html>