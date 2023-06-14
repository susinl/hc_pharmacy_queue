<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Update Report</title>
<link rel="stylesheet" type="text/css" href="w3.css">
<link rel="stylesheet" type="text/css" href="source/progress_bar.css">
<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>

<div id="demo"><?php 
	// error_reporting(E_ERROR | E_PARSE);
	if(!isset($_GET['pre_id']))$_GET['pre_id']='no input';
	$pre_id=$_GET['pre_id'];
	if(!isset($_GET['s_id']))$_GET['s_id']='no input';	
	$s_id=$_GET['s_id'];
	if(!isset($_GET['last_q_start_mill']))$_GET['last_q_start_mill']=0;	
	$last_q_start_mill=$_GET['last_q_start_mill'];

	date_default_timezone_set("Etc/GMT-7");
	$timestamp = date("Y-m-d H:i:s");
	$_SESSION['timestamp']= $timestamp;

	require("connection.php");
	$query="SELECT * FROM prescription WHERE pre_id='$pre_id'";
	$result=odbc_exec($db,$query);
	if($list=odbc_fetch_array($result)){
		$q_id=$list['q_id'];
		$s_id=$list['s_id'];
		$c_id=$list['c_id'];
		$finishtime=$list['finishTime'];
	}
	$query="SELECT * FROM status WHERE s_id='$s_id'";
	$result=odbc_exec($db,$query);
	if($list=odbc_fetch_array($result)){
		$next_id=$list['next_id'];
		$t_id=$list['t_id'];

	}
	$query="SELECT * FROM status WHERE s_id='$next_id'";
	$result=odbc_exec($db,$query);
	if($list=odbc_fetch_array($result)){
		$s_name = iconv("TIS-620", "UTF-8", $list['s_name']);
		// $s_name = $list['s_name'];
	}
	$query="SELECT * FROM queue WHERE q_id='$q_id'";
	$result=odbc_exec($db,$query);
	if($list=odbc_fetch_array($result)){
		$q_name = iconv("TIS-620", "UTF-8", $list['q_name']);
		// $q_name = $list['q_name'];

	}
	$query="SELECT * FROM type WHERE t_id='$t_id'";
	$result=odbc_exec($db,$query);
	if($list=odbc_fetch_array($result)){
		$t_name = iconv("TIS-620", "UTF-8", $list['t_name']);
		// $t_name = $list['t_name'];
	}
	$query2 ="SELECT c_name from get_cusinfo where HN='$c_id' ";
	$result2=odbc_exec($db2,$query2);
	if($list2=odbc_fetch_array($result2)){
		$c_name = iconv("TIS-620", "UTF-8", $list2['c_name']);
		// $c_name = $list2['c_name'];
	}
	//Move refresh to the top 
	?>

	<?php

	$close = false;
	$start_milliseconds = floor(microtime(true) * 1000);
	// echo $start_milliseconds;
	if(($last_q_start_mill > 0) && ($start_milliseconds < $last_q_start_mill + 13000)){
		$delay_needed = 13000 - ($start_milliseconds-$last_q_start_mill);
	}else{
		$delay_needed = 0;
	}
	$auto_refresh = ($delay_needed+17000)/1000;

	if(($s_id == 14 || $s_id == 22 || $s_id ==  31) && $last_q_start_mill > 0 && $start_milliseconds < $last_q_start_mill + 13000){
		header('refresh: '.$auto_refresh.'; url=update_status.php?pre_id='.$pre_id.'&s_id='.$s_id.''.'&checkk=1'.'&close='.$close);
		echo('<audio onloadeddata="var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, '.$delay_needed.')" id="static_buffer" onended="sound_Pre_TH.play()"><source src="Announcing Sound/tv-static-01.mp3" type="audio/mpeg"></audio>');
		echo('<audio id="sound_Pre_TH" onended="sound_TH_1.play()"><source src="Announcing Sound/Pre_TH.mp3" type="audio/mpeg"></audio>');
		echo('<audio id="sound_TH_1" onended="sound_TH_2.play()"><source src="Announcing Sound/Voice_TH_'.$q_name[0].'.mp3" type="audio/mpeg"></audio>');
		echo('<audio id="sound_TH_2" onended="sound_TH_3.play()"><source src="Announcing Sound/Voice_TH_'.$q_name[1].'.mp3" type="audio/mpeg"></audio>');
		echo('<audio id="sound_TH_3" onended="sound_TH_4.play()"><source src="Announcing Sound/Voice_TH_'.$q_name[2].'.mp3" type="audio/mpeg"></audio>');
		echo('<audio id="sound_TH_4" onended="sound_Post_TH.play()"><source src="Announcing Sound/Voice_TH_'.$q_name[3].'.mp3" type="audio/mpeg"></audio>');
		echo('<audio id="sound_Post_TH" onended="sound_Pre_EN.play()"><source src="Announcing Sound/Post_TH.mp3" type="audio/mpeg"></audio>');
		echo('<audio id="sound_Pre_EN" onended="sound_EN_1.play()"><source src="Announcing Sound/Pre_EN.mp3" type="audio/mpeg"></audio>');
		echo('<audio id="sound_EN_1" onended="sound_EN_2.play()"><source src="Announcing Sound/Voice_EN_'.$q_name[0].'.mp3" type="audio/mpeg"></audio>');
		echo('<audio id="sound_EN_2" onended="sound_EN_3.play()"><source src="Announcing Sound/Voice_EN_'.$q_name[1].'.mp3" type="audio/mpeg"></audio>');
		echo('<audio id="sound_EN_3" onended="sound_EN_4.play()"><source src="Announcing Sound/Voice_EN_'.$q_name[2].'.mp3" type="audio/mpeg"></audio>');
		echo('<audio id="sound_EN_4" onended="sound_Post_EN.play()"><source src="Announcing Sound/Voice_EN_'.$q_name[3].'.mp3" type="audio/mpeg"></audio>');
		echo('<audio id="sound_Post_EN"><source src="Announcing Sound/Post_EN.mp3" type="audio/mpeg"></audio>');
	}elseif(($s_id == 14 || $s_id == 22 || $s_id ==  31)){
			header('refresh: '.$auto_refresh.'; url=update_status.php?pre_id='.$pre_id.'&s_id='.$s_id.''.'&checkk=1'.'&close='.$close);
			echo('<audio onloadeddata="var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 0)" id="static_buffer" onended="sound_Pre_TH.play()"><source src="Announcing Sound/tv-static-01.mp3" type="audio/mpeg"></audio>');
			echo('<audio id="sound_Pre_TH" onended="sound_TH_1.play()"><source src="Announcing Sound/Pre_TH.mp3" type="audio/mpeg"></audio>');
			echo('<audio id="sound_TH_1" onended="sound_TH_2.play()"><source src="Announcing Sound/Voice_TH_'.$q_name[0].'.mp3" type="audio/mpeg"></audio>');
			echo('<audio id="sound_TH_2" onended="sound_TH_3.play()"><source src="Announcing Sound/Voice_TH_'.$q_name[1].'.mp3" type="audio/mpeg"></audio>');
			echo('<audio id="sound_TH_3" onended="sound_TH_4.play()"><source src="Announcing Sound/Voice_TH_'.$q_name[2].'.mp3" type="audio/mpeg"></audio>');
			echo('<audio id="sound_TH_4" onended="sound_Post_TH.play()"><source src="Announcing Sound/Voice_TH_'.$q_name[3].'.mp3" type="audio/mpeg"></audio>');
			echo('<audio id="sound_Post_TH" onended="sound_Pre_EN.play()"><source src="Announcing Sound/Post_TH.mp3" type="audio/mpeg"></audio>');
			echo('<audio id="sound_Pre_EN" onended="sound_EN_1.play()"><source src="Announcing Sound/Pre_EN.mp3" type="audio/mpeg"></audio>');
			echo('<audio id="sound_EN_1" onended="sound_EN_2.play()"><source src="Announcing Sound/Voice_EN_'.$q_name[0].'.mp3" type="audio/mpeg"></audio>');
			echo('<audio id="sound_EN_2" onended="sound_EN_3.play()"><source src="Announcing Sound/Voice_EN_'.$q_name[1].'.mp3" type="audio/mpeg"></audio>');
			echo('<audio id="sound_EN_3" onended="sound_EN_4.play()"><source src="Announcing Sound/Voice_EN_'.$q_name[2].'.mp3" type="audio/mpeg"></audio>');	
			echo('<audio id="sound_EN_4" onended="sound_Post_EN.play()"><source src="Announcing Sound/Voice_EN_'.$q_name[3].'.mp3" type="audio/mpeg"></audio>');
			echo('<audio id="sound_Post_EN"><source src="Announcing Sound/Post_EN.mp3" type="audio/mpeg"></audio>');
	}else{
		header('refresh: 13; url=update_status.php?pre_id='.$pre_id.'&s_id='.$s_id.''.'&checkk=1');
	}
	?>


	</div>

	

