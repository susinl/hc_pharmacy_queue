<?php
	require_once ('connection.php');
	require_once('Classes/PHPExcel.php');
	

	if(!isset($_POST['from_date'])) 
		$_POST['from_date'] = date("Y-m-d");
	$from_date=$_POST['from_date'];
	if(!isset($_POST['from_time'])) 
		$_POST['from_time'] = "08:00:00";
	$from_time=$_POST['from_time'];

		//to
	if(!isset($_POST['to_date'])) 
		$_POST['to_date'] = date("Y-m-d");
	$to_date=$_POST['to_date'];
	if(!isset($_POST['to_time'])) 
		$_POST['to_time'] = "18:00:00";
	$to_time=$_POST['to_time'];
	if(!isset($_POST['decoct'])) 
		$_POST['decoct'] = "0";
     $decoct=$_POST['decoct'];
	if(!isset($_POST['selfdecoct'])) 
	    $_POST['selfdecoct'] = "0";
    $selfdecoct=$_POST['selfdecoct'];
	if(!isset($_POST['keli'])) 
	    $_POST['keli'] = "0";
    $keli=$_POST['keli'];
    if(!isset($_POST['readymade'])) 
	    $_POST['readymade'] = "0";
    $readymade=$_POST['readymade'];
	$from_dt = $from_date." ".$from_time;
	$to_dt = $to_date." ".$to_time;
    $index=1;

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()
	->setCellValue('A1', "ข้อมูลใบยาจากวันที่  ".$from_date." เวลา ".$from_time."  ถึงวันที่ ".$to_date."  เวลา ".$to_time."");

	//merge heading
	$objPHPExcel->setActiveSheetIndex(0)->mergeCells("A1:Q1");

	// set font style
	$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1')->getFont()->setSize(20);

