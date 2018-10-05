
<?php

include("../myconn.php");

$data1=json_decode(file_get_contents("php://input"));
mysqli_query($conn, "SET NAMES UTF8");

if(count($data1)>0){
	$user_id=($data1->user_id);
	$user_pass=($data1->user_pass);
	$user_name=($data1->user_name);
	$user_lastname=($data1->user_lastname);
	$user_group=($data1->user_group);
	$user_tel=($data1->user_tel);
	$user_level=($data1->user_level);
	$user_address=($data1->user_address);
	$user_email=($data1->user_email);

 $query="insert into tb_user(user_id,user_pass,user_name,user_lastname,
 user_group,user_tel,user_level,user_address,user_email) values 
 ('$user_id','$user_pass','$user_name','$user_lastname',Upper('$user_group'),
 '$user_tel','ไม่อนุมัติ','$user_address','$user_email')";
	if (mysqli_query($conn,$query)) {
		echo "yes";
		$test = "มีคำขอเป็นสมาชิกใหม่ : ".$user_id." ".$user_name." ".$user_lastname."  ";	
		include("../line.php");	
	}

}
?>