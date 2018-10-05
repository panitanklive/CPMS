<?php 
include("../myconn.php");
$data1=json_decode(file_get_contents("php://input"));
$user_id=($data1->user_id);
$user_pass=($data1->user_pass);

	$query="update tb_user set user_pass ='$user_pass' where user_id = '$user_id'";
									
	if (mysqli_query($conn,$query)) {
		echo "yes";
		# code...
	}else{
		echo "no";
	}

?>

