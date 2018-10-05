<?php 
include("../myconn.php");
$trip_start= $_GET["trip_start"];
$trip_end= $_GET["trip_end"];
$query = "select *  from tb_car WHERE carpool_id not in (SELECT carpool_id FROM tb_trip WHERE (trip_start not between '".$trip_start."' AND '".$trip_end."') 
or (trip_end not between '".$trip_start."' AND '".$trip_end."'))";
$outp="";
$result = mysqli_query($conn,$query);
if(mysqli_num_rows($result)>0){
	while($rs = $result->fetch_array(MYSQLI_ASSOC)){
		if ($outp != "") {$outp .= ",";}
			$outp .= '{"carpool_id":"' . $rs["carpool_id"] . '",';
			$outp .= '"carpool_brand":"' . $rs["carpool_brand"] . '",';
		    $outp .= '"carpool_model":"' . $rs["carpool_model"] . '",';
		    $outp .= '"carpool_type":"' . $rs["carpool_type"] . '",';
			$outp .= '"carpool_sit2":"' . $rs["carpool_sit2"] . '",';
			$outp .= '"carpool_go":"' . $rs["carpool_go"] . '"}';						
	}
$outp = '['.$outp.']';
echo ($outp);
}
?>