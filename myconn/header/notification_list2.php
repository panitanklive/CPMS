<?php 
//แสดงรายการรถที่ออกเดินทางวันนี้
include("../myconn.php");
$date = date('Y-m-d');
$outpb=""; 
$query = "select * FROM tb_trip where (trip_status = 0) and (trip_start = '$date') order by trip_time asc ";
$result = mysqli_query($conn,$query);
if(mysqli_num_rows($result)>0){
	while($rs = $result->fetch_array(MYSQLI_ASSOC)){
		if ($outpb != "") {$outpb .= ",";}
			$outpb .= '{"carpool_id":"' . $rs["carpool_id"] . '",';
			$outpb .= '"trip_id":"' . $rs["trip_id"] . '",';
			$outpb .= '"trip_end":"' . $rs["trip_end"] . '",';
			$outpb .= '"trip_time":"' . $rs["trip_time"] . '",';
			$outpb .= '"trip_start":"' . $rs["trip_start"] . '"}';
}
$outpb = '['.$outpb.']';
echo ($outpb);
}
else{
	echo '[{"carpool_id":0}]';
}
?>


