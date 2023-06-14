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
    ?>
    <div class="w3-section w3-row-padding" style="height: 700px;">

        <div class="w3-col l5 w3-card" style="height: 100%;">

            <h1 class="w3-center w3-red"><i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;เชิญรับยา (Finish) </h2>

            <div class="w3-animate-right mySlides">
                <h1 class="w3-center"><i class="fa fa-fire" aria-hidden="true"></i>&nbsp;ยาต้ม 1</h3>
                <table class="w3-table w3-striped-red w3-xxxlarge">
                    <tr>
                        <td><b>A001</b></td>
                        <td><b>A002</b></td>
                        <td><b>A004</b></td>
                    </tr>
                    <tr>
                        <td>A005</td>
                        <td>A007</td>
                        <td>A008</td>
                    </tr>
                    <tr>
                        <td>A010</td>
                        <td>A011</td>
                        <td>A012</td>
                    </tr>
                    <tr>
                        <td>A015</td>
                        <td>A016</td>
                        <td>A021</td>
                    </tr>
                    <tr>
                        <td>A015</td>
                        <td>A016</td>
                        <td>A021</td>
                    </tr>
                    <tr>
                        <td>A015</td>
                        <td>A016</td>
                        <td>A021</td>
                    </tr>
                </table>
            </div>



             <div class="w3-animate-right mySlides">
                <h3 class="w3-center"><i class="fa fa-balance-scale" aria-hidden="true"></i>&nbsp;ยาจัด (B)</h3>
                <table class="w3-table w3-striped-red w3-xxxlarge">
                    <tr>
                        <td>B001</td>
                        <td>B002</td>
                    </tr>
                    <tr>
                        <td>B004</td>
                        <td>B005</td>
                    </tr>
                    <tr>
                        <td>B007</td>
                        <td>B008</td>
                    </tr>
                    <tr>
                        <td>B010</td>
                        <td>B011</td>
                    </tr>
                    <tr>
                        <td>B012</td>
                        <td>B015</td>
                    </tr>
                    <tr>
                        <td>B016</td>
                        <td>B021</td>
                    </tr>
                </table>
            </div>

        </div>



<!-- Status -->
        <div class="w3-col l7 w3-card w3-container w3-row-padding" style="height: 100%;">

            <h1 class="w3-center w3-blue"><i class="fa fa-cogs" aria-hidden="true"></i>&nbsp;กำลังเตรียม (Preparing) </h2>
    
    <!-- Status left half -->
            <!-- <div class="w3-half" style="height: 100%;"> -->
            <div style="height: 100%;">

            <!-- slide 1 -->
                <div class="w3-animate-right mySlides2">
                    <h1 class="w3-center"><i class="fa fa-fire" aria-hidden="true"></i>&nbsp;ยาต้ม (A)</h2>
                    <h2 class="w3-center"><?php type_process(1); ?></h2>

                    <table class="w3-table w3-center w3-padding w3-striped-blue w3-xxxlarge">

                        <tr class="w3-blue w3-medium">
                            <th>คิว</th>
                            <th>รับได้ประมาณ</th>
                            <th>สถานะ</th>
                        </tr>
                        <tr>
                            <th>A001</th>
                            <td>14:30</td>
                            <td>กำลังจัดยา</td>
                        </tr>
                        <tr>
                            <th>A002</th>
                            <td>15:00</td>
                            <td>รอจัดยา</td>
                        </tr>
                        <tr>
                            <th>A003</th>
                            <td>15:00</td>
                            <td>รอต้ม</td>
                        </tr>
                        <tr>
                            <th>A004</th>
                            <td>15:00</td>
                            <td>กำลังต้ม</td>
                        </tr>
                        <tr>
                            <th>A005</th>
                            <td>15:00</td>
                            <td>กำลังต้ม</td>
                        <!-- 5 rows -->
                    </table>
                </div>

                <div class="w3-animate-right mySlides2">
                    <h1 class="w3-center"><i class="fa fa-balance-scale" aria-hidden="true"></i>&nbsp;ยาจัด (B) </h2>
                    <h3 class="w3-center"><?php type_process(2); ?></h3>
                    <table class="w3-table w3-center w3-striped-blue w3-xxlarge">
                        <tr class="w3-blue w3-medium">
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
                            <th>B007</th>
                            <td>15:00</td>
                            <td>รอจัดยา</td>
                        </tr>
                    </table>
                </div>

            
               
            </div> 
        </div>
            
    </div>
    <?php
        require("connection.php"); 
        require("pb/pb_display.php");
        require 'function.php';
        $fin = find_fin_array(); //เช็คทุกคนที่ไม่ใช่อันสุดท้ายและยกเลิก
        $wip = find_wip_array();
        date_default_timezone_set("Etc/GMT-7");
        $today = date("Y-m-d");
        echo count($fin);
        echo count($wip);
        echo $today;
    ?>


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
            setTimeout(carousel, 10000); // Change image every 2 seconds
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
            setTimeout(carousel2, 10000); // Change image every 2 seconds
        }
    </script>

</body>
</html>