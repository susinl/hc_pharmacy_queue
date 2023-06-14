<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>progress bar</title>
<link rel="stylesheet" type="text/css" href="w3.css">
<link rel="stylesheet" type="text/css" href="source/progress_bar.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>

<?php
	// in inserted page must provide s_id, t_id	
	// demo input
		$t_id = 1;
		$s_id = 13;
	//find lenght of the bar
	require("connection.php");
	$query="SELECT s_id, t_id, s_name FROM status WHERE t_id='$t_id' ORDER BY s_id";
	$result=odbc_exec($db,$query);	
	$lenght = 0;
	while($list=odbc_fetch_array($result)){
		$viewing_s_id=$list['s_id'];
		if($viewing_s_id<100){
			$lenght++;
		}
	}
	//Query result from the server again to display the bar
	$query="SELECT s_id, t_id, s_name FROM status WHERE t_id='$t_id' ORDER BY s_id";
	$result=odbc_exec($db,$query);	
?>

	<ol class="progress progress--medium">
	<?php
		//echo progress bar according to $t_id $s_id
		$count = 1;
		while($list=odbc_fetch_array($result)){
			$label_s_id=$list['s_id'];
			$s_name=$list['s_name'];
			$next_id=$list['next_id'];
			if($label_s_id<100){
				if($count<$lenght){
					if($label_s_id<$s_id){
					echo 	"<li class='is-complete' data-step='$count'> $s_name </li>";
					}
					elseif ($label_s_id==$s_id) {
						echo "<li class='is-active' data-step='$count'> $s_name </li>";
					}
					else{
						echo "<li data-step='$count'> $s_name </li>";
					}
				}
				else{
					if($label_s_id<$s_id){
					echo 	"<li class='is-complete' data-step='$count'> $s_name </li>";
					}
					elseif ($label_s_id==s_id) {
						echo "<li class='is-active progress__last' data-step='$count'> $s_name </li>";
					}
					else{
						echo "<li class='progress__last' data-step='$count'> $s_name </li>";
					}
				}
			}	
			$count++;
		}
				
	?>
	</ol>
</body>
</html>