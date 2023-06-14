<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>cancel_report</title>
</head>
<!--<link rel="stylesheet" type="text/css" href="style.css">-->
<link rel="stylesheet" type="text/css" href="w3.css">
<meta name="viewport" content="width=device-width, initial-scale=1">

<body>
<div id="demo"></div>
<?php
	// prevent dreamweaver error
if(!isset($_GET['pre_id']))$_GET['pre_id']='no input';
$pre_id=$_GET['pre_id'];


?>
<?php
	require('header.html');
	require("connection.php");
	$query="SELECT * FROM prescription WHERE pre_id='$pre_id'";
	$result=odbc_exec($db,$query);
	if($list=odbc_fetch_array($result)){
		$q_id=$list['q_id'];
		$s_id=$list['s_id'];
		$finishtime=$list['finishtime'];
	}
	$query="SELECT * FROM status WHERE s_id='$s_id'";
	$result=odbc_exec($db,$query);
	if($list=odbc_fetch_array($result)){
		$t_id=$list['t_id'];
		$s_name = iconv("TIS-620", "UTF-8", $list['s_name']);

	}
	$query="SELECT * FROM queue WHERE q_id='$q_id'";
	$result=odbc_exec($db,$query);
	if($list=odbc_fetch_array($result)){
		$q_name=iconv("TIS-620", "UTF-8",$list['q_name']);

	}
	$query="SELECT * FROM type WHERE t_id='$t_id'";
	$result=odbc_exec($db,$query);
	if($list=odbc_fetch_array($result)){
		$t_name=iconv("TIS-620", "UTF-8",$list['t_name']);

	}

?>
<!--
	<div class="heading">
	<h1>รายงานสถานะใบยา</h1>
	</div>
	<div class="main_body">
		<div class="clearfix">
			<div class="column report">
				<table>
				  <tbody>
					<tr>
					  <th scope="row">รหัสใบยา</th>
					  <td></td>
					</tr>
					<tr>
					  <th scope="row">ชนิด</th>
					  <td></td>
					</tr>
					<tr>
					  <th scope="row">คิวที่</th>
					  <td></td>
					</tr>
					<tr>
					  <th scope="row">สถานะ</th>
					  <td></td>
					</tr>
				  </tbody>
				</table>
			</div>
			<div class="column form">
					<form method='get' action='cancel_input.php'>
					<div>
                    <input type='submit' value='Cancel'>
						</div>
				</form>
			</div>
		</div>
	</div>
-->
<div class="w3-row w3-container w3-card-2 w3-section"  style="width: 75%; margin: auto;">
		<div class="w3-container w3-border-bottom">
			<h1 class="w3-center">ยกเลิกใบยา</h1>
		</div>
		<div class="w3-row-padding">
			<div class="w3-twothird w3-container">
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
						<th>สถานะ</th>
						<td><?php echo  $s_name.'>ยกเลิก'; ?></td>
					</tr>
				</table>
			</div>
			<div class="w3-third w3-container">
				<div class="w3-container">
					<h2 class="w3-text-white">สำเร็จ</h2>
				</div>
				<p><a id="confirm" class=" w3-btn w3-block w3-green w3-xxlarge" href="cancel_status.php?pre_id=<?php echo $pre_id; ?>">ยืนยัน</a></p>
				<p><a class=" w3-btn w3-block w3-red w3-xxlarge" href="cancel_input.php" >ล้มเลิก</a></p>
			 </div>
		</div>

	</div>
				
				

<script>
// Set the date we're counting down to

var countDownDate = new Date();
countDownDate.setSeconds(countDownDate.getSeconds() + 7);

// Update the count down every 1 second
var x = setInterval(function() {

    // Get todays date and time
    var now = new Date().getTime();
    
    // Find the distance between now an the count down date
    var distance = countDownDate - now;
    
    // Time calculations for days, hours, minutes and seconds
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
    // Output the result in an element with id='confirm'
    document.getElementById('confirm').innerHTML = 'ยืนยัน (' + seconds + 's)';
    
    // If the count down is over, write some text 
    if (distance < 0) {
        clearInterval(x);
		document.getElementById('demo').innerHTML = "<?php header('refresh: 7; url=cancel_status.php?pre_id='.$pre_id); ?>";
    }
}, 1000);
</script>



</body>



</html>