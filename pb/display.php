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

        <div class="w3-third w3-card-2 w3-margin-right" style="height: 100%;">

            <h2 class="w3-center w3-red"><i class="fa fa-check-circle" aria-hidden="true"></i>&nbsp;เชิญรับยา (Finish) </h2>

            <div class="w3-animate-right mySlides">
                <h3 class="w3-center"><i class="fa fa-fire" aria-hidden="true"></i>&nbsp;ยาต้ม 1</h3>
                <table class="w3-table w3-striped-red w3-xxlarge">
                    <tr>
                        <td>A001</td>
                        <td>A002</td>
                        <td>A003</td>
                    </tr>
                    <tr>
                        <td>A004</td>
                        <td>A005</td>
                        <td>A006</td>
                    </tr>
                    <tr>
                        <td>A007</td>
                        <td>A008</td>
                        <td></td>
                    </tr>
                </table>
            </div>

            <div class="w3-animate-right mySlides">
                 <h3 class="w3-center"><i class="fa fa-balance-scale" aria-hidden="true"></i>&nbsp;ยาจัด 2</h3>
                <table class="w3-table w3-center w3-xxlarge">
                    <tr>
                        <td>B001</td>
                        <td>B002</td>
                        <td>B003</td>
                    </tr>
                    <tr>
                        <td>B004</td>
                        <td>B005</td>
                        <td>B006</td>
                    </tr>
                    <tr>
                        <td>B007</td>
                        <td>B008</td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>



<!-- Status -->
        <div class="w3-rest w3-card-2 w3-container w3-row-padding" style="height: 100%;">

            <h2 class="w3-center w3-blue"><i class="fa fa-cogs" aria-hidden="true"></i>&nbsp;กำลังเตรียม (Preparing) </h2>
    
    <!-- Status left half -->
            <!-- <div class="w3-half" style="height: 100%;"> -->
            <div style="height: 100%;">

            <!-- slide 1 -->
                <div class="w3-animate-right mySlides2">
                    <h3 class="w3-center"><i class="fa fa-fire" aria-hidden="true"></i>&nbsp;ยาต้ม </h3>

                    <table class="w3-table w3-center w3-striped-blue" style="font-size: 32px;">
                        <tr class="w3-blue w3-medium">
                            <th>คิว</th>
                            <th>รับได้ประมาณ</th>
                            <th>สถานะ</th>
                            <th></th>
                        </tr>
                        <tr>
                            <td>A004</td>
                            <td>14:30</td>
                            <td>กำลังจัดยา</td>
                            <td class="w3-centered">
                            	<?php status_bar(11); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>A007</td>
                            <td>15:00</td>
                            <td>รอจัด</td>
                        </tr>
                        <tr>
                            <td>A007</td>
                            <td>15:00</td>
                            <td>รอต้ม</td>
                            <td class="w3-centered">
                            	<?php status_bar(12); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>A007</td>
                            <td>15:00</td>
                            <td>กำลังต้ม</td>
                            <td class="w3-centered">
                            	<?php status_bar(13); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>A007</td>
                            <td>15:00</td>
                            <td>เชิญรับยา</td>
                            <td class="w3-centered">
                            	<?php status_bar(15); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>A007</td>
                            <td>15:00</td>
                            <td>รอจัด</td>
                            <td class="w3-centered">
                            	<?php status_bar(10); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>A007</td>
                            <td>15:00</td>
                            <td>รอจัด</td>
                            <td class="w3-centered">
                            	<?php status_bar(10); ?>
                            </td>
                        </tr>
                        <!-- 7 rows -->
                    </table>
                </div>

                <div class="w3-animate-right mySlides2">
                    <h3 class="w3-center"><i class="fa fa-balance-scale" aria-hidden="true"></i>&nbsp;ยาจัด </h3>
                    <table class="w3-table w3-center w3-xxlarge w3-striped-blue">
                        <tr class="w3-blue w3-medium"">
                            <th>คิว</th>
                            <th>รับได้ประมาณ</th>
                            <th>สถานะ</th>
                            <th></th>
                        </tr>
                        <tr>
                            <td>B004</td>
                            <td>14:30</td>
                            <td>จัด</td>
                            <td class="w3-centered">
                            	<?php status_bar(21); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>B007</td>
                            <td>15:00</td>
                            <td>รอจัด</td>
                            <td class="w3-centered">
                            	<?php status_bar(20); ?>
                            </td>
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