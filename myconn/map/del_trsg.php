<?php
include('../myconn.php');
$trsg_id= $_GET['trsg_id'];
$query1 = "DELETE FROM tb_trsg WHERE (trsg_id='$trsg_id')";
if(mysqli_query($conn,$query1)){
	echo 1 ;
}else{
	echo 0 ;
}
?>