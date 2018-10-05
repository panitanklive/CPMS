
<?php

include("../myconn.php");

$data1=json_decode(file_get_contents("php://input"));
mysqli_query($conn, "SET NAMES UTF8");

if(count($data1)>0){
	$user_id=($data1->user_id);
	$user_pass=($data1->user_pass);
	$user_name=($data1->user_name);
	$user_lastname=($data1->user_lastname);
	$user_group=($data1->user_group);
	$user_tel=($data1->user_tel);
	$user_level=($data1->user_level);
	$user_address=($data1->user_address);
	$user_email=($data1->user_email);
	$user_live=($data1->user_live);
	$btnName=($data1->btnName);
	//echo $btnName;

if($btnName =='เพิ่ม'){
 $query="insert into tb_user(user_id,user_pass,user_name,user_lastname,
 user_group,user_tel,user_level,user_address,user_email,user_live) values 
 ('$user_id','$user_pass','$user_name','$user_lastname',Upper('$user_group'),
 '$user_tel','$user_level','$user_address','$user_email','$user_live')";
	if (mysqli_query($conn,$query)) {
		echo "yes";
		# code...
	}else{
		echo "no";
	}
}

if($btnName =='แก้ไข'){
	$query="update tb_user set 
									user_pass ='$user_pass',
									user_name ='$user_name',
									user_lastname = '$user_lastname',
									user_group = '$user_group',
									user_tel = '$user_tel',
									user_level = '$user_level',
									user_address='$user_address',
									user_email='$user_email',
										user_live='$user_live'
									where user_id = '$user_id'";
									
	if (mysqli_query($conn,$query)) {
		echo "yes";
		# code...
	}else{
		echo "no";
	}

}
}
?>