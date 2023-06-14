<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php 
require("connection.php");
require("function.php");
session_start();
$c1=0;
$c2=0;
if(!isset($_GET['pre_id']))$_GET['pre_id']='';
$pre_id=$_GET['pre_id'];
if(!isset($_GET['s_id']))$_GET['s_id']='';
$s_id=$_GET['s_id'];
if(!isset($_GET['o_id1']))$_GET['o_id1']='';
$o_id1=$_GET['o_id1'];
if(!isset($_GET['o_id2']))$_GET['o_id2']='';
$o_id2=$_GET['o_id2'];
$timestamp = $_SESSION['timestamp'];
$next_id = find_next_id($s_id,$db);
$duration = find_duration($pre_id,$s_id, $timestamp,$db);

  $query="UPDATE prescription SET s_id='$next_id' WHERE pre_id='$pre_id' ";
odbc_exec($db,$query);
  $query="UPDATE psrel SET duration='$duration' WHERE pre_id='$pre_id' and s_id='$s_id' ";
odbc_exec($db,$query);


  if($o_id1!=''&&$o_id2!=''){
  $NoofOper = 2;
  }
  if($o_id1!=''&&$o_id2==''){
      $NoofOper = 1;
  }

  $n=$NoofOper;
  while($n!=0){
      if($n==2){
      $temp = $o_id2;
      }
      if($n==1){
      $temp = $o_id1;
      }
      $query ="INSERT INTO oprel (o_id, pre_id,op_time,s_id)  VALUES ('$temp','$pre_id','$timestamp','$next_id');";
      odbc_exec($db,$query);
      $n=$n-1;
  }

  $query="SELECT * FROM prescription WHERE pre_id='$pre_id'";
  $result=odbc_exec($db,$query);
  if($list=odbc_fetch_array($result)){
      $q_id=$list['q_id'];
  }
  $query ="INSERT INTO psrel (pre_id, s_id,ps_time,duration,numberOfOper)  VALUES ('$pre_id','$next_id','$timestamp',0,'$NoofOper');";
  odbc_exec($db,$query);
  
  header("refresh: 0; url=pre_id_input.php");



?>

</body>
</html>