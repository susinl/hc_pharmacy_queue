<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE> New Document </TITLE>
<META NAME="Generator" CONTENT="EditPlus">
<META NAME="Author" CONTENT="">
<META NAME="Keywords" CONTENT="">
<META NAME="Description" CONTENT="">
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="w3.css">
<link rel="stylesheet" type="text/css" href="source/progress_bar.css">
<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script>
function che(pre_id){
	var test = confirm("คุณกำลังไปหน้าเช็คสถานะใบยาของใบยาหมายเลข"+pre_id);
	if(test){
		window.open('check_report.php?pre_id='+pre_id,'_self');
		}
	}
</script>
</HEAD>
<BODY>
<?php 
	 require('header.html');	 
?>
<div class="w3-row-padding w3-section w3-container">

			<div class="w3-row w3-border-bottom">
				<div class="w3-third">
					<a class="w3-btn w3-white w3-xlarge" href="manager_page.php"> &laquo; กลับ</a>
				</div>
				<div class="w3-third w3-center w3-center w3-xxlarge">
					<i class="fa fa-clone" aria-hidden="true"></i>&nbsp;ใบยาในระบบ
				</div>
				<div class="w3-third">
				</div>
			</div>
			<div class="w3-quarter w3-container w3-margin-bottom w3-section w3-card-2">
				<h2 class="w3-center">ใบยาในระบบ</h2>
				<table class="w3-table-all w3-large w3-margin-bottom">
					<!--//<caption>ใบยาในระบบ</caption>-->

					<TR>
						<TH>สถานะ</TH>
						<TH>จำนวนใบยา</TH>
					</TR>
				<?php 
					require("connection.php");
					$total=0;
					//$d=strtotime("-8 hours");
					//$ref=date("Y-m-d H:i:s",$d);
					date_default_timezone_set("Etc/GMT-7");
					if(!isset($_GET['c_date'])) $_GET['c_date']= date("Y-m-d");
        			$c_date=$_GET['c_date'];

					$query ="SELECT * from status ";
					$result=odbc_exec($db,$query);
					while($list=odbc_fetch_array($result)){
						$temps=$list['s_id'];
						$s_name = iconv("TIS-620", "UTF-8", $list['s_name']);
						// $s_name = $list['s_name'];
						$temps2='1';
						$temps3='1';
						$temps4='1';
						if($temps<16&&$temps>9||$temps==102||$temps==30||$temps==31||$temps==103){ //103 คือจัดยาวันอื่นเ เพิ่งเพิ่มมานะ
							if($temps==10){
								$temps2=20;
							}
							if($temps==11){
								$temps2=21;
							}
							if($temps==14){
								$temps2=22;
							}
							if($temps==15){
								$temps2=23;
								$temps3=32;
								$temps4=40;
							}
							if($temps==102){
								$temps2=202;
								$temps3=302;
								$temps4=402;
							}


							$query2 = "SELECT count(s_id) AS count 
									FROM prescription 
									where (s_id=$temps 
										or s_id=$temps2 
										or s_id=$temps3 
										or s_id=$temps4) 
										AND in_datetime > '$c_date'
                						AND in_datetime <= dateadd(day, 1, '$c_date')";
							$result2=odbc_exec($db,$query2);
							if($list=odbc_fetch_array($result2)){
								$count=$list['count'];
								$total=$total+$count;
							}
							if($temps==14)$s_name='รอหยิบยาสำเร็จรูป';
							if($temps==30)$s_name='รอหยิบยาKeli';
							if($temps==31)$s_name='จัดยาKeli';						 
							echo "<TR>
								  <TD>$s_name</TD>
								  <TD>$count</TD>
							  </TR>";
						}
					}
					echo "<TR>
							<TD>รวม</TD>
							<TD>$total</TD>
						</TR>";

					if(!isset($_GET['s_id']))$_GET['s_id']=1000;
					$s_id=$_GET['s_id'];
				?>
				</table>	
			</div>	
				
			<div class="w3-container w3-rest w3-margin-bottom">
				<div class="w3-container w3-center w3-card-2 w3-section">	
					<form method=get name=f1 action='prescription.php'>	
						<h2><i class="fa fa-search" aria-hidden="true"></i> &nbsp;เลือกสถานะ</h2>
						<select class="w3-select w3-border w3-large" style="max-width: 400px;" name=s_id value=''>
						<option value='1000'>ทั้งหมด</option> 
							<?php 

						//ทำ drop down
						$query = " SELECT *  from status " ;
						$result=odbc_exec($db,$query);
						while($list=odbc_fetch_array($result))
						{	
							$temp = iconv("TIS-620", "UTF-8", $list['s_id']);
							$tempn = iconv("TIS-620", "UTF-8", $list['s_name']);
							if($temp==14)$tempn='รอหยิบยาสำเร็จรูป';	
							if($temp==30)$tempn='รอหยิบยาKeli';
							if($temp==31)$tempn='จัดยาKeli';
							//ตั้งแต่ 10 - 16 เอามาแสดง	
							if($temp<17&&$temp>9||$temp==101||$temp==102||$temp==30||$temp==31||$temp==103){
								echo "<option value='$temp'>$tempn</option>";
							}
						}
						?>
						</select>
						<input class="w3-input w3-large w3-border w3-margin-top w3-margin-bottom" type="date" name="c_date" required value=<?php echo date("Y-m-d"); ?> style="margin: auto; max-width: 400px;" >
						<input class="w3-btn w3-blue" type="submit" value="ตกลง">
					</form>
				</div>
				<div class="w3-container w3-card-2 w3-margin-bottom">
					<div class="w3-container">
						<h2>รายละเอียดของแต่ละใบยา</h2>
					</div>
					<table class="w3-table-all w3-margin-bottom">
						<TR>
								<Th>เวลา</Th>
								<Th>ใบยา</Th>
								<Th>คิว</Th>
								<Th>สถานะ</Th>
								<Th>HN</Th>
								<Th>คนไข้</Th>
								<Th>เริ่ม</TD>
								<!-- <Th>Operator ID</Th> -->
								<Th>พนักงาน</Th>
								<!-- <Th>Check</Th> -->
						</TR>	
							<?php
							if($s_id==1000){
								$query ="SELECT * 
										from Prescription 
										where s_id!=16 
											and s_id!=24 
											and s_id!=33 
											and s_id!=41 
											and s_id!=101 
											and s_id!=201 
											and s_id!=301 
											and s_id!=401 
											AND in_datetime > '$c_date'
                							AND in_datetime <= dateadd(day, 1, '$c_date')
										ORDER BY in_datetime ASC";
								$result=odbc_exec($db,$query);
								if(!$list=odbc_fetch_array($result)){
									echo '			
									<div class="w3-panel w3-orange">
									<span onclick="this.parentElement.style.display=\'none\'" class="w3-closebtn">&times;</span>
									<h3>ไม่พบใบยาในระบบ!</h3>
									<p>โปรดลองใหม่อีกครั้งหนึ่ง</p>
									</div>';
								}
								$result=odbc_exec($db,$query);
								while($list=odbc_fetch_array($result)){
									$pre_id=$list['pre_id'];
									$date=$list['in_datetime'];
									$temps=$list['s_id'];
									$q_id=$list['q_id'];
									$c_id=$list['c_id'];
									$query2 ="SELECT * from status where s_id=$temps  ";
									$result2=odbc_exec($db,$query2);
									if($list2=odbc_fetch_array($result2)){
										$t_id=$list2['t_id'];
										$s_name = iconv("TIS-620", "UTF-8", $list2['s_name']);
										// $s_name = $list2['s_name'];
									}		
									$query2 ="SELECT * from type where t_id=$t_id ";
									$result2=odbc_exec($db,$query2);
									if($list2=odbc_fetch_array($result2)){
										$t_name = iconv("TIS-620", "UTF-8", $list2['t_name']);
										// $t_name = $list2['t_name'];
									}
									$query2 ="SELECT * from queue where q_id=$q_id ";
									$result2=odbc_exec($db,$query2);
									if($list2=odbc_fetch_array($result2)){
										$q_name = iconv("TIS-620", "UTF-8", $list2['q_name']);
										// $q_name = $list2['q_name'];
									}
									$query2 ="SELECT c_name from get_cusinfo where HN='$c_id'";
									$result2=odbc_exec($db2,$query2);
									if($list2=odbc_fetch_array($result2)){
										$c_name = iconv("TIS-620", "UTF-8", $list2['c_name']);
										// $c_name = $list2['c_name'];
									}
									$query2 ="SELECT * from oprel where pre_id=$pre_id and s_id=$temps";
									$result2=odbc_exec($db,$query2);
									if($list2=odbc_fetch_array($result2)){
										$o_id=$list2['o_id'];
										$op_time=$list2['op_time'];
										$query2 ="SELECT * from operator where o_id='$o_id' ";
									  	$result2=odbc_exec($db,$query2);
									 	if($list2=odbc_fetch_array($result2)){
											$o_name = iconv("TIS-620", "UTF-8", $list2['o_name']);
											// $o_name = $list2['o_name'];
										}
										echo "<TR>
											<TD>".date("H:i", strtotime($date))."</TD>
											<TD><a  href='check_report.php?pre_id=$pre_id'>$pre_id</a></TD>
											<TD>$q_name</TD>
											<TD>$s_name</TD>
											<TD>$c_id</TD>
											<TD>$c_name</TD>
											<TD>".date("H:i", strtotime($op_time))."</TD>
											<TD>$o_name</TD>
										</TR>";
									}
									else echo "<TR>
										<TD>".date("H:i", strtotime($date))."</TD>
										<TD><a href='check_report.php?pre_id=$pre_id'>$pre_id</a></TD>
										<TD>$q_name</TD>
										<TD>$s_name</TD>
										<TD>$c_id</TD>
										<TD>$c_name</TD>
										<TD>-</TD>
										<TD>-</TD>
									</TR>";
									  $op_time='';
									  $o_id='';
									  $o_name='';
									  $c_name='';
									  $q_name='';
									  $t_name='';
								}
							}else{
								$temps2='1';
								$temps3='1';
								$temps4='1';
								if($s_id==10){
									$temps2=20;
								}
								if($s_id==11){
									$temps2=21;
								}
								if($s_id==14){
									$temps2=22;
								}
								if($s_id==15){
									$temps2=23;
									$temps3=32;
									$temps4=40;
								}
								if($s_id==16){
									$temps2=24;
									$temps3=33;
									$temps4=41;
								}
								if($s_id==101){
									$temps2=201;
									$temps3=301;
									$temps4=401;
								}
								if($s_id==102){
									$temps2=202;
									$temps3=302;
									$temps4=402;
								}
								$query ="SELECT * from Prescription 
										where (s_id=$s_id or s_id=$temps2 
										or s_id=$temps3 
										or s_id=$temps4) 
										AND in_datetime > '$c_date'
                						AND in_datetime <= dateadd(day, 1, '$c_date')
										ORDER BY in_datetime ASC ";
								$result=odbc_exec($db,$query);
								if(!$list=odbc_fetch_array($result)){
									echo '		
									<div class="w3-panel w3-orange">
									<span onclick="this.parentElement.style.display=\'none\'" class="w3-closebtn">&times;</span>
									<h3>ไม่พบใบยาในระบบ!</h3>
									<p>โปรดลองใหม่อีกครั้งหนึ่ง</p>
									</div>';
								}
								$result=odbc_exec($db,$query);
								while($list=odbc_fetch_array($result)){
									$pre_id=$list['pre_id'];
									$temps=$list['s_id'];
									$date=$list['in_datetime'];
									$q_id=$list['q_id'];
									$c_id=$list['c_id'];
									$query2 ="SELECT * from status where s_id=$temps ";
									$result2=odbc_exec($db,$query2);
									if($list=odbc_fetch_array($result2)){
										$t_id=$list['t_id'];
										$s_name = iconv("TIS-620", "UTF-8", $list['s_name']);
									}		
									$query2 ="SELECT * from type where t_id=$t_id ";
									$result2=odbc_exec($db,$query2);
									if($list=odbc_fetch_array($result2)){
										$t_name = iconv("TIS-620", "UTF-8", $list['t_name']);
									}
									$query2 ="SELECT * from queue where q_id=$q_id ";
									$result2=odbc_exec($db,$query2);
									if($list=odbc_fetch_array($result2)){
										$q_name = iconv("TIS-620", "UTF-8", $list['q_name']);
									}
									$query2 ="SELECT c_name from get_cusinfo where HN='$c_id'";
									$result2=odbc_exec($db2,$query2);
									if($list2=odbc_fetch_array($result2)){
										$c_name = iconv("TIS-620", "UTF-8", $list2['c_name']);
									}
									$query2 ="SELECT * from oprel where pre_id=$pre_id and s_id=$temps ";
									$result2=odbc_exec($db,$query2);
									if($list=odbc_fetch_array($result2)){
										$o_id=$list['o_id'];
										$op_time=$list['op_time'];
									  	$query2 ="SELECT * from operator where o_id='$o_id '";
									  	$result2=odbc_exec($db,$query2);
									  	if($list=odbc_fetch_array($result2)){
											$o_name = iconv("TIS-620", "UTF-8", $list['o_name']);
									  	}
										echo "<TR>
											<TD>".date("H:i", strtotime($date))."</TD>
											<TD><a href='check_report.php?pre_id=$pre_id'>$pre_id</a></TD>
											<TD>$q_name</TD>
											<TD>$s_name</TD>
											<TD>$c_id</TD>
											<TD>$c_name</TD>
											<TD>".date("H:i", strtotime($op_time))."</TD>
											<TD>$o_name</TD>
										</TR>";
									}
									else echo "<TR>
										<TD>".date("H:i", strtotime($date))."</TD>
										<TD><a href='check_report.php?pre_id=$pre_id'>$pre_id</a></TD>
										<TD>$q_name</TD>
										<TD>$s_name</TD>
										<TD>$c_id</TD>
										<TD>$c_name</TD>
										<TD>-</TD>
										<TD>-</TD>
									</TR>";
									  $op_time='';
									  $o_id='';
									  $o_name='';
									  $c_name='';
									  $q_name='';
									  $t_name='';
								}
							}

							?> 
					</table>
				</div>

			</div>
	</div>




</BODY>
</HTML>
