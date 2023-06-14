<?php
	// in inserted page must provide s_id, t_id	
	// demo input
	//	$t_id = 1;
	$active_s_id = $s_id;
	if($s_id == 103){
		$active_s_id = 12; //ตั้งให้แสดงว่ารอต้มถ้ามาเช็ค
		echo "<h1 class='w3-center w3-blue'>ต้มยาวันอื่น</h1>";
	}
	//Start the bar
	echo "<ol class='progress progress--medium'>";
	//find lenght of the bar
	$query="SELECT s_id, t_id, s_name FROM status WHERE t_id='$t_id' ORDER BY s_id";
	$result=odbc_exec($db,$query);	
	$lenght = 0;
	while($list=odbc_fetch_array($result)){
		$viewing_s_id=$list['s_id'];
		if($viewing_s_id<100){
			$lenght++;
		}
	}
	//Query result from the server again to display the bar
	$query="SELECT s_id, t_id, s_name FROM status WHERE t_id='$t_id' ORDER BY s_id";
	$result=odbc_exec($db,$query);
	//echo progress bar according to $t_id $s_id
	$count = 1;
	while($list=odbc_fetch_array($result)){
		$label_s_id=$list['s_id'];
		$s_name_pb = $list['s_name'];
		$s_name_pb = iconv("tis-620", "utf-8", $s_name_pb);
		$next_id=$list['next_id'];
		if($label_s_id<100){
			if($count<$lenght){
				if($label_s_id<$active_s_id){
				echo 	"<li id='$s_name_pb' class='is-complete' data-step='$count'> $s_name_pb </li>";
				}
				elseif ($label_s_id==$active_s_id) {
					echo "<li id='$s_name_pb' class='is-active' data-step='$count'> $s_name_pb </li>";
				}
				else{
					echo "<li id='$s_name_pb' data-step='$count'> $s_name_pb </li>";
				}
			}
			else{
				if($label_s_id<$active_s_id){
				echo 	"<li id='$s_name_pb' class='is-complete' data-step='$count'> $s_name_pb </li>";
				}
				elseif ($label_s_id==$active_s_id) {
					echo "<li id='$s_name_pb' class='is-active progress__last' data-step='$count'> $s_name_pb </li>";
				}
				else{
					echo "<li id='$s_name_pb' class='progress__last' data-step='$count'> $s_name_pb </li>";
				}
			}
		}	
		$count++;
	}		
	//END the bar
		echo "</ol>";
?>
