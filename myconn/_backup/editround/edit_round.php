<?php
include("../myconn.php");
$data1=json_decode(file_get_contents("php://input"));
mysqli_query($conn, "SET NAMES UTF8");
	$carpool_id=($data1->carpool_id);
	$trip_id=($data1->trip_id);
	$trip_start=($data1->trip_start);
	$trip_time=($data1->trip_time);
	$trip_end=($data1->trip_end);
	$trip_sit=($data1->trip_sit);
	$trsg_id=($data1->trsg_id);
	$btnName=($data1->btnName);
	if($btnName =='แก้ไข'){
	$query="update tb_trip set
	trip_start = '$trip_start',
	trip_time = '$trip_time',
	trip_end = '$trip_end',
	trip_sit = '$trip_sit',
	trsg_id = '$trsg_id' 
	where trip_id = '$trip_id'";
if (mysqli_query($conn,$query)) {
		echo 1;
		
	}else{
		echo 0;
	}
}	
	
?>