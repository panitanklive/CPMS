<?php 
include("../myconn.php");
$carpool_id = $_GET["carpool_id"];

$query = "SELECT * from tb_car where carpool_id = '$carpool_id' ";

$outpb="";
$result = mysqli_query($conn,$query);
if(mysqli_num_rows($result)>0){
	while($rs = $result->fetch_array(MYSQLI_ASSOC)){
		if ($outpb != "") {$outpb .= ",";}
			$outpb .= '{"carpool_id":"' . $rs["carpool_id"] . '",';
			$outpb .= '"carpool_brand":"' . $rs["carpool_brand"] . '",';
			$outpb .= '"carpool_model":"' . $rs["carpool_model"] . '",';
			$outpb .= '"carpool_sit2":"' . $rs["carpool_sit2"] . '",';
			$outpb .= '"carpool_type":"' . $rs["carpool_type"] . '",';
			$outpb .= '"carpool_go":"' . $rs["carpool_go"] . '",';
			$outpb .= '"carpool_mile":"' . $rs["carpool_mile"] . '",';
			$outpb .= '"carpool_park":"' . $rs["carpool_park"] . '",';
			$outpb .= '"carpool_use":"' . $rs["carpool_use"] . '"}';
	}

$outpb = '['.$outpb.']';
echo ($outpb);
}
?>