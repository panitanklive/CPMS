<?php 
include("../myconn.php");
$data1=json_decode(file_get_contents("php://input"));
$user_id=($data1->user_id);

$query = "SELECT * FROM tb_user where user_name='$user_id' ";
$outp="";
$result = mysqli_query($conn,$query);
if(mysqli_num_rows($result)>0){
	while($rs = $result->fetch_array(MYSQLI_ASSOC)){
			$outp .= '{"user_name":"' . $rs["user_name"] . '",';
		   	$outp .= '"name":"' . $rs["name"] . '",';
		    $outp .= '"user_level":"' . $rs["user_level"]  . '"}';
	}
$outp = '['.$outp.']';
echo ($outp);
}else{
	echo '[{"user_name":"ผู้ใช้ทั่วไป","user_level":0}]';
}

?>

