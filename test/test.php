<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Update Report</title>
<link rel="stylesheet" type="text/css" href="w3.css">
<link rel="stylesheet" type="text/css" href="source/progress_bar.css">
<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
<?php
	date_default_timezone_set("Etc/GMT-7");
	echo "hello world<br>"; 
	echo date('H:i')."<br>";
	//echo date("Y-m-d H:i:s",date_time_set(date("Y-m-d"),00,00,00));
	$a = strtotime(date("Y-m-d")." 00:00:00");
	echo date("Y-m-d H:i:s", $a);
?>

</body>



</html>