// set cell alignment
	//$objPHPExcel->setActiveSheetIndex(0)->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
   $objPHPExcel->setActiveSheetIndex(0)
				->setTitle("วันที่");

	/* Create a first sheet, representing  data*/
    if($decoct=='1'){
	    $objPHPExcel->createSheet();
		$objPHPExcel->setActiveSheetIndex($index);
	    $objPHPExcel->getActiveSheet()->setCellValue('A1', "รหัสใบยา");
		$objPHPExcel->getActiveSheet()->setCellValue('B1', "เวลาที่ใบยาเข้าระบบ");
		$objPHPExcel->getActiveSheet()->setCellValue('C1', "เวลาที่ยาพร้อมจ่าย");
	    $objPHPExcel->getActiveSheet()->setCellValue('D1', "เวลาที่ทำนาย");
		$objPHPExcel->getActiveSheet()->setCellValue('E1', "เวลาที่จัดเสร็จ");
	    $objPHPExcel->getActiveSheet()->setCellValue('F1', "เวลาที่ต้มเสร็จ");
		$objPHPExcel->getActiveSheet()->setCellValue('G1', "จำนวนยา");
		$objPHPExcel->getActiveSheet()->setCellValue('H1', "จำนวนแพ็ค");
	    $objPHPExcel->getActiveSheet()->setCellValue('I1', "คนจัด");
	    $objPHPExcel->getActiveSheet()->setCellValue('J1', "คนต้ม");
		$objPHPExcel->getActiveSheet()->setCellValue('K1', "เวลารอจัด(นาที)");
	    $objPHPExcel->getActiveSheet()->setCellValue('L1', "เวลาจัด(นาที)");
	    $objPHPExcel->getActiveSheet()->setCellValue('M1', "เวลารอต้ม(นาที)");
	    $objPHPExcel->getActiveSheet()->setCellValue('N1', "เวลาต้ม(นาที)");
		$objPHPExcel->getActiveSheet()->setCellValue('O1', "เวลาหลังต้มเสร็จ(นาที)");
	    $objPHPExcel->getActiveSheet()->setCellValue('P1', "เวลารอจ่ายยา(นาที)");
         $objPHPExcel->getActiveSheet()->setCellValue('Q1', "ต้มเสร็จไม่ทันเวลาที่พยากรณ์เป็น1");
		$i=2;
	$query1= "SELECT  prescription.pre_id, prescription.in_datetime,prescription.finishTime, prescription.numberOfMed,prescription.numberOfPack,
		max(CASE WHEN (psrel.s_id  = 15 ) THEN ps_time ELSE NULL END) as realtime,
		max(CASE WHEN (psrel.s_id  = 12 ) THEN ps_time ELSE NULL END) as finishpicktime,
		max(CASE WHEN (psrel.s_id  = 14 ) THEN ps_time ELSE NULL END) as finishdecocttime,
		max(CASE WHEN (oprel.s_id  = 11 ) THEN o_id ELSE NULL END) as picker,
		max(CASE WHEN (oprel.s_id  = 13 ) THEN o_id ELSE NULL END) as decocting_operator,
        max(CASE WHEN (psrel.s_id = 10) THEN duration ELSE NULL END) as waittopick,
        max(CASE WHEN (psrel.s_id  = 11 ) THEN duration ELSE NULL END) as picking,
        max(CASE WHEN (psrel.s_id  = 12) THEN duration ELSE NULL END) as waittodecoct,
        max(CASE WHEN (psrel.s_id = 13) THEN duration ELSE NULL END) as decocting,
        max(CASE WHEN (psrel.s_id = 14) THEN duration ELSE NULL END) as finishdecocting,
        max(CASE WHEN (psrel.s_id = 15) THEN duration ELSE NULL END) as ready
		FROM ((psrel INNER JOIN prescription ON prescription.pre_id=psrel.pre_id) 
		INNER JOIN oprel ON prescription.pre_id = oprel.pre_id)
 		WHERE prescription.t_id=1 AND prescription.in_datetime > '$from_dt'AND prescription.in_datetime<'$to_dt' AND psrel.s_id<100 
		group by  prescription.pre_id,prescription.in_datetime,prescription.finishTime,
		prescription.numberOfMed,prescription.numberOfPack ORDER BY prescription.in_datetime
	   ";
	$result1 = odbc_exec($db, $query1);
	/* Create new PHPExcel object*/
	
	while($row = odbc_fetch_array($result1)) {
		    $predict=$row['finishTime'];
			$real=$row['finishdecocttime'];
			if (strtotime($predict)<strtotime($real)){
				$value=1;
			}
		    else{$value=0;}
	
            $objPHPExcel->setActiveSheetIndex($index);
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$row["pre_id"]);
		   	$objPHPExcel->getActiveSheet()->setCellValue('B'.$i,$row["in_datetime"]);
		   	$objPHPExcel->getActiveSheet()->setCellValue('C'.$i,$row["realtime"]);
		   	$objPHPExcel->getActiveSheet()->setCellValue('D'.$i,$row["finishTime"]);
		   	$objPHPExcel->getActiveSheet()->setCellValue('E'.$i,$row["finishpicktime"]);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$i,$row["finishdecocttime"]);
		   	$objPHPExcel->getActiveSheet()->setCellValue('G'.$i,$row["numberOfMed"]);
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$i,$row["numberOfPack"]);
		   	$objPHPExcel->getActiveSheet()->setCellValue('I'.$i,$row["picker"]);
		   	$objPHPExcel->getActiveSheet()->setCellValue('J'.$i,$row["decocting_operator"]);
		   	$objPHPExcel->getActiveSheet()->setCellValue('K'.$i,$row["waittopick"]);
		   	$objPHPExcel->getActiveSheet()->setCellValue('L'.$i,$row["picking"]);
		   	$objPHPExcel->getActiveSheet()->setCellValue('M'.$i,$row["waittodecoct"]);
		   	$objPHPExcel->getActiveSheet()->setCellValue('N'.$i,$row["decocting"]);
		   	$objPHPExcel->getActiveSheet()->setCellValue('O'.$i,$row["finishdecocting"]);
		   	$objPHPExcel->getActiveSheet()->setCellValue('P'.$i,$row["ready"]);
			$objPHPExcel->getActiveSheet()->setCellValue('Q'.$i,$value);
		   $i++;			
	    }
	$objPHPExcel->setActiveSheetIndex($index)
				->setTitle('ยาต้ม');
	$index=$index+1;
	}
