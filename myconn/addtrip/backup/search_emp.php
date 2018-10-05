<?php 
include("../myconn.php");

$employee_id=$_GET['employee_id'];

$query = "SELECT * FROM tb_employee where employee_id='$employee_id' ";
$outp="";
$result = mysqli_query($conn,$query);
if(mysqli_num_rows($result)>0){
	while($rs = $result->fetch_array(MYSQLI_ASSOC)){
			$employee_title = $rs["employee_title"];
			$employee_id = $rs["employee_id"];
			$employee_firstname = $rs["employee_firstname"];
			$employee_lastname = $rs["employee_lastname"];
			$employee_group = $rs["employee_group"];
			$employee_dep = $rs["employee_dep"];

	}
	
$employee_detail = $employee_title.$employee_firstname."  ".$employee_lastname;
	
echo '[{"employee_id": "'.$employee_id.'","employee_detail": "'.$employee_detail.'","employee_dep":"'.$employee_dep.'","passenger_tel":"","passenger_tel_table":""}]';

}else{
	echo '[{"employee_detail":""}]';
}

?>
