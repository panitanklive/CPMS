<?php 
include("../myconn.php");

$query = "SELECT * from tb_trsg ;";

$outpb="";
$result = mysqli_query($conn,$query);
if(mysqli_num_rows($result)>0){
	while($rs = $result->fetch_array(MYSQLI_ASSOC)){
		if ($outpb != "") {$outpb .= ",";}
			$outpb .= '{"trsg_id":"' . $rs["trsg_id"] . '",';
			$outpb .= '"trsg_name":"' . $rs["trsg_name"] . '",';
			$outpb .= '"trsg_city":"' . $rs["trsg_city"] . '",';
			$outpb .= '"ba_id":"' . $rs["ba_id"] . '",';
			$outpb .= '"ba_name":"' . $rs["ba_name"] . '",';
			$outpb .= '"trsg_map":"' . $rs["trsg_map"] . '"}';
	}

$outpb = '['.$outpb.']';
echo ($outpb);
}
?>