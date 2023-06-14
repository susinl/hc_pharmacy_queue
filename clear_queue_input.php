<!DOCTYPE html>
<html>
<title>Home</title>
<meta charset="UTF-8">
<!-- <link rel="stylesheet" type="text/css" href="source/progress_bar.css"> -->
<link rel="stylesheet" type="text/css" href="w3.css">
<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<body>
    <?php
        require("connection.php"); 
        require("header.html");
        date_default_timezone_set("Etc/GMT-7");
		$today = date("Y-m-d");
        
    ?>
        <div class="w3-card-2 w3-section w3-container" style="max-width: 800px; margin: auto;">
            <div class="w3-center w3-border-bottom">
                <h2><i class="fa fa-tags" aria-hidden="true"></i>&nbsp;จัดการคิว</h2>
            </div>
            <?php
                require('source/warning_pre_id.php');
            ?>
            <form class="w3-container" method="get" action="clear_queue.php">
                <h3 class="trirong">วันที่รับบริการ</h3>
                <input class="w3-input w3-large w3-border" type="date" name="c_date" required id="c_date" value=<?php echo date("Y-m-d"); ?> >
                <h3>หมายเลขคิว หรือ HN</h3>
                <label>ex. A012 หรือ 251304</label>
                <input class="w3-input w3-large w3-border" type="text" name="input" required id="input">
                 <input class="w3-btn-block w3-blue w3-large w3-section trirong" type="submit" value="Submit">
            </form>
        </div>
</body>
<script>
  document.getElementById('input').focus();
</script>
</html>