<?php

if($_GET["key"]=='88385427e706fcce259c5b9db1e3b6b3'){
	cclean();
}

function cclean() {
	include("../myconn.php");
	mysqli_query($conn, "SET NAMES UTF8");
	$query1="delete from tb_passenger"; 
	
	if (mysqli_query($conn,$query1)) {
		echo 1;
	}else{
		echo 0;
	}
//////////////////////////////////////////////////////////////////////
	$query2="delete from tb_trip";

	if (mysqli_query($conn,$query2)) {
		echo 1;
	}else{
		echo 0;
	}
///////////////////////////////////////////////////////////////////////
	$query3="delete from tb_oil";

	if (mysqli_query($conn,$query3)) {
		echo 1;
	}else{
		echo 0;
	}
///////////////////////////////////////////////////////////////////////
	$query4="update tb_car set
	carpool_go = 'จอด',
	carpool_use = '1',
	carpool_mile = '0',
	carpool_park = 'โรงอาหาร' 
	";
	if (mysqli_query($conn,$query4)) {
		echo 1;
	}else{
		echo 0;
	}

}


	
	

	
?>