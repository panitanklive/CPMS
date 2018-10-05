<?php
header("Content-type:text/html; charset=UTF-8");                
header("Cache-Control: no-store, no-cache, must-revalidate");               
header("Cache-Control: post-check=0, pre-check=0", false);    

$carpool_id = $_GET["carpool_id"];
$date_m = date('Y-m-d',strtotime($_GET["date"]. "-1 days"));
$date_p = date('Y-m-d',strtotime($_GET["date"]. "+1 days"));	
$_month_name = array("01"=>"มกราคม",  "02"=>"กุมภาพันธ์",  "03"=>"มีนาคม",    
		"04"=>"เมษายน",  "05"=>"พฤษภาคม",  "06"=>"มิถุนายน",    
		"07"=>"กรกฎาคม",  "08"=>"สิงหาคม",  "09"=>"กันยายน",    
		"10"=>"ตุลาคม", "11"=>"พฤศจิกายน",  "12"=>"ธันวาคม"); 
		$vardate=date('Y-m-d');
		$yy=date('Y');
		$mm =date('m');$dd=date('d'); 
		if ($dd<10){
		$dd=substr($dd,1,2);
		}
		$date=$dd ." ".$_month_name[$mm]."  ".$yy+= 543;
		
function fetch_data2(){ 
$i=0;
	$output ='';
	include("../../myconn/myconn.php");
        $sql="select * FROM tb_oil WHERE trip_id = '".$_SESSION["trip_id"]."'  ";
		$result = mysqli_query($conn,$sql);
		while($row = $result->fetch_assoc()){
				 	$i++;
$output .='
 <tr>
    <td align="center">'.$i.'.</td>
	<td align="center">'.$row["oil_mile"].'</td>
  	<td align="center">'.$row["oil_price"].' บาท.</td>
	<td align="center">'.$row["oil_liter"].' ลิตร</td>
	<td align="center">'.$row["oil_net"].' บาท.</td>
  </tr>';
}
$var = 3-$i;
for ($i1=0; $i1 < $var ; $i1++) { 
$output .='        
<tr>
    <td></td>
	<td></td>
 	<td></td>
	<td></td>
 	<td></td>
</tr>';
}

return $output;
}

