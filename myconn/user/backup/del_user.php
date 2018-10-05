<?php
include('../myconn.php');

$id = $_GET['id'];

$query = "delete from tb_user where user_id = '$id'";
if(mysqli_query($conn,$query)){
	echo '[{"where":"yes"}]';
}else{
	echo '[{"where":"no"}]';
}

?>