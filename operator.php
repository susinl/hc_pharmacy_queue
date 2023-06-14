<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE>รายชื่อพนักงาน </TITLE>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="w3.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
</HEAD>

<style>
#myDIV {display: none;}
</style>

<BODY>

<?php 
	//connect to database
	require("connection.php");


	error_reporting(0);
	//clear $_GET Error
	if(!isset($_GET['time']))$_GET['time']=3;
	$time=$_GET['time'];
	if(!isset($_POST['cat']))$_POST['cat']='';
	$cat = $_POST['cat'];
	if(!isset($_POST['action']))$_POST['action']='';
	$action = $_POST['action'];
	

	//display header	
	require("header.html");
?>

<script>

//Toggle_table	
function myFunction() {
  var x = document.getElementById("myDIV");
  if (x.style.display === "none") {
    x.style.display = "block";
  } else {
    x.style.display = "none";
  }
} 
</script>




<div class="w3-row-padding w3-container w3-section">
		<div class="w3-container">
			<h1 class="w3-center"> พนักงาน </h1>
		</div>
		<div class="w3-row-padding">
			<div class="w3-container w3-third w3-large w3-margin-right w3-margin-bottom">
				<div class="w3-card-2">
					<div class="w3-container w3-border-bottom">
						<h2>ค้นหา</h2>
					</div>
					<div class="w3-container">
							<FORM class="w3-section" METHOD=POST ACTION='operator.php?time=<?php echo $time?>'>
								<label>ค้นหาด้วย</label>
								<select class="w3-select" name=cat value='1'>
									<option value='1'>รหัสพนักงาน</option>
									<option value='2'>ชื่อ-นามสกุล</option>
								</select>
								<INPUT class="w3-input" TYPE='text' NAME='word'>
								<INPUT TYPE='hidden' name='action' value='search'>
									<div class="w3-margin-top w3-center"><INPUT class="w3-btn-block w3-blue" TYPE='submit' value='Search'></div>
							</FORM>
					</div>
				</div>
				<div class="w3-card-2">
					<div class="w3-container w3-border-bottom w3-section">
						<h2>เพิ่มพนักงาน</h2>
					</div>
					<div class="w3-container">
						<FORM METHOD=POST ACTION='operator_action.php?time=<?php echo $time?>'>
							<INPUT TYPE='hidden' name='action' value='add'>
							<INPUT class="w3-btn-block w3-green" TYPE="submit" value='เพิ่มพนักงานในระบบ'>
						</FORM>
					</div>
				</div>
			</div>
			<div class="w3-rest w3-container w3-card-2">
				<div class="w3-container w3-border-bottom">
					<h2>รายชื่อพนักงาน</h2>
				</div>
				<table class="w3-table w3-margin-bottom">
				<TR>
					<TH>รหัสพนักงาน</TH>
					<TH>ชื่อ-สกุล</TH>
					<TH>งาน</TH>
					<TH>การจ้าง</TH>
					<TH>แก้ไข</TH>
					<TH>ซ่อน</TH>
				</TR>
				<?php 
					//show
					if($_POST['action']=='search'){
						$word=$_POST['word'];
						if($cat==1){
							$se = "o_id";
						}else{
							$se = "o_name";
						}
						$query="SELECT * FROM Operator WHERE $se like'%$word%'";
						$result=odbc_exec($db,$query);
						if(!$list=odbc_fetch_array($result)){
							echo '
								<div class="w3-panel w3-orange">
									<span onclick="this.parentElement.style.display=\'none\'" class="w3-closebtn">&times;</span>
									<h3>ไม่พบพนักงานในระบบ!</h3>
									<p>โปรดลองใหม่อีกครั้งหนึ่ง</p>
								</div>';
						}
						$query="SELECT * FROM Operator WHERE $se like'%$word%' AND hide=0";
						$result=odbc_exec($db,$query);
						while($list=odbc_fetch_array($result)){
							if($list['o_id']!=''){
								$o_id=$list['o_id'];
								$o_name = iconv("TIS-620", "UTF-8", $list['o_name']);
								$o_type=$list['o_type'];
								$parttime=$list['parttime'];
								if($o_type==1)$temp="Picking";
								if($o_type==2)$temp="Decocting";
								if($o_type==3)$temp="Dispensing";
								if($time==$parttime){
									if($parttime==1)$part="Full-Time";
									else $part="Part-Time";
									echo "<TR>
										<TD>$o_id</TD>
										<TD>$o_name</TD>
										<TD>$temp</TD>
										<TD>$part</TD>
										<TD><A HREF='operator_action.php?o_id=$o_id&time=$time'>More+Edit</A>
										<TD><A HREF='operator_hide.php?o_id=$o_id&time=$time'>Hide</A>
									</TR>";
								}
							}
						}
					}else{
						
						$word=$_POST['word'];
						if($cat==1){
							$se = "o_id";
						}else{
							$se = "o_name";
						}
						
						$query="SELECT * FROM Operator ";
						$result=odbc_exec($db,$query);
						if(!$list=odbc_fetch_array($result)){
							echo '
								<div class="w3-panel w3-orange">
									<span onclick="this.parentElement.style.display=\'none\'" class="w3-closebtn">&times;</span>
									<h3>ไม่พบพนักงานในระบบ!</h3>
									<p>โปรดลองใหม่อีกครั้งหนึ่ง</p>
								</div>';
						}
						$query="SELECT * FROM Operator WHERE $se like'%$word%' AND hide=0";
						$result=odbc_exec($db,$query);
						while($list=odbc_fetch_array($result)){
							if($list['o_id']!=''){
								$o_id=$list['o_id'];
								$o_name = iconv("TIS-620", "UTF-8", $list['o_name']);
								$o_type=$list['o_type'];
								$parttime=$list['parttime'];
								if($o_type==1)$temp="Picking";
								if($o_type==2)$temp="Decocting";
								if($o_type==3)$temp="Dispensing";
								if($time==$parttime){
									if($parttime==1)$part="Full-Time";
									else $part="Part-Time";
									echo "<TR>
										<TD>$o_id</TD>
										<TD>$o_name</TD>
										<TD>$temp</TD>
										<TD>$part</TD>";
										$o_name = iconv("TIS-620", "UTF-8", $list['o_name']);
										echo "
										<TD><A HREF='operator_action.php?o_id=$o_id&time=$time'>More+Edit</A>
										<TD><A HREF='operator_hide.php?o_id=$o_id&time=$time'>Hide</A>
									</TR>";
								}
							}
						}
					}
					?>
				</table>
				<div class="w3-center w3-section">
				<button onclick="myFunction()">Show/Hide hidden </button>
				</div>
			 </div>
		</div>
		
		
	</div>
	


