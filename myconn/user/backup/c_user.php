<?php 
include("../myconn.php");
//$data1=json_decode(file_get_contents("php://input"));
$user_id=$_GET['id'];

$query = "SELECT * FROM tb_user where user_id='$user_id' ";
$outp="";
$result = mysqli_query($conn,$query);
if(mysqli_num_rows($result)>0){
	while($rs = $result->fetch_array(MYSQLI_ASSOC)){
			$u=$rs["user_id"];	
	}
echo '[{"i":"t"}]';

}else{
	echo '[{"i":"f"}]';
}

?>

