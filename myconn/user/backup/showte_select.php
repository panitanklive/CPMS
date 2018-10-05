<?php 
include("../myconn.php");
$id = $_GET['id'];
$query = "select tb_oequ.*,tb_user.* FROM tb_oequ NATURAL JOIN tb_user where (user_id ='$id') order by oequ_id desc";
$outp="";
$date = date('Y-m-d');
$result = mysqli_query($conn,$query);
if(mysqli_num_rows($result)>0){
	while($rs = $result->fetch_array(MYSQLI_ASSOC)){
		if ($outp != "") {$outp .= ",";}
			$outp .= '{"oequ_id":"' . $rs["oequ_id"] . '",';
			$id = $rs["oequ_id"];
$query0 = "select oequ_detail_id FROM tb_oequ_detail  where (oequ_id = '$id') 
and (oequ_detail_volume2  !=0) and (oequ_detail_return < '$date') ";
$ss = mysqli_query($conn,$query0);
if(mysqli_num_rows($ss)>0){$outp .= '"time": "true" ,';}else{$outp .= '"time": "false" ,';}	
			$outp .= '"user_id":"' . $rs["user_id"] . '",';
			$outp .= '"user_name":"' . $rs["user_name"] . '",';
			$outp .= '"user_level":"' . $rs["user_level"] . '",';
			$outp .= '"user_lastname":"' . $rs["user_lastname"] . '",';
			$outp .= '"oequ_teacher":"' . $rs["oequ_teacher"] . '",';
			$outp .= '"oequ_year":"' . $rs["oequ_year"] . '",';
			$outp .= '"oequ_object":"' . $rs["oequ_object"] . '",';
			$outp .= '"oequ_status":"' . $rs["oequ_status"] . '",';
			$outp .= '"oequ_get":"' . $rs["oequ_get"] . '",';
		    $outp .= '"oequ_date":"' . $rs["oequ_date"] . '"}';
	}
$outp = '['.$outp.']';
echo ($outp);
}
?>