<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="source/plotly/plotly-latest.min.js"></script>
</head>

<body>

<div id="tester2" style="width:600px;height:250px;"></div>

<script>

	
<?php 
require "connection.php";
$h=array();
$count=array();
$from_dt = date('Y-m-d H:i:s', strtotime('yesterday'));
$to_dt = date('Y-m-d H:i:s');
$query = "SELECT a.h, count(a.pre_id) as count
			FROM (SELECT pre_id, datepart("."hh".", in_datetime) as h FROM [ieproject].[dbo].[prescription] where in_datetime >= '$from_dt' AND in_datetime <= '$to_dt') as a 
			group by a.h
			order by a.h;";
$result = odbc_exec($db, $query);
$i=0;
while($list = odbc_fetch_array($result)){
	$h[$i]=$list['h'];
	$count[$i]=$list['count'];
	$i=$i+1;
}
$h = json_encode($h);
$count = json_encode($count);
?>

	TESTER2 = document.getElementById('tester2');
	var layout = {
      yaxis: {title: "แกนํY"},       // set the y axis title
      xaxis: {title: "แกนX"},
      margin: {t: 0 }
	}

	Plotly.plot( TESTER2,[{
	x: <?php echo $h ;?>,
	y: <?php echo $count ;?>,
	type: 'bar' }], layout );
	

</script>
</body>
</html>