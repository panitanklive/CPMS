<?php
include("../myconn.php");
mysqli_query($conn, "SET NAMES UTF8");
$json = file_get_contents('php://input');
$data = json_decode($json,true);

foreach($data as $row) {
	$sql = "insert into tb_oil
	(oil_mile,trip_id,oil_price,oil_liter,oil_net) 
	values 
	('".$row["oil_mile"]."','".trim($row["trip_id"],"  ")."', '".$row["oil_price"]."', '".$row["oil_liter"]."', '".$row["oil_net"]."')";	
	if (mysqli_query($conn,$sql)) {
		echo 1;
	}else{
		echo 0;
	}
  }
  
?>