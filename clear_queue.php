<!DOCTYPE html>
<html>
<title>Clear Queue</title>
<meta charset="UTF-8">
<!-- <link rel="stylesheet" type="text/css" href="source/progress_bar.css"> -->
<link rel="stylesheet" type="text/css" href="w3.css">
<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="source/progress_bar.css">
<link href="https://fonts.googleapis.com/css?family=Kanit|Pridi|Trirong" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
    .pridi {
        font-family: 'Pridi', serif;
    }

    .kanit {
        font-family: 'Kanit', sans-serif;
    }
    .trirong{
        font-family: 'Trirong', serif;
    }
    .underline {
        background-image: linear-gradient(to right, red 50%, red 50%);
        background-position: 0 1.3em;
        background-repeat: repeat-x;
        background-size: 6px 3px;
    }
</style>
<script>
	function clear_queue(q_id){
		var test = confirm("ยืนยันที่จะเปลี่ยนสถานะคิว");
		if (test) {
			window.open('clear_queue_handler.php?q_id='+q_id, '_self');
		}
	}
</script>

<body>

    <?php
        require("connection.php"); 
        date_default_timezone_set("Etc/GMT-7");
        //Get the input
        if(!isset($_GET['input']))$_GET['input']='';
        $q_name=$_GET['input'];
        $c_id = $_GET['input'];
        if(!isset($_GET['c_date']))$_GET['c_date']= date("Y-m-d");
        $c_date=$_GET['c_date'];

        //หาด้วย q_name
        $query = "
            SELECT p.pre_id, p.c_id, p.in_datetime, p.q_id, q.q_name,  p.s_id, s.s_name, s.s_display_thai, s.t_id, t.t_name, p.finishtime
            FROM ieproject.dbo.prescription AS p, ieproject.dbo.type AS t, ieproject.dbo.status AS s, ieproject.dbo.queue AS q
            WHERE p.s_id=s.s_id 
                AND q.q_id = p.q_id 
                AND s.t_id=t.t_id 
                AND p.in_datetime > '$c_date'
                AND p.in_datetime <= dateadd(day, 1, '$c_date') 
                AND q.q_name = '$q_name' 
            ORDER BY p.t_id ASC;"
            ;
        $result=odbc_exec($db,$query);

        //หาด้วย HN
        $query2 = "
            SELECT p.pre_id, p.c_id, p.in_datetime, p.q_id, q.q_name,  p.s_id, s.s_name, s.s_display_thai, s.t_id, t.t_name, p.finishtime
            FROM ieproject.dbo.prescription AS p, ieproject.dbo.type AS t, ieproject.dbo.status AS s, ieproject.dbo.queue AS q
            WHERE p.s_id=s.s_id 
                AND q.q_id = p.q_id 
                AND s.t_id=t.t_id 
                AND p.in_datetime > '$c_date'
                AND p.in_datetime <= dateadd(day, 1, '$c_date') 
                AND p.c_id = '$c_id' 
            ORDER BY p.t_id ASC;"
            ;
        $result2 =odbc_exec($db,$query2);

        if($list=odbc_fetch_array($result)){ //With q_name OK?
            //get customer name from hospital database
            $c_id=$list['c_id'];
            $query2 ="SELECT c_name from get_cusinfo where HN='$c_id' ";
            $result2=odbc_exec($db2,$query2);
            if($list2=odbc_fetch_array($result2)){
                $c_name = iconv("TIS-620", "UTF-8", $list2['c_name']);
            }

            //assign data to each variable
            $pre_id=$list['pre_id'];
            $s_id=iconv("TIS-620", "UTF-8",$list['s_id']);
            $s_name=iconv("TIS-620", "UTF-8",$list['s_name']);
            $s_display_thai=iconv("TIS-620", "UTF-8",$list['s_display_thai']);
            $q_id=iconv("TIS-620", "UTF-8",$list['q_id']);
            $q_name=iconv("TIS-620", "UTF-8",$list['q_name']);
            $t_id=iconv("TIS-620", "UTF-8",$list['t_id']);
            $t_name=iconv("TIS-620", "UTF-8",$list['t_name']);
            $finishtime=$list['finishtime'];
            $in_datetime=$list['in_datetime'];
            $fin_time_display = round(strtotime($finishtime) / 300) * 300;
        }
        else if($list=odbc_fetch_array($result2)) { //with HN OK?
        	//get customer name from hospital database
            $c_id=$list['c_id'];
            $query2 ="SELECT c_name from get_cusinfo where HN='$c_id' ";
            $result2=odbc_exec($db2,$query2);
            if($list2=odbc_fetch_array($result2)){
                $c_name = iconv("TIS-620", "UTF-8", $list2['c_name']);
            }

            //assign data to each variable
            $pre_id=$list['pre_id'];
            $s_id=iconv("TIS-620", "UTF-8",$list['s_id']);
            $s_name=iconv("TIS-620", "UTF-8",$list['s_name']);
            $s_display_thai=iconv("TIS-620", "UTF-8",$list['s_display_thai']);
            $q_id=iconv("TIS-620", "UTF-8",$list['q_id']);
            $q_name=iconv("TIS-620", "UTF-8",$list['q_name']);
            $t_id=iconv("TIS-620", "UTF-8",$list['t_id']);
            $t_name=iconv("TIS-620", "UTF-8",$list['t_name']);
            $finishtime=$list['finishtime'];
            $in_datetime=$list['in_datetime'];
            $fin_time_display = round(strtotime($finishtime) / 300) * 300;
        }
        else { //if fail to query the result back to input
            session_start();
            $_SESSION['c']=1;
            header("refresh: 0; url=clear_queue_input.php");
        }
        require('header.html');
    ?>

    <div class="w3-row-padding w3-container w3-section">
		<div class="w3-container">
			<h1 class="w3-center"><i class="fa fa-tags" aria-hidden="true"></i>&nbsp;จัดการคิว</h1>
		</div>
		

		<div class="w3-row-padding">
			<div class="w3-container w3-third w3-large w3-card-2 w3-margin-right">
				<div class="w3-container w3-border-bottom">
					<h2>รายเอียด</h2>
				</div>
				<table class="w3-table w3-margin-bottom">
					<tr>
						<th>คิว</th>
						<td><?php echo $q_name;?></td>
					</tr>
					<tr>
						<th>HN</th>
						<td><?php echo $c_id;?></td>
					</tr>
					<tr>
						<th>ชื่อ</th>
						<td><?php echo $c_name;?></td>
					</tr>
					<tr>
						<th>วันที่</th>
						<td><?php echo date("Y-m-d", strtotime($c_date));?></td>
					</tr>
					<tr>
						<th>เวลาเข้าระบบ</th>
						<td><?php echo date("H:i", strtotime($in_datetime));?></td>
					</tr>
				</table>
				<div class="w3-center w3-section">
					<button class="w3-btn-block w3-green w3-xlarge w3-margin-bottom" style="width: 60%;" onClick="clear_queue(<?php echo "$q_id"; ?>)" >
						คิวเสร็จแล้ว
					</button>
					<a class="w3-btn-block w3-light-grey w3-xlarge" style="width: 60%;" href="clear_queue_input.php"> &laquo; กลับ</a>
				</div>
			</div>


			<div class="w3-rest w3-container w3-card-2">
				<div class="w3-container w3-border-bottom">
					<h2>ใบยาในคิว</h2>
				</div>
				<table class="w3-table w3-margin-bottom w3-xlarge">
					<tr>
						<th>คาดว่าเสร็จ</th>
						<th>รหัสใบยา</th>
						<th>ชนิด</th>
						<th>สถานะ</th>
						<th>เวลา</th>
						<th>พนักงาน</th>
					</tr>
					<?php
					// Print the first presciption that had been extract from the $list

					//Qeury status detail
						$query1 = "
							SELECT psrel.ps_time ,psrel.pre_id, psrel.s_id, status.s_name
							FROM psrel INNER JOIN status on psrel.s_id = status.s_id
							WHERE psrel.pre_id='$pre_id' 
							AND psrel.s_id = $s_id;
							";
						$result1=odbc_exec($db,$query1);
						if($list1=odbc_fetch_array($result1)){
							$ps_time = iconv("TIS-620", "UTF-8",$list1['ps_time']);
							$o_name = '-';
							//Find involved operator name
							$query2 = 
								"SELECT oprel.pre_id, oprel.s_id, oprel.o_id, operator.o_name 
								FROM oprel INNER JOIN operator on oprel.o_id=operator.o_id
								WHERE oprel.pre_id ='$pre_id' AND oprel.s_id ='$s_id' ";
							$result2=odbc_exec($db,$query2);

							if($list2=odbc_fetch_array($result2)){
								$o_name = iconv("TIS-620", "UTF-8",$list2['o_name']);
							}
							echo "
								<tr>
									<td>".date("H:i",$fin_time_display)."</td>
									<td><a href='check_report.php?pre_id=$pre_id'>$pre_id</a></td>
									<td>".$t_name."</td>
									<td>".$s_name."</td>
									<td>".date("H:i",strtotime($ps_time))."</td>
									<td>".$o_name."</td>
								</tr>";
						}

						// หาใบยาอื่น ๆ
						while($list=odbc_fetch_array($result)){
				            //assign data to each variable
				            $pre_id=$list['pre_id'];
				            $s_id=iconv("TIS-620", "UTF-8",$list['s_id']);
				            $s_name=iconv("TIS-620", "UTF-8",$list['s_name']);
				            $s_display_thai=iconv("TIS-620", "UTF-8",$list['s_display_thai']);
				            $q_id=iconv("TIS-620", "UTF-8",$list['q_id']);
				            $q_name=iconv("TIS-620", "UTF-8",$list['q_name']);
				            $t_id=iconv("TIS-620", "UTF-8",$list['t_id']);
				            $t_name=iconv("TIS-620", "UTF-8",$list['t_name']);
				            $finishtime=$list['finishtime'];
				            $in_datetime=$list['in_datetime'];
				            $fin_time_display = round(strtotime($finishtime) / 300) * 300;

				            // FIND STATUS DETAIL
				            $query1 = "
							SELECT psrel.ps_time ,psrel.pre_id, psrel.s_id, status.s_name
							FROM psrel INNER JOIN status on psrel.s_id = status.s_id
							WHERE psrel.pre_id='$pre_id' 
							AND psrel.s_id = $s_id;
							";
							$result1=odbc_exec($db,$query1);
							if($list1=odbc_fetch_array($result1)){
								$ps_time = iconv("TIS-620", "UTF-8",$list1['ps_time']);
								$o_name = '-';
								//Find involved operator name
								$query2 = 
									"SELECT oprel.pre_id, oprel.s_id, oprel.o_id, operator.o_name 
									FROM oprel INNER JOIN operator on oprel.o_id=operator.o_id
									WHERE oprel.pre_id ='$pre_id' AND oprel.s_id ='$s_id' ";
								$result2=odbc_exec($db,$query2);

								if($list2=odbc_fetch_array($result2)){
									$o_name = iconv("TIS-620", "UTF-8",$list2['o_name']);
								}
								echo "
									<tr>
										<td>".date("H:i",$fin_time_display)."</td>
										<td><a href='check_report.php?pre_id=$pre_id'>$pre_id</a></td>
										<td>".$t_name."</td>
										<td>".$s_name."</td>
										<td>".date("H:i",strtotime($ps_time))."</td>
										<td>".$o_name."</td>
									</tr>";
							}

				        }
					?>
				</table>
			 </div>

		</div>
	</div>


</body>
</html>