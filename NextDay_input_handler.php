<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>NextDay_input_handler.php</title>
</head>

<body>
<?php 
	require("connection.php");
	session_start();
	if(!isset($_GET['pre_id']))$_GET['pre_id']='';
	$pre_id=$_GET['pre_id'];


	$query="SELECT * FROM prescription WHERE pre_id='$pre_id'";
	$result=odbc_exec($db,$query);

	if($list=odbc_fetch_array($result))
	{	
		$s_id=$list['s_id'];
		$t_id=$list['t_id'];
		
		//เช็คว่าโดน cancel ไปหรือยัง (เริ่ม)
		$query="SELECT * FROM get_preinfo WHERE pre_id='$pre_id'"; // AND date>'$ref' ไม่ต้องใส่ก็ได้
		$result=odbc_exec($db2,$query);
		if($list=odbc_fetch_array($result)){
			$status=$list['Status'];
			if($status==1){ //ถ้าโดน cancel แล้ว
				if($t_id==1)$ca=101;
				if($t_id==2)$ca=201;
				if($t_id==3)$ca=301;
				if($t_id==4)$ca=401;
				if($s_id!=$ca){ //ถ้าในระบบยังไม่เคยยกเลิกไปแล้วให้ใส่ยกเลิกลง psrel ด้วย
					$query ="INSERT INTO psrel (pre_id,s_id,ps_time,duration,numberOfOper) VALUES ('$pre_id','$ca','$timestamp',0,0)";
					odbc_exec($db,$query);
				}
				$query="UPDATE prescription SET s_id='$ca' WHERE pre_id='$pre_id' and s_id='$s_id' ";
				odbc_exec($db,$query);
				
				$_SESSION['c']=2;
				header("refresh: 0; url=NextDay_input.php");
			}
		}
		//เช็คว่าโดน cancel ไปหรือยัง (จบ)
		
		header("refresh: 0; url=NextDay_report.php?pre_id=$pre_id"); //ไปหน้าต่อไปถ้าผ่านอันด้านบนมาได้
	}
	else
	{
		$_SESSION['c']=1;
		header("refresh: 0; url=NextDay_input.php");
	}
?>

</body>
</html>