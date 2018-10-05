<?php 
	include("../myconn.php");
	session_start();
	require_once("idm-service.php");
	$service = new IDMService();
	$userName= $_GET["employee_id"];
	
	if($userName!=""){
		//echo $userName."2".$password;
//		$results = $service->login('76A167DD-3936-4443-A1EB-198E71456E27',$userName, $password); 
		$results1 = $service->getEmployeeInfoByUsername("93567815-dfbb-4727-b4da-ce42c046bfca",$userName);		
		if(isset($results1['GetEmployeeInfoByUsernameResult']['ResultObject']['TitleFullName'])){
			$employee_detail =	$results1['GetEmployeeInfoByUsernameResult']['ResultObject']['TitleFullName'].$results1['GetEmployeeInfoByUsernameResult']['ResultObject']['FirstName'] ." ". $results1['GetEmployeeInfoByUsernameResult']['ResultObject']['LastName'];
			$employee_dep = $results1['GetEmployeeInfoByUsernameResult']['ResultObject']['DepartmentFullName']; 
			echo '[{"employee_detail":"'.$employee_detail.'","employee_dep":"'.$employee_dep.'"}]';
		}
			else{
			echo '[{"employee_detail":"ไม่พบพนักงาน"}]';
			}
		}
	
//TitleFullName คำนำหน้า
//DepartmentShortName แผนกเต็ม
//DepartmentFullName แผนกย่อ

?>

