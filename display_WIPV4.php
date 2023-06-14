<!DOCTYPE html>
<html>
<title>คิวรับยา</title>
<meta charset="UTF-8">
<!-- <link rel="stylesheet" type="text/css" href="source/progress_bar.css"> -->
<link rel="stylesheet" type="text/css" href="w3.css">
<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="source/progress_bar.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<style>
    img {
        width: 100px;
        height: 100px;
        float: left;
        margin-right: 10;
    }
.mySlidesWIP1 {display:none;} 
.mySlidesWIP2 {display:none;}

.w3-striped-blue tbody tr:nth-child(even){background-color:#e6ffff;}
.w3-striped-red tbody tr:nth-child(even){background-color:#ffe6e6;}
</style>
<body>
    <?php
        error_reporting(E_ERROR | E_PARSE);
    	header('refresh: 180;');
        require("connection.php"); 
        require("source/display_functions_fin_time_2022V4.php");
        require ('function.php');
        $fin = find_fin_array(); //เช็คทุกคนที่ไม่ใช่อันสุดท้ายและยกเลิก
        $wip = find_wip_array();
        date_default_timezone_set("Etc/GMT-7");
		$today = date("Y-m-d");
		$language = "th";
		//$refresh_time = refresh_time($db, $today);

    ?>

       
    <div class="w3-row-padding w3-padding-top" style="height: 10vh">
        <div class="w3-col l1" style="height: 100%;">
        
            <img src="HC LOGO.png" alt="" style="height: 10vh; width: 5.625vw">

        </div>

        <div class="w3-col l6" style="height: 100%;">
        
            <h1 class="w3-center" style="font-size:4vw!important; color: #000">กำลังเตรียม Preparing</h1>

        </div>

        <div class="w3-col l3" style="height: 100%; color: black;">

            <h1 class="w3-center w3-jumbo">
                <?php echo(strftime("%d/%m/%Y")); ?></p>
            </h1>

        </div>

        <div id="time" class="w3-col l1" style="height: 100%; color: black;">
            
            <h1 class="w3-center w3-jumbo">
                    <?php echo(strftime("%H:%M")); ?></p>
            </h1>
        </div>
        <div class="w3-col l1" style="height: 100%; color: black;">
            
            <h1 class="w3-center w3-jumbo">
                    <?php echo(" hrs"); ?></p>
            </h1>
        </div>

    </div>


    <div id="first_row"> 
            <!-- Status -->
            <div class="w3-col l6" style="height: 10vh;">
                <!-- ยาต้ม -->
                <div class="w3-animate-right mySlidesWIP1">
                    <h1 class="w3-center w3-jumbo w3-blue" style="font-size:3vw!important"> A คลินิกต้มให้ Decocted Service</h1>
                    <h2 class="w3-center"><?php type_process(1); ?></h2>
                    <table class="w3-table w3-center w3-padding w3-striped-blue w3-xxxlarge">
                        <tr class="w3-blue w3-jumbo">
                            <th style="width:25%">คิว</th>
                            <th style="width:35%">เสร็จเวลา</th>
                            <th style="width:30%">สถานะ</th>
                            <th style="width:10%"></th>
                        </tr>
                    <?php 
                        $fin_s_id = 15;
                        $collected_s_id = 16;
                        $cancle_s_id = 101;
                        $t_id = 1;
                        $title = "A คลินิกต้มให้ Decocted Service";
                        display_status($db, $fin_s_id, $collected_s_id, $cancle_s_id, $t_id, $title, $today, $language);
                    ?>
                    </table>
                </div>
            </div>

            
            <div class="w3-col l6" style="height: 10vh;">
                <!-- ยาจัด -->
                <div class="w3-animate-right mySlidesWIP2">
                    <h1 class="w3-center w3-jumbo w3-red" style="font-size:3vw!important"> B ต้มเอง Self Decocted</h1>
                    <h2 class="w3-center"><?php type_process(2); ?></h2>
                    <table class="w3-table w3-center w3-padding w3-striped-red w3-xxxlarge">
                        <tr class="w3-red w3-jumbo">
                            <th style="width:25%">คิว</th>
                            <th style="width:35%">เสร็จเวลา</th>
                            <th style="width:30%">สถานะ</th>
                            <th style="width:10%"></th>
                        </tr>
                    <?php 
                        $fin_s_id = 23;
                        $collected_s_id = 24;
                        $cancle_s_id = 201;
                        $t_id = 2;
                        $title = "B ต้มเอง Self Decocted";
                        display_status2($db, $fin_s_id, $collected_s_id, $cancle_s_id, $t_id, $title, $today, $language);
                    ?>
                    </table>
                </div>

                <!-- เคอลี่ -->
                <div class="w3-animate-right mySlidesWIP2">
                    <h1 class="w3-center w3-jumbo w3-red" style="font-size:3vw!important"> C ยาเคอลี่ Keli</h1>
                    <h2 class="w3-center"><?php type_process(3); ?></h2>
                    <table class="w3-table w3-center w3-padding w3-striped-red w3-xxxlarge">
                        <tr class="w3-red w3-jumbo">
                            <th style="width:25%">คิว</th>
                            <th style="width:35%">เสร็จเวลา</th>
                            <th style="width:30%">สถานะ</th>
                            <th style="width:10%"></th>
                        </tr>
                    <?php 
                        $fin_s_id = 32;
                        $collected_s_id = 33;
                        $cancle_s_id = 301;
                        $t_id = 3;
                        $title = "C ยาเคอลี่ Keli";
                        display_status2($db, $fin_s_id, $collected_s_id, $cancle_s_id, $t_id, $title, $today, $language);
                    ?>
                    </table>
                </div>

            </div>
        
        </div>
    </div>


    <script>
        var myIndex = 0;
        var myIndex2 = 0;
        var fin_end = 0;
        var status_end = 0;
        var status_end2 = 0;
        carousel();
        carousel2();

        function carousel() {
            var i;
            var x = document.getElementsByClassName("mySlidesWIP1");
            for (i = 0; i < x.length; i++) {
               x[i].style.display = "none";  
            }
            myIndex++;
            if (myIndex > x.length) {myIndex = 1; status_end = 1;}    
            x[myIndex-1].style.display = "block";  
            setTimeout(carousel, 8000); // Change image every 2 seconds
        }

        function carousel2() {
            var j;
            var y = document.getElementsByClassName("mySlidesWIP2");
            for (j = 0; j < y.length; j++) {
               y[j].style.display = "none";  
            }
            myIndex2++;
            if (myIndex2 > y.length) {myIndex2 = 1; status_end2 = 1;}    
            y[myIndex2-1].style.display = "block";  
            setTimeout(carousel2, 8000); // Change image every 2 seconds
        }

        $(document).ready(function(){
        setInterval(function(){
            $("#time").load(window.location.href + " #time" );
        }, 1000);
        });

    </script>

</body>
</html>