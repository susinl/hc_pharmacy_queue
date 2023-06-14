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
	if(!isset($_GET['pre_id']))$_GET['pre_id']='no input';
	$pre_id=$_GET['pre_id'];
	require("connection.php");
	$query="SELECT prescription.finishTime,status.s_name,status.s_id,queue.q_name,type.t_name,type.t_id  FROM prescription, type, status, queue WHERE prescription.s_id=status.s_id AND queue.q_id = prescription.q_id AND status.t_id=type.t_id AND prescription.pre_id = '$pre_id'";
	$result=odbc_exec($db,$query);
	if($list=odbc_fetch_array($result)){
		$finishtime=$list['finishtime'];
		$t_id=$list['t_id'];
		$s_id=$list['s_id'];
		$s_name=iconv("TIS-620", "UTF-8",$list['s_name']);
		$q_name=iconv("TIS-620", "UTF-8",$list['q_name']);
		$t_name=iconv("TIS-620", "UTF-8",$list['t_name']);
	}
	//$query="SELECT * FROM prescription WHERE pre_id='$pre_id'";
//	$result=odbc_exec($db,$query);
//	if($list=odbc_fetch_array($result)){
//		$q_id=$list['q_id'];
//		$s_id=$list['s_id'];
//		$finishtime=$list['finishtime'];
//	}
//	$query="SELECT * FROM status WHERE s_id='$s_id'";
//	$result=odbc_exec($db,$query);
//	if($list=odbc_fetch_array($result)){
//		$t_id=$list['t_id'];
//
//	}
//	$query="SELECT * FROM status WHERE s_id='$s_id'";
//	$result=odbc_exec($db,$query);
//	if($list=odbc_fetch_array($result)){
//		$s_name = iconv("TIS-620", "UTF-8", $list['s_name']);
//	}
//	$query="SELECT * FROM queue WHERE q_id='$q_id'";
//	$result=odbc_exec($db,$query);
//	if($list=odbc_fetch_array($result)){
//		$q_name = iconv("TIS-620", "UTF-8", $list['q_name']);
//
//	}
//	$query="SELECT * FROM type WHERE t_id='$t_id'";
//	$result=odbc_exec($db,$query);
//	if($list=odbc_fetch_array($result)){
//		$t_name = iconv("TIS-620", "UTF-8", $list['t_name']);
//	}
	//Move refresh to the top
	header('refresh: 5; url=pre_id_input.php'); 
	?>
		
	</div>
<?php
	// prevent dreamweaver error

?>
<?php
	require('header.html');

?>

<div class="w3-row w3-container w3-card-2 w3-section"  style="width: 75%; margin: auto;">
		<div class="w3-container w3-border-bottom">
			<h1 class="w3-center">ยืนยันการเปลี่ยนสถานะ</h1>
		</div>
		<div class="w3-margin-top">
			<?php
				$s_id=$s_id-1;
				require('pb/pb.php');
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
						<th>เวลาเสร็จ</th>
						<td><?php //echo $finishtime; ?> n/a </td>
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
				<p><a id="confirm" class="w3-button w3-block w3-green w3-xxlarge" href="pre_id_input.php">ยืนยัน</a></p>
				<p><a class="w3-button w3-block w3-red w3-xxlarge" href="start_delete.php?pre_id=<?php echo $pre_id?>">ล้มเลิก</a></p>
			 </div>
		</div>

	</div>


<script>
// Set the date we're counting down to

	var countDownDate = new Date();
	countDownDate.setSeconds(countDownDate.getSeconds() + 6);

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