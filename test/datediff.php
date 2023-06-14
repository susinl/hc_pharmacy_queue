<!DOCTYPE html>
<html>
<title>คิวรับยา</title>
<meta charset="UTF-8">
<!-- <link rel="stylesheet" type="text/css" href="source/progress_bar.css"> -->
<link rel="stylesheet" type="text/css" href="w3.css">
<link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="source/progress_bar.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<body>
<?php
    $str = '2017-03-10 10:20:00';
    $fin = '2017-03-10 12:32:00';
    $time = round(strtotime($fin) / 300) * 300;

    echo date('H:i', $time);
?>

</body>
</html>