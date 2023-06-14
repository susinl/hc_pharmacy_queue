<!DOCTYPE html>
<html>
<title>คิวรับยา</title>
<meta charset="UTF-8">
<!-- <link rel="stylesheet" type="text/css" href="source/progress_bar.css"> -->
<link rel="stylesheet" type="text/css" href="w3.css">
<link rel="stylesheet" type="text/css" href="custom_text_class.css">
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
.mySlides3c {display:none;}
.mySlides2c {display:none;}
.mySlides1c {display:none;}

.w3-striped-blue tbody tr:nth-child(even){background-color:#e6ffff;}
.w3-striped-red tbody tr:nth-child(even){background-color:#ffe6e6;}

td {
    text-align: center;
}
</style>
<body>
    <?php
        error_reporting(E_ERROR | E_PARSE);
    	header('refresh: 80;');
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
        
            <h1 class="w3-center" style="font-size:4vw!important; font-weight: bold; color: #000">เชิญรับยา Finished</h1>

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
        <div class="w3-row-padding w3-padding-top" style="height: 20vh">
            <h1 class="w3-center w3-red w3-large" style="font-size:2vw!important">คิวที่เสร็จล่าสุด Recently Finished </h1>
            <div class="w3-col l6">
            <!-- <div class="w3-animate-right"> -->
                <!-- <table class="w3-table w3-striped-red" style="font-size:4vw!important"> -->
                <?php 
                    $query1 = "SELECT TOP 1 q.q_name, pr.ps_time
                                FROM prescription p
                                LEFT OUTER JOIN psrel pr ON pr.pre_id = p.pre_id 
                                LEFT OUTER JOIN queue q ON p.q_id = q.q_id
                                WHERE pr.s_id = 15
                                AND p.in_datetime > '$today'
                                AND p.in_datetime <= dateadd(day, 1, '$today') 
                                ORDER BY pr.ps_time DESC;";
                    $result = odbc_exec($db, $query1);
                    $item = 1;
                    $list = odbc_fetch_array($result);
                    $q_name_last = $list['q_name'];
                    $last_ps_time = strtotime($list['ps_time']);
                    $time_now = strtotime(date("Y-m-d H:i:s"));

                    if($last_ps_time > $time_now-60){
                        echo 	'<table class="w3-table w3-centered blinking extra-bold" style="font-size:4vw!important">';
                    }else{
                        echo 	'<table class="w3-table w3-centered extra-bold" style="font-size:4vw!important; color:#fd00db!important">';
                    }

                    echo '<tr><td><b style="font-size:5vw">'.$q_name_last.'</b></td>';



                    

                ?>
                </table>
            </div>

            <div class="w3-col l4">
            <!-- <div class="w3-animate-right"> -->
                <!-- <table class="w3-table w3-striped-red" style="font-size:4vw!important"> -->
                <?php 
                    $query1 = "SELECT TOP 1 q.q_name, pr.ps_time
                                FROM prescription p
                                LEFT OUTER JOIN psrel pr ON pr.pre_id = p.pre_id 
                                LEFT OUTER JOIN queue q ON p.q_id = q.q_id
                                WHERE pr.s_id = 23
                                AND p.in_datetime > '$today'
                                AND p.in_datetime <= dateadd(day, 1, '$today') 
                                ORDER BY pr.ps_time DESC;";
                    $result = odbc_exec($db, $query1);
                    $item = 1;
                    $list = odbc_fetch_array($result);
                    $q_name_last = $list['q_name'];
                    $last_ps_time = strtotime($list['ps_time']);
                    $time_now = strtotime(date("Y-m-d H:i:s"));

                    if($last_ps_time > $time_now-60){
                        echo 	'<table class="w3-table w3-centered blinking extra-bold" style="font-size:4vw!important">';
                    }else{
                        echo 	'<table class="w3-table w3-centered extra-bold" style="font-size:4vw!important; color:#fd00db!important">';
                    }

                    echo '<tr><td><b style="font-size:5vw">'.$q_name_last.'</b></td>';

                    

                ?>
                </table>
            </div>

            <div class="w3-col l2">
            <!-- <div class="w3-animate-right"> -->
                <!-- <table class="w3-table w3-striped-red" style="font-size:4vw!important"> -->
                <?php 
                    $query1 = "SELECT TOP 1 q.q_name, pr.ps_time
                                FROM prescription p
                                LEFT OUTER JOIN psrel pr ON pr.pre_id = p.pre_id 
                                LEFT OUTER JOIN queue q ON p.q_id = q.q_id
                                WHERE pr.s_id = 32
                                AND p.in_datetime > '$today'
                                AND p.in_datetime <= dateadd(day, 1, '$today') 
                                ORDER BY pr.ps_time DESC;";
                    $result = odbc_exec($db, $query1);
                    $item = 1;
                    $list = odbc_fetch_array($result);
                    $q_name_last = $list['q_name'];
                    $last_ps_time = strtotime($list['ps_time']);
                    $time_now = strtotime(date("Y-m-d H:i:s"));

                    if($last_ps_time > $time_now-60){
                        echo 	'<table class="w3-table w3-centered blinking extra-bold" style="font-size:4vw!important">';
                    }else{
                        echo 	'<table class="w3-table w3-centered extra-bold" style="font-size:4vw!important; color:#fd00db!important">';
                    }

                    echo '<tr><td><b style="font-size:5vw">'.$q_name_last.'</b></td>';

                    

                ?>
                </table>
            </div>
        </div>
    </div>

    <div id="second_row">
    <!-- <div class="w3-row-padding" style="height: 720px;"> -->
        <div class="w3-row-padding w3-padding-top" style="height: 60vh">
            <!-- Finished Queue -->
            <div id="first_col" class="w3-col l6" style="height: 60vh;">

                <h1 class="w3-center w3-red w3-large" style="font-size:2vw!important">A คลินิกต้มให้ Decoction Service </h1>
                <!-- <h1 class="w3-center">A คลินิคต้มให้ Decoction Service</h1> -->
                <div class="w3-animate-right mySlides3c">
                    <table class="w3-table w3-striped-red extra-bold" style="font-size:80px!important">
                    <?php 
                        //ต้องเรียกใช้จาก source/display_fuction ที่ function finish_table($db, $fin_s_id, $fin, $today, $title){ 
                        // ใช้แสดงคิวที่เสร็จแล้ว ต้องใส่ค่อ 
                        //$fin_s_id ซึ่งคือ id ที่แปลว่าพร้อมจ่ายยา, $title เป็นชื่อหัวข้อของตาราง, $today เป็นวันที่อยู่ใน format 'yyyy-mm-dd'
                        finish_table_3c($db, 15, $fin, $today, 'คลินิกต้มให้ (A)1234');
                    ?>
                    </table>
                </div>
            </div>

            <div id="second_col" class="w3-col l4" style="height: 60vh;">
                
                <h1 class="w3-center w3-red" style="font-size:2vw!important">B ต้มเอง Self Decocted </h1> 
                <!-- <h1 class="w3-center">B ต้มเอง Self Decocted</h1> -->
                <div class="w3-animate-right mySlides2c">
                    <table class="w3-table w3-striped-red extra-bold" style="font-size:80px!important">
                    <?php 
                        //ต้องเรียกใช้จาก source/display_fuction ที่ function finish_table($db, $fin_s_id, $fin, $today, $title){ 
                        // ใช้แสดงคิวที่เสร็จแล้ว ต้องใส่ค่อ 
                        //$fin_s_id ซึ่งคือ id ที่แปลว่าพร้อมจ่ายยา, $title เป็นชื่อหัวข้อของตาราง, $today เป็นวันที่อยู่ใน format 'yyyy-mm-dd'
                        finish_table_2c($db, 23, $fin, $today, 'ต้มเอง (B)');
                    ?>
                    </table> 
                </div>
            </div>

            <div id="third_col" class="w3-col l2" style="height: 60vh;">

                <h1 class="w3-center w3-red" style="font-size:2vw!important">C เคอลี่ Granule</h1> 
                <!-- <h1 class="w3-center">B ต้มเอง Self Decocted</h1> -->
                <div class="w3-animate-right mySlides1c">
                    <table class="w3-table w3-striped-red extra-bold" style="font-size:80px!important">
                    <?php 
                        //ต้องเรียกใช้จาก source/display_fuction ที่ function finish_table($db, $fin_s_id, $fin, $today, $title){ 
                        // ใช้แสดงคิวที่เสร็จแล้ว ต้องใส่ค่อ 
                        //$fin_s_id ซึ่งคือ id ที่แปลว่าพร้อมจ่ายยา, $title เป็นชื่อหัวข้อของตาราง, $today เป็นวันที่อยู่ใน format 'yyyy-mm-dd'
                        finish_table_1c($db, 32, $fin, $today, 'เคอลี่ (C)');
                    ?>
                    </table> 
                </div>
            </div>

        </div>    
    </div>

    <div class="w3-col l12" style="height:10vh ">
            <h1 class="w3-center w3-red" style="font-size:2vw!important">D ยาสำเร็จรูปรับยาได้ทันที Code “D” pharmaceutical product pick up at the counter</h1> 
        </div>

    <script>
        var myIndex = 0;
        var myIndex2 = 0;
        var myIndex3 = 0;
        var fin_end = 0;
        var status_end = 0;
        var status_end2 = 0;
        var status_end3 = 0;
        carousel();
        carousel2();
        carousel3();

        function carousel() {
            var i;
            var x = document.getElementsByClassName("mySlides3c");
            for (i = 0; i < x.length; i++) {
               x[i].style.display = "none";  
            }
            myIndex++;
            if (myIndex > x.length) {myIndex = 1; status_end = 1;}    
            x[myIndex-1].style.display = "block";  
            // if (fin_end == 1 && status_end == 1){
            //     location.reload(true);
            //     //location.assign("display_eng.php");
            // }
            setTimeout(carousel, 8000); // Change image every 2 seconds
        }

        function carousel2() {
            var i;
            var y = document.getElementsByClassName("mySlides2c");
            for (i = 0; i < y.length; i++) {
               y[i].style.display = "none";  
            }
            myIndex2++;
            if (myIndex2 > y.length) {myIndex2 = 1; status_end2 = 1;}    
            y[myIndex2-1].style.display = "block";  
            // if (fin_end == 1 && status_end2 == 1){
            //     location.reload(true);
            //     //location.assign("display_eng.php");
            // }
            setTimeout(carousel2, 8000); // Change image every 2 seconds
        }

        function carousel3() {
            var i;
            var z = document.getElementsByClassName("mySlides1c");
            for (i = 0; i < z.length; i++) {
               z[i].style.display = "none";  
            }
            myIndex3++;
            if (myIndex3 > z.length) {myIndex3 = 1; status_end3 = 1;}    
            z[myIndex3-1].style.display = "block";  
            // if (fin_end == 1 && status_end3 == 1){
            //     location.reload(true);
            //     //location.assign("display_eng.php");
            // }
            setTimeout(carousel3, 8000); // Change image every 2 seconds
        }


        $(document).ready(function(){
        setInterval(function(){
            $("#time").load(window.location.href + " #time" );
        }, 1000);
        setInterval(function(){
            $("#first_row").load(window.location.href + " #first_row" );
        }, 4000);
        // setInterval(function(){
        //     $("#second_row").load(window.location.href + " #second_row" );
        // }, 32000);
        });

        

        
    </script>

<!-- <div id="here">dynamic content ?</div> -->

</body>
</html>