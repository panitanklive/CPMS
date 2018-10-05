<?php 
include("../myconn.php");
//$data1=json_decode(file_get_contents("php://input"));
$trip_id=$_GET["trip_id"];

mysqli_query($conn, "SET NAMES UTF8");

$query = "SELECT * FROM tb_passenger  where trip_id='$trip_id' ";
$outp="";
$result = mysqli_query($conn,$query);
if(mysqli_num_rows($result)>0){
	while($rs = $result->fetch_array(MYSQLI_ASSOC)){
		if ($outp != "") {$outp .= ",";}
			$outp .= '{"trip_id":"' . $rs["trip_id"] . '",';
			$outp .= '"passenger_id":"' . $rs["passenger_id"] . '",';	
			$outp .= '"employee_id":"' . $rs["employee_id"] . '",';
			$outp .= '"employee_detail":"' .$rs["employee_detail"].'",';
			$outp .= '"employee_dep":"' . $rs["employee_dep"] . '",';
			$outp .= '"passenger_tel":"' . $rs["passenger_tel"] . '",';
			$outp .= '"passenger_tel_table":"' . $rs["passenger_tel_table"] . '",';
			$outp .= '"passenger_status":"' . $rs["passenger_status"] . '"}';
	}
$outp = '['.$outp.']';
echo ($outp);
			}
?>