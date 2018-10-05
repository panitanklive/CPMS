<?php 
include("../myconn.php");
$user_name = $_GET["user_name"];
$query = "SELECT * FROM tb_user where user_name ='$user_name' ";

$outp="";
$result = mysqli_query($conn,$query);
if(mysqli_num_rows($result)>0){
	while($rs = $result->fetch_array(MYSQLI_ASSOC)){
		if ($outp != "") {$outp .= ",";}
			$outp .= '{"user_name":"' . $rs["user_name"] . '",';
		    $outp .= '"name":"' . $rs["name"] . '",';
			
			$outp .= '"password":"' . base64_decode($rs["password"]) . '",';
			if($rs["user_level"]==1){
				$user_level = "ผู้ควบคุมยานพาหนะ";
			}else if($rs["user_level"]==2){
				$user_level = "ผู้ดูแลระบบ";
			}
		    $outp .= '"user_level":"' . $user_level . '"}';
	}
$outp = '['.$outp.']';
echo ($outp);
}?>

