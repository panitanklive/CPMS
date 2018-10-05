<?php

include("../myconn.php");

$data1=json_decode(file_get_contents("php://input"));
mysqli_query($conn, "SET NAMES UTF8");

	$carpool_id=($data1->carpool_id);
	$carpool_brand=($data1->carpool_brand);
	$carpool_model=($data1->carpool_model);
	$carpool_type=($data1->carpool_type);
	$carpool_sit2=($data1->carpool_sit2);
	$carpool_mile=($data1->carpool_mile);
	$carpool_park=($data1->carpool_park);
	$btnName=($data1->btnName);

	if($btnName =='แก้ไข'){
	$query="update tb_car set
	carpool_id ='$carpool_id',
	carpool_brand = '$carpool_brand',
	carpool_model = '$carpool_model',
	carpool_sit2 = '$carpool_sit2',
	carpool_type = '$carpool_type',
	carpool_mile = '$carpool_mile',
	carpool_park = '$carpool_park'
	where carpool_id = '$carpool_id'";
	
	if (mysqli_query($conn,$query)) {
		echo 1;
	}else{
		echo 2;
	}
}

	
	

?>