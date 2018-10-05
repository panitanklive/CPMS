<?php 
include("../myconn.php");
$id = $_GET["id"];
$date = date('Y-m-d');
$sql= "select ochem_id,count(ochem_id) as peet FROM tb_ochem where ochem_status='รอดำเนินการ' ";  
$result = mysqli_query($conn,$sql);
if(mysqli_num_rows($result)>0){
	while($rs = $result->fetch_array(MYSQLI_ASSOC))
	    $outp = $rs["peet"];
	}
$sql2= "select oequ_id,count(oequ_id) as peet2 FROM tb_oequ where oequ_status='รอดำเนินการ' ";
$result2 = mysqli_query($conn,$sql2);
if(mysqli_num_rows($result2)>0){
	while($rs2 = $result2->fetch_array(MYSQLI_ASSOC))
	    $outp2 = $rs2["peet2"];
}else{
	 $outp2 = 0;
}
$sql3= "select count(damage_id) as peet3 FROM tb_damage where damage_status !='ชดใช้แล้ว' and '$date' > damage_return";
$result3 = mysqli_query($conn,$sql3);
if(mysqli_num_rows($result3)>0){
	while($rs3 = $result3->fetch_array(MYSQLI_ASSOC))
	    $outp3 = $rs3["peet3"];
}


$sql4= "select count(DISTINCT(oequ_id)) as peet4 FROM tb_oequ_detail WHERE
 (oequ_detail_volume2  !=0) and ('$date' > oequ_detail_return ); ";
 
$result4 = mysqli_query($conn,$sql4);
if(mysqli_num_rows($result4)>0){
	while($rs4= $result4->fetch_array(MYSQLI_ASSOC))
	    $outp4 = $rs4["peet4"];
}

$sql42= "select count(damage_id) as peet42 FROM tb_damage WHERE user_id='$id' and damage_status !='ชดใช้แล้ว' and '$date' > damage_return";
 
$result42 = mysqli_query($conn,$sql42);
if(mysqli_num_rows($result42)>0){
	while($rs42= $result42->fetch_array(MYSQLI_ASSOC))
	    $outp42 = $rs42["peet42"];
}

$sql5= "select count(DISTINCT(oequ_id)) as peet5 FROM tb_oequ_detail natural join tb_oequ WHERE user_id='$id' and
 (oequ_detail_volume2  !=0) and ('$date' > oequ_detail_return ); ";

$result5 = mysqli_query($conn,$sql5);
if(mysqli_num_rows($result5)>0){
	while($rs5= $result5->fetch_array(MYSQLI_ASSOC))
	    $outp5 = $rs5["peet5"];
}else{
	 $outp5 = 0;
}


$outp6 = '[{"peet":"'.$outp.'","peet2":"'.$outp2.'","peet3":"'.$outp3.'","peet4":"'.$outp4.'","peet42":"'.$outp42.'","peet5":"'.$outp5.'"}]';
echo ($outp6);

?>

