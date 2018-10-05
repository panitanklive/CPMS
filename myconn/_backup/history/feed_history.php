<?php 
include("../myconn.php");
$date = date('Y-m-d');
$query = "SELECT * from tb_car natural join tb_trsg natural join tb_trip where trip_status = '2' ";
$outpb="";
$result = mysqli_query($conn,$query);
	while($rs = $result->fetch_array(MYSQLI_ASSOC)){
		if ($outpb != "") {$outpb .= ",";}
			$outpb .= '{"trip_id":"' . $rs["trip_id"] . '",';
			$outpb .= '"carpool_id":"' . $rs["carpool_id"] . '",';
			$outpb .= '"carpool_brand":"' . $rs["carpool_brand"] . '",';
			$outpb .= '"carpool_model":"' . $rs["carpool_model"] . '",';
			$outpb .= '"trip_sit":"' . $rs["trip_sit"] . '",';	
			$outpb .= '"carpool_sit2":"' . $rs["carpool_sit2"] . '",';
			$outpb .= '"trip_start":"' . $rs["trip_start"] . '",';
			$outpb .= '"trip_status":"' . $rs["trip_status"] . '",';
			$outpb .= '"trip_time":"' . $rs["trip_time"] . '",';	
			$outpb .= '"trip_end":"' . $rs["trip_end"] . '",';
			$outpb .= '"trsg_name":"' . $rs["trsg_name"] . '",';
			$outpb .= '"trsg_map":"' . $rs["trsg_map"] . '"}';
	}
$outpb = '['.$outpb.']';
echo ($outpb);

?>