<?php
include("../myconn.php");
$data1=json_decode(file_get_contents("php://input"));
mysqli_query($conn, "SET NAMES UTF8");

	$trsg_id=($data1->trsg_id);
	$trsg_name=($data1->trsg_name);
	$trsg_city=($data1->trsg_city);
	$trsg_map=($data1->trsg_map);
	$btnName=($data1->btnName);

	if($btnName =='เพิ่ม'){
	$query="insert into tb_trsg(trsg_id,trsg_name,trsg_city,trsg_map)
 values ('$trsg_id','$trsg_name','$trsg_city','$trsg_map')";
	
	if (mysqli_query($conn,$query)) {
		echo 1;
	}else{
		echo 2;
	}
}

?>