<?php
	require('header.html');
?>

	<div class="w3-row w3-container w3-card-2 w3-section"  style="width: 90%; margin: auto;">
		<div class="w3-container w3-border-bottom">
			<h1 class="w3-center">ยืนยันการเปลี่ยนสถานะ</h1>
		</div>
		<div class="w3-margin-top">
			<?php
				require('pb/pb_translate.php');
				
				
			?>
		</div>
		<div class="w3-row-padding">
			<div class="w3-twothird w3-container w3-large">
				<div class="w3-container w3-border-bottom">
					<h2>รายละเอียด</h2>
				</div>
				<table class="w3-table w3-margin-bottom">
					<tr>
						<th>รหัสใบยา</th>
						<td><?php echo $pre_id; ?></td>
					</tr>
					<tr>
						<th>ชนิด</th>
						<td><?php echo $t_name; ?></td>
					</tr>
					<tr>
						<th>คิวที่</th>
						<td><?php echo $q_name; ?></td>
					</tr>
					<tr>
						<th>HN</th>
						<td><?php echo $c_id; ?></td>
					</tr>
					<tr>
						<th>คนไข้</th>
						<td><?php echo $c_name; ?></td>
					</tr>
					<tr>
						<th>สถานะ</th>
						<td><?php echo $s_name; ?></td>
					</tr>
				</table>
			</div>
			<div class="w3-third w3-container" style="height: 100%">
				<div class="w3-container">
					<h2 class="w3-text-white">สำเร็จ</h2>
				</div>
				<p><a id="confirm" class="w3-button w3-block w3-green w3-xxlarge" 
				href="update_status.php?pre_id=<?php echo $pre_id; ?>&s_id=<?php echo $s_id; ?>&last_q_start_mill=<?php echo ($start_milliseconds+$delay_needed); ?>&checkk=1" target="_blank" 
					onclick="javascript: setTimeout('window.close()',
						<?php 
							$close = true;
							// $click_milliseconds = floor(microtime(true) * 1000);
							// $delay_close = $delay_needed+(13000-($click_milliseconds-$start_milliseconds)-500);
							// echo ($delay_close);
							// echo (5000); 
						?>
					) ">ยืนยัน</a></p>

				<?php /*
					<p><a id="confirm" class="w3-button w3-block w3-green w3-xxlarge" href="pre_id_input.php?last_q_start_mill=<?php echo ($milliseconds+$delay_needed); ?>" target="_blank" 
						onclick="javascript: setTimeout('window.close()',<?php echo ($delay_needed-100); ?>) ">ยืนยัน</a></p>
				*/ ?>

				<p><a class="w3-button w3-block w3-red w3-xxlarge" href="pre_id_input.php?last_q_start_mill=<?php echo $last_q_start_mill; ?>">ล้มเลิก</a></p>
			</div>
		</div>
	</div> 


	


<script>
// Set the date we're counting down to

	var countDownDate = new Date();
	countDownDate.setSeconds(countDownDate.getSeconds() + 13);

	// Update the count down every 1 second
	var x = setInterval(function() {

	    // Get todays date and time
	    var now = new Date().getTime();
	    
	    // Find the distance between now an the count down date
	    var distance = countDownDate - now;
	    
	    // Time calculations for days, hours, minutes and seconds
	    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
	    
	    // Output the result in an element with id='demo'
	    document.getElementById('confirm').innerHTML = 'ยืนยัน (' + seconds + 's)';
	    
	    // If the count down is over, write some text 
	    if (distance < 0) {
	    	// move to the top
	  //       clearInterval(x);
			// document.getElementById('demo').innerHTML = "<?php 
			// header('refresh: 5; url=update_status.php?pre_id='.$pre_id.'&s_id='.$s_id.''.'&checkk=1'); ?>";
	    }
	}, 1000);

	
	

</script>

</body>



</html>