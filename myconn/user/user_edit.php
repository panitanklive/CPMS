<?php 
include("../myconn.php");

$request=json_decode(file_get_contents("php://input"));
$user_name = ($request->user_name);
$password = base64_encode($request->password);
//echo $password;

$query = "update tb_user set password = '$password' where user_name='$user_name'";

if(mysqli_query($conn,$query)){
	echo 1;
}else{
	echo 0;
}

?>

