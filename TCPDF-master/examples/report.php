<?php
header("Content-type:text/html; charset=UTF-8");                
header("Cache-Control: no-store, no-cache, must-revalidate");               
header("Cache-Control: post-check=0, pre-check=0", false);    

require_once('tcpdf_include.php');
class MYPDF extends TCPDF {
    //Page header
    public function Header() {
		include("../../myconn/myconn.php");
		$carpool_id ='ทั้งหมด';
		$trsg_name ="ทั้งหมด";
		$trip_start = $_GET["trip_start"];
		$trip_end = $_GET["trip_end"];
		if(!empty($_GET["carpool_id"])){
		$carpool_id = $_GET["carpool_id"];
		}
		if(!empty($_GET["trsg_id"])){
		$trsg_id = $_GET["trsg_id"];
		
		$sql2="SELECT trsg_name from tb_trsg where trsg_id ='$trsg_id'";
		$result2 = mysqli_query($conn,$sql2);
		if(mysqli_num_rows($result2)>0){
			while($rs = $result2->fetch_array(MYSQLI_ASSOC)){
			 	$trsg_name = $rs["trsg_name"];
			}
		}
	}
		$_month_name = array("01"=>"มกราคม",  "02"=>"กุมภาพันธ์",  "03"=>"มีนาคม",    
		"04"=>"เมษายน",  "05"=>"พฤษภาคม",  "06"=>"มิถุนายน",    
		"07"=>"กรกฎาคม",  "08"=>"สิงหาคม",  "09"=>"กันยายน",    
		"10"=>"ตุลาคม", "11"=>"พฤศจิกายน",  "12"=>"ธันวาคม"); 
		$yy = substr($trip_start,0,-6);
		$mm = substr($trip_start,5,-3);
		$dd = substr($trip_start,8);  
		if ($dd<10){
		$dd=substr($dd,1,2);
		}
		$yy2 = substr($trip_end,0,-6);
		$mm2 = substr($trip_end,5,-3);
		$dd2 = substr($trip_end,8);   
		if ($dd2<10){
		$dd2=substr($dd2,1,2);
		}
		$trip_start = $dd ." ".$_month_name[$mm]."  ".$yy+= 543;
		$trip_end = $dd2 ." ".$_month_name[$mm2]."  ".$yy2+= 543;
		
		
		
        // Logo
		$image_file = K_PATH_IMAGES.'gg.png';
        $this->Image($image_file, 5, 7, 19, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $image_file = K_PATH_IMAGES.'sci.png';
        $this->Image($image_file, 27, 7, 14.5, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('thsarabun', 'B', 16, '', true);
        // Title
        $this->Ln(5);
        $this->Cell(385, 5, 'รายงานการใช้รถยนต์ประจำเดือน  ตั้งแต่วันที่ : '.$trip_start.' ถึง '.$trip_end.'                                               หน้า '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'M', 'M');
		
        $this->Ln();
		$this->SetFont('thsarabun', '', 14, '', true);
		$this->Cell(290, 5, 'ค้นหาจากทะเบียนรถยนต์ : '.$carpool_id.' และ ค้นหาจากสถานที่ : '.$trsg_name, 0, false, 'C', 0, '', 0, false, 'M', 'M');
		 $this->Ln();
        $this->Cell(290, 5, 'การไฟฟ้าส่วนภูมิภาค เขต 1 (ภาคกลาง)', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln();
		//$this->Cell(585, 10, 'หน้า '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
			
    }
    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('thsarabun', '', 14, '', true);
        // Page number
        //$this->Cell(585, 10, 'หน้า '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('รายงานการใช้รถยนต์ประจำเดือน/การไฟฟ้าส่วนภูมิภาค เขต 1 (ภาคกลาง)');
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
define('MYPDF_MARGIN_LEFT',3);
define('MYPDF_MARGIN_TOP',30);
define('MYPDF_MARGIN_RIGHT',3);
define('MYPDF_MARGIN_HEADER',0);
define('MYPDF_MARGIN_FOOTER',0);
define('MYPDF_MARGIN_BOTTOM',14);
$pdf->SetMargins(MYPDF_MARGIN_LEFT, MYPDF_MARGIN_TOP, MYPDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(MYPDF_MARGIN_HEADER);
$pdf->SetFooterMargin(MYPDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, MYPDF_MARGIN_BOTTOM);

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
$pdf->AddPage('L', 'A4');

// set text shadow effect
//$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
$html .= body(); 

function body(){
	$html1 = '

    <table border="1" width="100%">
	<thead>
    	<tr>
		<td width="5%"  bgcolor="#F2F2F2" align="center"><b>ลำดับที่</b></td>
		<td width="13%"  bgcolor="#F2F2F2" align="center"><b>วันที่เดินทาง</b></td>
        <td width="9%" bgcolor="#F2F2F2" align="center"><b>รหัสจอง</b></td>
		<td  bgcolor="#F2F2F2" align="center"><b>ทะเบียนรถ</b></td>
        <td width="14%"  bgcolor="#F2F2F2" align="center"><b>ชื่อ-นามสกุลผู้จอง</b></td>
		<td  bgcolor="#F2F2F2" align="center"><b>เบอร์โต๊ะ</b></td>
		<td width="13%" bgcolor="#F2F2F2" align="center"><b>แผนก</b></td>
		<td width="12%"  bgcolor="#F2F2F2" align="center"><b>สถานที่</b></td>
		<td width="9%"  bgcolor="#F2F2F2" align="center"><b>การเติมน้ำมัน</b></td>
		<td width="5%" bgcolor="#F2F2F2" align="center"><b>ยกเลิก</b></td>
        </tr>
		</thead>
		<tbody> ';
		$html1 .= feed();
 
return $html1 .='</tbody></table><br />';
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

function feed(){
	$carpool_id = $_GET["carpool_id"];
	$trsg_id = $_GET["trsg_id"];
	//$date_m = date('Y-m-d',strtotime($_GET["trip_start"]. "-1 days"));
	//$date_p = date('Y-m-d',strtotime($_GET["trip_end"]. "+1 days"));	
	$trip_start = $_GET["trip_start"];
	$trip_end = $_GET["trip_end"];
	
	$i=0;
	$output ='';
	include("../../myconn/myconn.php");
	$sql="SELECT  *  FROM tb_car NATURAL JOIN tb_trip  NATURAL JOIN tb_passenger NATURAL JOIN tb_trsg WHERE 
	(passenger_status ='จอง')  and (trip_status >= 2 ) ";
	
	if(!empty($trip_start) && !empty($trip_end)) {
		$sql .= "AND (trip_start between '$trip_start' and '$trip_end') ";
	}
	if(!empty($carpool_id)){
		$sql .= "AND carpool_id ='$carpool_id' ";
	}
	if(!empty($trsg_id)){
		$sql .= "AND trsg_id ='$trsg_id' ";
	}	
		$sql .=" order by trip_start asc";
		$result = mysqli_query($conn,$sql);
		while($row = $result->fetch_assoc()){
			$i++;
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
		
		$sql2="SELECT count(oil_id) as oil from tb_oil where trip_id ='".$row["trip_id"]."'";
		$result2 = mysqli_query($conn,$sql2);
		if(mysqli_num_rows($result2)>0){
			while($rs = $result2->fetch_array(MYSQLI_ASSOC)){
				$oil = $rs["oil"];
			}
		}
		if($row["trip_status"] == 3){
			$cancel = 	'X';
		}
		
		$output .='<tr>
		<td width="5%" align="center">'.$i.'.</td>
		<td width="13%" align="center">'.$trip_start.' - '.$trip_end.'</td>
		<td width="9%" align="center">'.$row["trip_id"].'</td>
		<td align="center">'.$row["carpool_id"].'</td>
		<td width="14%">&nbsp;'.$row["employee_detail"].'</td>
		<td align="center">'.$row["passenger_tel_table"].'</td>
		<td width="13%" align="center">'.$row["employee_dep"].'</td>
		<td width="12%" align="center">'.$row["trsg_name"].'</td>
		<td width="9%" align="center">'.$oil.'</td>
		
		<td width="5%" align="center">'.$cancel.'</td>
		</tr>'; 				
}

/*$z = 1;
while($z < 100){
	$output .='<tr>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
<td></td>
</tr>'; 
$z++;	
} */

return $output;
}
