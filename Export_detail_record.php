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
$objPHPExcel = PHPExcel_IOFactory::load("Detail_record.xls");

// Set document properties
echo date('H:i:s') , " Set document properties" , EOL;
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
							 ->setLastModifiedBy("Maarten Balliauw")
							 ->setTitle("PHPExcel Test Document")
							 ->setSubject("PHPExcel Test Document")
							 ->setDescription("Test document for PHPExcel, generated using PHP classes.")
							 ->setKeywords("office PHPExcel php")
							 ->setCategory("Test result file");


// Write data from MySQL result
$u = "projectc";
$p = "projectc";
$constr = "DRIVER={SQL Server};SERVER=localhost;DATABASE=ieproject";
$db = odbc_connect($constr, $u,$p);
$objDB = $db;


$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'รายละเอียดทั้งหมดของวันที่ '.$from_dt.' น. ถึง '.$to_dt.' น.');
$query = "SELECT *
		FROM [ieproject].[dbo].[operator_display]
		WHERE in_datetime > '$from_dt'
			AND in_datetime < '$to_dt' ORDER by pre_id
		;";
//Execute Query

//echo $query;
$result = odbc_exec($db, $query);
$i=3;
while($list = odbc_fetch_array($result)){
	//Print Row
	$pre_id = $list['pre_id'];
	$t_name = iconv("TIS-620", "UTF-8", $list['t_name']);
	$numberOfMed = $list['numberOfMed'];
	$numberOfPack = $list['numberOfPack'];
	$in_datetime = date('Y-m-d H:i:s',strtotime($list['in_datetime']));
	$numberOfOper = $list['numberOfOper'];
	$o_id = $list['o_id'];
	$o_name = iconv("TIS-620", "UTF-8", $list['o_name']);
	$o_type = $list['o_type'];
	$parttime = $list['parttime'];
	$s_name = iconv("TIS-620", "UTF-8", $list['s_name']);
	$duration = $list['duration'];
	$ps_time = date('Y-m-d H:i:s',strtotime($list['ps_time']));
	$objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $pre_id);
	$objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $t_name);
	$objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $numberOfMed);
	$objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $numberOfPack);
	$objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $in_datetime);
	$objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $numberOfOper);
	$objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $o_id);
	$objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $o_name);
	if($o_type==1)$ot='จัดยา';
	else $ot='ต้มยา';
	$objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $ot);
	if($parttime==1)$pt='Fulltime';
	else $pt='Parttime';
	$objPHPExcel->getActiveSheet()->setCellValue('J'.$i, $pt);
	$objPHPExcel->getActiveSheet()->setCellValue('K'.$i, $s_name);
	$objPHPExcel->getActiveSheet()->setCellValue('M'.$i, $duration);
	$objPHPExcel->getActiveSheet()->setCellValue('L'.$i, $ps_time);
	$i=$i+1;;
}


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
