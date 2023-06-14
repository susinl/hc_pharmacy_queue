<!DOCTYPE html>
<HTML>
<HEAD>
<TITLE> Day Summary </TITLE>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="w3.css">
<link rel="stylesheet" type="text/css" href="source/progress_bar.css">
<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="source/plotly/plotly-latest.min.js"></script>

</HEAD>
<BODY>
		<?php 
			//Get datetime
			if(!isset($_GET['c_date'])) $_GET['c_date'] = date("Y-m-d");
			$c_date = $_GET['c_date'];

			//HeaderNav
			require('header.html');	 
			require('connection.php');
		?>
		

		<content class="w3-section w3-container">
      		<!-- row1 ชื่อหน้า -->
			<div class="w3-row w3-border-bottom">
				<div class="w3-third">
					<a class="w3-btn w3-white w3-xlarge" href="manager_page.php"> &laquo; กลับ</a>
				</div>
				<div class="w3-third w3-center w3-center w3-xxlarge">
					<i class="fa fa-bar-chart" aria-hidden="true"></i>&nbsp;สรุปข้อมูลรายวัน
				</div>
				<div class="w3-third">
				</div>
			</div>

			<!-- row2 ขั้นแถวไหมส่วน content -->
			<div class="w3-row-padding">
				<!-- Left column -->
				<div class="w3-quarter w3-container w3-margin-bottom w3-section w3-card-2">
					<h2 class="w3-crnter">สรุป</h2>
				<table class="w3-table-all w3-margin-top w3-margin-bottom">
					<tr>
						<th>ชนิดยา</th>
						<th>จำนวนใบยา</th>
					</tr>
					<?php
						// Find number of prescription that occure in the specified period.
						$query = "
							SELECT p.t_id, t.t_name,
								count(p.pre_id) as [count]
							 from ieproject.dbo.prescription as p inner join ieproject.dbo.[type] as t on p.t_id = t.t_id
							 WHERE p.in_datetime > '$c_date'
									AND p.in_datetime <= dateadd(day, 1, '$c_date')
							 GROUP BY p.t_id,  t.t_name
							 ORDER BY p.t_id;";
						$result = odbc_exec($db, $query);
						$sum = 0;
						while($list = odbc_fetch_array($result)){
							$t_name = iconv("TIS-620", "UTF-8", $list['t_name']);
							$count = $list['count'];
							$sum += $count;
							echo 
							"<tr>
								<td>$t_name</td>
								<td>$count</td>
							</tr>";
						}
						echo 
							"<tr>
								<th>รวม</th>
								<th>$sum</th>
							</tr>";
					?>
				</table>	
				
					<h2 class="w3-center">จำนวนพนักงาน</h2>
					<table class="w3-table-all w3-large w3-margin-bottom">
						<TR>
							<TH>ชนิด</TH>
							<TH>จำนวน</TH>
						</TR>
						<tr>
	 						 <td>พนักงานจัดยา</td>
	 						 <td>XXX</td> 
						</tr>
						<tr>
	 						 <td>พนักงานต้มยา</td>
	 						 <td>XXX</td>
						</tr>
						<tr>
	 						 <td>รวม</td>
	 						 <td>XXX</td>
						</tr>
					</table>	

<!-- 					<h2 class="w3-center">เวลารอแต่ละขั้นตอน</h2>
					
							<div class="w3-container">
								<A class="w3-btn-block w3-leftbar w3-xlarge w3-pale-green w3-margin-bottom w3-margin-top w3-padding-12" HREF="summarydaytype1.php">ยาต้ม</A><br>
						  		<A class="w3-btn-block w3-leftbar w3-xlarge w3-pale-green w3-margin-bottom w3-margin-top w3-padding-12" HREF="summarydaytype2.php">ยาจัด</A><br>
						  		<A class="w3-btn-block w3-leftbar w3-xlarge w3-pale-green w3-margin-bottom w3-margin-top w3-padding-12" HREF="summarydaytype3.php">ยาเคอลี่</A><br>
				       </div> -->

				</div>	


				<!-- Right Column -->
				<div class="w3-container w3-rest w3-margin-bottom">

					<!-- Date Selection Form -->
					<div class="w3-container w3-center w3-card-2 w3-section">	
						<form class="w3-section" method=get name=f1 action='summaryday.php'>	
							<label class="w3-large"><i class="fa fa-search" aria-hidden="true"></i> &nbsp;วันที่</lable>
							<input class="w3-input w3-large w3-border w3-margin-top w3-margin-bottom" type="date" name="c_date" required value=<?php echo $c_date; ?> style="margin: auto; max-width: 400px;" >
							<input class="w3-btn-block w3-blue" style="margin: auto; max-width: 400px;" type="submit" value="ตกลง">
						</form>
					</div>

					<!-- Entering count by hour -->
					<div class="w3-container w3-card-2 w3-section">	
						<h2 class="w3-center">จำนวนใบยาที่เข้ามาในระบบ</h2>
						<div id="enteringGraph" style="margin: auto; height: 300px; max-width: 600px;"></div>
	   				</div>

	   				<!-- Waiting time of Decocting medicine by time -->
	   				<div class="w3-container w3-card-2 w3-section">	
						<h2 class="w3-center">เวลารอ - ยาต้ม</h2>
						<div id="decoctWaiting" style="margin: auto; height: 300px; max-width: 600px;"></div>
	   				</div>

	   				<!-- Waiting time of self decoct medicine by time -->
	   				<div class="w3-container w3-card-2 w3-section">	
						<h2 class="w3-center">เวลารอ - ยาจัด</h2>
						<div id="selfWaiting" style="margin: auto; height: 300px; max-width: 600px;"></div>
	   				</div>
					
				</div>
				
			</div>
		</content>












