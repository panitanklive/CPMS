<?php
include("../myconn.php");
$data1=json_decode(file_get_contents("php://input"));
mysqli_query($conn, "SET NAMES UTF8");

	$carpool_id=($data1->carpool_id);
	$trip_id=($data1->trip_id);
	$trip_mile=($data1->trip_mile);

	$query="update tb_trip set
	trip_mile = '$trip_mile',
	trip_status = '1'
	where trip_id = '$trip_id'";
	//echo $query;
	
	$query2="update tb_car set
	carpool_go = 'เดินทาง'
	where carpool_id = '$carpool_id'";
	
if (mysqli_query($conn,$query)) {
		echo 1;
		mysqli_query($conn,$query2);
	}else{
		echo 0;
	}

	
?>