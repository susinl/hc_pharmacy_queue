
<!doctype html>
<html lang="en">
 <head>
  <meta charset="UTF-8">
  <meta name="Generator" content="EditPlus®">
  <meta name="Author" content="">
  <meta name="Keywords" content="">
  <meta name="Description" content="">
  <title>Document</title>
 
 </head>
 <body>


<?php 
if(!isset($_GET['from_dt'])) $_GET['from_dt'] = date_time_set(date('Y-m-d H:i:s',strtotime("-1 Months")));
$from_dt=$_GET['from_dt'];
if(!isset($_GET['to_dt'])) $_GET['to_dt'] = date_time_set(date('Y-m-d H:i:s'));
$to_dt=$_GET['to_dt'];
date_default_timezone_set("Etc/GMT-7");
$from_dt = date('Y-m-d H:i:s',$from_dt);
$to_dt = date('Y-m-d H:i:s', $to_dt);
/*echo $from_dt;
echo $to_dt;*/
require("Export_detail_record.php");
$file = 'Export_detail_record.xls';

if (file_exists($file)) {
header('Content-Description: File Transfer'); 
header('Content-Type: application/octet-stream'); 
header("Content-Disposition: attachment; filename='$file'"); 
header('Content-Transfer-Encoding: binary'); 
header('Expires: 0'); 
header('Cache-Control: must-revalidate, post-check=0, pre-check=0'); 
header('Pragma: public'); 
header('Content-Length: ' . filesize($file)); 
ob_clean(); 
flush(); 
readfile($file);      
exit();

}
?>


 </body>
</html>
