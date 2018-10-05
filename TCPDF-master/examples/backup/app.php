<?php
include('myconn.php');
$data=json_decode(file_get_contents("php://input"));
$student_id=$data->student_id;

$query = "update tb_student set student_level='1' where student_id = '$student_id'";
if(mysqli_query($conn,$query)){
	echo "Data Inserted";
}else{
	echo "error";
}
?>