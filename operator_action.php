<!DOCTYPE html>
<HTML>
<meta charset="UTF-8">
<title>Manage People</title>
<link rel="stylesheet" type="text/css" href="w3.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" type="text/css" href="source/progress_bar.css">
  <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</HEAD>

<BODY>
<?php
	//conect to database
	require("connection.php");
	// prevent dreamweaver error
	if(!isset($_GET['o_id'])){
		$_GET['o_id']='';
	}
	$o_id=$_GET['o_id'];
	if(!isset($_POST['action'])){
		$_POST['action']='';
		$action="edit";
	}else{
		$action=$_POST['action'];
	}
	if(!isset($_GET['time']))$_GET['time']=3;
	$time=$_GET['time'];
	// Header and sidenav import
	require("header.html");
?>

<?php
//select data
$query="SELECT * FROM Operator where o_id = '$o_id' ";
$result=odbc_exec($db,$query);
while($list=odbc_fetch_array($result))
{
	if($list['o_id']!=''){
	$o_id=$list['o_id'];
	$o_name = iconv("TIS-620", "UTF-8", $list['o_name']);
	$o_type=$list['o_type'];
	$birthdate=$list['birthdate'];
	$address=iconv("TIS-620", "UTF-8",$list['address']);
	$parttime=$list['parttime'];
	}
}
?>

	<div class="w3-container w3-section">
		<div class="w3-container w3-card-2 w3-center">
			<h2 class="w3-border-bottom">
			<A class="w3-btn w3-left w3-white w3-xlarge" HREF="operator.php?time=<?php echo $time;?>"> &laquo; กลับ</A>
				<?php
					//Echo heading
				if ($action=='edit'){
					$new_id="";
					echo "แก้ไขรายชื่อพนักงาน";
				}else {
					$result=odbc_exec($db,"SELECT COUNT(o_id)+1 AS MaxID FROM operator");
					if($list=odbc_fetch_array($result)){
						$new_id=$list['MaxID'];
					}
					echo "เพิ่มรายชื่อพนักงาน";
					$o_id="0".$new_id;
					$o_name="";
					$o_type=1;
					$birthdate="";
					$address="";
					$parttime=$time;
				}
				?>
			</h2>
		<FORM class="w3-center w3-section" METHOD=POST ACTION="operator_success.php?time=<?php echo $time;?>">
			<TABLE class="w3-table w3-center" style="width: 500px; margin: auto">
				<tr>
					<td>รหัสพนักงาน<br><span class="w3-small w3-text-gray">part time ใช้รหัสประจำตัวประชาชน</span></td>
					<td><?php if($action=='edit')echo  "<input class='w3-input' type='text' name='new_id' value=".$o_id."><INPUT TYPE='hidden' name='o_id' value=".$o_id.">" ; else echo "<input class='w3-input' type='text' name='o_id' value=".$o_id.">" ; ?> </td>
				</tr>
				<tr>
					<td>ชื่อ-สกุล<br></td>
					<td><input class='w3-input' type="text" name="o_name" value="<?php echo $o_name;?>"></td>
				</tr>
				<tr>
					<td>งานที่ทำ<br></td>
					<td><select class='w3-select' name=o_type value='1'></option>
					<?php
						if ($o_type==1)
						echo "<option value='1'>Picking</option>
							<option value='2'>Decocting</option>
							<option value='3'>Dispensing</option>
							</select>";
						else
						echo "<option value='1'>Picking</option>
							<option value='2'>Decocting</option>
							<option value='3'>Dispensing</option>
							</select>";
					?></td>
				</tr>
					<tr>
					<td>วันเกิด<br></td>
					<td><input class='w3-input' type="date" id="dateInput"  name="birthdate"  value="<?php echo date('Y-m-d', $birthdate); ?>" >
             	</td>
				</tr>
				<tr>
					<td>ที่อยู่<br></td>
					<td><input class='w3-input' type="text" name="address" value="<?php echo $address;?>"></td>
				</tr>
				<tr>
					<td>สัญญาจ้าง<br></td>
					<td><select class='w3-select' name=parttime value='1'></option>
					<?php
						if($time==$parttime){
							if ($parttime==1)
							echo "<option value='1'>Full-Time</option>
								<option value='2'>Part-Time</option>
								</select>";
							else
							echo "
								<option value='2'>Part-Time</option>
								<option value='1'>Full-Time</option>
								</select>";
						}
					?></td>
				</tr>
			</TABLE>
			<INPUT TYPE='hidden' name='action' value='<?php echo $action;?>'></INPUT>
			<INPUT class="w3-btn w3-green w3-large w3-padding-12" TYPE='submit' value='ยืนยัน'></INPUT>
			<INPUT class="w3-btn w3-light-gray w3-large" TYPE="reset" value="เริ่มใหม่"></INPUT>
		</div>
	</div>


<!--Form send data-->



</body>
</html>