require_once('tcpdf_include.php');
class MYPDF extends TCPDF {
    //Page header
    public function Header() {
        // Logo
		$image_file = K_PATH_IMAGES.'gg.png';
        $this->Image($image_file, 25, 15, 19, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $image_file = K_PATH_IMAGES.'sci.png';
        $this->Image($image_file, 50, 15, 14.5, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('thsarabun', 'B', 16, '', true);
        // Title
        $this->Ln(5);
        $this->Cell(183, 5, 'รายงานรถยนต์ที่พบปัญหา', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln();
       // $this->SetFont('thsarabun', '', 14, '', true);
        $this->Cell(183, 5, 'การไฟฟ้าส่วนภูมิภาค เขต 1 (ภาคกลาง)', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln();
    }
    // Page footer
    public function Footer() {
         // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('thsarabun', '', 14, '', true);
        // Page number
		$image_file = K_PATH_IMAGES.'qr.png';
        $this->Image($image_file, 15, 260, 22, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $image_file = K_PATH_IMAGES.'sci.png';
        $this->Image($image_file, 50, 15, 14.5, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		$this->SetFont('thsarabun', 'B', 14, '', true);
        // Title
        $this->Ln(250);
        $this->Cell(2, 5, '                        ขั้นตอนและข้อกำหนดในการใช้รถยนต์ ', 0, false, 'l', 0, '', 0, false, 'M', 'M');
        $this->Ln();
       // $this->SetFont('thsarabun', '', 14, '', true);
        $this->Cell(0, 5, '                        สแกน qr code เพื่ออ่านเพิ่มเติม', 0, false, '', 0, '', 0, false, 'M', 'M');
        $this->Ln();
		$this->Cell(0, 5, '                        หากมีข้อสงสัยกรุณาติดต่อ แผนกยานพาหนะและเครื่องมือกล (10173)', 0, false, '', 0, '', 0, false, 'M', 'M');
        $this->Ln();
    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


$pdf->SetCreator(PDF_CREATOR);

$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('รายงานรถยนต์ที่พบปัญหา/การไฟฟ้าส่วนภูมิภาค เขต 1 (ภาคกลาง)');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
$pdf->setFooterData(array(0,64,0), array(0,64,128));

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
	require_once(dirname(__FILE__).'/lang/eng.php');
	$pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
$pdf->SetFont('thsarabun', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
$pdf->AddPage();

// set text shadow effect
//$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
$html .= ochem_id();

function passenger(){
	$output ='';
	include("../../myconn/myconn.php");
	 $sql="select * FROM  tb_passenger WHERE trip_id = '".$_SESSION["trip_id"]."' ";
		$result = mysqli_query($conn,$sql);
		while($row = $result->fetch_assoc()){
				 	$i++;	
		$employee_id=$row["employee_id"];
		$employee_detail=$row["employee_detail"];
		$passenger_tel=$row["passenger_tel"];
		$passenger_tel_table=$row["passenger_tel_table"];
		$employee_dep=$row["employee_dep"];
		$passenger_status=$row["passenger_status"];
		$var = 11-$i;
		$output .= '
		<tr>
			<td align="center">'.$i.'.</td>
			<td align="center">'.$employee_id.'</td>
			<td align="left">&nbsp;&nbsp;'.$employee_detail.'</td>
			<td align="center">'.$passenger_tel.'</td>
			<td align="center">'.$passenger_tel_table.'</td>
			<td align="center">'.$employee_dep.'</td>
			<td align="center">'.$passenger_status.'</td>
		</tr>';
		for ($i1=0; $i1 < $var ; $i1++) { 
		$output .='        
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>';
}
return $output;
 }	
}

function ochem_id(){
	$carpool_id = $_GET["carpool_id"];
	$date_m = date('Y-m-d',strtotime($_GET["date"]. "-1 days"));
	$date_p = date('Y-m-d',strtotime($_GET["date"]. "+1 days"));	
	$i=0;
	$output ='';
	include("../../myconn/myconn.php");
	$sql="SELECT trip_id FROM tb_trip NATURAL JOIN tb_car  NATURAL JOIN tb_passenger NATURAL JOIN tb_trsg WHERE 
(tb_trip.trip_status = 2) AND (tb_passenger.passenger_status ='จอง') AND
(tb_trip.trip_start < '$date_p') AND
(tb_trip.trip_end > '$date_m') AND (carpool_id = '$carpool_id') AND (trip_status != 3)";
		$result = mysqli_query($conn,$sql);
		while($row = $result->fetch_assoc()){
	    session_start();	
	    $_SESSION["trip_id"]= $row["trip_id"];
}
	$_month_name = array("01"=>"มกราคม",  "02"=>"กุมภาพันธ์",  "03"=>"มีนาคม",    
		"04"=>"เมษายน",  "05"=>"พฤษภาคม",  "06"=>"มิถุนายน",    
		"07"=>"กรกฎาคม",  "08"=>"สิงหาคม",  "09"=>"กันยายน",    
		"10"=>"ตุลาคม", "11"=>"พฤศจิกายน",  "12"=>"ธันวาคม"); 
		$vardate=date('Y-m-d');
		$yy=date('Y');
		$mm =date('m');$dd=date('d'); 
		if ($dd<10){
		$dd=substr($dd,1,2);
		}
		$date=$dd ." ".$_month_name[$mm]."  ".$yy+= 543;
	$html1 =''; 
	include("../../myconn/myconn.php");
        $sql="select * FROM tb_trip NATURAL JOIN tb_car NATURAL JOIN tb_trsg WHERE trip_id = '".$_SESSION["trip_id"]."' ";
		$result = mysqli_query($conn,$sql);
		while($row = $result->fetch_assoc()){
		$trip_time = $row["trip_time"];
		$day =  (strtotime($row["trip_end"]) - strtotime($row["trip_start"]));
		$day = floor($day/3600/24)+1;
		
		$_month_name = array("01"=>"ม.ค.",  "02"=>"ก.พ.",  "03"=>"มี.ค.",    
		"04"=>"เม.ย.",  "05"=>"พ.ค.",  "06"=>"มิ.ย.",    
		"07"=>"ก.ค.",  "08"=>"ส.ค.",  "09"=>"ก.ย.",    
		"10"=>"ต.ค.", "11"=>"พ.ย.",  "12"=>"ธ.ค."); 
	
		$yy = substr(($row["trip_start"]+543),2,5);
		$mm = substr($row["trip_start"],5,-3);
		$dd = substr($row["trip_start"],8); 
		if ($dd<10){
		$dd=substr($dd,1,2);
		}
		$trip_start=$dd ." ".$_month_name[$mm]."  ".$yy;
		
		$yy2 = substr(($row["trip_end"]+543),2,5);
		$mm2 = substr($row["trip_end"],5,-3);
		$dd2 = substr($row["trip_end"],8); 
		if ($dd2<10){
		$dd2=substr($dd2,1,2);
		}
		$trip_end=$dd2 ." ".$_month_name[$mm2]."  ".$yy2;
		
		$trsg_name = $row["trsg_name"];
		$carpool_id = $row["carpool_id"];
		$carpool_name = $row["carpool_name"];
		$carpool_model = $row["carpool_model"];
		$carpool_type = $row["carpool_type"];
		$carpool_sit2 = $row["carpool_sit2"];
		$carpool_brand = $row["carpool_brand"];
		$carpool_mile = $row["carpool_mile"];
		$trip_mile = $row["trip_mile"];
		$trip_mile_end = $row["trip_mile_end"];
		}
	$html1 .= '
<html>
<head>
</head>	
	<br><br>
	<b align="right">วันที่ออกเอกสาร : '.$date.'</b><br>
	<b align="right">เลขที่ใบจองรถ :  '.$_SESSION["trip_id"].'</b>
  
	<h4><b>ข้อมูลการเดินทาง</b></h4><br><hr>
		
		<table border="0" width="100%">
    	<tr>
			<td width="20%" align="center" bgcolor="#FFFFFF"><b>วันที่เดินทาง</b></td>
			<td width="20%" bgcolor="#FFFFFF" align="center"><b>เวลาเดินทาง</b></td>
			<td width="20%" align="center" bgcolor="#FFFFFF"><b>วันที่กลับ</b></td>
			<td width="20%" bgcolor="#FFFFFF" align="center"><b>จำนวนวัน</b></td>
			<td width="20%" bgcolor="#FFFFFF" align="center"><b>สถานที่</b></td>
        </tr>
		<tr>
			<td align="center">'.$trip_start.'</td>
			<td align="center">'.$trip_time.' น.</td>
			<td align="center">'.$trip_end.'</td>
			<td align="center">'.$day.'</td>
			<td align="center">'.$trsg_name.'</td>
		</tr>
		</table>
		<hr>
	<h4><b>ข้อมูลรถ</b></h4><br><hr>
		
		<table border="0" width="100%">
    	<tr>
			<td width="14.28%" align="center" bgcolor="#FFFFFF"><b>ทเะบียนรถ</b></td>
			<td width="14.28%" bgcolor="#FFFFFF" align="center"><b>ยี่ห้อ</b></td>
			<td width="14.28%" align="center" bgcolor="#FFFFFF"><b>รุ่น</b></td>
			<td width="14.28%" bgcolor="#FFFFFF" align="center"><b>ประเภท</b></td>
			<td width="14.28%" bgcolor="#FFFFFF" align="center"><b>จำนวนที่นั่ง </b></td>
			<td width="14.28%" bgcolor="#FFFFFF" align="center"><b>เลขไมล์ปัจจุบัน* </b></td>
		    <td width="14.28%" bgcolor="#FFFFFF" align="center"><b>เลขไมล์ส่งคืน*</b></td>
        </tr>
		<tr>
			<td align="center">'.$carpool_id.'</td>
			<td align="center">'.$carpool_brand.'</td>
			<td align="center">'.$carpool_model.'</td>
			<td align="center">'.$carpool_type.'</td>
			<td align="center">'.$carpool_sit2.'</td>
			<td align="center">'.$trip_mile.'</td>
			<td align="center">'.$trip_mile_end.'</td>
		</tr>
		</table><hr>

	<h4><b>ข้อมูลผู้จองรถ</b></h4><br>
    <table border="1" width="100%">
    	<tr>
		<td width="40" align="center" bgcolor="#F2F2F2"><b>ลำดับที่</b></td>
        <td width="55" bgcolor="#F2F2F2" align="center"><b>รหัส</b></td>
        <td width="175" bgcolor="#F2F2F2" align="center"><b>ชื่อ-นามสกุล</b></td>
		<td width="80" bgcolor="#F2F2F2" align="center"><b>เบอร์ติดต่อ</b></td>
		<td width="55" bgcolor="#F2F2F2" align="center"><b>เบอร์โต๊ะ</b></td>
		<td width="145" bgcolor="#F2F2F2" align="center"><b>แผนก</b></td>
		<td width="70" bgcolor="#F2F2F2" align="center"><b>สถานะ</b></td>
        </tr>';
		
$html1 .= passenger();		
$html1 .=  '</table><h4><b>ข้อมูลการเติมน้ำมัน</b></h4><br>
		<div>	
		<table border="1" width="100%">
    	<tr>
			<td width="5%" align="center" bgcolor="#F2F2F2"><b>ครั้งที่</b></td>
			<td width="22%" bgcolor="#F2F2F2" align="center"><b>เลขไมล์ที่เติม*</b></td>
			<td width="23%" align="center" bgcolor="#F2F2F2"><b>ราคาต่อลิตร (บาท.)*</b></td>
			<td width="25%" bgcolor="#F2F2F2" align="center"><b>จำนวน (ลิตร)*</b></td>
			<td width="25.5%" bgcolor="#F2F2F2" align="center"><b>รวมเป็นเงิน (บาท.)*</b></td>
        </tr>';
		
 $html1.= fetch_data2(); 	
 
 $html1.='</table>
		</div>
		
		<table border="" width="100%">
    	<tr>
			<td width="55%" align="left"  bgcolor="#F2F2F2"><b>**ปัญหาที่พบในการใช้รถยนต์</b></td>
			<td width="45%" align="left"  bgcolor="#F2F2F2"><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ลงชื่อผู้ดูแลรถยนต์</b></td>
        </tr>
			<tr>
			<td>
			</td>
			<td>
			</td>
		</tr>
		<tr>
			<td>............................................................................................................
			</td>
			<td>(........................................................................................)
			</td>
		</tr>
	
		
	';
 
return $html1 .='</body></html>';
}

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
ob_end_clean();
$pdf->Output('example_001.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
