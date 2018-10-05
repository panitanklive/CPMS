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
$ohem_id = $_GET["id"]; 
$i=0;
	$output ='';
	include("../../myconn/myconn.php");
        $sql="select chemical_id,chemical_name,chemical_formula,ochem_detail_volume,chemical_unit FROM tb_ochem_detail NATURAL JOIN tb_chemical
WHERE ochem_id = '$ohem_id' ";
		$result = mysqli_query($conn,$sql);
    	if($result && $result->num_rows>0){ 
			while($row = $result->fetch_assoc()){
				 	$i++;
$output .='
  <tr>
   <td align="center">'.$i.'.</td>
	<td align="left">&nbsp;&nbsp;'.$row["chemical_name"].'</td>
	<td align="center">'.$row["ochem_detail_volume"].'&nbsp;'.$row["chemical_unit"].'</td>
  	<td align="center">'.$row["chemical_formula"].'</td>
	
 	<td align="center">&nbsp;</td>
  </tr>';
}
$var = 12-$i;
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
        $this->Cell(183, 5, 'มหาวิทลัยเทคโลยีราชมงคลสุวรรณภูมิ ศูนย์หันตรา', 0, false, 'C', 0, '', 0, false, 'M', 'M');
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
$pdf->SetTitle('TCPDF Example 001');
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
	$ochem_id = $_GET["id"]; 
	include("../../myconn/myconn.php");
	$query="select tb_ochem.*, tb_user.* from tb_ochem NATURAL JOIN tb_user WHERE ochem_id = '$ochem_id' ";
	$result = mysqli_query($conn,$query);
		if($result && $result->num_rows>0){ 
			while($row = $result->fetch_assoc()){
			$ochem_id = $row['ochem_id'];
			$user_id = $row['user_id'];
			$user_name = $row['user_name'];
			$user_group = $row['user_group'];
			$user_tel = $row['user_tel'];
			$user_lastname = $row['user_lastname'];
			$ochem_teacher = $row['ochem_teacher'];
			$ochem_year = $row['ochem_year'];
			$ochem_object = $row['ochem_object'];
			$ochem_objectd = $row['ochem_objectd'];
			$ochem_date =  $row['ochem_date'];
			$ochem_date =substr($ochem_date,0,10);

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

	<div><br><br><br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<b>ใบความเสียหายเลขที่ :</b>
	
    <br>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<b>ปีการศึกษา :</b>  <br>
	

	<b>วันที่ลงบันทึก :</b><br>
	<b>ชื่อ - สกุล ผู้ทำความเสียหาย :</b><br>
	<b>กลุ่มเรียน :</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  / <b>เบอร์ติดต่อ :</b><br>
	<b>ที่อยู่ที่ติดต่อได้</b> :  <br>
	<b>ในรายวิชา</b> : </div>
	<div>
    <table border="1" width="100%">
    	<tr>
		<td width="40" align="center" bgcolor="#F2F2F2"><b>ลำดับที่</b></td>
        <td width="230" bgcolor="#F2F2F2" align="center"><b>ชื่ออุปกรณ์</b></td>
        <td width="80" bgcolor="#F2F2F2" align="center"><b>จำนวน</b></td>
		<td width="180" bgcolor="#F2F2F2" align="center"><b>ราคา/หน่วย</b></td>
		<td width="85" bgcolor="#F2F2F2" align="center"><b>รวม</b></td>
        </tr>
	
        ';
 $html1 .=   fetch_data(); 
 $html1 .=  '</table></div>';
 $html1 .=  '***ตามรายการดังกล่าวนี้จะส่งคืนหรือชดใช้ค่าเสียหายภายในวันเวลาที่กำหนดข้างต้น  ข้าพเจ้าขอรับผิดชอบโดยไม่มีมีเงื่อนไขใดๆ ทั้งสิ้น<br>
			<div>ลงชื่อ .................................................................... อาจารย์ที่ปรึกษางานวิจัย/ผู้รับผิดชอบรายวิชา/เจ้าหน้าที่<br>
			วันที่ .................. เดือน ............................... พ.ศ. .......................<br><br>
			<b>ลงชื่อผู้ชดใช้</b>.......................................................&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<b>ลงชื่อผู้รับเรื่อง</b>........................................................<br>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;วันที่ ........................ เวลา ...................

			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;วันที่ ........................ เวลา ..................		
			
			</div>
			
			<div>
			<b>***หมายเหตุ</b><br>
			
			&nbsp;&nbsp;&nbsp;&nbsp;1. ให้นักศึกษายื่นใบเบิกสารเคมีก่อนรับของ 3 วัน<br>
			&nbsp;&nbsp;&nbsp;&nbsp;2. ต้องเตรียมภาชนะมาใส่สารเคมีที่ต้องการเบิก<br>
			&nbsp;&nbsp;&nbsp;&nbsp;3. หากมีการอนุมัติจากที่อาจารย์แล้วสารเคมีไม่เพียงพอ ผู้จ่ายสารเคมีจะไม่มีรับผิดชอบหากเกิดกรณีสารเคมีไม่เพียงพอ
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
