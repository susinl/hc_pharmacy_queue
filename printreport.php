
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
require("Export_datareport.php");
$file = 'export_datareport.xls';

if (file_exists($file)) {
header('Content-Description: File Transfer'); 
header('Content-Type: application/octet-stream'); 
header("Content-Disposition: attachment; filename=$file"); 
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