////ยาจัด
 if($selfdecoct=='2'){
	    $objPHPExcel->createSheet();
		$objPHPExcel->setActiveSheetIndex($index);
		$objPHPExcel->getActiveSheet()->setCellValue('A1', "รหัสใบยา");
		$objPHPExcel->getActiveSheet()->setCellValue('B1', "เวลาที่ใบยาเข้าระบบ");
		$objPHPExcel->getActiveSheet()->setCellValue('C1', "เวลาที่ยาพร้อมจ่าย");
	    $objPHPExcel->getActiveSheet()->setCellValue('D1', "เวลาที่ทำนาย");
		$objPHPExcel->getActiveSheet()->setCellValue('E1', "เวลาที่จัดเสร็จ");
	    $objPHPExcel->getActiveSheet()->setCellValue('F1', "จำนวนยา");
	    $objPHPExcel->getActiveSheet()->setCellValue('G1', "จำนวนแพ็ค");
	    $objPHPExcel->getActiveSheet()->setCellValue('H1', "คนจัด");
		$objPHPExcel->getActiveSheet()->setCellValue('I1', "เวลารอจัด(นาที)");
	    $objPHPExcel->getActiveSheet()->setCellValue('J1', "เวลาจัด(นาที)");
		$objPHPExcel->getActiveSheet()->setCellValue('K1', "เวลาหลังจัดเสร็จ(นาที)");
	    $objPHPExcel->getActiveSheet()->setCellValue('L1', "เวลารอจ่ายยา(นาที)");
        $objPHPExcel->getActiveSheet()->setCellValue('M1', "จัดเสร็จไม่ทันเวลาพยากรณ์เป็น1");
		$i=2;
		 $query= "SELECT  prescription.pre_id, prescription.in_datetime,prescription.finishTime,
		 prescription.numberOfMed,prescription.numberOfPack,
		 max(CASE WHEN (psrel.s_id  = 23 ) THEN ps_time ELSE NULL END) as realtime,
		 max(CASE WHEN (psrel.s_id  = 22 ) THEN ps_time ELSE NULL END) as finishpicktime,
		max(CASE WHEN (oprel.s_id  = 21 ) THEN o_id ELSE NULL END) as picker,
        max(CASE WHEN (psrel.s_id = 20) THEN duration ELSE NULL END) as waittopick,
        max(CASE WHEN (psrel.s_id  = 21 ) THEN duration ELSE NULL END) as picking,
        max(CASE WHEN (psrel.s_id  = 22) THEN duration ELSE NULL END) as finishpicking,
        max(CASE WHEN (psrel.s_id = 23) THEN duration ELSE NULL END) as ready
		FROM ((psrel INNER JOIN prescription ON prescription.pre_id=psrel.pre_id) 
		INNER JOIN oprel ON prescription.pre_id = oprel.pre_id)
 		WHERE prescription.t_id=2 AND prescription.in_datetime > '$from_dt'AND prescription.in_datetime<'$to_dt'AND psrel.s_id<200 
		group by  prescription.pre_id,prescription.in_datetime,prescription.finishTime,
		prescription.numberOfMed,prescription.numberOfPack ORDER BY prescription.in_datetime
	   ";
		 $result = odbc_exec($db, $query);
	/* Create new PHPExcel object*/
	
	while($row = odbc_fetch_array($result)) {
		    $predict=$row['finishTime'];
			$real=$row['finishpicktime'];
			if (strtotime($predict)<strtotime($real)){
				$value=1;
			}
		    else{$value=0;}

          $objPHPExcel->setActiveSheetIndex($index);
			   			$objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$row["pre_id"]);
		   				$objPHPExcel->getActiveSheet()->setCellValue('B'.$i,$row["in_datetime"]);
		   				$objPHPExcel->getActiveSheet()->setCellValue('C'.$i,$row["realtime"]);
		   				$objPHPExcel->getActiveSheet()->setCellValue('D'.$i,$row["finishTime"]);
		   				$objPHPExcel->getActiveSheet()->setCellValue('E'.$i,$row["finishpicktime"]);
		   				$objPHPExcel->getActiveSheet()->setCellValue('F'.$i,$row["numberOfMed"]);
			            $objPHPExcel->getActiveSheet()->setCellValue('G'.$i,$row["numberOfPack"]);
		   				$objPHPExcel->getActiveSheet()->setCellValue('H'.$i,$row["picker"]);
		   				$objPHPExcel->getActiveSheet()->setCellValue('I'.$i,$row["waittopick"]);
		   				$objPHPExcel->getActiveSheet()->setCellValue('J'.$i,$row["picking"]);
		   				$objPHPExcel->getActiveSheet()->setCellValue('K'.$i,$row["finishpicking"]);
		   				$objPHPExcel->getActiveSheet()->setCellValue('L'.$i,$row["ready"]);
						$objPHPExcel->getActiveSheet()->setCellValue('M'.$i,$value);
		   $i++;			
	    }
	$objPHPExcel->setActiveSheetIndex($index)
				->setTitle('ยาจัด');
	 $index=$index+1;

 }
