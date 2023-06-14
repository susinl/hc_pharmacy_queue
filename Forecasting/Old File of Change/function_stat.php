<?php 
/*
function find_finishtime($pre_id,$t_id,$numberOfQ1,$numberOfQ2,$inprocessQ1,$inprocessQ2) {
	date_default_timezone_set("Etc/GMT-7");
	$weekday = date('w');
	$inprocess=0;
	$predict=0;
	$con=array(101.55,83.25,105.1,73.9,90.82,86.47,93.03,11.25,12.5,15.85,13.79,17.02,17.25,13.02);
	$coef=array(0.635,1.098,0.665,1.6433,0.872,1.193,0.776,1.727,2.36,1.887,2.186,1.469,2.045,1.733);
	$z=1.645;
	$s=array(25.9351,23.1113,25.5884,23.5129,25.2554,23.113,24.3614,9.6493,9.60339,11.4195,9.9032,10.4052,9.92488,10.0881);
	$n=array(242,139,179,237,227,205,249,89,61,114,107,109,74,113);
	$mean=array(45.149,21.604,24.173,31.16,27.709,22.454,49.189,11.91,6.721,7.509,10.579,7.459,6.297,16.407);
	$sd=array(11.121,7.097,10.27,15.372,9.035,6.229,13.906,4.954,2.752,4.469,7.163,3.495,2.922,8.281);
	if($t_id==1){
		$in=$weekday;
		//sunday $weekday==0
		$inprocess=$numberOfQ2+$inprocessQ2;
		$predict=$con[$in]+$coef[$in]*$inprocess+$z*$s[$in]*sqrt(1+1/$n[$in]+($inprocess-$mean[$in])*($inprocess-$mean[$in])/($sd[$in]*$sd[$in]*($n[$in]-1)));
	}
	if($t_id==2){
		$in=$weekday+7;
		$inprocess=$numberOfQ1+$inprocessQ1;
		$predict=$con[$in]+$coef[$in]*$inprocess+$z*$s[$in]*sqrt(1+1/$n[$in]+($inprocess-$mean[$in])*($inprocess-$mean[$in])/($sd[$in]*$sd[$in]*($n[$in]-1)));
	}	
	$predict = ceil($predict);
	$d=strtotime("+".$predict." minutes");
	date_default_timezone_set("Etc/GMT-7");
	$finishtime=date("Y-m-d H:i:s",$d);
	return $finishtime;
}
*/


require('connection.php');


/*
$query="SELECT * 
	FROM equation WHERE Version IN 
	( SELECT MAX(Version)
		FROM equation
	)";
	$result=odbc_exec($db,$query);
	if($list=odbc_fetch_array($result))
		{
			$Version=$list['Version'];
			$datetime=$list['datetime'];
			$Intercept=$list['Intercept'];
			$Coef1=$list['Coef1'];
			$Coef2=$list['Coef2'];
			$Coef3=$list['Coef3'];
			$Coef4=$list['Coef4'];
			$Coef5=$list['Coef5'];
			$Coef6=$list['Coef6'];
			$Coef7=$list['Coef7'];
			$Coef8=$list['Coef8'];
			$Coef9=$list['Coef9'];
			$Coef10=$list['Coef10'];
			$Coef11=$list['Coef11'];
			$Coef12=$list['Coef12'];
			$Coef13=$list['Coef13'];
			$Coef14=$list['Coef14'];
			$Zvalue=$list['Zvalue'];
			$TuneA=$list['TuneA'];
			$TuneB=$list['TuneB'];
			
			*/
			
			
			//function find_finishtime($pre_id,$t_id,$numberOfQ1,$numberOfQ2,$inprocessQ1,$inprocessQ2,$numberOfPack,$Intercept,$Coef1,$Coef2,$Coef3,$Coef4,$Coef5,$Coef6,$Coef7,$Coef8,$Coef9,$Coef10,$Coef11,$Coef12,$Coef13,$Coef14,$Zvalue,$TuneA,$TuneB) {
				
			function find_finishtime($pre_id,$t_id,$numberOfQ1,$numberOfQ2,$inprocessQ1,$inprocessQ2,$numberOfPack,$Intercept,$Coef1,$Coef2,$Coef3,$Coef4,$Coef5,$Coef6,$Coef7,$Coef8,$Coef9,$Coef10,$Coef11,$Coef12,$Coef13,$Coef14,$Zvalue,$TuneA,$TuneB) {	
				date_default_timezone_set("Etc/GMT-7");
				$weekday = date('w');
				$hr=intval(date('h'));
				$in=$weekday;
				$inprocess=0;
				$numberOfQ3=$numberOfQ2-$numberOfQ1;
				$predict=0;
				$wd_bf8=array(0,0,0,0,0,0,1);
				$wd_bf13=array(1,0,0,0,0,0,0);
				$typev=array(0,1);
				$lasttune=array($TuneA,$TuneB);
				$BF1=$typev[$t_id-1];
				$BF2=max(0,$numberOfQ1-23);
				$BF3=max(0,23-$numberOfQ1);
				$BF4=max(0,$hr-11);
				$BF5=max(0,11-$hr);
				$BF6=$BF4*$typev[$t_id-1];
				$BF7=$BF5*$typev[$t_id-1];
				$BF8=$wd[$in];
				$BF9=max(0,$numberOfPack-4);
				$BF10=max(0,4-$numberOfPack);
				$BF11=$BF3*max(0,$numberOfQ3-3);
				$BF12=$BF2*max(0,3-$numberOfQ3);
				$BF13=$wd[$in]*$typev[$t_id-1];
				$BF14=max(0,$hr-13);
				$predict=$Intercept+($Coef1*$BF1)+($Coef2*$BF2)+($Coef3*$BF3)+($Coef4*$BF4)+($Coef5*$BF5)+($Coef6*$BF6)+($Coef7*$BF7)+($Coef8*$BF8)+($Coef9*$BF9)+($Coef10*$BF10)+($Coef11*$BF11)+($Coef12*$BF12)+($Coef13*$BF13)+($Coef14*$BF14);
				$allowance=$Zvalue*1.2533*(11.54+0.043*$predict);
				$predict=$predict+$allowance+$lasttune[$t_id-1];
				
				$query="UPDATE INTO test_test VALUES (1,1)";
				odbc_exec($db,$query);
				
				
				/*
				if($t_id==1){
					$in=$weekday;
					//sunday $weekday==0
					$predict=$Intercept+($Coef1*$BF1)+($Coef2*$BF2)+($Coef3*$BF3)+($Coef4*$BF4)+($Coef5*$BF5)+($Coef6*$BF6)+($Coef7*$BF7)+($Coef8*$BF8)+($Coef9*$BF9)+($Coef10*$BF10)+($Coef11*$BF11)+($Coef12*$BF12)+($Coef13*$BF13)+($Coef14*$BF14);
				}
				if($t_id==2){
					$in=$weekday+7;
					$inprocess=$numberOfQ1+$inprocessQ1;
					$predict=$con[$in]+$coef[$in]*$inprocess+$z*$s[$in]*sqrt(1+1/$n[$in]+($inprocess-$mean[$in])*($inprocess-$mean[$in])/($sd[$in]*$sd[$in]*($n[$in]-1)));
				}	
				*/
				$predict = ceil($predict);
				$d=strtotime("+".$predict." minutes");
				date_default_timezone_set("Etc/GMT-7");
				$finishtime=date("Y-m-d H:i:s",$d);
				return $finishtime;
		}
		



?>