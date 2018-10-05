<?php

include("myconn.php");
$request=json_decode(file_get_contents("php://input"));
$user_id = mysqli_real_escape_string($conn,$request->user_id);
$user_pass = mysqli_real_escape_string($conn,base64_encode($request->user_pass));

$strSQL = "select * from tb_user where ((user_name = '$user_id') and (password = '$user_pass'))";
$objQuery = mysqli_query($conn,$strSQL);
	$objResult = mysqli_fetch_array($objQuery);
	if(!$objResult){
		echo "0";
	}else{
		
		echo "1" ;
	}
	
?>