<!DOCTYPE html>
<html>
<title>Huachiew TCM Prescription Status</title>
<meta charset="UTF-8">
<!-- <link rel="stylesheet" type="text/css" href="source/progress_bar.css"> -->
<link rel="stylesheet" type="text/css" href="source/w3.css">
<link rel="stylesheet" href="source/font-awesome-4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="source/progress_bar.css">
<link href="https://fonts.googleapis.com/css?family=Kanit|Pridi|Trirong" rel="stylesheet">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
    .pridi {
        font-family: 'Pridi', serif;
    }

    .kanit {
        font-family: 'Kanit', sans-serif;
    }
    .trirong{
        font-family: 'Trirong', serif;
    }
    .underline {
        background-image: linear-gradient(to right, red 50%, red 50%);
        background-position: 0 1.3em;
        background-repeat: repeat-x;
        background-size: 6px 3px;
    }
</style>
<body>

    <?php
        require("connection.php"); 
        require("source/check_function.php");
        date_default_timezone_set("Etc/GMT-7");
        if(!isset($_GET['input']))$_GET['input']='';
        $q_name=$_GET['input'];
        $c_id_get=$_GET['input'];
		$c_id_get=$c_id_get +0;
        if(!isset($_GET['c_date']))$_GET['c_date']= date("Y-m-d");
        $c_date=$_GET['c_date'];
        $query = "SELECT *
					FROM queue
					WHERE q_name='$q_name'
					OR c_id='$c_id_get'";
        $result=odbc_exec($db,$query);
		
        if($list=odbc_fetch_array($result)){
            //get customer name from hospital database
            if($c_id_get=$list['c_id']){
				header("refresh: 0; url=HNfind.php?c_date=$c_date&c_id=$c_id_get");
			}
            if($q_name=$list['q_name']){
				header("refresh: 0; url=../check_status/check_status.php?c_date=$c_date&q_name=$q_name");
			}
			else{
            session_start();
            $_SESSION['c']=1;
            //header("refresh: 0; url=../check_status/index.php");
        }
		}
    ?>


    </div>


</body>
</html>