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
     require("connection.php");
?>
<div class="w3-row-padding w3-section w3-container">

			<div class="w3-row w3-border-bottom">
				<div class="w3-third">
					<a class="w3-btn w3-white w3-xlarge" href="manager_page.php"> &laquo; กลับ</a>
				</div>
				<div class="w3-third w3-center w3-center w3-xxlarge">
					<i class="fa fa-caret-square-o-right" aria-hidden="true"></i>&nbsp;ใบยาต้มวันอื่น
				</div>
				<div class="w3-third">
				</div>
			</div>
				
			<div class="w3-container w3-rest w3-margin-bottom">
				
				<div class="w3-container w3-card-2 w3-margin-bottom">
					<div class="w3-container">
						<h2>รายละเอียดของแต่ละใบยา</h2>
					</div>
					<table class="w3-table-all w3-margin-bottom">
						<TR>
								<Th>เวลา</Th>
								<Th>ใบยา</Th>
								<Th>คิว</Th>
								<Th>เสร็จเวลา</Th>
								<Th>สถานะ</Th>
								<Th>HN</Th>
								<Th>คนไข้</Th> 
								<Th>วันที่ต้ม</Th>
								<Th>เริ่ม</TD>
								<!-- <Th>Operator ID</Th> -->
								<Th>พนักงาน</Th>
								<!-- <Th>Check</Th> -->
								<Th>เบอร์โทร</Th>
						</TR>	
                            <?php
                            require("connection.php");
                            $total=0;
                            //$d=strtotime("-8 hours");
                            //$ref=date("Y-m-d H:i:s",$d);
                            date_default_timezone_set("Etc/GMT-7");
                            if(!isset($_GET['c_date'])) $_GET['c_date']= date("Y-m-d");
                            $c_date=$_GET['c_date'];
							if(true){
								$query ="SELECT p.in_datetime, p.pre_id, p.s_id, p.q_id, p.c_id, max(ps.ps_time) as ps_time, q.q_name
										from Prescription p
										left join queue q on p.q_id = q.q_id
										left join psrel ps on (ps.s_id = 15 or ps.s_id = 23 or ps.s_id = 32 or ps.s_id = 40) and p.pre_id = ps.pre_id
										where p.in_datetime > '$c_date'
                							AND p.in_datetime <= dateadd(day, 1, '$c_date')
										GROUP BY p.in_datetime, p.pre_id, p.s_id, p.q_id, p.c_id, q.q_name
										ORDER BY q.q_name ASC";
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
                                    $ready_time=$list['ps_time'];


                                    $query3="SELECT * FROM get_preinfo WHERE pre_id='$pre_id'"; // AND date>'$ref' ไม่ต้องใส่ก็ได้
                                    $result3=odbc_exec($db2,$query3);
                                    if($list3=odbc_fetch_array($result3)){
                                        $boil_date = $list3['BoilDate'];
                                        // $boil_date = iconv("TIS-620", "UTF-8", $list3['BoilDate']);
                                        // Check if BoilDate is not null
                                        if (!is_null($boil_date)) {
                                            $boil_date = date('Y-m-d', strtotime($list3['BoilDate']));
                                            $query2 ="SELECT * from status where s_id=$temps  ";
                                            $result2=odbc_exec($db,$query2);
                                            if($list2=odbc_fetch_array($result2)){
                                                $t_id=$list2['t_id'];
                                                $s_name = iconv("TIS-620", "UTF-8", $list2['s_name']);
                                            }		
                                            $query2 ="SELECT * from type where t_id=$t_id ";
                                            $result2=odbc_exec($db,$query2);
                                            if($list2=odbc_fetch_array($result2)){
                                                $t_name = iconv("TIS-620", "UTF-8", $list2['t_name']);
                                            }
                                            $query2 ="SELECT * from queue where q_id=$q_id ";
                                            $result2=odbc_exec($db,$query2);
                                            if($list2=odbc_fetch_array($result2)){
                                                $q_name = iconv("TIS-620", "UTF-8", $list2['q_name']);
                                            }
                                            $query2 ="SELECT c_name from get_cusinfo where HN='$c_id'";
                                            $result2=odbc_exec($db2,$query2);
                                            if($list2=odbc_fetch_array($result2)){
                                                $c_name = iconv("TIS-620", "UTF-8", $list2['c_name']);
                                            }
                                            $query2 ="SELECT tel from get_cusinfo where HN='$c_id'";
                                            $result2=odbc_exec($db2,$query2);
                                            if($list2=odbc_fetch_array($result2)){
                                                $tel = iconv("TIS-620", "UTF-8", $list2['tel']);
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
                                                }
                                                echo "<TR>
                                                    <TD>".date("H:i", strtotime($date))."</TD>
                                                    <TD><a  href='check_report.php?pre_id=$pre_id'>$pre_id</a></TD>
                                                    <TD>$q_name</TD>
                                                    <TD>".date("H:i", strtotime($ready_time))."</TD>
                                                    <TD>$s_name</TD>
                                                    <TD>$c_id</TD>
                                                    <TD>$c_name</TD>
                                                    <TD>$boil_date</TD>
                                                    <TD>".date("H:i", strtotime($op_time))."</TD>
                                                    <TD>$o_name</TD>
                                                    <TD>$tel</TD>
                                                </TR>";
                                            }
                                            else echo "<TR>
                                                <TD>".date("H:i", strtotime($date))."</TD>
                                                <TD><a href='check_report.php?pre_id=$pre_id'>$pre_id</a></TD>
                                                <TD>$q_name</TD>
                                                <TD>".date("H:i", strtotime($ready_time))."</TD>
                                                <TD>$s_name</TD>
                                                <TD>$c_id</TD>
                                                <TD>$c_name</TD>
                                                <TD>$boil_date</TD>
                                                <TD>-</TD>
                                                <TD>-</TD>
                                                <TD>$tel</TD>
                                            </TR>";
                                            $op_time='';
                                            $o_id='';
                                            $o_name='';
                                            $c_name='';
                                            $q_name='';
                                            $t_name='';
                                            $ready_time='';
                                            $tel='';
                                            $boil_date='';
                                        }
									}


									
								}
							}

							?> 
					</table>
				</div>

			</div>
	</div>




</BODY>
</HTML>
