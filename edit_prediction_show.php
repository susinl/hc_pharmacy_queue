<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>edit_prediction_main</title>
<link rel="stylesheet" type="text/css" href="w3.css">
<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<!-- -->
<body>
<?php
	require('header.html');
	
	?>
<div class="w3-container">
		<div class="w3-card-2 w3-section" style="width:75%; margin:auto">
			<div class="w3-container w3-border-bottom">
				<h1 class="w3-center">
					<i class="fa fa-hourglass" aria-hidden="true"></i>&nbsp;ปรับเปลี่ยนสมการ (修改时间方程)
				</h1>
			</div>
		<div class="w3-container">
			<?php
				require('connection.php');
				$query="SELECT * 
						FROM equation WHERE Version IN 
						( SELECT MAX(Version)
							FROM equation
						)";
				$result=odbc_exec($db,$query);
				if($list=odbc_fetch_array($result))
					{
						$Version=$list['Version'];
						$datetime=$list['datetime'];
						$Intercept=round($list['Intercept'],4);
						$Coef1=round($list['Coef1'],4);
						$Coef2=round($list['Coef2'],4);
						$Coef3=round($list['Coef3'],4);
						$Coef4=round($list['Coef4'],4);
						$Coef5=round($list['Coef5'],4);
						$Coef6=round($list['Coef6'],4);
						$Coef7=round($list['Coef7'],4);
						$Coef8=round($list['Coef8'],4);
						$Coef9=round($list['Coef9'],4);
						$Coef10=round($list['Coef10'],4);
						$Coef11=round($list['Coef11'],4);
						$Coef12=round($list['Coef12'],4);
						$Coef13=round($list['Coef13'],4);
						$Coef14=round($list['Coef14'],4);
						$Zvalue=round($list['Zvalue'],4);
						$TuneA=$list['TuneA'];
						$TuneB=$list['TuneB'];
					}
				
				
			?>
			
			<div class="w3-container w3-large w3-card-2 w3-margin-right">
				<div class="w3-container w3-border-bottom">
					<h2>รายละเอียดสมการล่าสุด</h2>
				</div>
				<table class="w3-table w3-margin-bottom">
					<tr>
						<th>Version</th>
						<td><?php echo $Version;?></td>
					</tr>
					<tr>
						<th>Zvalue</th>
						<td><?php echo $Zvalue;?></td>
					</tr>
					<tr>
						<th>เวลาเผื่อสำหรับยาต้ม</th>
						<td><?php echo $TuneA." minutes";?></td>
					</tr>
					<tr>
						<th>เวลาเผื่อสำหรับยาจัด</th>
						<td><?php echo $TuneB." minutes";?></td>
					</tr>
					<tr>
						<th>เวลาที่บันทึก</th>
						<td><?php echo $datetime;?></td>
					</tr>
					
					
					<?php
					/*
					<tr>
						<th>Intercept</th>
						<td><?php echo $Intercept;?></td>
					</tr>
					<tr>
						<th>Coef1</th>
						<td><?php echo $Coef1;?></td>
					</tr>
					<tr>
						<th>Coef2</th>
						<td><?php echo $Coef2;?></td>
					</tr>
					<tr>
						<th>Coef3</th>
						<td><?php echo $Coef3;?></td>
					</tr>
					<tr>
						<th>Coef4</th>
						<td><?php echo $Coef4;?></td>
					</tr>
					<tr>
						<th>Coef5</th>
						<td><?php echo $Coef5;?></td>
					</tr>
					<tr>
						<th>Coef6</th>
						<td><?php echo $Coef6;?></td>
					</tr>
					<tr>
						<th>Coef7</th>
						<td><?php echo $Coef7;?></td>
					</tr>
					<tr>
						<th>Coef8</th>
						<td><?php echo $Coef8;?></td>
					</tr>
					<tr>
						<th>Coef9</th>
						<td><?php echo $Coef9;?></td>
					</tr>
					<tr>
						<th>Coef10</th>
						<td><?php echo $Coef10;?></td>
					</tr>
					<tr>
						<th>Coef11</th>
						<td><?php echo $Coef11;?></td>
					</tr>
					<tr>
						<th>Coef12</th>
						<td><?php echo $Coef12;?></td>
					</tr>
					<tr>
						<th>Coef13</th>
						<td><?php echo $Coef13;?></td>
					</tr>
					<tr>
						<th>Coef14</th>
						<td><?php echo $Coef14;?></td>
					</tr>
					*/
					
					?>
				</table>
				
				
				<div class="w3-half">
					<a class="w3-btn w3-red w3-xlarge" href="edit_prediction_main.php"> แก้ไขสมการ &raquo;</a>
				</div>
				<tr>
				</tr>

			</div>	
			
			
			
			
		
			
			</div>
		</div>
	</div>
</body>
<!--set focus on the input-->
<script>
  document.getElementById('pre_id').focus();
</script>

</html>