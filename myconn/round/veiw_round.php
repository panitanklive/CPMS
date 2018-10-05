<?php 
include("../myconn.php");
//$date =date("Y-m-d");
//$time = date("H:i");
$trip_id = $_GET["trip_id"];
$query = "SELECT * from tb_trip natural join tb_trsg natural join tb_car where trip_id ='$trip_id '";

$outpb="";
$result = mysqli_query($conn,$query);
if(mysqli_num_rows($result)>0){
	while($rs = $result->fetch_array(MYSQLI_ASSOC)){
		if ($outpb != "") {$outpb .= ",";}
			$outpb .= '{"trip_id":"' . $rs["trip_id"] . '",';
			$outpb .= '"carpool_id":"' . $rs["carpool_id"] . '",';
			$outpb .= '"carpool_brand":"' . $rs["carpool_brand"] . '",';
			$outpb .= '"carpool_model":"' . $rs["carpool_model"] . '",';
			$outpb .= '"trip_sit":"' . $rs["trip_sit"] . '",';	
			$outpb .= '"carpool_sit2":"' . $rs["carpool_sit2"] . '",';
			$outpb .= '"carpool_type":"' . $rs["carpool_type"] . '",';
			$outpb .= '"trip_start":"' . $rs["trip_start"] .'",';
			$outpb .= '"trip_time":"' . $rs["trip_time"] . '",';
			$outpb .= '"trip_end":"' . $rs["trip_end"] .'",';
			$outpb .= '"trsg_id":"' . $rs["trsg_id"] . '",';
			$outpb .= '"trsg_name":"' . $rs["trsg_name"] . '",';
			$outpb .= '"trsg_map":"' . $rs["trsg_map"] . '"}';
	}

$outpb = '['.$outpb.']';
echo ($outpb);
}else{
	echo '[{"trip_id":""}]' ;
}
?>