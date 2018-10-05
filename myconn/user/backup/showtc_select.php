<?php 
include("../myconn.php");

$id = $_GET['id'];
//$query = "select ochem_id,user_id,user_name,ochem_status,ochem_date FROM tb_ochem NATURAL JOIN tb_user;";
$query = "select tb_ochem.*,tb_user.* FROM tb_ochem NATURAL JOIN tb_user where user_id='$id' order by ochem_id desc ;";
$outp="";
$result = mysqli_query($conn,$query);
if(mysqli_num_rows($result)>0){
	while($rs = $result->fetch_array(MYSQLI_ASSOC)){
		if ($outp != "") {$outp .= ",";}
			$outp .= '{"ochem_id":"' . $rs["ochem_id"] . '",';
			$outp .= '"user_id":"' . $rs["user_id"] . '",';
			$outp .= '"user_name":"' . $rs["user_name"] . '",';
			$outp .= '"user_level":"' . $rs["user_level"] . '",';
			$outp .= '"user_lastname":"' . $rs["user_lastname"] . '",';
			$outp .= '"ochem_teacher":"' . $rs["ochem_teacher"] . '",';
			$outp .= '"ochem_year":"' . $rs["ochem_year"] . '",';
			$outp .= '"ochem_object":"' . $rs["ochem_object"] . '",';
			$outp .= '"ochem_objectd":"' . $rs["ochem_objectd"] . '",';
			$outp .= '"ochem_status":"' . $rs["ochem_status"] . '",';
		    $outp .= '"ochem_date":"' . $rs["ochem_date"] . '"}';
	}
$outp = '['.$outp.']';
echo ($outp);
}
?>