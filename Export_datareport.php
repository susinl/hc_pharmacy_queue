<?php
/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2015 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2015 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set("Etc/GMT-7");

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/../pharmacy_queue/Classes/PHPExcel.php';

// Create new PHPExcel object
echo date('H:i:s') , " Create new PHPExcel object" , EOL;
$objPHPExcel = PHPExcel_IOFactory::load("report.xls");

// Set document properties
echo date('H:i:s') , " Set document properties" , EOL;
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("PHPExcel Test Document")
							 ->setSubject("PHPExcel Test Document")
							 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
							 ->setKeywords("office PHPExcel php")
							 ->setCategory("Test result file");
$objPHPExcel->getDefaultStyle()->getFont()->setName('TH SarabunPSK');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(14);


// Write data from MySQL result
$u = "projectc";
$p = "projectc";
$constr = "DRIVER={SQL Server};SERVER=localhost;DATABASE=ieproject";
$db = odbc_connect($constr, $u,$p);
$objDB = $db;

$index=1;
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'ข้อมูลใบยาจากวันที่  '.$from_date.' เวลา '.$from_time.' น.  ถึงวันที่ '.$to_date.'  เวลา '.$to_time.' น.');

//Decoct
if($decoct=='1'){
	    $objPHPExcel->createSheet();
		$objPHPExcel->setActiveSheetIndex($index);
	    $objPHPExcel->getActiveSheet()->setCellValue('A1', 'รหัสใบยา');
		$objPHPExcel->getActiveSheet()->setCellValue('B1', 'เวลาที่ใบยาเข้าระบบ');
		$objPHPExcel->getActiveSheet()->setCellValue('C1', 'เวลาที่ยาพร้อมจ่าย');
	    $objPHPExcel->getActiveSheet()->setCellValue('D1', 'เวลาที่ทำนาย');
		$objPHPExcel->getActiveSheet()->setCellValue('E1', 'เวลาที่จัดเสร็จ');
	    $objPHPExcel->getActiveSheet()->setCellValue('F1', 'เวลาที่ต้มเสร็จ');
		$objPHPExcel->getActiveSheet()->setCellValue('G1', 'จำนวนยา');
		$objPHPExcel->getActiveSheet()->setCellValue('H1', 'จำนวนแพ็ค');
	    $objPHPExcel->getActiveSheet()->setCellValue('I1', 'คนจัด');
	    $objPHPExcel->getActiveSheet()->setCellValue('J1', 'คนต้ม');
		$objPHPExcel->getActiveSheet()->setCellValue('K1', 'เวลารอจัด(นาที)');
	    $objPHPExcel->getActiveSheet()->setCellValue('L1', 'เวลาจัด(นาที)');
	    $objPHPExcel->getActiveSheet()->setCellValue('M1', 'เวลารอต้ม(นาที)');
	    $objPHPExcel->getActiveSheet()->setCellValue('N1', 'เวลาต้ม(นาที)');
		$objPHPExcel->getActiveSheet()->setCellValue('O1', 'เวลาหลังต้มเสร็จ(นาที)');
	    $objPHPExcel->getActiveSheet()->setCellValue('P1', 'เวลารอจ่ายยา(นาที)');
         $objPHPExcel->getActiveSheet()->setCellValue('Q1', 'ต้มเสร็จไม่ทันเวลาที่พยากรณ์เป็น1');
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
		FROM (([ieproject].[dbo].[psrel] INNER JOIN [ieproject].[dbo].[prescription] ON prescription.pre_id=psrel.pre_id) 
		INNER JOIN oprel ON prescription.pre_id = oprel.pre_id)
 		WHERE prescription.t_id=1 AND prescription.in_datetime > '$from_dt'AND prescription.in_datetime<'$to_dt' AND psrel.s_id<100 
		group by  prescription.pre_id,prescription.in_datetime,prescription.finishTime,
		prescription.numberOfMed,prescription.numberOfPack ORDER BY prescription.in_datetime
	   ";
	$result1 = odbc_exec($db, $query1);
	/* Create new PHPExcel object*/
	
	while($list = odbc_fetch_array($result1)) {
		    $predict=$list['finishTime'];
			$real=$list['finishdecocttime'];
			if (strtotime($predict)<strtotime($real)){
				$value=1;
			}
		    else{$value=0;}
	        $objPHPExcel->setActiveSheetIndex($index);
			$objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$list["pre_id"]);
		   	$objPHPExcel->getActiveSheet()->setCellValue('B'.$i,$list["in_datetime"]);
		   	$objPHPExcel->getActiveSheet()->setCellValue('C'.$i,$list["realtime"]);
		   	$objPHPExcel->getActiveSheet()->setCellValue('D'.$i,$list["finishTime"]);
		   	$objPHPExcel->getActiveSheet()->setCellValue('E'.$i,$list["finishpicktime"]);
			$objPHPExcel->getActiveSheet()->setCellValue('F'.$i,$list["finishdecocttime"]);
		   	$objPHPExcel->getActiveSheet()->setCellValue('G'.$i,$list["numberOfMed"]);
			$objPHPExcel->getActiveSheet()->setCellValue('H'.$i,$list["numberOfPack"]);
		   	$objPHPExcel->getActiveSheet()->setCellValue('I'.$i,$list["picker"]);
		   	$objPHPExcel->getActiveSheet()->setCellValue('J'.$i,$list["decocting_operator"]);
		   	$objPHPExcel->getActiveSheet()->setCellValue('K'.$i,$list["waittopick"]);
		   	$objPHPExcel->getActiveSheet()->setCellValue('L'.$i,$list["picking"]);
		   	$objPHPExcel->getActiveSheet()->setCellValue('M'.$i,$list["waittodecoct"]);
		   	$objPHPExcel->getActiveSheet()->setCellValue('N'.$i,$list["decocting"]);
		   	$objPHPExcel->getActiveSheet()->setCellValue('O'.$i,$list["finishdecocting"]);
		   	$objPHPExcel->getActiveSheet()->setCellValue('P'.$i,$list["ready"]);
			$objPHPExcel->getActiveSheet()->setCellValue('Q'.$i,$value);
		   $i++;			
	    }
	$objPHPExcel->getActiveSheet()->setTitle('ยาต้ม');
	$index=$index+1;
	}