<!-- Generate Graph -->
	<script>
		<?php 
			//require "connection.php";
		?>

		//1. enteringGraph Ploting
			//1.1 Get Data From database for "enteringGraph"
			<?php
				
				$h=array();
				$count=array();
				$query = "SELECT a.h, count(a.pre_id) as count
							FROM (SELECT pre_id, datepart("."hh".", in_datetime) as h 
									FROM [ieproject].[dbo].[prescription] 
									WHERE in_datetime > '$c_date'
                						AND in_datetime <= dateadd(day, 1, '$c_date')
                				) as a 
							GROUP BY a.h
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

			//1.2 Set ploting parameters of enteringGraph
			var g1 = document.getElementById('enteringGraph');
			var g1Layout = {
		      yaxis: {title: "จำนวนใบยาที่เข้าระบบ"},
		      xaxis: {title: "เวลาเข้าระบบ"},
		      margin: {t: 0 }
			}
			var g1Data = [{
				x: <?php echo $h ;?>,
				y: <?php echo $count ;?>,
				type: 'bar'
			}];

			//1.3 plot enteringGraph
			Plotly.plot( g1, g1Data, g1Layout );

		//2. decoctWaiting Ploting
			//1.1 Get Data From database for "enteringGraph"
			<?php
				$h2=array();
				$dwt=array();
				$query = "SELECT a.h, AVG(a.duration) as dwt
						FROM (SELECT ps.pre_id, datepart("."hh".", p.in_datetime) as h, ps.duration
								FROM [ieproject].[dbo].[psrel]  as ps inner join [ieproject].[dbo].[prescription] as p on ps.pre_id = p.pre_id
								WHERE p.in_datetime > '$c_date'
									AND p.in_datetime <= dateadd(day, 1, '$c_date')
									AND ps.s_id = 10
							) as a 
						GROUP BY a.h
						order by a.h;";
				$result = odbc_exec($db, $query);
				$i=0;
				while($list = odbc_fetch_array($result)){
					$h2[$i]=$list['h'];
					$dwt[$i]=$list['dwt'];
					$i=$i+1;
				}
				$h2 = json_encode($h2);
				$dwt = json_encode($dwt);
			?>

			//1.2 Set ploting parameters of enteringGraph
			var g2 = document.getElementById('decoctWaiting');
			var g2Layout = {
		      yaxis: {title: "เวลารอจัดเฉลี่ย (นาที)"},
		      xaxis: {title: "เวลาเข้าระบบ"},
		      margin: {t: 0 }
			}
			var g2Data = [{
				x: <?php echo $h2 ;?>,
				y: <?php echo $dwt ;?>,
				type: 'bar'
			}];

			//1.3 plot enteringGraph
			Plotly.plot( g2, g2Data, g2Layout );


		//3. selfWaiting Ploting
			//1.1 Get Data From database for "selfWaiting"
			<?php
				$h3=array();
				$swt=array();
				$query = "SELECT a.h, AVG(a.duration) as swt
						FROM (SELECT ps.pre_id, datepart("."hh".", p.in_datetime) as h, ps.duration
								FROM [ieproject].[dbo].[psrel]  as ps inner join [ieproject].[dbo].[prescription] as p on ps.pre_id = p.pre_id
								WHERE p.in_datetime > '$c_date'
									AND p.in_datetime <= dateadd(day, 1, '$c_date')
									AND ps.s_id = 20
							) as a 
						GROUP BY a.h
						order by a.h;";
				$result = odbc_exec($db, $query);
				$i=0;
				while($list = odbc_fetch_array($result)){
					$h3[$i]=$list['h'];
					$swt[$i]=$list['swt'];
					$i=$i+1;
				}
				$h3 = json_encode($h3);
				$swt = json_encode($swt);
			?>

			//1.2 Set ploting parameters of selfWaiting
			var g3 = document.getElementById('selfWaiting');
			var g3Layout = {
		      yaxis: {title: "เวลารอจัดเฉลี่ย (นาที)"},
		      xaxis: {title: "เวลาเข้าระบบ"},
		      margin: {t: 0 }
			}
			var g3Data = [{
				x: <?php echo $h3 ;?>,
				y: <?php echo $swt ;?>,
				type: 'bar'
			}];

			//1.3 plot enteringGraph
			Plotly.plot( g3, g3Data, g3Layout );
			

	</script>


</BODY>
</HTML>
