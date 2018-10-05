<?php 
include("../myconn.php");

$id = $_GET['id'];
$date = date('Y-m-d');	
$query = "select tb_damage.*,tb_user.* FROM tb_damage NATURAL JOIN tb_user where user_id='$id' order by damage_id desc ;";
$outp="";
$result = mysqli_query($conn,$query);
if(mysqli_num_rows($result)>0){
	while($rs = $result->fetch_array(MYSQLI_ASSOC)){
		if ($outp != "") {$outp .= ",";}
			$outp .= '{"damage_id":"' . $rs["damage_id"] . '",';
			$outp .= '"user_id":"' . $rs["user_id"] . '",';
			$outp .= '"user_name":"' . $rs["user_name"] . '",';
			$outp .= '"user_level":"' . $rs["user_level"] . '",';
			$outp .= '"user_lastname":"' . $rs["user_lastname"] . '",';
			$outp .= '"damage_year":"' . $rs["damage_year"] . '",';
			$outp .= '"damage_sum":"' . $rs["damage_sum"] . '",';
			$outp .= '"damage_status":"' . $rs["damage_status"] . '",';
			$outp .= '"damage_return":"' . $rs["damage_return"] . '",';
			if($rs["damage_return"] < $date && $rs["damage_status"] !='ชดใช้แล้ว' ){
			$outp .= '"time": "true" ,';
			} else{
			$outp .= '"time": "false" ,';
			}
		    $outp .= '"damage_date":"' . $rs["damage_date"] . '"}';
	}
$outp = '['.$outp.']';
echo ($outp);
}
?>