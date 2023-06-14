<?php
	session_start();
	if(!isset($_SESSION['c']))$_SESSION['c']='';
	if($_SESSION['c']==1){
		echo '
		<div class="w3-panel w3-red">
			<span onclick="this.parentElement.style.display=\'none\'" class="w3-closebtn">&times;</span>
			<h3>ไม่พบใบยา!</h3>
			<p>โปรดตรวจสอบรหัสใบยาที่กรอกอีกครั้ง</p>
		</div>';
	}elseif($_SESSION['c']==2){
		echo '
		<div class="w3-panel w3-red">
			<span onclick="this.parentElement.style.display=\'none\'" class="w3-closebtn">&times;</span>
			<h3>ใบยาถูกยกเลิกไปแล้ว!</h3>
			<p>โปรดตรวจสอบรหัสใบยาที่กรอกอีกครั้ง</p>
		</div>';
	}elseif($_SESSION['c']==201){
		echo '
		<div class="w3-panel w3-red">
			<span onclick="this.parentElement.style.display=\'none\'" class="w3-closebtn">&times;</span>
			<h3>กรุณาจัดยาให้เสร็จก่อน!</h3>
			<p>เมื่อจัดยาเสร็จแล้ว (สถานะเป็นจัดยาเสร็จ หรือจ่ายยาแล้ว) ค่อยนำใบยามายิงเพื่อต้มยาจัด</p>
		</div>';
	}
	$_SESSION['c']=0;
?>