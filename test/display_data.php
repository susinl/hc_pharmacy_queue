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
        require("connection.php"); 
        require("pb/pb_display.php");
        require 'function.php';
        $fin = find_fin_array(); //เช็คทุกคนที่ไม่ใช่อันสุดท้ายและยกเลิก
        $wip = find_wip_array();
        date_default_timezone_set("Etc/GMT-7");
		$today = date("Y-m-d");

		function finish_table($db, $fin_s_id, $fin, $title){
            // Decoct Finished
            // 1. เลือกใบยาที่เสร็จแล้วออกมาจากระบบ
            // 2. ดึงแถวแรกออกมาแล้วเช็คว่าเป็นใบยาที่ต้องแสดงไหมจาก array ของยิม
            // 3. ดูว่าเสร็จทุกใบจริง ๆ แล้วยัง
            // 4. ถ้าเสร็จทุกใบแล้ว เอาไปพิมพ์ลงตาราง
            // 5. กลับไปเริ่มใหม่ที่ข้อ 2
        	//1.
        	$query1 = "SELECT p.pre_id, p.q_id, q.q_name 
						FROM ieproject.dbo.prescription as p, ieproject.dbo.queue as q 
						WHERE p.q_id = q.q_id 
						AND p.in_datetime > '$today' 
						AND p.in_datetime <= dateadd(day, 1, '$today') 
						AND p.s_id = $fin_s_id 
							ORDER BY p.q_id;";
        	$result = odbc_exec($db, $query1);
    	
         	// เขียนเรื่องให้มันไปอีกหน้าถ้าล้น
    		$item = 1; //ตอนนี้กำลังจะพิมพ์ตัวที่ item ใน 1 แถวจะมี 3 ตัว ใน 1 หน้ามี 18 ตัว

        	while ($list = odbc_fetch_array($result)){ //ดึงแถวแรกออกมา
        		$pre_id = $list['pre_id'];
        		$q_id = $list['q_id'];
        		$q_name = $list['q_name'];
        		//2.
        		//if(in_array($pre_id, $fin)){

            		//3.Check if there is any prescription with the same q_id that isn't finished.
            		$finished_all = 1;
            		$s_id_finish = array(15, 16, 23, 24, 32, 33, 40); //finish status
            		$query2 = "SELECT * FROM prescription where q_id = '$q_id';";
            		$result2 = odbc_exec($db, $query2);
            		while ($list2 = odbc_fetch_array($result2)) {
            			$check_s_id = $list2['s_id']; //ดูว่า s_id ของใบยาอื่น ๆ เสร็จหรือยัง
            			if (!in_array($check_s_id, $s_id_finish)){
            				$finished_all = 0;
            			}
            		}

            		//4.
            		if($finished_all==1){ //if all is finish
            			$mod3 = $item%3;
            			$mod18 = $item%18;
            			if($mod18 == 1 && $item != 1){ //ขึ้นหน้าใหม่ถ้าตัวต่อไปที่จะพิมพ์ ถ้า mod18 = 1 ก็คืเอเป็นตัวแรกของหน้า
		        			// ปิด table, div ที่เป็น slide
		        			echo 	"	</table>
		        					</div>";
		        			// เปิด div เขียนชนิดยา และเปิดตาราง
		        			echo 	
		        			'<div class="w3-animate-right mySlides">
		        				<h1 class="w3-center">$title</h3>
		            			<table class="w3-table w3-striped-red w3-xxxlarge">';
		        		}
            			
            			if($mod3 == 1){//ตัวแรกงของแถว
            				echo "<tr><td><b>".$q_name."</b></td>";
            				$item++;
            			}
            			if($mod3 == 2){//ตัวที่สองของแถว
            				echo "<td><b>".$q_name."</b></td>";
            				$item++;
            			}
            			if($mod3 == 0){
            				echo "<td><b>".$q_name."</b></td></tr>";
            				$item++;
            			}
            		}
            	//}
        	}

       		//พิพม์ครบแล้วต้องเช็คว่าอยู่ตัวที่เท่าไหร่จะได้ปิดตารางได้ครบ
        	$mod3 = $item%3;
        	if($mod3 == 1){ //ถ้าจะพิมพ์ตัวที่ 1 ของแถว ไม่ต้องปิดตารางเพราะเพิ่งปิดไป
			}
			else if($mod3 == 2){//เพิ่งพิมพ์ตัวแรกไปต้องพิมพ์อีก 2 ตัวเพื่อปิด
				echo "<td></td><td></td></tr>";
			}
			else if($mod3 == 0){ //พิมพ์ไปแล้ว 2 ตัวกำลังจะพิมพ์ตัวที่ 3 ดังนั้นต้องเอาอีก 1 ตัวแล้วค่อยปิด
				echo "<td></td></tr>";
			}
		}
    ?>
    <div class="w3-section w3-row-padding" style="height: 700px;">
    <!-- Finished Queue -->
        <div class="w3-col l5 w3-card" style="height: 100%;">

            <h1 class="w3-center w3-red"><i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;เชิญรับยา (Finish) </h1>

            <!-- ยาต้ม -->
            <div class="w3-animate-right mySlides">
	            <h1 class="w3-center">ยาต้ม (A)</h1>
	            <table class="w3-table w3-striped-red w3-xxxlarge">
	            <?php 
		            finish_table($db, 15, $fin, 'ยาต้ม (A)');
	            ?>
	        	</table>
	        </div>

	        <!-- ยาจัด -->
            <div class="w3-animate-right mySlides">
	            <h1 class="w3-center">ยาจัด (B)</h1>
	            <table class="w3-table w3-striped-red w3-xxxlarge">
	            <?php 
		            finish_table($db, 23, $fin, 'ยาจัด (B)');
	            ?>
	        	</table>
	        </div>

	        <!-- ยาเคิลี่ -->
            <div class="w3-animate-right mySlides">
	            <h1 class="w3-center">ยาเคอลี่ (C)</h1>
	            <table class="w3-table w3-striped-red w3-xxxlarge">
	            <?php 
		            finish_table($db, 32, $fin, 'ยาเคอลี่ (C)');
	            ?>
	        	</table>
	        </div>

	        <!-- ยาสำเร็จรูป -->
	        <div class="w3-animate-right mySlides">
	            <h1 class="w3-center">ยาสำเร็จรูป (D)</h1>
	            <table class="w3-table w3-striped-red w3-xxxlarge">
	            <?php 
		            finish_table($db, 32, $fin, 'ยาสำเร็จรูป (D)');
	            ?>
	        	</table>
	        </div>
	    </div>



