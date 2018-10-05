<?php

include("../myconn.php");
$carpool_id = $_GET["carpool_id"];

	$query="update tb_car set
	carpool_use = '0' where carpool_id = '$carpool_id'";
	
	if (mysqli_query($conn,$query)) {
		echo 1;
	}else{
		echo 0;
	}


	
	

?>