//Self-decoct
if($selfdecoct=='2'){
	    $objPHPExcel->createSheet();
		$objPHPExcel->setActiveSheetIndex($index);
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'รหัสใบยา');
		$objPHPExcel->getActiveSheet()->setCellValue('B1', 'เวลาที่ใบยาเข้าระบบ');
		$objPHPExcel->getActiveSheet()->setCellValue('C1', 'เวลาที่ยาพร้อมจ่าย');
	    $objPHPExcel->getActiveSheet()->setCellValue('D1', 'เวลาที่ทำนาย');
		$objPHPExcel->getActiveSheet()->setCellValue('E1', 'เวลาที่จัดเสร็จ');
	    $objPHPExcel->getActiveSheet()->setCellValue('F1', 'จำนวนยา');
	    $objPHPExcel->getActiveSheet()->setCellValue('G1', 'จำนวนแพ็ค');
	    $objPHPExcel->getActiveSheet()->setCellValue('H1', 'คนจัด');
		$objPHPExcel->getActiveSheet()->setCellValue('I1', 'เวลารอจัด(นาที)');
	    $objPHPExcel->getActiveSheet()->setCellValue('J1', 'เวลาจัด(นาที)');
		$objPHPExcel->getActiveSheet()->setCellValue('K1', 'เวลาหลังจัดเสร็จ(นาที)');
	    $objPHPExcel->getActiveSheet()->setCellValue('L1', 'เวลารอจ่ายยา(นาที)');
        $objPHPExcel->getActiveSheet()->setCellValue('M1', 'จัดเสร็จไม่ทันเวลาพยากรณ์เป็น1');
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
		FROM (([ieproject].[dbo].[psrel] INNER JOIN [ieproject].[dbo].[prescription] ON prescription.pre_id=psrel.pre_id) 
		INNER JOIN oprel ON prescription.pre_id = oprel.pre_id)
 		WHERE prescription.t_id=2 AND prescription.in_datetime > '$from_dt'AND prescription.in_datetime<'$to_dt'AND psrel.s_id<200 
		group by  prescription.pre_id,prescription.in_datetime,prescription.finishTime,
		prescription.numberOfMed,prescription.numberOfPack ORDER BY prescription.in_datetime
	   ";
		 $result = odbc_exec($db, $query);
	/* Create new PHPExcel object*/
	
	while($list = odbc_fetch_array($result)) {
		    $predict=$list['finishTime'];
			$real=$list['finishpicktime'];
			if (strtotime($predict)<strtotime($real)){
				$value=1;
			}
		    else{$value=0;}

          $objPHPExcel->setActiveSheetIndex($index);
		  $objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$list["pre_id"]);
		  $objPHPExcel->getActiveSheet()->setCellValue('B'.$i,$list["in_datetime"]);
		  $objPHPExcel->getActiveSheet()->setCellValue('C'.$i,$list["realtime"]);
		  $objPHPExcel->getActiveSheet()->setCellValue('D'.$i,$list["finishTime"]);
		  $objPHPExcel->getActiveSheet()->setCellValue('E'.$i,$list["finishpicktime"]);
		  $objPHPExcel->getActiveSheet()->setCellValue('F'.$i,$list["numberOfMed"]);
	      $objPHPExcel->getActiveSheet()->setCellValue('G'.$i,$list["numberOfPack"]);
		  $objPHPExcel->getActiveSheet()->setCellValue('H'.$i,$list["picker"]);
		  $objPHPExcel->getActiveSheet()->setCellValue('I'.$i,$list["waittopick"]);
		  $objPHPExcel->getActiveSheet()->setCellValue('J'.$i,$list["picking"]);
		  $objPHPExcel->getActiveSheet()->setCellValue('K'.$i,$list["finishpicking"]);
		  $objPHPExcel->getActiveSheet()->setCellValue('L'.$i,$list["ready"]);
	      $objPHPExcel->getActiveSheet()->setCellValue('M'.$i,$value);
		   $i++;			
	    }
	$objPHPExcel->getActiveSheet()->setTitle('ยาจัด');
	 $index=$index+1;

 }



