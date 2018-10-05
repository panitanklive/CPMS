<?php

include("../myconn.php");

$carpool_id = $_GET["carpool_id"];
$btn = $_GET["btn"];

	if($btn =='send'){
	$query="update tb_car set
	carpool_go = 'ซ่อมบำรุง'
	where carpool_id = '$carpool_id'";
	
}else if($btn =='back'){
	$query="update tb_car set
	carpool_go = 'จอด'
	where carpool_id = '$carpool_id'";
}

if (mysqli_query($conn,$query)) {
		echo 1;
	}else{
		echo 0;
	}

	
	

?>