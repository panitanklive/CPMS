<?php
include("../myconn.php");
$data1=json_decode(file_get_contents("php://input"));
mysqli_query($conn, "SET NAMES UTF8");

	$carpool_id=($data1->carpool_id);
	$carpool_park=($data1->carpool_park);
	$trip_id=($data1->trip_id);
	$trip_mile=($data1->trip_mile);
	$trip_mile_end=($data1->trip_mile_end);
	
	$query2="update tb_car set
	carpool_go = 'จอด',
	carpool_mile = '$trip_mile_end',
	carpool_park = '$carpool_park'
	where carpool_id = '$carpool_id'";
	
	if($trip_mile == $trip_mile_end){
		$query="update tb_trip set
		trip_mile = '$trip_mile',
		trip_mile_end = '$trip_mile_end',
		trip_status = 3
		where trip_id = '$trip_id'";
		
		if (mysqli_query($conn,$query)) {
		echo 2;
		mysqli_query($conn,$query2);
		}else{
		echo 0;
		}
		
	}else{
		$query="update tb_trip set
		trip_mile = '$trip_mile',
		trip_mile_end = '$trip_mile_end',
		trip_status = 2
		where trip_id = '$trip_id'";
		
		if (mysqli_query($conn,$query)) {
		echo 1;
		mysqli_query($conn,$query2);
	}else{
		echo 0;
	}
}
	

		
	
?>