//keli
if($keli=='3'){
	    $objPHPExcel->createSheet();
		$objPHPExcel->setActiveSheetIndex($index);
					$objPHPExcel->getActiveSheet()->setCellValue('A1', 'รหัสใบยา');
					$objPHPExcel->getActiveSheet()->setCellValue('B1', 'เวลาที่ใบยาเข้าระบบ');
					$objPHPExcel->getActiveSheet()->setCellValue('C1', 'เวลาที่ยาพร้อมจ่าย');
	    			$objPHPExcel->getActiveSheet()->setCellValue('D1', 'เวลาที่ทำนาย');
					$objPHPExcel->getActiveSheet()->setCellValue('E1', 'เวลาที่จัดเสร็จ');
			        $objPHPExcel->getActiveSheet()->setCellValue('F1', 'จำนวนยา');
			        $objPHPExcel->getActiveSheet()->setCellValue('G1', 'จำนวนแพ็ค');
	    			$objPHPExcel->getActiveSheet()->setCellValue('H1', 'คนจัด');
					$objPHPExcel->getActiveSheet()->setCellValue('I1', 'เวลารอจัด(นาที)');
	    			$objPHPExcel->getActiveSheet()->setCellValue('J1', 'เวลาจัด(นาที)');
	    			$objPHPExcel->getActiveSheet()->setCellValue('K1', 'เวลารอจ่ายยา(นาที)');
                    $objPHPExcel->getActiveSheet()->setCellValue('L1', 'จัดเสร็จไม่ทันเวลาที่พยากรณ์เป็น1');
		$i=2;
		 $query= "SELECT  prescription.pre_id, prescription.in_datetime,prescription.finishTime,
		  prescription.numberOfMed,prescription.numberOfPack,
		 max(CASE WHEN (psrel.s_id  = 32 ) THEN ps_time ELSE NULL END) as realtime,
		 max(CASE WHEN (psrel.s_id  = 32 ) THEN ps_time ELSE NULL END) as finishpicktime,
		max(CASE WHEN (oprel.s_id  = 31 ) THEN o_id ELSE NULL END) as picker,
        max(CASE WHEN (psrel.s_id = 30) THEN duration ELSE NULL END) as waittopick,
        max(CASE WHEN (psrel.s_id  = 31 ) THEN duration ELSE NULL END) as picking,
        max(CASE WHEN (psrel.s_id  = 32) THEN duration ELSE NULL END) as ready
		FROM (([ieproject].[dbo].[psrel] INNER JOIN [ieproject].[dbo].[prescription] ON prescription.pre_id=psrel.pre_id) 
		INNER JOIN oprel ON prescription.pre_id = oprel.pre_id)
 		WHERE prescription.t_id=3 AND prescription.in_datetime > '$from_dt'AND prescription.in_datetime<'$to_dt'AND psrel.s_id<300 
		group by  prescription.pre_id,prescription.in_datetime,prescription.finishTime, prescription.numberOfMed,prescription.numberOfPack ORDER BY prescription.in_datetime
	   ";
		 $result = odbc_exec($db, $query);

	
	while($list = odbc_fetch_array($result)) {
		    $predict=$list['finishTime'];
			$real=$list['realtime'];
			if (strtotime($predict)<strtotime($real)){
				$value=1;
			}
		    else{$value=0;}

           $objPHPExcel->setActiveSheetIndex($index);
		   $objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$list["pre_id"]);
		   $objPHPExcel->getActiveSheet()->setCellValue('B'.$i,$list["in_datetime"]);
		   $objPHPExcel->getActiveSheet()->setCellValue('C'.$i,$list["realtime"]);
		   $objPHPExcel->getActiveSheet()->setCellValue('D'.$i,$list["finishTime"]);
		   $objPHPExcel->getActiveSheet()->setCellValue('E'.$i,$list["finishpicktime"]);
		   $objPHPExcel->getActiveSheet()->setCellValue('F'.$i,$list["numberOfMed"]);
		   $objPHPExcel->getActiveSheet()->setCellValue('G'.$i,$list["numberOfPack"]);
		   $objPHPExcel->getActiveSheet()->setCellValue('H'.$i,$list["picker"]);
		   $objPHPExcel->getActiveSheet()->setCellValue('I'.$i,$list["waittopick"]);
		   $objPHPExcel->getActiveSheet()->setCellValue('J'.$i,$list["picking"]);
		   $objPHPExcel->getActiveSheet()->setCellValue('K'.$i,$list["ready"]);
		   $objPHPExcel->getActiveSheet()->setCellValue('L'.$i,$value);
		   $i++;			
	    }
	$objPHPExcel->getActiveSheet()->setTitle('ยาเคอลี่');
	$index=$index+1;}

