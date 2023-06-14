<?php
	// in inserted page must provide s_id, t_id	
	// demo input
	//	$t_id = 1;
	//เรียกตัวแปลภาษา
	require "source/translate.php";
	$org_t_id = $t_id;

	$a = array(101, 201, 301, 401);
	// if was cancelled
	if (in_array($s_id, $a)) {
	    echo "<h1 class='w3-center w3-red'>ใบยาถูกยกเลิกแล้ว</h1>";
	}
	 
	else{
		if($NextDay==1) {
			echo "<h1 class='w3-center w3-blue'>ต้มยาวันอื่น</h1>";
		}
		//Start bar
		echo "<ol class='progress progress--large'>";
		$active_s_id = $s_id + 1;//increase the s_id to display properly
		if($NextDay==1){
			$active_s_id = 12; //ตั้งให้แสดงว่าเป้นรอต้ม
		}
		if($s_id == 103){
			$active_s_id = 13; //ตั้งให้แสดงว่าต้ม ถ้าเป็นต้มวันอื่นมา
		}
		if($s_id == 211){
			$active_s_id = 14; //211 คือยาจัดที่กำลังต้มอยู่ ดังนั้นถ้าจะมาเปลี่ยนสถานะก็จะกลายเป็นต้มเสร็จ
			$t_id = 1;
		}
		if($s_id == 212){
			$active_s_id = 15; //212 ยาจัดที่เอาไปต้มเสร็จแล้ว ถ้าเปลี่ยนสถานะก็คือพร้อมจ่าย
			$t_id = 1;
		}

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
			$s_name_pb_chinese = add_chinese($s_name_pb);

			$next_id=$list['next_id'];
			if($label_s_id<100){
				if($count<$lenght){
					if($label_s_id<$active_s_id){
					echo 	"<li id='$s_name_pb' class='is-complete' data-step='$count'> $s_name_pb_chinese </li>";
					}
					elseif ($label_s_id==$active_s_id) {
						echo "<li id='$s_name_pb' class='is-active' data-step='$count'> $s_name_pb_chinese </li>";
					}
					else{
						echo "<li id='$s_name_pb' data-step='$count'> $s_name_pb_chinese </li>";
					}
				}
				else{
					if($label_s_id<$active_s_id){
					echo 	"<li id='$s_name_pb' class='is-complete' data-step='$count'> $s_name_pb_chinese </li>";
					}
					elseif ($label_s_id==$active_s_id) {
						echo "<li id='$s_name_pb' class='is-active progress__last' data-step='$count'> $s_name_pb_chinese </li>";
					}
					else{
						if($out == 1) {
							echo "<li id='$s_name_pb' class='is-active progress__last' data-step='$count'> $s_name_pb_chinese </li>";
						}
						else {
							echo "<li id='$s_name_pb' class='progress__last' data-step='$count'> $s_name_pb_chinese </li>";
						}
					}
				}
			}	
			$count++;
		}
		echo "</ol>";		
	}

	$t_id = $org_t_id; //Change t_id back to original (for the case of เอายาจัดมาต้ม)
?>