////ยาเคอลี่
if($keli=='3'){
	    $objPHPExcel->createSheet();
		$objPHPExcel->setActiveSheetIndex($index);
					$objPHPExcel->getActiveSheet()->setCellValue('A1', "รหัสใบยา");
					$objPHPExcel->getActiveSheet()->setCellValue('B1', "เวลาที่ใบยาเข้าระบบ");
					$objPHPExcel->getActiveSheet()->setCellValue('C1', "เวลาที่ยาพร้อมจ่าย");
	    			$objPHPExcel->getActiveSheet()->setCellValue('D1', "เวลาที่ทำนาย");
					$objPHPExcel->getActiveSheet()->setCellValue('E1', "เวลาที่จัดเสร็จ");
			        $objPHPExcel->getActiveSheet()->setCellValue('F1', "จำนวนยา");
			        $objPHPExcel->getActiveSheet()->setCellValue('G1', "จำนวนแพ็ค");
	    			$objPHPExcel->getActiveSheet()->setCellValue('H1', "คนจัด");
					$objPHPExcel->getActiveSheet()->setCellValue('I1', "เวลารอจัด(นาที)");
	    			$objPHPExcel->getActiveSheet()->setCellValue('J1', "เวลาจัด(นาที)");
	    			$objPHPExcel->getActiveSheet()->setCellValue('K1', "เวลารอจ่ายยา(นาที)");
                    $objPHPExcel->getActiveSheet()->setCellValue('L1', "จัดเสร็จไม่ทันเวลาที่พยากรณ์เป็น1");
		$i=2;
		 $query= "SELECT  prescription.pre_id, prescription.in_datetime,prescription.finishTime,
		  prescription.numberOfMed,prescription.numberOfPack,
		 max(CASE WHEN (psrel.s_id  = 32 ) THEN ps_time ELSE NULL END) as realtime,
		 max(CASE WHEN (psrel.s_id  = 32 ) THEN ps_time ELSE NULL END) as finishpicktime,
		max(CASE WHEN (oprel.s_id  = 31 ) THEN o_id ELSE NULL END) as picker,
        max(CASE WHEN (psrel.s_id = 30) THEN duration ELSE NULL END) as waittopick,
        max(CASE WHEN (psrel.s_id  = 31 ) THEN duration ELSE NULL END) as picking,
        max(CASE WHEN (psrel.s_id  = 32) THEN duration ELSE NULL END) as ready
		FROM ((psrel INNER JOIN prescription ON prescription.pre_id=psrel.pre_id) 
		INNER JOIN oprel ON prescription.pre_id = oprel.pre_id)
 		WHERE prescription.t_id=3 AND prescription.in_datetime > '$from_dt'AND prescription.in_datetime<'$to_dt'AND psrel.s_id<300 
		group by  prescription.pre_id,prescription.in_datetime,prescription.finishTime, prescription.numberOfMed,prescription.numberOfPack ORDER BY prescription.in_datetime
	   ";
		 $result = odbc_exec($db, $query);
	/* Create new PHPExcel object*/
	
	while($row = odbc_fetch_array($result)) {
		    $predict=$row['finishTime'];
			$real=$row['realtime'];
			if (strtotime($predict)<strtotime($real)){
				$value=1;
			}
		    else{$value=0;}

           $objPHPExcel->setActiveSheetIndex($index);
			   			$objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$row["pre_id"]);
		   				$objPHPExcel->getActiveSheet()->setCellValue('B'.$i,$row["in_datetime"]);
		   				$objPHPExcel->getActiveSheet()->setCellValue('C'.$i,$row["realtime"]);
		   				$objPHPExcel->getActiveSheet()->setCellValue('D'.$i,$row["finishTime"]);
		   				$objPHPExcel->getActiveSheet()->setCellValue('E'.$i,$row["finishpicktime"]);
		   				$objPHPExcel->getActiveSheet()->setCellValue('F'.$i,$row["numberOfMed"]);
			            $objPHPExcel->getActiveSheet()->setCellValue('G'.$i,$row["numberOfPack"]);
		   				$objPHPExcel->getActiveSheet()->setCellValue('H'.$i,$row["picker"]);
		   				$objPHPExcel->getActiveSheet()->setCellValue('I'.$i,$row["waittopick"]);
		   				$objPHPExcel->getActiveSheet()->setCellValue('J'.$i,$row["picking"]);
		   				$objPHPExcel->getActiveSheet()->setCellValue('K'.$i,$row["ready"]);
						$objPHPExcel->getActiveSheet()->setCellValue('L'.$i,$value);
		   $i++;			
	    }
	$objPHPExcel->setActiveSheetIndex($index)
				->setTitle('ยาเคอลี่');
	$index=$index+1;

}
////ยาสำเร็จรูป
if($readymade=='4'){
	    $objPHPExcel->createSheet();
		$objPHPExcel->setActiveSheetIndex($index);
					$objPHPExcel->getActiveSheet()->setCellValue('A1', "รหัสใบยา");
					$objPHPExcel->getActiveSheet()->setCellValue('B1', "เวลาที่ใบยาเข้าระบบ");
					$objPHPExcel->getActiveSheet()->setCellValue('C1', "เวลาที่รับยา");
			        $objPHPExcel->getActiveSheet()->setCellValue('D1', "จำนวนยา");
			        $objPHPExcel->getActiveSheet()->setCellValue('E1', "จำนวนแพ็ค");
	    			$objPHPExcel->getActiveSheet()->setCellValue('F1', "เวลารอจ่ายยา(นาที)");
		$i=2;
		 $query= "SELECT  prescription.pre_id, prescription.in_datetime,
		 prescription.numberOfMed,prescription.numberOfPack,
		 max(CASE WHEN (psrel.s_id  = 41 ) THEN ps_time ELSE NULL END) as realtime,
        max(CASE WHEN (psrel.s_id  = 40) THEN duration ELSE NULL END) as ready
		FROM (psrel INNER JOIN prescription ON prescription.pre_id=psrel.pre_id) 
 		WHERE prescription.t_id=4 AND prescription.in_datetime > '$from_dt'AND prescription.in_datetime<'$to_dt'AND psrel.s_id<100 
		group by  prescription.pre_id,prescription.in_datetime, prescription.numberOfMed,prescription.numberOfPack ORDER BY prescription.in_datetime
	   ";
		 $result = odbc_exec($db, $query);
	/* Create new PHPExcel object*/
	
	while($row = odbc_fetch_array($result)) {
           $objPHPExcel->setActiveSheetIndex($index);
			   			$objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$row["pre_id"]);
		   				$objPHPExcel->getActiveSheet()->setCellValue('B'.$i,$row["in_datetime"]);
		   				$objPHPExcel->getActiveSheet()->setCellValue('C'.$i,$row["realtime"]);
		   				$objPHPExcel->getActiveSheet()->setCellValue('D'.$i,$row["numberOfMed"]);
			            $objPHPExcel->getActiveSheet()->setCellValue('E'.$i,$row["numberOfPack"]);
		   				$objPHPExcel->getActiveSheet()->setCellValue('F'.$i,$row["ready"]);
		
		   $i++;			
	    }
	$objPHPExcel->setActiveSheetIndex($index)
				->setTitle('ยาสำเร็จรูป');
	$index=$index+1;
}

	header('Content-Type: application/vnd.ms-excel');
	//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
	header('Content-Disposition: attachment;filename="data_report.xls"');
	header('Cache-Control: max-age=0');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save('php://output');
	?>
