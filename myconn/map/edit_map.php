<?php
include("../myconn.php");
$data1=json_decode(file_get_contents("php://input"));
mysqli_query($conn, "SET NAMES UTF8");

	$trsg_id=($data1->trsg_id);
	$trsg_name=($data1->trsg_name);
	$trsg_city=($data1->trsg_city);
	$trsg_map=($data1->trsg_map);
	$btnName=($data1->btnName);

	if($btnName =='แก้ไข'){
	$query="update tb_trsg set
	trsg_name = '$trsg_name',
	trsg_city = '$trsg_city',
	trsg_map = '$trsg_map'
	where trsg_id = '$trsg_id'";
	
	if (mysqli_query($conn,$query)) {
		echo 1;
	}else{
		echo 2;
	}
}

	
	

?>