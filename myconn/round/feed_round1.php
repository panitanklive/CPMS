<?php 
include("../myconn.php");
$date =date("Y-m-d");
$time = date("H:i");

$query = "SELECT * from tb_car natural join tb_trsg natural join tb_trip where trip_status = 1 order by trip_end asc";

$outpb="";
$result = mysqli_query($conn,$query);
if(mysqli_num_rows($result)>0){
	while($rs = $result->fetch_array(MYSQLI_ASSOC)){
		if ($outpb != "") {$outpb .= ",";}
			$outpb .= '{"trip_id":"' . $rs["trip_id"] . '",';
			$outpb .= '"carpool_id":"' . $rs["carpool_id"] . '",';
			$outpb .= '"carpool_brand":"' . $rs["carpool_brand"] . '",';
			$outpb .= '"carpool_model":"' . $rs["carpool_model"] . '",';
			$outpb .= '"trip_sit":"' . $rs["trip_sit"] . '",';	
			$outpb .= '"carpool_sit2":"' . $rs["carpool_sit2"] . '",';
			////////////////////////////////////////////////////////////////
			$yy=substr($rs["trip_start"],0,-6);
		    $mm=substr($rs["trip_start"],5,-3);
		    $dd1=substr($rs["trip_start"],-2);
			$_month_name = array("01"=>"มกราคม",  "02"=>"กุมภาพันธ์",  "03"=>"มีนาคม",    
			"04"=>"เมษายน",  "05"=>"พฤษภาคม",  "06"=>"มิถุนายน",    
			"07"=>"กรกฎาคม",  "08"=>"สิงหาคม",  "09"=>"กันยายน",    
			"10"=>"ตุลาคม", "11"=>"พฤศจิกายน",  "12"=>"ธันวาคม"); 
			$date1=$dd1." ".$_month_name[$mm]."  ".$yy+= 543;
			$outpb .= '"trip_start":"'.$date1.'",';
			///////////////////////////////////////////////////////////////
			$outpb .= '"trip_time":"' . $rs["trip_time"] . '",';
			///////////////////////////////////////////////////////////////
			$yy=substr($rs["trip_end"],0,-6);
		    $mm=substr($rs["trip_end"],5,-3);
		    $dd1=substr($rs["trip_end"],-2);
			$_month_name = array("01"=>"มกราคม",  "02"=>"กุมภาพันธ์",  "03"=>"มีนาคม",    
			"04"=>"เมษายน",  "05"=>"พฤษภาคม",  "06"=>"มิถุนายน",    
			"07"=>"กรกฎาคม",  "08"=>"สิงหาคม",  "09"=>"กันยายน",    
			"10"=>"ตุลาคม", "11"=>"พฤศจิกายน",  "12"=>"ธันวาคม");
			$date2=$dd1." ".$_month_name[$mm]."  ".$yy+= 543;
			$outpb .= '"trip_end":"'.$date2.'",';
			//////////////////////////////////////////////////////////////
			if($date > $rs["trip_end"]){
				$outpb .= '"limit":"true",';
			}
			else if($date == $rs["trip_end"]){
				$outpb .= '"limit":"present",';
			}
			else{
				$outpb .= '"limit":"false",';
			}
			$outpb .= '"trsg_name":"' . $rs["trsg_name"] . '",';
			$outpb .= '"trsg_map":"' . $rs["trsg_map"] . '"}';
	}

$outpb = '['.$outpb.']';
echo ($outpb);
}else{
	echo '[{"trip_id":""}]' ;
}
?>