<?php
	//ใช้สำหรับเปลี่ยนสถานะใบยาในระบบให้ยกเลิกตามกับที่คุณหมอสั่งยกเลิกมาแล้ว
	// Result ที่เกิดขึ้น
	//	- เปลี่ยน s_id = ยกเลิกใน prescription
	// 	- ใส่ record ยกเลิกลงใน psrel

	// 1. ดึง pre_id ที่มีสถานะไม่ตรงกับในระบบกลางออกมาพร้อม type
	// 2. จัดการทีละ pre_id โดยจะ
			//2.1 ใส่ค่าที่เลือกมาลงตัวแปร
			//2.2 สร้าง status ที่แปลว่ายกเลิกโดย = ($t_id*100)+1
			//2.3 ใส่ record ยกเลิกลงใน psrel
			//2.4 UPDATE ให้ s_id ใน prescription เป็นยกเลิก
	$ts = date("Y-m-d H:i:s");
	//require("../connection.php");
	//1.
	$query = 	"SELECT p.pre_id, p.t_id, p.s_id, i.[Status]
				FROM ieproject.dbo.prescription as p inner join hospital.dbo.get_preinfo as i on p.pre_id = i.pre_id
				WHERE i.[Status] = 1
					AND s_id NOT IN (101, 201, 301, 401)
				ORDER BY p.pre_id";
	//Select all pre_id that had inconsistent cancel status
	$result = odbc_exec($db, $query); //run the sql

	//2.
	while($list=odbc_fetch_array($result)){
			//2.1
			$p_id = $list['pre_id'];
			$t_id = $list['t_id'];

			//2.2
			$cancel = ($t_id*100)+1; //เก็บค่า Status ที่แปลว่ายกเลิก
			//echo "$pre_id, $t_id, $cancel";

			//2.3
			$q2 = "INSERT INTO psrel
					VALUES ($p_id, $cancel, '$ts', 0, 0)";
			odbc_exec($db, $q2);

			// //2.4
			$q3 = "UPDATE prescription
					SET s_id = $cancel
					WHERE pre_id = $p_id;";
			odbc_exec($db, $q3);
			//echo "Status of $pre_id has been changed to $cancel <br>";
	}
?>