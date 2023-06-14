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
		<div class="w3-card-2 w3-section" style="width:100%;">
			<div class="w3-container w3-border-bottom">
				<h1 class="w3-center">
					<i class="fa fa-hourglass" aria-hidden="true"></i>&nbsp;ปรับเปลี่ยนสมการ (修改时间方程)
				</h1>
			</div>
	
        
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
										
				$myDateTime_A = DateTime::createFromFormat('Y-m-d H:i:s.u', $datetime_A);
				$newDateString_A = $myDateTime_A->format('Y-m-d H:i:s');
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
						$myDateTime_B = DateTime::createFromFormat('Y-m-d H:i:s.u', $datetime_B);
				$newDateString_B = $myDateTime_B->format('Y-m-d H:i:s');
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
						$myDateTime_C = DateTime::createFromFormat('Y-m-d H:i:s.u', $datetime_C);
				$newDateString_C = $myDateTime_C->format('Y-m-d H:i:s');
					}

			?>
            

		<div class="w3-container">
			<h1 class="w3-center">รายละเอียดสมการล่าสุด</h1>
		</div>
     <div class="w3-row-padding">
        <div class="w3-container w3-third w3-large w3-card-2 w3-section">
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
                        
						<td><?php echo $newDateString_A;?></td>
					</tr>
                  </table>
          </div>
                  
          <div class="w3-container w3-third w3-large w3-card-2 w3-section w3-container">
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
						<td><?php echo $newDateString_B;?></td>
					</tr>
                  </table>
                
         	</div>
            
       		<div class="w3-rest w3-third w3-container w3-large w3-card-2 w3-section">
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
						<td><?php echo $newDateString_C;?></td>
					</tr>
                  </table> 
         	</div><br>
            <div class="w3-center w3-section">
					<a class="w3-btn w3-red w3-xlarge" href="edit_prediction_main.php"> แก้ไขสมการ &raquo;</a>
				</div>
				<tr>
				</tr>

			</div>	
            <br>
     </div>   
        
</div>
        
</body>

<!--set focus on the input-->
<script>
  document.getElementById('pre_id').focus();
</script>

</html>        
        