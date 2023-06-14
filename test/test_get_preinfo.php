<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Queue Display</title>
<link rel="stylesheet" type="text/css" href="w3.css">
<link rel="stylesheet" type="text/css" href="source/progress_bar.css">
<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
<?php
	require('connection.php');
	$query="SELECT * FROM get_preinfo WHERE pre_id=2";
	$result=odbc_exec($db2,$query);
	if($list=odbc_fetch_array($result)){
		$pre_id = $list['pre_id'];
		echo $pre_id,"<br>";
		echo $list['q_name'], "<br>";
		echo $list['c_id'], "<br>";
		echo $list['type'], "<br>";
		echo $list['date'], "<br>";
		echo $list['numberofmed'], "<br>";
		echo $list['decoctingtime'], "<br>";

	}
?>


</body>



</html>