<?php 
include("../myconn.php");
$date =date("Y-m-d");
$time = date("H:i");

$carpool_id = $_GET["carpool_id"];
$date_m = date('Y-m-d',strtotime($_GET["date"]. "-1 days"));
$date_p = date('Y-m-d',strtotime($_GET["date"]. "+1 days"));	

$query = "SELECT * FROM tb_trip NATURAL JOIN tb_car NATURAL JOIN tb_employee NATURAL JOIN tb_passenger NATURAL JOIN tb_trsg WHERE 
(tb_trip.trip_status = 2) AND (tb_passenger.passenger_status ='จอง') AND
(tb_trip.trip_start < '$date_p') AND
(tb_trip.trip_end > '$date_m') ";

if($carpool_id != ""){
	$query .= "AND carpool_id = '$carpool_id'";
}

$outpb="";
$result = mysqli_query($conn,$query);
if(mysqli_num_rows($result)>0){
	while($rs = $result->fetch_array(MYSQLI_ASSOC)){
		if ($outpb != "") {$outpb .= ",";}
			$outpb .= '{"trip_id":"' . $rs["trip_id"] . '",';
			$outpb .= '"carpool_id":"' . $rs["carpool_id"] . '",';
			$outpb .= '"carpool_brand":"' . $rs["carpool_brand"] . '",';
			$outpb .= '"carpool_model":"' . $rs["carpool_model"] . '",';
			////////////////////////////////////////////////////////////////
			$yy=substr($rs["trip_start"],0,-6);
		    $mm=substr($rs["trip_start"],5,-3);
		    $dd1=substr($rs["trip_start"],-2);
			$_month_name = array("01"=>"ม.ค.",  "02"=>"ก.พ.",  "03"=>"มี.ค.",    
			"04"=>"เม.ย.",  "05"=>"พ.ค.",  "06"=>"มิ.ย.",    
			"07"=>"ก.ค.",  "08"=>"ส.ค.",  "09"=>"ก.ย.",    
			"10"=>"ต.ค.", "11"=>"พ.ย.",  "12"=>"ธ.ค.");
			$yy = substr($yy+=543,2);
			
			$date=$dd1." ".$_month_name[$mm]."  ".$yy;
			$outpb .= '"trip_start":"'.$date.'",';
			///////////////////////////////////////////////////////////////
			$yy=substr($rs["trip_end"],0,-6);
		    $mm=substr($rs["trip_end"],5,-3);
		    $dd1=substr($rs["trip_end"],-2);
			$yy = substr($yy+=543,2);
	
			$date2=$dd1." ".$_month_name[$mm]."  ".$yy;
			$outpb .= '"trip_end":"'.$date2.'",';
			//////////////////////////////////////////////////////////////
			$outpb .= '"employee_title":"' . $rs["employee_title"] . '",';
			$outpb .= '"employee_firstname":"' . $rs["employee_firstname"] . '",';
			$outpb .= '"employee_lastname":"' . $rs["employee_lastname"] . '",';
			$outpb .= '"trsg_name":"' . $rs["trsg_name"] . '",';
			$outpb .= '"passenger_tel_table":"' . $rs["passenger_tel_table"] . '",';
			$outpb .= '"passenger_tel":"' . $rs["passenger_tel"] . '"}';
	}

$outpb = '['.$outpb.']';
echo ($outpb);
}else{
	echo '[{"trip_id":""}]' ;
}
?>