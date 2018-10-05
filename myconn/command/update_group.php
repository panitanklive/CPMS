<?php

include("../myconn.php");
mysqli_query($conn, "SET NAMES UTF8");
	
	$query1="update tb_employee set
	employee_group = 'กองบริการลูกค้า'
	where employee_dep 
	in('แผนกบริการและงานธุรกิจ',
		'แผนกลูกค้าสัมพันธ์',
		'แผนกมิเตอร์และหม้อแปลง',
		'แผนกแผนธุรกิจ',
		'แผนกวิเคราะห์คุณภาพ',
		'แผนกบริการธุรกิจโทรคมฯ'
	) ";

	if (mysqli_query($conn,$query1)) {
		echo 1;
	}else{
		echo 0;
	}
//////////////////////////////////////////////////////////////////////
	$query2="update tb_employee set
	employee_group = 'กองวิศวกรรมและวางแผน'
	where employee_dep 
	in('แผนกวางแผนระบบไฟฟ้า',
		'แผนกแผนที่ระบบไฟฟ้า',
		'แผนกปรับปรุงระบบไฟฟ้า',
		'แผนกมาตรฐานและทดสอบฯ',
		'แผนกความปลอดภัยและชีวอนามัย',
		'แผนกส่งเสริมพลังงานทดแทนฯ'
	) ";

	if (mysqli_query($conn,$query2)) {
		echo 1;
	}else{
		echo 0;
	}
///////////////////////////////////////////////////////////////////////
	$query2_1="update tb_employee set
	employee_group = 'กองก่อสร้างและบริหารฯ'
	where employee_dep 
	in('แผนกจัดการฯสายส่ง',
		'แผนกก่อสร้างระบบไฟฟ้า',
		'แผนกจัดการและสถานี',
		'แผนกงานโยธาและสถาปัตย์',
		'แผนกยานพาหนะและเครื่องมือกล'
	) ";

	if (mysqli_query($conn,$query2_1)) {
		echo 1;
	}else{
		echo 0;
	}
///////////////////////////////////////////////////////////////////////
	$query3="update tb_employee set
	employee_group = 'กองบัญชี'
	where employee_dep 
	in('แผนกประมวลบัญชี',
		'แผนกบริหารพัสดุ',
		'แผนกบัญชีก่อสร้างและทรัพย์สิน',
		'แผนกบัญชีต้นทุน',
		'แผนกติดตามประเมิลผลการปฏิบัติงาน',
		'แผนกจัดซื้อและจัดจ้าง'
	) ";

	if (mysqli_query($conn,$query3)) {
		echo 1;
	}else{
		echo 0;
	}
///////////////////////////////////////////////////////////////////////
	$query4="update tb_employee set
	employee_group = 'กองซื้อขายไฟฟ้า'
	where employee_dep 
	in('แผนกงบประมาณ',
		'แผนกบริหารการขาย',
		'แผนกเศรฐกิจและวางแผนฯ',
		'แผนกบริหารการซื้อไฟฟ้า',
		'แผนกบริหารหนี้'
	) ";

	if (mysqli_query($conn,$query4)) {
		echo 1;
	}else{
		echo 0;
	}
///////////////////////////////////////////////////////////////////////
	$query5="update tb_employee set
	employee_group = 'กองระบบสารสนเทศ'
	where employee_dep 
	in('แผนกสารสนเทศด้านบริการลูกค้า',
		'แผนกสารสนเทศด้านการจัดองค์กร',
		'แผนกปฏิบัติการเครือข่ายคอมฯ',
		'แผนกปฏิบัติการคอมพิวเตอร์'
	) ";

	if (mysqli_query($conn,$query5)) {
		echo 1;
	}else{
		echo 0;
	}
///////////////////////////////////////////////////////////////////////	
	$query6="update tb_employee set
	employee_group = 'กองปฏิบัติการ'
	where employee_dep 
	in('แผนกควบคุมการจ่ายไฟ',
		'แผนกวิเคราะห์และวางแผนฯ',
		'แผนกระบบควบคุมศูนย์ฯ',
		'แผนกจัดการงานสถานีฯ1',
		'แผนกจัดการงานสถานีฯ2'
	) ";

	if (mysqli_query($conn,$query6)) {
		echo 1;
	}else{
		echo 0;
	}
///////////////////////////////////////////////////////////////////////	
	$query7="update tb_employee set
	employee_group = 'กองบำรุงรักษา'
	where employee_dep 
	in('แผนกบำรุงรักษาสถานีไฟฟ้า',
		'แผนกบำรุงรักษาอุปกรณ์ฯ',
		'แผนกควบคุมและบำรุงรักษาฯ',
		'แผนกรีเลย์และอุปกรณ์ควบคุม',
		'แผนกตรวจสอบและบำรุงรักษา',
		'แผนกปฏิบัติการฮอทไลน์'
	) ";

	if (mysqli_query($conn,$query7)) {
		echo 1;
	}else{
		echo 0;
	}
///////////////////////////////////////////////////////////////////////	
	$query8="update tb_employee set
	employee_group = 'กองระบบสื่อสาร'
	where employee_dep 
	in('แผนกระบบสื่อสารอิเล็กฯ',
		'แผนกโครงข่ายเคเบิ้ลฯ',
		'แผนกสื่อสารสำนักงาน',
		'แผนกสื่อสัญญาณความเร็วสูง'
	) ";

	if (mysqli_query($conn,$query8)) {
		echo 1;
	}else{
		echo 0;
	}
///////////////////////////////////////////////////////////////////////	
	$query9="update tb_employee set
	employee_group = 'กองอำนวยการ'
	where employee_dep 
	in('แผนกบริหารงานทั่วไป',
		'แผนกพัฒนาและฝึกอบรม',
		'แผนกกฏหมาย',
		'แผนกบุคคลและสวัสดิการ',
		'แผนกกิจการสังคมและฯ'
	) ";

	if (mysqli_query($conn,$query9)) {
		echo 1;
	}else{
		echo 0;
	}
///////////////////////////////////////////////////////////////////////	


	
?>