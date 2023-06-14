<?php
	function add_chinese($text){
		$chineses ="";
		$result ="";
		if($text == "รอจัด") $chineses = "等待配药";
		if($text == "จัดยา") $chineses = "配药";
		if($text == "รอต้ม") $chineses = "等待煎药";
		if($text == "ต้ม") $chineses = "煎药";
		if($text == "ต้มเสร็จ") $chineses = "煎药完成";
		if($text == "รอจ่ายยา") $chineses = "等待发药";
		if($text == "รับยาแล้ว") $chineses = "已发药";
		if($text == "ยกเลิก") $chineses = "删除";
		if($text == "hold") $chineses = "保存";
		if($text == "จัดยาเสร็จ") $chineses = "配药完成";
		$result =$text." <br>(".$chineses.")";
		return $result;
	}
?>