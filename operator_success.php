<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
<HEAD>
<TITLE>รายงานผล </TITLE>
<META NAME="Generator" CONTENT="EditPlus">
<META NAME="Author" CONTENT="">
<META NAME="Keywords" CONTENT="">
<META NAME="Description" CONTENT="">
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="w3.css">
<meta name="viewport" content="width=device-width, initial-scale=1">

</HEAD>

<BODY>

<?php 
require("connection.php");
require('header.html');
if(!isset($_GET['time']))$_GET['time']=3;
$time=$_GET['time'];
?>



<div class="w3-row w3-container w3-card-2 w3-section"  style="width: 75%; margin: auto;">
		<div class="w3-container w3-border-bottom">
			<h1 class="w3-center">
				<?php 
				// Echo heading
					if(!isset($_POST['o_id']))$_POST['o_id']='';
					$o_id=$_POST['o_id'];
					if(!isset($_POST['new_id']))$_POST['new_id']='';
					$new_id=$_POST['new_id'];
					if(!isset($_POST['action']))$_POST['action']='';
					$action = $_POST['action'];
					if($action=="add")
					{
						$o_id=$_POST['o_id'];
						$o_name = iconv("UTF-8", "TIS-620", $_POST['o_name']);
						$o_type=$_POST['o_type'];
						$birthdate=$_POST['birthdate'];
						$address=iconv("UTF-8", "TIS-620",$_POST['address']);
						$parttime=$_POST['parttime'];
						$query ="INSERT INTO Operator (o_id,o_name,o_type,birthdate,address,parttime)  VALUES ('$o_id','$o_name','$o_type','$birthdate','$address','$parttime')";
						odbc_exec($db,$query);
						echo "เพิ่มรายชื่อพนักงานสำเร็จ";
					}
					if($action=='edit')
					{
						$o_name = iconv("UTF-8", "TIS-620", $_POST['o_name']);
						$o_type=$_POST['o_type'];
						$birthdate=$_POST['birthdate'];
						$address=iconv("UTF-8", "TIS-620", $_POST['address']);
						$parttime=$_POST['parttime'];
						$query="UPDATE Operator SET o_id='$new_id', o_name='$o_name',o_type='$o_type',birthdate='$birthdate',address='$address',parttime='$parttime' WHERE o_id='$o_id' ";
						odbc_exec($db,$query);
						echo "แก้ไขรายชื่อพนักงานสำเร็จ";
						$o_id=$new_id;
					}


					$query="SELECT * FROM Operator where o_id = '$o_id' ";
					$result=odbc_exec($db,$query);

					while($list=odbc_fetch_array($result))
					{
						if($list['o_id']!=0){
						$o_id=$list['o_id'];
						$o_name = iconv("TIS-620", "UTF-8", $list['o_name']);
						$o_type=$list['o_type'];
						$birthdate=$list['birthdate'];
						$address=iconv("TIS-620", "UTF-8",$list['address']);
						$parttime=$list['parttime'];
						}
					}
					if($o_type==1)$type="Picking";
					if($o_type==2)$type="Decocting";
					if($o_type==3)$type="Dispensing";
					if($parttime==1)$part="Full-Time";
					else $part="Part-Time";
					
					
					?>
			</h1>
		</div>
		<div class="w3-row-padding">
			<div class="w3-twothird w3-container">
				<div class="w3-container w3-border-bottom">
					<h2>รายละเอียด</h2>
				</div>
				<TABLE class="w3-table">
					<tr>
							<td>Operator id</td>
							<td><?php echo $o_id ;?></td>
						</tr>
						<tr>
							<td>Operator name</td>
							<td><?php echo $o_name ;?></td>
						</tr>
						<tr>
							<td>Operator type</td>
							<td><?php echo $type ;?></td>
						</tr>
						<tr>
							<td>Birthdate</td>
							<td><?php echo $birthdate ;?></td>
						</tr>
						<tr>
							<td>Address</td>
							<td><?php echo $address ;?></td>
						</tr>
						<tr>
							<td>Contract</td>
							<td><?php echo $part ;?></td>
						</tr>
					</TABLE>
				
			</div>
			<div class="w3-third w3-container">
				<div class="w3-container">
					<h2 class="w3-text-white">สำเร็จ</h2>
				</div>
				<p><a id="confirm" class=" w3-btn w3-block w3-green w3-xxlarge" HREF="operator.php?time=<?php echo $time;?>">กลับ</a></p>
			 </div>
		</div>

	</div>






</body>
</html>