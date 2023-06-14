<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../../w3.css">
<meta charset="UTF-8">
</head>
<body>
<?php
	$o_id = $_GET['o_id'];
	$from_dt = $_GET['from_dt'];
	$from_dt = date("Y-m-d H:i:s", $from_dt); //convert datetime to string
	$to_dt = $_GET['to_dt'];
	$to_dt = date("Y-m-d H:i:s", $to_dt); //convert datetime to string

	// $o_id = '99';
	// $from_dt = '2017-07-01 08:00:00'; 
	// $to_dt = '2017-07-31 18:00:00'; 

	require "../../connection.php";

	//   1.Print the summary table and detail record header.

	$query = "SELECT o_id, o_name, o_type, parttime,
				SUM(CASE t_id WHEN 1 THEN 1 ELSE 0 END) AS DecBill,
				SUM(CASE t_id WHEN 1 THEN numberOfPack ELSE 0 END) AS DecPack,
				AVG(CASE t_id WHEN 1 THEN duration ELSE NULL END) AS DecTime,
				SUM(CASE t_id WHEN 2 THEN 1 ELSE 0 END) AS SelfBill,
				SUM(CASE t_id WHEN 2 THEN numberOfPack ELSE 0 END) AS SelfPack,
				AVG(CASE t_id WHEN 2 THEN duration ELSE NULL END) AS SelfTime,
				SUM(CASE t_id WHEN 3 THEN 1 ELSE 0 END) AS KeliBill,
				SUM(CASE t_id WHEN 3 THEN numberOfPack ELSE 0 END) AS KeliPack,
				AVG(CASE t_id WHEN 3 THEN duration ELSE NULL END) AS KeliTime
			FROM [ieproject].[dbo].[operator_display]
			WHERE in_datetime > '$from_dt'
				AND in_datetime < '$to_dt'
				AND o_id = '$o_id'
			GROUP BY o_id,o_name, o_type, parttime;";
	$result2 = odbc_exec($db, $query);

	if($list = odbc_fetch_array($result2)){
		$o_type = $list['o_type'];
		$o_name = iconv('TIS-620', 'UTF-8', $row['o_name']);
		$parttime = $list['parttime'];
		$DecBill = $list['DecBill'];
		$DecPack = $list['DecPack'];
		$DecTime = round($list['DecTime'],1);
		$SelfBill = $list['SelfBill'];
		$SelfPack = $list['SelfPack'];
		$SelfTime = round($list['SelfTime'],1);
		$KeliBill = $list['KeliBill'];
		$KeliPack = $list['KeliPack'];
		$KeliTime = round($list['KeliTime'],1);

		//พิมพ์ช่องบอกชื่อ 
		echo "<div class='w3-panel w3-pale-blue w3-leftbar w3-border-blue'>
					<h2>$o_id $o_name</h2>
					<p>";
		if($o_type == 1) echo "พนักงานจัดยา";
		if($o_type == 2) echo "พนักงานต้มยา";

		if($parttime == 1)echo "-ประจำ";
		if($parttime == 2)echo "-ชั่วคราว";

		echo "</p></div>";

		//พิมพ์ตารางสรุป
		echo "<table class='w3-table-all w3-section'>
				<tr>
					<th>ชนิด</th>
					<th>จำนวนใบสั่ง</th>
					<th>จำนวน pack</th>
					<th>เวลาเฉลี่ย</th>
				</tr>
				<tr>
					<th> ยาต้ม</th>
					<td>$DecBill ใบ</td>
					<td>$DecPack</td>
					<td>$DecTime นาที</td>
				</tr>
				<tr>
					<th>ยาจัด</th>
					<td>$SelfBill ใบ</td>
					<td>$SelfPack</td>
					<td>$SelfTime นาที</td>
				</tr>
				<tr>
					<th>Keli</th>
					<td>$KeliBill ใบ</td>
					<td>$KeliPack</td>
					<td>$KeliTime นาที</td>
				</tr>
			</table>
			";
			


		//พิมพ์หัวตารางของประวัติการทำงาน
		echo "<h2 class='w3-border-bottom'>ประวัติการทำงาน</h2>";
		echo "<table class='w3-table-all w3-section'>
		<tr>
			<th>รหัสใบยา</th>
			<th>ชนิด</th>
			<th>วันเข้าระบบ</th>
			<th>เวลาเข้าระบบ</th>
			<th>HN</th>
			<th>จำนวนยา</th>
			<th>Pack</th>
			<th>งาน</th>
			<th>เวลาเริ่ม</th>
			<th>เวลาทำงาน</th>
		</tr>";
	}







	$sql="SELECT od.pre_id,
		od.t_name,
		convert(varchar(10),od.in_datetime,105) as in_date, 
		convert(varchar(8), od.in_datetime, 108) as in_time,
		p.c_id as HN,
		od.NumberOfMed as nm,
		od.NumberOfPack as np,
		od.s_name,
		convert(varchar(8), od.ps_time, 108) as process_time,
		od.o_id,
		od.o_name,
		od.duration
	FROM ieproject.dbo.operator_display as od, ieproject.dbo.prescription as p 
	WHERE p.pre_id = od.pre_id
		AND od.o_id = '$o_id'
		AND od.in_datetime >= '$from_dt'
		AND od.in_datetime <= '$to_dt'
	ORDER BY od.t_id ASC 
		, od.in_datetime ASC
	;";
	$result = odbc_exec($db, $sql);

	

	while($row = odbc_fetch_array($result)) {
		$pre_id = iconv('TIS-620', "UTF-8", $row['pre_id']);
		$t_name = iconv('TIS-620', "UTF-8", $row['t_name']);
		$in_date = iconv('TIS-620', "UTF-8", $row['in_date']);
		$in_time = iconv('TIS-620', "UTF-8", $row['in_time']);
		$HN = iconv('TIS-620', "UTF-8", $row['HN']);
		$s_name = iconv('TIS-620', 'UTF-8', $row['s_name']);
		$nm = iconv('TIS-620', "UTF-8", $row['nm']);
		$np = iconv('TIS-620', "UTF-8", $row['np']);
		$process_time = iconv('TIS-620', "UTF-8", $row['process_time']);
		$duration = round($row['duration'], 1);

		
		//ควรให้มันเรียงแยกตามชนิดด้วยจะดีมาก
			echo "<tr>
				<td>$pre_id</td>
				<td>$t_name</td>
				<td>$in_date</td>
				<td>$in_time</td>
				<td>$HN</td>
				<td>$nm</td>
				<td>$np</td>
				<td>$s_name</td>
				<td>$process_time</td>
				<td>$duration นาที</td>
			</tr>";
	}
echo "</table>";
?>
</body>
</html>
