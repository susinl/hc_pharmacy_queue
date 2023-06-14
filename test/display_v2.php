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
        require("source/display_functions_v2.php");
        require ('function.php');
        $fin = find_fin_array(); //เช็คทุกคนที่ไม่ใช่อันสุดท้ายและยกเลิก
        $wip = find_wip_array();
        date_default_timezone_set("Etc/GMT-7");
		$today = date("Y-m-d");
		$language = "th";
		//$refresh_time = refresh_time($db, $today);

    ?>
    <div id="top"></div>
    <div class="w3-row-padding" style="height: 720px;">
    	<!-- Finished Queue -->
        <div class="w3-col l5 w3-card" style="height: 100%;">

            <h1 class="w3-center w3-red w3-xxxlarge"><i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;เชิญรับยา (Finished) </h1>


            <!-- ยาต้ม -->
            <div class="w3-animate-right mySlides">
	            <h1 class="w3-center">โรงพยาบาลต้มให้ (A)</h1>
	            <table class="w3-table w3-striped-red w3-xxxlarge">
	            <?php 
			        //ต้องเรียกใช้จาก source/display_fuction ที่ function finish_table($db, $fin_s_id, $fin, $today, $title){ 
					// ใช้แสดงคิวที่เสร็จแล้ว ต้องใส่ค่อ 
					//$fin_s_id ซึ่งคือ id ที่แปลว่าพร้อมจ่ายยา, $title เป็นชื่อหัวข้อของตาราง, $today เป็นวันที่อยู่ใน format 'yyyy-mm-dd'
		            finish_table($db, 15, $fin, $today, 'โรงพยาบาลต้มให้ (A)');
	            ?>
	        	</table>
	        </div>

	        <!-- ยาจัด -->
            <div class="w3-animate-right mySlides">
	            <h1 class="w3-center">ต้มเอง (B)</h1>
	            <table class="w3-table w3-striped-red w3-xxxlarge">
	            <?php 
		            finish_table($db, 23, $fin, $today, 'ต้มเอง (B)');
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
		            finish_table($db, 40, $fin, $today, 'ยาสำเร็จรูป (D)');
	            ?>
	        	</table>
	        </div>
	    </div>



		<!-- Status -->
        <div class="w3-col l7 w3-card" style="height: 100%;">

            <h1 class="w3-center w3-blue"><i class="fa fa-cogs" aria-hidden="true"></i>&nbsp;กำลังเตรียม (Preparing) </h1>

            <!-- ยาต้ม -->
            <div class="w3-animate-right mySlides2">
                <h1 class="w3-center"> โรงพยาบาลต้มให้ (A)</h1>
                <h2 class="w3-center"><?php type_process(1); ?></h2>
                <table class="w3-table w3-center w3-padding w3-striped-blue w3-xxxlarge">
                    <tr class="w3-blue w3-xxlarge">
                        <th>คิว</th>
                        <th>เสร็จเวลา</th>
                        <th>สถานะ</th>
                    </tr>
                <?php 
                	$fin_s_id = 15;
                	$collected_s_id = 16;
                    $cancle_s_id = 101;
                	$t_id = 1;
                	$title = "โรงพยาบาลต้มให้ (A)";
                	display_status($db, $fin_s_id, $collected_s_id, $cancle_s_id, $t_id, $title, $today, $language);
                ?>
                </table>
            </div>

            <!-- ยาจัด -->
            <div class="w3-animate-right mySlides2">
                <h1 class="w3-center"> ต้มเอง (B)</h1>
                <h2 class="w3-center"><?php type_process(2); ?></h2>
                <table class="w3-table w3-center w3-padding w3-striped-blue w3-xxxlarge">
                    <tr class="w3-blue w3-xxlarge">
                        <th>คิว</th>
                        <th>เสร็จเวลา</th>
                        <th>สถานะ</th>
                    </tr>
                <?php 
                	$fin_s_id = 23;
                	$collected_s_id = 24;
                    $cancle_s_id = 201;
                	$t_id = 2;
                	$title = "ต้มเอง (B)";
                	display_status($db, $fin_s_id, $collected_s_id, $cancle_s_id, $t_id, $title, $today, $language);
                ?>
                </table>
            </div>

            <!-- เคอลี่ -->
            <div class="w3-animate-right mySlides2">
                <h1 class="w3-center"> เคอลี่ (C)</h1>
                <h2 class="w3-center"><?php type_process(3); ?></h2>
                <table class="w3-table w3-center w3-padding w3-striped-blue w3-xxxlarge">
                    <tr class="w3-blue w3-xlarge">
                        <th>คิว</th>
                        <th>เสร็จเวลา</th>
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
        var fin_end = 0;
        var status_end = 0;
        carousel();
        carousel2();

        function carousel() {
            var i;
            var x = document.getElementsByClassName("mySlides");
            for (i = 0; i < x.length; i++) {
               x[i].style.display = "none";  
            }
            myIndex++;
            if (myIndex > x.length) {myIndex = 1; fin_end = 1;}    
            x[myIndex-1].style.display = "block";  
            if (fin_end == 1 && status_end == 1){
                location.reload(true);
                //location.assign("display_eng.php");
            }
            setTimeout(carousel, 16000); // Change image every 2 seconds
        }

        function carousel2() {
            var j;
            var y = document.getElementsByClassName("mySlides2");
            for (j = 0; j < y.length; j++) {
               y[j].style.display = "none";  
            }
            myIndex2++;
            if (myIndex2 > y.length) {myIndex2 = 1; status_end = 1;}    
            y[myIndex2-1].style.display = "block";  
            setTimeout(carousel2, 8000); // Change image every 2 seconds
        }
    </script>

</body>
</html>