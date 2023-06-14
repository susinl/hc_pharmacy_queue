<?php 
function find_next_id($s_id,$db) {
 	$query="SELECT * FROM status WHERE s_id='$s_id'";
	$result=odbc_exec($db,$query);
	if($list=odbc_fetch_array($result)){
		$next_id=$list['next_id'];
	}
	return $next_id;
}

function find_duration($pre_id,$s_id, $timemark,$db) {
 	$query="SELECT * FROM psrel WHERE pre_id='$pre_id' and s_id='$s_id' ";
	$result=odbc_exec($db,$query);
	if($list=odbc_fetch_array($result)){
		$ps_time=$list['ps_time'];
	}
	echo $ps_time;
	echo ' ';
	echo $timemark;
	echo ' ';
	$secs = strtotime($timemark) - strtotime($ps_time); 
	$duration = ($secs/60); //use this to calculate (min)
	$dmin = floor($secs/60);
	$dsec = (($secs/60) - floor($secs/60))*60;
	$showduration = "{$dmin}:{$dsec}";
	echo $duration;
	echo ' ';
	echo $showduration;
	return $duration;
	

	//$tbegin = date('H:i:s',strtotime($timemark));
	//$tend = date('H:i:s',strtotime($ps_time));
	//echo $tbegin;
	//echo $tend;

	//$time=datediff($ps_time,$timemark);
	//$duration = $time;
	//return $duration;
}
function find_wip_array() {
	require('connection.php');
	date_default_timezone_set("Etc/GMT-7");
	$d=strtotime("-8 hours");
	$ref=date("Y-m-d H:i:s",$d);
	$nottabu=array();
	$old='';
	$oldt='';
 	$query="SELECT prescription.pre_id,prescription.finishtime,prescription.t_id,queue.* FROM queue,prescription WHERE queue.in_datetime>'$ref' and prescription.c_id=queue.c_id and prescription.q_id=queue.q_id and prescription.s_id <> 15 and prescription.s_id <> 16 and prescription.s_id <> 101 and prescription.s_id <> 23 and prescription.s_id <> 24 and prescription.s_id <> 201  and prescription.s_id <> 32 and prescription.s_id <> 33 and prescription.s_id <> 301 and prescription.s_id <> 40 and prescription.s_id <> 41 and prescription.s_id <> 401 order by q_name
";
	$result=odbc_exec($db,$query);
	while($list=odbc_fetch_array($result)){
		$pre_id=$list['pre_id'];
		$q_id=$list['q_id'];
		$new=$list['q_name'];
		$newt=$list['finishtime'];
		$c_id=$list['c_id'];
		if($old==$new){
			if($oldt<$newt){
				array_shift($nottabu);
				array_unshift($nottabu,$pre_id);
			}
		}else array_unshift($nottabu,$pre_id);
		$old=$new;
		$oldt=$newt;
	}
	return $nottabu;
}
function find_fin_array() {
	require('connection.php');
	date_default_timezone_set("Etc/GMT-7");
	$d=strtotime("-8 hours");
	$ref=date("Y-m-d H:i:s",$d);
	$nottabu=array();
	$old='';
	$oldt='';
 	$query="SELECT prescription.pre_id,prescription.finishtime,prescription.t_id,queue.* FROM queue,prescription WHERE queue.in_datetime>'$ref' and prescription.c_id=queue.c_id and prescription.q_id=queue.q_id and (prescription.s_id = 15 or prescription.s_id = 23 or prescription.s_id = 32 or prescription.s_id = 40)order by q_name
";
	$result=odbc_exec($db,$query);
	while($list=odbc_fetch_array($result)){
		$pre_id=$list['pre_id'];
		$q_id=$list['q_id'];
		$new=$list['q_name'];
		$newt=$list['finishtime'];
		$c_id=$list['c_id'];
		if($old==$new){
			if($oldt<$newt){
				array_shift($nottabu);
				array_unshift($nottabu,$pre_id);
			}
		}else array_unshift($nottabu,$pre_id);
		$old=$new;
		$oldt=$newt;
	}
	return $nottabu;
}

?>