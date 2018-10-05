<?php 
//ทำให้รถออกเดินทาง auto ตามเวลาที่เริ่มเดินทาง
include("../myconn.php");
$date = date("Y-m-d").' '.date("H:i");

$sql = "update tb_trip SET trip_status = 1 where (trip_status = 0) and ('$date' >= CONCAT(trip_start,' ',trip_time))";
mysqli_query($conn,$sql);

$sql2 = "select carpool_id from tb_trip natural join tb_car where (trip_status = 1) and (carpool_go = 'จอด' ) "; 
$result2 = mysqli_query($conn,$sql2);

if(mysqli_num_rows($result2)>0){
	while($rs = $result2->fetch_array(MYSQLI_ASSOC)){
	       $carpool_id = $rs["carpool_id"];
		   $sql3 = "update tb_car SET carpool_go = 'เดินทาง'     where carpool_id = '$carpool_id' "; 
	mysqli_query($conn,$sql3);		  
 } echo  '[{"get":"'.$carpool_id.'"}]' ;
}else{
	echo '[{"get":0}]' ;
}
?>

