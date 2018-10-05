<?php 
include("../myconn.php");
$query = "SELECT * FROM tb_trsg";
$outp="";
$result = mysqli_query($conn,$query);
if(mysqli_num_rows($result)>0){
	while($rs = $result->fetch_array(MYSQLI_ASSOC)){
		if ($outp != "") {$outp .= ",";}
			$outp .= '{"trsg_id":"' . $rs["trsg_id"] . '",';
			$outp .= '"trsg_name":"' . $rs["trsg_name"] . '",';
		    $outp .= '"ba_id":"' . $rs["ba_id"] . '",';	   
			$outp .= '"ba_name":"' . $rs["ba_name"] . '",';				
		    $outp .= '"trsg_map":"' . $rs["trsg_map"] . '"}';   

	
	}
$outp = '['.$outp.']';
echo ($outp);
}
?>