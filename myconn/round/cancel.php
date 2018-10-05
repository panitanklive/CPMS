<?php
include('../myconn.php');
$trip_id = $_GET['trip_id'];

$query1 = "DELETE FROM tb_trip  WHERE (trip_id='$trip_id')";
$query2 = "DELETE FROM tb_passenger WHERE (trip_id='$trip_id')";

if(mysqli_query($conn,$query1)){
	echo 1 ;
}else{
	echo 0 ;
}


if(mysqli_query($conn,$query2)){
	echo 1 ;
}else{
	echo 0 ;
}

?>