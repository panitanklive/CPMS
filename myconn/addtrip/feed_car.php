<?php 
include("../myconn.php");
$carpool_id = $_GET["carpool_id"];
$query = "SELECT * FROM tb_car where carpool_id = '$carpool_id'";
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