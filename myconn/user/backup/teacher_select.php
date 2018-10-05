<?php 
include("../myconn.php");
$query = "SELECT * FROM tb_user where user_id !='admin' and user_level in('อาจารย์')  and user_live in('ในระบบ') order by user_name asc;";
$outp="";
$result = mysqli_query($conn,$query);
if(mysqli_num_rows($result)>0){
	while($rs = $result->fetch_array(MYSQLI_ASSOC)){
		if ($outp != "") {$outp .= ",";}
			$outp .= '{"user_id":"' . $rs["user_id"] . '",';
			//$outp .= '"user_pass":"' . $rs["user_pass"] . '",';
		   	$outp .= '"user_name":"' . $rs["user_name"] . '",';
		    $outp .= '"user_lastname":"' . $rs["user_lastname"] . '",';
		    //$outp .= '"user_group":"' . $rs["user_group"] . '",';
		    //$outp .= '"user_tel":"' . $rs["user_tel"] . '",';
		    $outp .= '"user_level":"' . $rs["user_level"] . '",';
		    $outp .= '"user_date":"' . $rs["user_date"] . '"}';
	}
$outp = '['.$outp.']';
echo ($outp);
}?>

