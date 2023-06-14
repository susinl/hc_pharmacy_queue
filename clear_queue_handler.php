<?php 
require("connection.php");
session_start();
if(!isset($_GET['q_id']))$_GET['q_id']='';
$q_id = $_GET['q_id'];
$query = "
            SELECT p.pre_id, p.c_id, p.in_datetime, p.q_id, q.q_name,  p.s_id, s.s_name, s.s_display_thai, s.t_id, t.t_name, p.finishtime
            FROM ieproject.dbo.prescription AS p, ieproject.dbo.type AS t, ieproject.dbo.status AS s, ieproject.dbo.queue AS q
            WHERE p.s_id=s.s_id 
                AND q.q_id = p.q_id 
                AND s.t_id=t.t_id 
                AND q.q_id = '$q_id' ";
$result=odbc_exec($db,$query);
while($list=odbc_fetch_array($result)){

    $pre_id=$list['pre_id'];
    $s_id=iconv("TIS-620", "UTF-8",$list['s_id']);
    $q_name=iconv("TIS-620", "UTF-8",$list['q_name']);
    $t_id=iconv("TIS-620", "UTF-8",$list['t_id']);
    $in_datetime=$list['in_datetime'];

	//Find s_id that represent รับยาแล้ว
	$query2 = "SELECT * FROM status WHERE t_id = '$t_id' AND s_id < 100 ORDER BY s_id DESC";
	$result2 = odbc_exec($db,$query2);
	$list2=odbc_fetch_array($result2);

	//s_id that represent รับยาแล้ว
	$out_id = $list2['s_id'];
	$cancled = array(101,201,301,401);

	if($s_id != $out_id && !in_array($s_id, $cancled)) {
		//set s_id to รับยาแล้ว in prescription
		$query="UPDATE prescription SET s_id='$out_id' WHERE pre_id='$pre_id' ";
		odbc_exec($db,$query);

		//fine time stamp
		date_default_timezone_set("Etc/GMT-7");
		$timestamp = date("Y-m-d H:i:s");

		//update duration
		$query="UPDATE psrel SET duration='$duration' WHERE pre_id='$pre_id' and s_id='$s_id'";
		odbc_exec($db,$query);

		$NoofOper = 0;

		$query ="INSERT INTO psrel (pre_id,s_id,ps_time,duration,numberofOper)  VALUES ('$pre_id','$out_id','$timestamp',0,'$NoofOper');";
		odbc_exec($db,$query);
	}
}

$c_date = date("Y-m-d", strtotime($in_datetime));
// echo $c_date;
header("refresh: 0; url=clear_queue.php?c_date=$c_date&input=$q_name");


?>