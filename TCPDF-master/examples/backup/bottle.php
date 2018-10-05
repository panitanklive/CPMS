<?php
header("Content-type:text/html; charset=UTF-8");                
header("Cache-Control: no-store, no-cache, must-revalidate");               
header("Cache-Control: post-check=0, pre-check=0", false);    

function fetch_data(){  
//$bottle_brand = $_GET["brand"];
$chemical_name = $_GET["name"];
$chemical_formula = $_GET["formula"];
$bottle_brand  = $_GET["brand"];
//$bottle_grade = $_GET["grade"];
$bottle_grade = '';
$bottle_amount  = $_GET["amount"];
$bottle_unit  = $_GET["unit"];
$bottle_balance1 = $_GET["balance1"];
$bottle_balance2 = $_GET["balance2"];
//$bottle_get = $_GET["get"];
//$bottle_open = $_GET["open"];
//$bottle_close = $_GET["close"];
$bottle_status = $_GET["status"];
$bottle_order = $_GET["order"];
	$output ='';
	include("../../myconn/myconn.php");
	$i=1;
        $sql="SELECT tb_bottle.* , tb_chemical.* FROM tb_bottle NATURAL JOIN tb_chemical WHERE true ";
        if($chemical_name !=""){$sql.=" AND chemical_name like '%".$chemical_name."%' ";}
        if($chemical_formula !=""){$sql.=" AND chemical_formula like '%".$chemical_formula."%' ";}
 		if($bottle_brand !=""){$sql.=" AND bottle_brand like '%".$bottle_brand."%' ";}
		if($bottle_grade !=""){$sql.=" AND bottle_grade like '%".$bottle_grade."%' ";}
        if($bottle_amount !=""){$sql.=" AND (bottle_amount='$bottle_amount')";}
        if($bottle_unit !=""){$sql.=" AND (chemical_unit='$bottle_unit')";}
        if($bottle_balance1 !="" && $bottle_balance2 !=""){$sql.=" AND (bottle_balance BETWEEN '$bottle_balance1' AND  '$bottle_balance2') ";}
        if($bottle_status !=""){$sql.=" AND (bottle_status='$bottle_status')";}
        if($bottle_order ==''){$sql.="";}
        if($bottle_order == 'B'){$sql.=" order by chemical_name asc";}		
        if($bottle_order == 'C'){$sql.=" order by bottle_balance desc";}
        if($bottle_order == 'D'){$sql.=" order by bottle_balance asc";}		
        if($bottle_order == 'E'){$sql.=" order by bottle_get desc";}	
         if($bottle_order == 'F'){$sql.=" order by bottle_get asc";}	
		$result = mysqli_query($conn,$sql); 
		if($result && $result->num_rows>0){ 
			while($row = $result->fetch_assoc()){
				$output .='
				   <tr>
    <td align="center">'.$row["bottle_id"].'</td>
	<td align="left">&nbsp;'.$row["chemical_name"].'</td>
	<td align="center">&nbsp;'.$row["bottle_balance"].'</td>
	<td align="center">&nbsp;'.$row["chemical_unit"].'</td>
	<td align="center">&nbsp;'.$row["bottle_get"].'</td>
	<td align="center">&nbsp;'.$row["bottle_open"].'</td>
	<td align="center">&nbsp;'.$row["bottle_status"].'</td>
  </tr>
		<?php $i++; }}?>    
	';
}return $output;}}

require_once('tcpdf_include.php');
class MYPDF extends TCPDF {
    //Page header
    public function Header() {
		if($this->page==1){
        // Logo
        $image_file = K_PATH_IMAGES.'logo_1.jpg';
        $this->Image($image_file, 28, 7, 10, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $image_file = K_PATH_IMAGES.'sci.png';
        $this->Image($image_file, 43, 7, 16, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('thsarabun', 'B', 14, '', true);
        // Title
        $this->Ln(5);
        $this->Cell(183, 5, 'รายงานปริมาณสารเคมี / ห้องปฏบัติการเคมี', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln();
         $this->SetFont('thsarabun', '', 14, '', true);
        $this->Cell(183, 5, 'มหาวิทยาลัยเทคโนโลยีราชมงคลสุวรรณภูมิ คณะวิทยาศาสตร์และเทคโนโลยี', 0, false, 'C', 0, '', 0, false, 'M', 'M');
        $this->Ln();
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
		
		
        $this->Cell(183, 5, 'สาขาวิชาเคมี วันที่ออกเอกสาร '.$date, 0, false, 'C', 0, '', 0, false, 'M', 'M');
   
    }
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

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
//$pdf->SetFont('freeserif', '', 14, '', true);
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
$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Set some content to print
$html = '';
$html .= '
<style>
td{
        border:1px dashed #CCC;  
}
</style>
<br><br>
  <table cellspacing="0" cellpadding="1" border="0" style="width:1100px;">  
    	<tr>
        <td width="105" align="center" bgcolor="#F2F2F2">รหัสขวด</td>
        <td width="230" bgcolor="#F2F2F2" align="center">ชื่อสารเคมี</td>
		<td width="40" align="center" bgcolor="#F2F2F2">คงเหลือ</td>
		<td width="45" align="center" bgcolor="#F2F2F2">หน่วย</td>
		<td width="70" bgcolor="#F2F2F2" align="center">วันที่รับ</td>
		<td width="70" bgcolor="#F2F2F2" align="center">วันเปิด</td>
		<td width="55" bgcolor="#F2F2F2" align="center">สถานะ</td>
        </tr>';
 $html .= fetch_data();
  $html .=  '</table>';

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('example_001.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
