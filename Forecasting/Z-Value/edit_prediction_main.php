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
	error_reporting(E_ERROR | E_PARSE);
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
						FROM equation WHERE t_id='1' AND Version IN 
						( SELECT MAX(Version)
							FROM equation WHERE t_id='1'
						)";
				$result=odbc_exec($db,$query);
				if($list=odbc_fetch_array($result))
					{
						$Version_A=$list['Version'];
						$datetime_A=$list['datetime'];
						$TuneA=$list['Tune'];
						$Zvalue_A=round($list['Zvalue'],4);
					}
				$query="SELECT * 
						FROM equation WHERE t_id='2' AND Version IN 
						( SELECT MAX(Version)
							FROM equation WHERE t_id='2'
						)";
				$result=odbc_exec($db,$query);
				if($list=odbc_fetch_array($result))
					{
						$Version_B=$list['Version'];
						$datetime_B=$list['datetime'];
						$TuneB=$list['Tune'];
						$Zvalue_B=round($list['Zvalue'],4);
					}
				$query="SELECT * 
						FROM equation WHERE t_id='3' AND Version IN 
						( SELECT MAX(Version)
							FROM equation WHERE t_id='3'
						)";
				$result=odbc_exec($db,$query);
				if($list=odbc_fetch_array($result))
					{
						$Version_C=$list['Version'];
						$datetime_C=$list['datetime'];
						$TuneC=$list['Tune'];
						$Zvalue_C=round($list['Zvalue'],4);
					}
				
				
			?>
            <div class="w3-container">
			<h1 class="w3-left">รายละเอียดสมการล่าสุด</h1>
		</div>
			
			<div class="w3-half w3-container w3-large w3-card-2 w3-margin-right">
                
                <div class="w3-container w3-border-bottom">
					<h2>ยาต้ม</h2>
				</div>
				<table class="w3-table w3-margin-bottom">
					<tr>
						<th>Version</th>
						<td><?php echo $Version_A;?></td>
					</tr>
					<tr>
						<th>Zvalue</th>
						<td><?php echo $Zvalue_A;?></td>
					</tr>
					<tr>
						<th>เวลาเผื่อสำหรับยาต้ม</th>
						<td><?php echo $TuneA." minutes";?></td>
					</tr>
					<tr>
						<th>เวลาที่บันทึก</th>
						<td><?php echo $datetime_A;?></td>
					</tr>
                  </table>
                  
                 <div class="w3-container w3-border-bottom">
					<h2>ยาจัด</h2>
				</div>
                <table class="w3-table w3-margin-bottom">
					<tr>
						<th>Version</th>
						<td><?php echo $Version_B;?></td>
					</tr>
					<tr>
						<th>Zvalue</th>
						<td><?php echo $Zvalue_B;?></td>
					</tr>
					<tr>
						<th>เวลาเผื่อสำหรับยาจัด</th>
						<td><?php echo $TuneB." minutes";?></td>
					</tr>
					<tr>
						<th>เวลาที่บันทึก</th>
						<td><?php echo $datetime_B;?></td>
					</tr>
                  </table>
					
                <div class="w3-container w3-border-bottom">
					<h2>ยาเคอรี่</h2>
				</div>
                <table class="w3-table w3-margin-bottom">
					<tr>
						<th>Version</th>
						<td><?php echo $Version_C;?></td>
					</tr>
					<tr>
						<th>Zvalue</th>
						<td><?php echo $Zvalue_C;?></td>
					</tr>
					<tr>
						<th>เวลาเผื่อสำหรับยาจัด</th>
						<td><?php echo $TuneC." minutes";?></td>
					</tr>
					<tr>
						<th>เวลาที่บันทึก</th>
						<td><?php echo $datetime_C;?></td>
					</tr>
                  </table>


			</div>	
			
		<div class="w3-third w3-container">
					<div class="w3-container w3-border-bottom">
						<h2>ค่าใหม่ที่ต้องการ</h2>
					</div>
					<form class="w3-container w3-section" method="get" action="edit_prediction_update.php">

                     ประเภทยา : <br><br><select class="w3-form-control w3-large" name="t_id" type="int" id="t_id" required>
    <option disabled selected value> -- เลือกประเภทยา -- </option>
    <option value=1>ยาต้ม</option>
    <option value=2>ยาจัด</option>
    <option value=3>ยาเคอรี่</option>
  </select><br><br>
                    
					
						Z-value : <input class="w3-input w3-large" type="int" name="Zvalue" placeholder="Ex. 0.84 " id="Zvalue" required > <br>	
				
						เวลาเผื่อ(minute): <input class="w3-input w3-large" type="int" name="Tune" placeholder="Ex. -10,10 " id="TuneA" required > <br>
						
						
						<p><input class="w3-button w3-block w3-green w3-large" type="submit" ></a></p>
							
				</div>
			
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
        