<?php
header("Content-type:text/html; charset=UTF-8");                
header("Cache-Control: no-store, no-cache, must-revalidate");               
header("Cache-Control: post-check=0, pre-check=0", false);    
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

function fetch_data(){ 
$damage_id = $_GET["id"]; 
$i=0;
$sum = 0;
	$output ='';
	include("../../myconn/myconn.php");
        $sql="select * FROM tb_damage_detail NATURAL JOIN tb_equipment 
WHERE damage_id = '$damage_id' ";
		$result = mysqli_query($conn,$sql);
    	if($result && $result->num_rows>0){ 
			while($row = $result->fetch_assoc()){
				 	$i++;
				 	$sum = $row["damage_detail_sum"] + $sum;
$output .='
  <tr>
    <td align="center">'.$i.'.</td>
	<td align="left">&nbsp;&nbsp;'.$row["equipment_name"].'</td>
  	<td align="center">'.$row["damage_detail_volume"]. '  '.$row["equipment_unit"].'</td>
	<td align="center">'.$row["damage_detail_sum"].' บาท.</td>
 	<td align="center">&nbsp;</td>
  </tr>';
}
$var = 10-$i;
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
$output .='        
<tr>
    <td colspan="3" align="center"><b>ราคารวมสุทธิ</b></td>
 	<td align="center"><b>'.$sum.' บาท.</b></td>
	<td></td>
 	
</tr>';

return $output;}
}
require_once('tcpdf_include.php');

class MYPDF extends TCPDF {
    //Page header
    public function Header() {
        // Logo
       $image_file = K_PATH_IMAGES.'logo_1.jpg';
        $this->Image($image_file, 25, 15, 11, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $image_file = K_PATH_IMAGES.'sci.png';
        $this->Image($image_file, 40, 15, 18, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('thsarabun', 'B', 16, '', true);
        // Title
        $this->Ln(5);
        $this->Cell(183, 5, 'ใบเสร็จความเสียหาย / ห้องปฏิบัติการเคมี ', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln();
       // $this->SetFont('thsarabun', '', 14, '', true);
        $this->Cell(183, 5, 'สาขาวิชาเคมี คณะวิทยาศาสตร์และเทคโนโลยี', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln();
        $this->Cell(183, 5, 'มหาวิทยาลัยเทคโนโลยีราชมงคลสุวรรณภูมิ ศูนย์หันตรา', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln();
   		
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('thsarabun', '', 14, '', true);
        // Page number
        $this->Cell(360, 10, 'หน้า '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');

    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


$pdf->SetCreator(PDF_CREATOR);

$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('ใบเสร็จความเสียหาย / ห้องปฏิบัติการเคมี ');
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



$html = ochem_id();

function ochem_id(){
	$html1 =''; 
	$damage_id = $_GET["id"]; 
	include("../../myconn/myconn.php");
	$query="select tb_damage.*, tb_user.* from tb_damage NATURAL JOIN tb_user WHERE damage_id = '$damage_id' ";
	$result = mysqli_query($conn,$query);
		if($result && $result->num_rows>0){ 
			while($row = $result->fetch_assoc()){
			$damage_id = $row['damage_id'];
			$damage_year = $row['damage_year'];
			$damage_get = $row['damage_get'];
			$damage_object = $row['damage_object'];
			$damage_pay = $row['damage_pay'];
			$user_id = $row['user_id'];
			$user_name = $row['user_name'];
			$user_lastname = $row['user_lastname'];
			$user_group = $row['user_group'];
			$user_tel = $row['user_tel'];
	
		$_month_name = array("01"=>"มกราคม",  "02"=>"กุมภาพันธ์",  "03"=>"มีนาคม",    
		"04"=>"เมษายน",  "05"=>"พฤษภาคม",  "06"=>"มิถุนายน",    
		"07"=>"กรกฎาคม",  "08"=>"สิงหาคม",  "09"=>"กันยายน",    
		"10"=>"ตุลาคม", "11"=>"พฤศจิกายน",  "12"=>"ธันวาคม"); 
		//$vardate=date('Y-m-d');
		$yy=substr($ochem_date,0,4);
		$mm =substr($ochem_date,5,-3);
		$dd=substr($ochem_date,8);
		if ($dd<10){
		$dd=substr($dd,1,2);
		}
		$date=$dd ." ".$_month_name[$mm]."  ".$yy+= 543;
			}	
	}


	$html1 = '
<htm>
<head>
</head>	
	<div><br><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<b>ใบความเสียหายเลขที่ :</b> '.$damage_id.'

    <br>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<b>ปีการศึกษา :</b> '.$damage_year.' <br>
	
	<b>วันที่ชดใช้ความเสียหาย :</b> '.$damage_get.' น.<br>
	<b>ชื่อ - สกุล ผู้ทำความเสียหาย :</b> '.$user_name.' '.$user_lastname.' <br>
	<b>กลุ่มเรียน :</b> '.$user_group.' / <b>เบอร์ติดต่อ :</b> '.$user_tel.' <br>
	<b>ประเภทการชดใช้ :</b> '.$damage_pay.' / <b>ศึกษาในรายวิชา :</b> '.$damage_object.'
	</div>
	<div>
    <table border="1" width="100%">
    	<tr>
		<td width="40" align="center" bgcolor="#F2F2F2"><b>ลำดับที่</b></td>
        <td width="230" bgcolor="#F2F2F2" align="center"><b>ชื่ออุปกรณ์ทดอลง</b></td>
        <td width="100" bgcolor="#F2F2F2" align="center"><b>จำนวนที่เสียหาย</b></td>
		<td width="160" bgcolor="#F2F2F2" align="center"><b>ราคารวม</b></td>
		<td width="85" bgcolor="#F2F2F2" align="center"><b>หมายเหตุ</b></td>
        </tr>
	
        ';
 $html1 .=   fetch_data(); 
 $html1 .=  '</table></div>';
 $html1 .=  '***ตามรายการดังกล่าวนี้จะส่งคืนภายในวันเวลาที่กำหนดข้างต้น ถ้าชำรุดเสียหายหรือยู่ในสภาพที่ไม่สะอาดเรียบร้อย ข้าพเจ้าขอรับผิดชอบโดยไม่มีมีเงื่อนไขใดๆ ทั้งสิ้น<br>
			<div>ลงชื่อ .................................................................... อาจารย์ที่ปรึกษางานวิจัย/ผู้รับผิดชอบรายวิชา/เจ้าหน้าที่<br>
			วันที่ .................. เดือน ............................... พ.ศ. .......................<br><br>
			<b>ลงชื่อผู้ชดใช้</b>..........................................................&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<b>ลงชื่อเจ้าหน้าที่</b>........................................................<br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;วันที่ ........................ เวลา ...................

			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;วันที่ ........................ เวลา ..................		
			
			</div>
			
			<div>
			<b>***หมายเหตุ</b><br>
			
			&nbsp;&nbsp;&nbsp;&nbsp;1. ให้นักศึกษาเก็บใบเสร็จความเสียหายนี้ไว้เพื่อเป็นหลักฐานในการยืนยันการชดใช้<br>
			
			</div>';
 
return $html1 .='</body></html>';
}
  

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('example_001.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
