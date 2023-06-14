<!DOCTYPE html>
<html>
<title>คิวรับยา</title>
<meta charset="UTF-8">
<!-- <link rel="stylesheet" type="text/css" href="source/progress_bar.css"> -->
<link rel="stylesheet" type="text/css" href="w3.css">
<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="source/progress_bar.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
.mySlides {display:none;}
.mySlides2 {display:none;}

.w3-striped-blue tbody tr:nth-child(even){background-color:#e6ffff;}
.w3-striped-red tbody tr:nth-child(even){background-color:#ffe6e6;}
</style>
<body>
    <?php
    	//header('refresh: 120; url=display_eng.php');
        require("connection.php"); 
        require("source/display_functions.php");
        require ('function.php');
        $fin = find_fin_array(); //เช็คทุกคนที่ไม่ใช่อันสุดท้ายและยกเลิก
        $wip = find_wip_array();
        date_default_timezone_set("Etc/GMT-7");
		$today = date("Y-m-d");
		$language = "th";
		//$refresh_time = refresh_time($db, $today);

    ?>
    <div class="w3-section w3-row-padding" style="height: 700px;">
    	<!-- Finished Queue -->
        <div class="w3-col l5 w3-card" style="height: 100%;">

            <h1 class="w3-center w3-red"><i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;เชิญรับยา (Finished) </h1>


            <!-- ยาต้ม -->
            <div class="w3-animate-right mySlides">
	            <h1 class="w3-center">ยาต้ม (A)</h1>
	            <table class="w3-table w3-striped-red w3-xxxlarge">
	            <?php 
			        //ต้องเรียกใช้จาก source/display_fuction ที่ function finish_table($db, $fin_s_id, $fin, $today, $title){ 
					// ใช้แสดงคิวที่เสร็จแล้ว ต้องใส่ค่อ 
					//$fin_s_id ซึ่งคือ id ที่แปลว่าพร้อมจ่ายยา, $title เป็นชื่อหัวข้อของตาราง, $today เป็นวันที่อยู่ใน format 'yyyy-mm-dd'
		            finish_table($db, 15, $fin, $today, 'ยาต้ม (A)');
	            ?>
	        	</table>
	        </div>

	        <!-- ยาจัด -->
            <div class="w3-animate-right mySlides">
	            <h1 class="w3-center">ยาจัด (B)</h1>
	            <table class="w3-table w3-striped-red w3-xxxlarge">
	            <?php 
		            finish_table($db, 23, $fin, $today, 'ยาจัด (B)');
	            ?>
	        	</table>
	        </div>

	        <!-- ยาเคิลี่ -->
            <div class="w3-animate-right mySlides">
	            <h1 class="w3-center">ยาเคอลี่ (C)</h1>
	            <table class="w3-table w3-striped-red w3-xxxlarge">
	            <?php 
		            finish_table($db, 32, $fin, $today, 'ยาเคอลี่ (C)');
	            ?>
	        	</table>
	        </div>

	        <!-- ยาสำเร็จรูป -->
	        <div class="w3-animate-right mySlides">
	            <h1 class="w3-center">ยาสำเร็จรูป (D)</h1>
	            <table class="w3-table w3-striped-red w3-xxxlarge">
	            <?php 
		            finish_table($db, 32, $fin, $today, 'ยาสำเร็จรูป (D)');
	            ?>
	        	</table>
	        </div>
	    </div>



		<!-- Status -->
        <div class="w3-col l7 w3-card" style="height: 100%;">

            <h1 class="w3-center w3-blue"><i class="fa fa-cogs" aria-hidden="true"></i>&nbsp;กำลังเตรียม (Preparing) </h1>

            <!-- ยาต้ม -->
            <div class="w3-animate-right mySlides2">
                <h1 class="w3-center"> ยาต้ม (A)</h1>
                <h2 class="w3-center"><?php type_process(1); ?></h2>
                <table class="w3-table w3-center w3-padding w3-striped-blue w3-xxxlarge">
                    <tr class="w3-blue w3-medium">
                        <th>คิว</th>
                        <th>รับได้เวลาประมาณ</th>
                        <th>สถานะ</th>
                    </tr>
                <?php 
                	$fin_s_id = 15;
                	$collected_s_id = 16;
                    $cancle_s_id = 101;
                	$t_id = 1;
                	$title = "ยาต้ม (A)";
                	$query1 = "SELECT p.pre_id, p.q_id, q.q_name, p.finishtime, p.s_id, s.s_display_thai, s.s_display, p.in_datetime, p.t_id
                    FROM ieproject.dbo.prescription as p, ieproject.dbo.queue as q, status as s
                    WHERE p.q_id = q.q_id 
                    AND p.s_id = s.s_id
                    AND p.in_datetime > '$today' 
                    AND p.in_datetime <= dateadd(day, 1, '$today') 
                    AND p.s_id != '$fin_s_id'
                    AND p.s_id != '$collected_s_id'
                    AND p.s_id != '$cancle_s_id'
                    AND p.t_id = '$t_id'
                        ORDER BY p.q_id;";
        $result = odbc_exec($db, $query1);
        // เขียนเรื่องให้มันไปอีกหน้าถ้าล้น
        $item = 1; //ตอนนี้กำลังจะพิมพ์ตัวที่ item ใน 1 แถวจะมี 3 ตัว ใน 1 หน้ามี 18 ตัว
        while ($list = odbc_fetch_array($result)){ //ดึงแถวแรกออกมา
            $pre_id = $list['pre_id'];
            $q_id = $list['q_id'];
            $q_name = $list['q_name'];
            // $finishtime = $list['finishtime'];
            $in_datetime = $list['in_datetime'];
            $t_id = $list['t_id'];
            $s_id = $list['s_id'];
            $s_display = $list['s_display'];
            $s_display_thai = iconv('TIS-620', 'UTF-8', $list['s_display_thai']);
            //2.
            //if(in_array($pre_id, $wip)){
                //3.ถ้าเป็นตัวที่ขึ้นหน้าใหม่ ปิดตาราง div และขึ้น div ใหม่
                $mod5 = $item%5;
                if($mod5 == 1 && $item != 1){ //ขึ้นหน้าใหม่ถ้าตัวต่อไปที่จะพิมพ์ ถ้า mod5 = 1 ก็คืเอเป็นตัวแรกของหน้า
                    // ปิด table, div ที่เป็น slide
                    echo    "   </table>
                            </div>";
                    // เปิด div เขียนชนิดยา เปิดตาราง และหัวข้อ
                    echo    
                    '<div class="w3-animate-right mySlides2">
                        <h1 class="w3-center">'.$title.'</h1>
                        <h2 class="w3-center">';
                    type_process($t_id);
                    echo '</h2>
                        <table class="w3-table w3-center w3-padding w3-striped-blue w3-xxxlarge">
                            <tr class="w3-blue w3-medium">
                                <th>คิว</th>
                                <th>รับได้เวลาประมาณ</th>
                                <th>สถานะ</th>
                            </tr>';
                }

                //4.พิมพ์ยาตัวนี้
                //าษาอังกฤษ
                if($language == "eng"){
                    $in_time = strtotime($in_datetime);
                    if ($in_time >= strtotime('14:30:00') && $t_id =1){
                        $s_display = "Next day";
                    }
                    echo 
                    '<tr>
                        <th>'.$q_name.'</th>
                        <td>'.date('h:m:s', $in_datetime).'</td>
                        <td>'.$s_display.'</td>
                    </tr>
                    ';
                }
                if($language == "th"){
                    $in_time = strtotime($in_datetime);
                    if ($in_time >= strtotime('14:30:00') && $t_id =1){
                        $s_display_thai = "โปรดรับวันรุ่งขึ้น";
                    }
                    echo 
                    '<tr>ß
                        <th>'.$q_name.'</th>
                        <td>'.date("H:i",$in_time).'</td>
                        <td>'.$s_display_thai.'</td>
                    </tr>
                    ';
                    $item++;
                }
            //}
        }
                ?>
                </table>
            </div>

            <!-- ยาจัด -->
            <div class="w3-animate-right mySlides2">
                <h1 class="w3-center"> ยาจัด (B)</h1>
                <h2 class="w3-center"><?php type_process(2); ?></h2>
                <table class="w3-table w3-center w3-padding w3-striped-blue w3-xxxlarge">
                    <tr class="w3-blue w3-medium">
                        <th>คิว</th>
                        <th>รับได้เวลาประมาณ</th>
                        <th>สถานะ</th>
                    </tr>
                <?php 
                	$fin_s_id = 23;
                	$collected_s_id = 24;
                    $cancle_s_id = 201;
                	$t_id = 2;
                	$title = "ยาจัด (B)";
                	display_status($db, $fin_s_id, $collected_s_id, $cancle_s_id, $t_id, $title, $today, $language);
                ?>
                </table>
            </div>

            <!-- ยาจัด -->
            <div class="w3-animate-right mySlides2">
                <h1 class="w3-center"> เคอลี่ (C)</h1>
                <h2 class="w3-center"><?php type_process(3); ?></h2>
                <table class="w3-table w3-center w3-padding w3-striped-blue w3-xxxlarge">
                    <tr class="w3-blue w3-medium">
                        <th>คิว</th>
                        <th>รับได้เวลาประมาณ</th>
                        <th>สถานะ</th>
                    </tr>
                <?php 
                	$fin_s_id = 32;
                	$collected_s_id = 33;
                    $cancle_s_id = 301;
                	$t_id = 3;
                	$title = "เคอลี่ (C)";
                	display_status($db, $fin_s_id, $collected_s_id, $cancle_s_id, $t_id, $title, $today, $language);
                ?>
                </table>
            </div>

        </div>
    
    </div>

    <script>
        var myIndex = 0;
        var myIndex2 = 0;
        carousel();
        carousel2();

        function carousel() {
            var i;
            var x = document.getElementsByClassName("mySlides");
            for (i = 0; i < x.length; i++) {
               x[i].style.display = "none";  
            }
            myIndex++;
            if (myIndex > x.length) {myIndex = 1}    
            x[myIndex-1].style.display = "block";  
            setTimeout(carousel, 7000); // Change image every 2 seconds
        }

        function carousel2() {
            var j;
            var y = document.getElementsByClassName("mySlides2");
            for (j = 0; j < y.length; j++) {
               y[j].style.display = "none";  
            }
            myIndex2++;
            if (myIndex2 > y.length) {myIndex2 = 1}    
            y[myIndex2-1].style.display = "block";  
            setTimeout(carousel2, 7000); // Change image every 2 seconds
        }
    </script>

</body>
</html>