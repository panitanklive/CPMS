<?php 
include("../myconn.php");

$carpool_id = $_GET["carpool_id"];

$query = "SELECT * from tb_car where carpool_id = '$carpool_id'";

$result = mysqli_query($conn,$query);
if(mysqli_num_rows($result)>0){
	while($rs = $result->fetch_array(MYSQLI_ASSOC)){
			$carpool_mile= $rs["carpool_mile"];
			$carpool_brand = $rs["carpool_brand"];
			$carpool_type= $rs["carpool_type"];
	}
echo  '[{"call":"'.$carpool_mile.'","carpool_brand":"'.$carpool_brand.'","carpool_type":"'.$carpool_type.'"}]' ;
//echo $carpool_mile;
}else{
	//echo '[{"call":"no"}]' ;
}	//echo "no"
?>