//Readymade
if($readymade=='4'){
	    $objPHPExcel->createSheet();
		$objPHPExcel->setActiveSheetIndex($index);
		$objPHPExcel->getActiveSheet()->setCellValue('A1', 'รหัสใบยา');
		$objPHPExcel->getActiveSheet()->setCellValue('B1', 'เวลาที่ใบยาเข้าระบบ');
		$objPHPExcel->getActiveSheet()->setCellValue('C1', 'เวลาที่รับยา');
        $objPHPExcel->getActiveSheet()->setCellValue('D1', 'จำนวนยา');
		$objPHPExcel->getActiveSheet()->setCellValue('E1', 'จำนวนแพ็ค');
	    $objPHPExcel->getActiveSheet()->setCellValue('F1', 'เวลารอจ่ายยา(นาที)');
		$i=2;
		 $query= "SELECT  prescription.pre_id, prescription.in_datetime,
		 prescription.numberOfMed,prescription.numberOfPack,
		 max(CASE WHEN (psrel.s_id  = 41 ) THEN ps_time ELSE NULL END) as realtime,
        max(CASE WHEN (psrel.s_id  = 40) THEN duration ELSE NULL END) as ready
		FROM ([ieproject].[dbo].[psrel] INNER JOIN [ieproject].[dbo].[prescription] ON prescription.pre_id=psrel.pre_id) 
 		WHERE prescription.t_id=4 AND prescription.in_datetime > '$from_dt'AND prescription.in_datetime<'$to_dt'AND psrel.s_id<100 
		group by  prescription.pre_id,prescription.in_datetime, prescription.numberOfMed,prescription.numberOfPack ORDER BY prescription.in_datetime
	   ";
		 $result = odbc_exec($db, $query);
	/* Create new PHPExcel object*/
	
	while($list = odbc_fetch_array($result)) {
           $objPHPExcel->setActiveSheetIndex($index);
			   			$objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$list["pre_id"]);
		   				$objPHPExcel->getActiveSheet()->setCellValue('B'.$i,$list["in_datetime"]);
		   				$objPHPExcel->getActiveSheet()->setCellValue('C'.$i,$list["realtime"]);
		   				$objPHPExcel->getActiveSheet()->setCellValue('D'.$i,$list["numberOfMed"]);
			            $objPHPExcel->getActiveSheet()->setCellValue('E'.$i,$list["numberOfPack"]);
		   				$objPHPExcel->getActiveSheet()->setCellValue('F'.$i,$list["ready"]);
		
		   $i++;			
	    }
	$objPHPExcel->getActiveSheet()->setTitle('ยาสำเร็จรูป');
	$index=$index+1;}


$objPHPExcel->setActiveSheetIndex(0);

// Save Excel 2007 file
echo date('H:i:s') , " Write to Excel2007 format" , EOL;
$callStartTime = microtime(true);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save(str_replace('.php', '.xls', __FILE__));
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;

echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
// Echo memory usage
echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;


// Save Excel 95 file
echo date('H:i:s') , " Write to Excel5 format" , EOL;
$callStartTime = microtime(true);

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save(str_replace('.php','.xls', __FILE__));
$callEndTime = microtime(true);
$callTime = $callEndTime - $callStartTime;

echo date('H:i:s') , " File written to " , str_replace('.php', '.xls', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL;
echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL;
// Echo memory usage
echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL;


// Echo memory peak usage
echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL;

// Echo done
echo date('H:i:s') , " Done writing files" , EOL;
echo 'Files have been created in ' , getcwd() , EOL;
?>











