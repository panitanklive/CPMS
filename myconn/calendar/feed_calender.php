<?php 
include("../myconn.php");
$carpool_id = $_GET['carpool_id'];
$query = "SELECT * from tb_trip natural join tb_trsg where carpool_id = '$carpool_id' and trip_status < 3 ";
$outpb="";
$result = mysqli_query($conn,$query);
if(mysqli_num_rows($result)>0){
	while($rs = $result->fetch_array(MYSQLI_ASSOC)){
		if ($outpb != "") {$outpb .= ",";}
			$outpb .= '{"trip_id":"' . $rs["trip_id"] . '",';
			$outpb .= '"title":"' . $rs["trsg_name"] . '",';
			$outpb .= '"start":"' . $rs["trip_start"] . '",';
			$end = date("Y-m-d", strtotime("+1 day", strtotime($rs["trip_end"])));
			$outpb .= '"end":"'.$end.'",';
			$outpb .= '"trip_time":"' . $rs["trip_time"] . '",';
			$outpb .= '"trsg_map":"' . $rs["trsg_map"] . '"}';
	}
$outpb = '['.$outpb.']';
}else if(mysqli_num_rows($result)<=0){
$outpb ='[{"start":"","end":"","title":""}]';
}
echo ($outpb);
?>