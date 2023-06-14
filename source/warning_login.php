<?php
	session_start();
	if(!isset($_SESSION['c']))$_SESSION['c']='';
	if($_SESSION['c']==99){
		echo '
		<div class="w3-panel w3-red">
			<span onclick="this.parentElement.style.display=\'none\'" class="w3-closebtn">&times;</span>
			<h3>Username หรือ Password ผิดพลาด!</h3>
			<p>โปรดตรวจสอบ Username และ Password ที่กรอกอีกครั้ง</p>
		</div>';
	}
?>