<div class="w3-row-padding w3-container w3-section" id="myDIV">
		<div class="w3-container">
			<h1 class="w3-center"> พนักงานที่ซ่อนไว้</h1>
		</div>
		<div class="w3-row-padding">
			<div class="w3-container w3-third w3-large w3-margin-right w3-margin-bottom">
				<div class="w3-card-2">
					<div class="w3-container w3-border-bottom">
						<h2>ค้นหา</h2>
					</div>
					<div class="w3-container">
							<FORM class="w3-section" METHOD=POST ACTION='operator.php?time=<?php echo $time?>'>
								<label>ค้นหาด้วย</label>
								<select class="w3-select" name=cat value='1'>
									<option value='1'>รหัสพนักงาน</option>
									<option value='2'>ชื่อ-นามสกุล</option>
								</select>
								<INPUT class="w3-input" TYPE='text' NAME='word'>
								<INPUT TYPE='hidden' name='action' value='search'>
									<div class="w3-margin-top w3-center"><INPUT class="w3-btn-block w3-blue" TYPE='submit' value='Search'></div>
							</FORM>
					</div>
				</div>
				
			</div>
			<div class="w3-rest w3-container w3-card-2">
				<div class="w3-container w3-border-bottom">
					<h2>รายชื่อพนักงาน</h2>
				</div>
				<table class="w3-table w3-margin-bottom">
				<TR>
					<TH>รหัสพนักงาน</TH>
					<TH>ชื่อ-สกุล</TH>
					<TH>งาน</TH>
					<TH>การจ้าง</TH>
					<TH>แก้ไข</TH>
					<TH>ซ่อน</TH>
				</TR>
				<?php 
					//show
					if($_POST['action']=='search'){
						$word=$_POST['word'];
						if($cat==1){
							$se = "o_id";
						}else{
							$se = "o_name";
						}
						$query="SELECT * FROM Operator WHERE $se like'%$word%'";
						$result=odbc_exec($db,$query);
						if(!$list=odbc_fetch_array($result)){
							echo '
								<div class="w3-panel w3-orange">
									<span onclick="this.parentElement.style.display=\'none\'" class="w3-closebtn">&times;</span>
									<h3>ไม่พบพนักงานในระบบ!</h3>
									<p>โปรดลองใหม่อีกครั้งหนึ่ง</p>
								</div>';
						}
						$query="SELECT * FROM Operator WHERE $se like'%$word%' AND hide=1";
						$result=odbc_exec($db,$query);
						while($list=odbc_fetch_array($result)){
							if($list['o_id']!=''){
								$o_id=$list['o_id'];
								$o_name = iconv("TIS-620", "UTF-8", $list['o_name']);
								$o_type=$list['o_type'];
								$parttime=$list['parttime'];
								if($o_type==1)$temp="Picking";
								if($o_type==2)$temp="Decocting";
								if($o_type==3)$temp="Dispensing";
								if($time==$parttime){
									if($parttime==1)$part="Full-Time";
									else $part="Part-Time";
									echo "<TR>
										<TD>$o_id</TD>
										<TD>$o_name</TD>
										<TD>$temp</TD>
										<TD>$part</TD>
										<TD><A HREF='operator_action.php?o_id=$o_id&time=$time'>More+Edit</A>
										<TD><A HREF='operator_show.php?o_id=$o_id&time=$time'>Show</A>
									</TR>";
								}
							}
						}
					}else{
						
						$word=$_POST['word'];
						if($cat==1){
							$se = "o_id";
						}else{
							$se = "o_name";
						}
						
						$query="SELECT * FROM Operator ";
						$result=odbc_exec($db,$query);
						if(!$list=odbc_fetch_array($result)){
							echo '
								<div class="w3-panel w3-orange">
									<span onclick="this.parentElement.style.display=\'none\'" class="w3-closebtn">&times;</span>
									<h3>ไม่พบพนักงานในระบบ!</h3>
									<p>โปรดลองใหม่อีกครั้งหนึ่ง</p>
								</div>';
						}
						$query="SELECT * FROM Operator WHERE $se like'%$word%' AND hide=1";
						$result=odbc_exec($db,$query);
						while($list=odbc_fetch_array($result)){
							if($list['o_id']!=''){
								$o_id=$list['o_id'];
								$o_name = iconv("TIS-620", "UTF-8", $list['o_name']);
								$o_type=$list['o_type'];
								$parttime=$list['parttime'];
								if($o_type==1)$temp="Picking";
								if($o_type==2)$temp="Decocting";
								if($o_type==3)$temp="Dispensing";
								if($time==$parttime){
									if($parttime==1)$part="Full-Time";
									else $part="Part-Time";
									echo "<TR>
										<TD>$o_id</TD>
										<TD>$o_name</TD>
										<TD>$temp</TD>
										<TD>$part</TD>";
										$o_name = iconv("TIS-620", "UTF-8", $list['o_name']);
										echo "
										<TD><A HREF='operator_action.php?o_id=$o_id&time=$time'>More+Edit</A>
										<TD><A HREF='operator_show.php?o_id=$o_id&time=$time'>Show</A>
									</TR>";
								}
							}
						}
					}
					?>
				</table>
				<div class="w3-center w3-section">
				
				
				</div>
			 </div>
		</div>


</body>
</html>