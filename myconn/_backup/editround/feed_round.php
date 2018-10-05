<?php 
include("../myconn.php");
$trip_id=$_GET["trip_id"];
mysqli_query($conn, "SET NAMES UTF8");
$query = "SELECT * FROM tb_trip where trip_id = '$trip_id' ";
$outp="";
$result = mysqli_query($conn,$query);
if(mysqli_num_rows($result)>0){
	while($rs = $result->fetch_array(MYSQLI_ASSOC)){
		if ($outp != "") {$outp .= ",";}
			$outp .= '{"trip_id":"' . $rs["trip_id"] . '",';	
			$outp .= '"trip_start":"' . $rs["trip_start"] . '",';
			$outp .= '"trip_time":"' . $rs["trip_time"] . '",';
			$outp .= '"trip_end":"' . $rs["trip_end"] . '",';
			$outp .= '"trip_sit":"' . $rs["trip_sit"] . '",';				
		    $outp .= '"trsg_id":"' . $rs["trsg_id"] . '"}';
	}
$outp = '['.$outp.']';
echo ($outp);
			}
?>