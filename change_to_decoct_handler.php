<?php 
	require("connection.php");
	require("function_stat.php");
	session_start();
	if(!isset($_GET['pre_id']))$_GET['pre_id']='';
	$pre_id=$_GET['pre_id'];

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
		$s_id=$list['s_id'];
		$t_id=$list['t_id'];

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
		if($s_id==22 or $s_id==23 or $s_id==24){ 
		//เช็คว่าเป็นยาจัดท่จัดเสร็จแล้วหรือยัง ถ้าใช่ก็จะจัดการให้ไปหน้าใส่ Operator
			header("refresh: 0; url=change_to_decoct_operator_input.php?pre_id=$pre_id&s_id=$s_id");
		} 
		//ย้อนกลับไปหน้าเดิมแล้วขึ้นว่าให้จัดให้เสร็จก่อนแล้วค่อยเปลี่ยน
		else {
			$_SESSION['c']=201;
			header("refresh: 0; url=change_to_decoct.php");
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
				$inprocessQ1=0;
				$inprocessQ2=0;
				$query2 ="SELECT count(s_id) AS count FROM prescription where (s_id=10  or s_id=20) AND in_datetime>'$ref2' ";
				$result2=odbc_exec($db,$query2);
				while($list=odbc_fetch_array($result2)){
					$count=$list['count'];
					$numberOfQ1=$numberOfQ1+$count;
				}

				$query2 ="SELECT count(s_id) AS count FROM prescription where ((s_id>9 and s_id<13 ) or s_id=20 or s_id=21)AND in_datetime>'$ref2'";
				$result2=odbc_exec($db,$query2);
				while($list=odbc_fetch_array($result2)){
					$count=$list['count'];
					$numberOfQ2=$numberOfQ2+$count;
				}

				$query2 ="SELECT count(s_id) AS count FROM prescription where (s_id=11 or s_id=21) AND in_datetime>'$ref2'";
				$result2=odbc_exec($db,$query2);
				while($list=odbc_fetch_array($result2)){
					$count=$list['count'];
					$inprocessQ1=$inprocessQ1+$count;
				}

				$query2 ="SELECT count(s_id) AS count FROM prescription where s_id=13 AND in_datetime>'$ref2'";
				$result2=odbc_exec($db,$query2);
				while($list=odbc_fetch_array($result2)){
					$count=$list['count'];
					$inprocessQ2=$inprocessQ2+$count;
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
				$finish=find_finishtime($pre_id,$t_id,$numberOfQ1,$numberOfQ2,$inprocessQ1,$inprocessQ2);

				//ใส่ข้อมูลลงตาราง prescription
				$query ="INSERT INTO prescription ( pre_id,c_id,s_id,q_id,t_id,in_datetime,decoctingtime,cc,average_weight,finishTime,numberOfMed,numberOfPack,numberOfQ1,numberOfQ2,inprocessQ1,inprocessQ2, boilinfo) VALUES ('$pre_id','$c_id','$s_id','$new_id','$t_id','$timestamp','$decoctingtime',0,0,'$finish','$numberofmed','$numberofpack','$numberOfQ1','$numberOfQ2','$inprocessQ1','$inprocessQ2', '$boilinfo')";
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
