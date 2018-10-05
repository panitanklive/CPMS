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

	if($btnName =='เพิ่ม'){
	$query="insert into tb_car(carpool_id,carpool_brand,carpool_model,carpool_sit2,carpool_type,carpool_park)
 values ('$carpool_id','$carpool_brand','$carpool_model','$carpool_sit2','$carpool_type','$carpool_mile','$carpool_park')";
	
	
	if (mysqli_query($conn,$query)) {
		echo 1;
		# code...
	}else{
		echo 2;
	}
}

	
	

?>