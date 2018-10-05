<?php 
include("../myconn.php");
$trip_start = $_GET["trip_start"];
$trip_end = $_GET["trip_end"];

$query = "
select * from tb_car where carpool_id  not in ((select carpool_id from tb_trip natural join tb_car WHERE ((trip_start between '".$trip_start."' AND '".$trip_end."') or
(trip_end  between '".$trip_start."' AND '".$trip_end."')) AND (carpool_use = 1) AND (trip_status < 3))) AND carpool_go not in('ซ่อมบำรุง')";

$outpb="";
$result = mysqli_query($conn,$query);
if(mysqli_num_rows($result) != null ){
	while($rs = $result->fetch_array(MYSQLI_ASSOC)){
		if ($outpb != "") {$outpb .= ",";}
			$outpb .= '{"carpool_id":"' . $rs["carpool_id"] . '",';
			$outpb .= '"carpool_brand":"' . $rs["carpool_brand"] . '",';
			$outpb .= '"carpool_model":"' . $rs["carpool_model"] . '",';
			$outpb .= '"carpool_sit2":"' . $rs["carpool_sit2"] . '",';
			$outpb .= '"carpool_type":"' . $rs["carpool_type"] . '",';
			$outpb .= '"carpool_go":"' . $rs["carpool_go"] . '",';
			$outpb .= '"carpool_use":"' . $rs["carpool_use"] . '"}';
	}

}else if (mysqli_num_rows($result)==null){
	$query2 = "SELECT * from tb_car where carpool_use = 1 AND carpool_go not in('ซ่อมบำรุง')";
	$result2 = mysqli_query($conn,$query2);
	while($rs = $result2->fetch_array(MYSQLI_ASSOC)){
		if ($outpb != "") {$outpb .= ",";}
			$outpb .= '{"carpool_id":"' . $rs["carpool_id"] . '",';
			$outpb .= '"carpool_brand":"' . $rs["carpool_brand"] . '",';
			$outpb .= '"carpool_model":"' . $rs["carpool_model"] . '",';
			$outpb .= '"carpool_sit2":"' . $rs["carpool_sit2"] . '",';
			$outpb .= '"carpool_type":"' . $rs["carpool_type"] . '",';
			$outpb .= '"carpool_go":"' . $rs["carpool_go"] . '",';
			$outpb .= '"carpool_use":"' . $rs["carpool_use"] . '"}';
	}
}
$outpb = '['.$outpb.']';
echo ($outpb);
?>