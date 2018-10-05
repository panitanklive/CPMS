<?php
include("../myconn.php");
mysqli_query($conn, "SET NAMES UTF8");
$json = file_get_contents('php://input');
$data = json_decode($json,true);

foreach($data as $row) {
	$sql = "insert into tb_passenger 
	(employee_id,trip_id,employee_detail,employee_dep,passenger_tel,passenger_tel_table,passenger_status) 
	values 
	('".$row["employee_id"]."','".trim($row["trip_id"],"  ")."', '".$row["employee_detail"]."', '".$row["employee_dep"]."', '".$row["passenger_tel"]."', '".$row["passenger_tel_table"]."', '".$row["passenger_status"]."')";	
	if (mysqli_query($conn,$sql)) {
		echo 1;
	}else{
		echo 0;
	}
  }
?>