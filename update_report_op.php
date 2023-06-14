<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Update Report with operator</title>
<link rel="stylesheet" type="text/css" href="w3.css">
<link rel="stylesheet" type="text/css" href="source/progress_bar.css">
<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
<div id="demo">
	<?php 
		header('refresh: 5; url=pre_id_input.php');
		if(!isset($_GET['pre_id']))$_GET['pre_id']='no input';
		$pre_id=$_GET['pre_id'];
		if(!isset($_GET['s_id']))$_GET['s_id']='no input';
		$s_id=$_GET['s_id'];
		if(!isset($_GET['o_id1']))$_GET['o_id1']='';
		$o_id1=$_GET['o_id1'];
		if(!isset($_GET['o_id2']))$_GET['o_id2']='';
		$o_id2=$_GET['o_id2'];

		require("connection.php");

		$query="SELECT * FROM prescription WHERE pre_id='$pre_id'";
		$result=odbc_exec($db,$query);
		if($list=odbc_fetch_array($result)){
			$q_id=$list['q_id'];
			$s_id=$list['s_id'];
			$c_id=$list['c_id'];
			$finishtime=$list['finishtime'];
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
			  $s_name=$list['s_name'];
			  $s_name = iconv("tis-620", "utf-8", $s_name);
		  }
		$query="SELECT * FROM queue WHERE q_id='$q_id'";
		$result=odbc_exec($db,$query);
		if($list=odbc_fetch_array($result)){
			$q_name=$list['q_name'];
			$q_name = iconv("tis-620", "utf-8", $q_name);

		}
		$query="SELECT * FROM type WHERE t_id='$t_id'";
		$result=odbc_exec($db,$query);
		if($list=odbc_fetch_array($result)){
			$t_name=$list['t_name'];
			$t_name = iconv("tis-620", "utf-8", $t_name);
		}

		$query="SELECT * FROM operator WHERE o_id='$o_id1'";
		$result=odbc_exec($db,$query);
		if($list=odbc_fetch_array($result)){
			$o_name1=$list['o_name'];
			$o_name1 = iconv("tis-620", "utf-8", $o_name1);
		}

		$o_name2='-';
		if($o_id2!='') {
			$query="SELECT * FROM operator WHERE o_id='$o_id2'";
			$result=odbc_exec($db,$query);
			if($list=odbc_fetch_array($result)){
				$o_name2=$list['o_name'];
				$o_name2 = iconv("tis-620", "utf-8", $o_name2);
			} 
		}
		$query2 ="SELECT c_name from get_cusinfo where HN='$c_id' ";
		$result2=odbc_exec($db2,$query2);
		if($list2=odbc_fetch_array($result2)){
			$c_name = iconv("TIS-620", "UTF-8", $list2['c_name']);
		}
		
		//refresh
		header('refresh: 5; url=input_operator_handler.php?pre_id='.$pre_id.'&s_id='.$s_id.'&o_id1='.$o_id1.'&o_id2='.$o_id2);
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
						<?php require('pb/pb_translate.php'); ?>
					</div>
					<div class="w3-row-padding">
						<div class="w3-twothird w3-container w3-large">
							<div class="w3-container w3-border-bottom">
								<h2>รายละเอียด</h2>
							</div>
							<table class="w3-table w3-margin-bottom">
								<tr class="w3-blue">
									<th>พนักงาน 1</th>
									<td><?php echo $o_name1; ?></td>
								</tr>
								<?php
									if($o_name2 != '-'){
										echo "
										<tr class='w3-blue'>
										<th>พนักงาน 2</th>
											<td> $o_name2 </td>
										</tr>";
									}
								?>
								<tr>
								<th>HN</th>
									<td><?php echo $c_id; ?></td>
								</tr>
								<th>คนไข้</th>
									<td><?php echo $c_name; ?></td>
								</tr>
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
									<th>สถานะ</th>
									<td><?php echo $s_name; ?></td>
								</tr>
								
								<tr>
								<th>การรับยา</th>
								<td><?php 
								error_reporting(0);
								
								$today=date('y-m-d');
								$query2="SELECT *
										FROM vDl
										WHERE DocDate>'$today'
										AND HN1='$c_id'
										OR HN2='$c_id'
										OR HN3='$c_id'
										OR HN4='$c_id'
										OR HN5='$c_id'";
								$result2=odbc_exec($db2,$query2);
						
								if($list2=odbc_fetch_array($result2)){
												echo '<i style="color:red;font-size:30px;font-family:calibri ;"> Delivery </i> ';
												}
								else{echo '<i style="color:blue;font-size:30px;font-family:calibri ;"> Self-Pickup </i> ';} ?></td>
							</tr>

							</table>
						</div>
						<div class="w3-third w3-container" style="height: 100%">
							<div class="w3-container">
								<h2 class="w3-text-white">สำเร็จ</h2>
							</div>
							<p><a id="confirm" class="w3-button w3-block w3-green w3-xxlarge" 
             					href="input_operator_handler.php?pre_id=<?php echo $pre_id;?>&s_id=<?php echo $s_id;?>&o_id1=
								<?php echo $o_id1;?>&o_id2=<?php echo $o_id2;?>&checkk=1" >ยืนยัน</a></p>
							<p><a class="w3-button w3-block w3-red w3-xxlarge" href="pre_id_input.php">ล้มเลิก</a></p>
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

		// Time calculations for days, hours, minutes and second
		var seconds = Math.floor((distance % (1000 * 60)) / 1000);

		// Output the result in an element with id='demo'
		document.getElementById('confirm').innerHTML = 'ยืนยัน (' + seconds + 's)';

		// If the count down is over, write some text 
		if (distance < 0) {
		    clearInterval(x);
			//document.getElementById('demo').innerHTML = "<?php //header('refresh: 5; url=huachiewtcm.dyndns.org:84/pharmacy_queue/input_operator_handler.php?pre_id='.$pre_id.'&s_id='.$s_id.'&o_id1='.$o_id1.'&o_id2='.$o_id2); ?>";
		}
		}, 1000);
</script>


</body>



</html>