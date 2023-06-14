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
			
			
			//function find_finishtime($pre_id,$t_id,$numberOfQ1,$numberOfQ2,$inprocessQ1,$inprocessQ2,$numberofpack,$Intercept,$Coef1,$Coef2,$Coef3,$Coef4,$Coef5,$Coef6,$Coef7,$Coef8,$Coef9,$Coef10,$Coef11,$Coef12,$Coef13,$Coef14,$Zvalue,$TuneA,$TuneB) {
				
			function find_finishtime($pre_id,$t_id,$numberOfQ1,$numberOfQ2,$numberOfQ3,$inprocessQ1,$inprocessQ2,$inprocessQ3,$numberOfB1,$numberofmed,$numberofpack,$Intercept,$Coef1,$Coef2,$Coef3,$Coef4,$Coef5,$Coef6,$Coef7,$Coef8,$Coef9,$Coef10,$Coef11,$Coef12,$Coef13,$Coef14,$Coef15,$Coef16,$Coef17,$Coef18,$Coef19,$Coef20,$Coef21,$Coef22,$Coef23,$Coef24,$Zvalue,$Tune) {				
				date_default_timezone_set("Etc/GMT-7");
				$weekday = date('w');
				$hr=date("H");
				$wd_Sun=array(1,0,0,0,0,0,0);
				$wd_Mon=array(0,1,0,0,0,0,0); 
				$wd_Tue=array(0,0,1,0,0,0,0);
				$wd_Fri=array(0,0,0,0,0,1,0);
				$wd_Sat=array(0,0,0,0,0,0,1);			
				$in=$weekday;
				$Wait_Decoct = $numberOfQ1 + $inprocessQ1 + $numberOfB1;
				$predict=0;
				
				if($t_id==1){
					$BF1 = max(0,24-$numberofpack);
					$BF2 = max(0,$numberofpack-24);
					$BF3 = max(0,10-$hr);
					$BF4 = max(0,7-$numberOfQ1);
					$BF5 = max(0,$numberOfQ1-7);
					$BF6 = max(0,12-$numberOfQ2);
					$BF7 = max(0,32-$Wait_Decoct);
					$BF8 = max(0,$Wait_Decoct-32);
					$BF9 = $BF3*$wd_Mon[$in];
					$BF10 = $wd_Sat[$in]*$BF7;
					$BF11 = max(0,6-$numberofmed)*$BF1;
					$BF12 = max(0,$numberofmed-6)*$BF1;
					$BF13 = max(0,16-$numberofmed)*$BF5;
					$BF14 = max(0,$numberofmed-16)*$BF5;
					$BF15 = $BF3*max(0,10-$numberOfQ1);
					$BF16 = $BF3*$BF7;
					$BF17 = max(0,$hr-10)*$BF7;
					$BF18 = $BF4*max(0,$Wait_Decoct-13);
					$BF19 = $BF4*max(0,13-$Wait_Decoct);
					
					$predict=$Intercept+($Coef1*$BF1)+($Coef2*$BF2)+($Coef3*$BF3)+($Coef4*$BF4)+($Coef5*$BF5)+($Coef6*$BF6)+($Coef7*$BF7)+($Coef8*$BF8)+($Coef9*$BF9)+($Coef10*$BF10)+($Coef11*$BF11)+($Coef12*$BF12)+($Coef13*$BF13)+($Coef14*$BF14)+($Coef15*$BF15)+($Coef16*$BF16)+($Coef17*$BF17)+($Coef18*$BF18)+($Coef19*$BF19);				
					$predict=$predict+$Tune;
					}
					
				elseif($t_id==2){
					$BF1 = max(0,$numberofmed-1);
					$BF2 = max(0,4-$numberofmed);
					$BF3 = max(0,$numberofmed-4);
					$BF4 = max(0,$numberofpack-11);
					$BF5 = max(0,6-$numberOfQ1);
					$BF6 = max(0,$numberOfQ1-6);
					$BF7 = max(0,4-$numberOfQ2);
					$BF8 = max(0,$numberOfQ2-4);
					$BF9 = $BF3*$wd_Mon[$in];
					$BF10 = $BF2*max(0,11-$numberofpack);
					$BF11 = $BF3*max(0,11-$numberofpack);
					$BF12 = $BF2*$BF8;
					$BF13 = $BF3*$BF8;
					$BF14 = max(0,$numberofpack-21)*$BF7;
					$BF15 = max(0,11-$hr)*$BF6;
					$BF16 = max(0,11-$hr)*$BF5;
					$BF17 = max(0,$hr-11)*$BF6;
					$BF18 = max(0,$hr-11)*$BF5;
					$BF19 = max(0,9-$hr)*$BF7;
					$BF20 = $BF5*max(0,$inprocessQ2-1);
					$BF21 = $BF6*max(0,$Wait_Decoct-38);
					$BF22 = $BF6*max(0,38-$Wait_Decoct);
					$BF23 = $BF7*max(0,$inprocessQ1-3);
					$BF24 = $BF7*max(0,3-$inprocessQ1);
					
					$predict=$Intercept+($Coef1*$BF1)+($Coef2*$BF2)+($Coef3*$BF3)+($Coef4*$BF4)+($Coef5*$BF5)+($Coef6*$BF6)+($Coef7*$BF7)+($Coef8*$BF8)+($Coef9*$BF9)+($Coef10*$BF10)+($Coef11*$BF11)+($Coef12*$BF12)+($Coef13*$BF13)+($Coef14*$BF14)+($Coef15*$BF15)+($Coef16*$BF16)+($Coef17*$BF17)+($Coef18*$BF18)+($Coef19*$BF19)+($Coef20*$BF20)+($Coef21*$BF21)+($Coef22*$BF22)+($Coef23*$BF23)+($Coef24*$BF24);
					$predict=$predict+$Tune;
					}
					
				elseif($t_id==3){
					$BF1 =$wd_Sun[$in];
					$BF2 =$wd_Tue[$in];
					$BF3 =$wd_Fri[$in];
					$BF4 =$wd_Sat[$in];
					$BF5 = max(0,$numberofmed-1);
					$BF6 = max(0,4-$numberofmed);
					$BF7 = max(0,$numberofmed-4);
					$BF8 = max(0,$numberofpack-5);
					$BF9 = max(0,9-$hr);
					$BF10 = max(0,$hr-14);
					$BF11 = max(0,6-$numberOfQ1);
					$BF12 = max(0,2-$numberOfQ2);
					$BF13 = max(0,1-$numberOfQ3);
					$BF14 = max(0,$numberOfQ3-1);
					$BF15 = max(0,1-$inprocessQ1);
					$BF16 = max(0,1-$inprocessQ3);
					$BF17 = max(0,$inprocessQ3-1);
					$BF18 = max(0,2-$Wait_Decoct);
					$BF19 = max(0,$Wait_Decoct-2);
					
					$predict=$Intercept+($Coef1*$BF1)+($Coef2*$BF2)+($Coef3*$BF3)+($Coef4*$BF4)+($Coef5*$BF5)+($Coef6*$BF6)+($Coef7*$BF7)+($Coef8*$BF8)+($Coef9*$BF9)+($Coef10*$BF10)+($Coef11*$BF11)+($Coef12*$BF12)+($Coef13*$BF13)+($Coef14*$BF14)+($Coef15*$BF15)+($Coef16*$BF16)+($Coef17*$BF17)+($Coef18*$BF18)+($Coef19*$BF19);
					$predict=$predict+$Tune;
					}
					else{
						$predict=0;
						}

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