<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>input_operator_2</title>
<link rel="stylesheet" type="text/css" href="w3.css">
<link rel="stylesheet" type="text/css" href="source/progress_bar.css">
<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="jquery-3.1.1.js"></script>
</head>

<body>
	<!-- input from pre_id_input_handler -->
		<?php
			// prevent dreamweaver error
			if(!isset($_GET['pre_id']))$_GET['pre_id']='no input';
			$pre_id=$_GET['pre_id'];
			if(!isset($_GET['s_id']))$_GET['s_id']='no input';
			$s_id=$_GET['s_id'];

			require('header.html');
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
				$s_name = iconv("TIS-620", "UTF-8", $list['s_name']);
				$t_id=$list['t_id'];

			}
			$query="SELECT * FROM queue WHERE q_id='$q_id'";
			$result=odbc_exec($db,$query);
			if($list=odbc_fetch_array($result)){
				$q_name = iconv("TIS-620", "UTF-8", $list['q_name']);

			}
			$query="SELECT * FROM type WHERE t_id='$t_id'";
			$result=odbc_exec($db,$query);
			if($list=odbc_fetch_array($result)){
				$t_name = iconv("TIS-620", "UTF-8", $list['t_name']);
			}
			$query2 ="SELECT c_name from get_cusinfo where HN='$c_id' ";
			$result2=odbc_exec($db2,$query2);
			if($list2=odbc_fetch_array($result2)){
				$c_name = iconv("TIS-620", "UTF-8", $list2['c_name']);
			}
		?>

		<div class="w3-container w3-card-2 w3-section"  style="width: 90%; margin: auto;">
			<div class="w3-border-bottom">
				<a class="w3-btn w3-left w3-white w3-xlarge" href="pre_id_input.php"> &laquo; กลับ</a>
				<h1 class="w3-center"><i class="fa fa-barcode" aria-hidden="true"></i>&nbsp;เปลี่ยนสถานะใบยา</h1>
			</div>
			<?php
				// error warning
				session_start();
				if(!isset($_SESSION['c']))$_SESSION['c']='';
				if($_SESSION['c']==2){
					echo '<div class="w3-panel w3-red">
					<span onclick="this.parentElement.style.display=\'none\' class="w3-closebtn">&times;</span>
					<h3>รหัสซ้ำกัน!</h3><p>โปรดกรอกรหัสใหม่อีกครั้ง</p></div>';
				}
				if($_SESSION['c']==1){
					echo '<div class="w3-panel w3-red">
					<span onclick="this.parentElement.style.display=\'none\'" class="w3-closebtn">&times;</span>
					<h3>รหัสผิดพลาด!</h3><p>โปรดตรวจสอบรหัสพนักงานที่กรอกอีกครั้ง</p></div>';
				}
				$_SESSION['c']=0;
			?>
			<div class="w3-row-padding-">
				<div class="w3-section w3-container">
					<?php
						require('pb/pb_translate.php');
					?>
				</div>
				<div class="w3-third w3-container">
					<div class="w3-container w3-border-bottom">
						<h2>รายละเอียด</h2>
					</div>
					<table class="w3-table w3-margin-bottom">
						<tr>
							<th>รหัสใบยา</th>
							<td><?php echo $pre_id; ?></td>
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
							<th>ชนิด</th>
							<td><?php 
								echo $t_name; ?></td>
						</tr>
					  	<tr>
							<th>คิวที่</th>
							<td><?php echo $q_name; ?></td>
						</tr>
						<th>สถานะ</th>
							<td><?php echo $s_name; ?></td>
						</tr>
					</table>
					
				</div>
			
				<div class="w3-third w3-container">
					<div class="w3-container w3-border-bottom">
						<h2>พนักงานที่ทำงาน</h2>
					</div>
					<form class="w3-container w3-section" method="get" action="input_operator_check_2.php">
				
						รหัสพนักงาน 1: <input class="w3-input w3-large" type="text"  onkeyup="this.value = this.value.toUpperCase();" name="o_id1" placeholder="Scan the barcode" id="o_id1" required><br>
						รหัสพนักงาน 2: <input class="w3-input w3-large" type="text"  onkeyup="this.value = this.value.toUpperCase();" name="o_id2" placeholder="Scan the barcode" ><br>
							<p><a class="w3-btn-block w3-xlarge w3-light-grey" href="input_operator.php?pre_id=<?php echo $pre_id; ?>&s_id=<?php echo $s_id; ?>&checkk=1""> ทำ 1 คน </a></p>       
						   <INPUT TYPE="hidden" name="pre_id" value=<?php echo $pre_id; ?>>
						   <INPUT TYPE="hidden" name="s_id" value=<?php echo $s_id; ?>>
						
				</div>
				<div class="w3-third w3-container">
							<p><input class="w3-button w3-block w3-green w3-xxlarge" type="submit" ></a></p>
							<p><input class="w3-button w3-block w3-red w3-xxlarge" type="reset" ></a></p>
				</div>
					</form>
			</div>
		</div>

</body>

<script>
	//focus the first input
  	document.getElementById('o_id1').focus();
	
	//change to next input after press enter
	jQuery.extend(jQuery.expr[':'], {
		focusable: function (el, index, selector) {
			return $(el).is('a, button, :input, [tabindex]');
		}
	});

	$(document).on('keypress', 'input,select', function (e) {
		if (e.which == 13) {
			e.preventDefault();
			// Get all focusable elements on the page
			var $canfocus = $(':focusable');
			var index = $canfocus.index(this) + 1;
			if (index >= $canfocus.length) index = 0;
			$canfocus.eq(index).focus();
		}
	});
</script>

</html>