<!-- Status -->
        <div class="w3-col l7 w3-card" style="height: 100%;">

            <h1 class="w3-center w3-blue"><i class="fa fa-cogs" aria-hidden="true"></i>&nbsp;กำลังเตรียม (Preparing) </h1>
    
    <!-- Status left half -->
            <!-- <div class="w3-half" style="height: 100%;"> -->
            <div style="height: 100%;">

            <!-- slide 1 -->
                <div class="w3-animate-right mySlides2">
                    <h3 class="w3-center"><i class="fa fa-fire" aria-hidden="true"></i>&nbsp;ยาต้ม (A) </h3>

                    <table class="w3-table w3-center w3-padding w3-striped-blue w3-xxlarge">
                        <tr class="w3-blue w3-medium">
                            <th>คิว</th>
                            <th>รับได้ประมาณ</th>
                            <th>สถานะ</th>
                        </tr>
                        <tr>
                            <th>A004</th>
                            <td>14:30</td>
                            <td>กำลังจัดยา</td>
                        </tr>
                        <tr>
                            <th>A007</th>
                            <td>15:00</td>
                            <td>รอจัดยา</td>
                        </tr>
                        <tr>
                            <th>A007</th>
                            <td>15:00</td>
                            <td>รอต้ม</td>
                        </tr>
                        <tr>
                            <th>A007</th>
                            <td>15:00</td>
                            <td>กำลังต้ม</td>
                        </tr>
                        <tr>
                            <th>A007</th>
                            <td>15:00</td>
                            <td>กำลังต้ม</td>
                        </tr>
                        <tr>
                            <th>A007</th>
                            <td>15:00</td>
                            <td>รอจัดยา</td>
                        </tr>
                        <tr>
                            <th>A007</th>
                            <td>15:00</td>
                            <td>รอจัดยา</td>
                        </tr>
                        <!-- 7 rows -->
                    </table>
                </div>

                <div class="w3-animate-right mySlides2">
                    <h3 class="w3-center"><i class="fa fa-balance-scale" aria-hidden="true"></i>&nbsp;ยาจัด </h3>
                    <table class="w3-table w3-center w3-striped-blue w3-xxlarge>
                        <tr class="w3-blue w3-medium"">
                            <th>คิว</th>
                            <th>รับได้ประมาณ</th>
                            <th>สถานะ</th>
                            <th></th>
                        </tr>
                        <tr>
                            <th>B004</th>
                            <td>14:30</td>
                            <td>กำลังจัดยา</td>
                        </tr>
                        <tr>
                            <th>B007</th>
                            <td>15:00</td>
                            <td>รอจัดยา</td>
                        </tr>
                        <tr>
                            <td>B007</td>
                            <td>15:00</td>
                            <td>รอจัดยา</td>
                        </tr>
                    </table>
                </div>

            
               
            </div>


            
        </div>
            
    </div>





<!--       <div class="w3-section mySlides2 w3-card-2 w3-animate-right w3-green" style="height: 300px;">
        <h1> 2 </h1>
      </div>
      <div class="w3-section mySlides2 w3-card-2 w3-animate-right w3-blue" style="height: 300px;">
        <h1> 3 </h1>
      </div>
    </div> -->

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