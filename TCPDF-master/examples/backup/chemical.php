<?php
header("Content-type:text/html; charset=UTF-8");                
header("Cache-Control: no-store, no-cache, must-revalidate");               
header("Cache-Control: post-check=0, pre-check=0", false);    

function fetch_data(){
$chemical_id = $_GET["id"];
$chemical_like_id = $_GET["like_id"];
$chemical_name = $_GET["name"];
$chemical_like = $_GET["like"];
$chemical_formula = $_GET["formula"];
//$chemical_grade = $_GET["grade"];
$chemical_address = $_GET["address"];
$chemical_status = $_GET["status"];
$chemical_order = $_GET["order"];
$i=0;	
	$output ='';
	include("../../myconn/myconn.php");
        $sql="SELECT * FROM tb_chemical WHERE true"; 
        if($chemical_id !=""){
            $sql.=" AND chemical_id like '%".$chemical_id."%' ";
            if($chemical_like_id !=""){
            $sql.=" AND chemical_id like '%".$chemical_id."%' ";
                 }
            if($chemical_like_id =="หน้า"){
            $sql.=" AND chemical_id like '".$chemical_id."%' ";
                 }
        }
        //-----------------------------------------------------------------------
        if($chemical_name !=""){
        	$sql.=" AND chemical_name like '%".$chemical_name."%' ";
            if($chemical_like !=""){
            $sql.=" AND chemical_name like '%".$chemical_name."%' ";
                 }
             if($chemical_like =="หน้า"){
            $sql.=" AND chemical_name like '".$chemical_name."%' ";
                 }
            if($chemical_like =="ท้าย"){
            $sql.=" AND chemical_name like '%".$chemical_name."' ";
                }
        }
         //-----------------------------------------------------------------------
         if($chemical_formula !=""){
        	$sql.=" AND chemical_formula like '%".$chemical_formula."%' ";
        }
        //-----------------------------------------------------------------------
       // if($chemical_grade !=""){
        //	$sql.=" AND chemical_grade='$chemical_grade'";
       // }
        if($chemical_address !=""){
        	$sql.=" AND chemical_address='$chemical_address'";
        }
        if($chemical_status !=""){
        	$sql.=" AND chemical_status='$chemical_status'";
        }
        if($chemical_order == ''){
         	$sql.="";
         }
          if($chemical_order == 'B'){
         	$sql.=" order by chemical_name asc";
         }		
       	 if($chemical_order == 'C'){
         	$sql.=" order by chemical_formula asc";
         }	
          if($chemical_order == 'D'){
         	$sql.=" order by chemical_status asc";
         }	
         	 if($chemical_order == 'E'){
         	$sql.=" order by chemical_address asc";
         }	
          //if($chemical_order == 'F'){
         	//$sql.="order by chemical_unit asc";
      //   }	
         if($chemical_order == 'G'){
         	$sql.=" order by chemical_grade asc";
         }	
		$result = mysqli_query($conn,$sql); 
		if($result && $result->num_rows>0){ 
			while($row = $result->fetch_assoc()){
				$i++;
				$output .='
	<tr>
	<td align="center">'.$i.'.</td>
    <td align="center">'.$row["chemical_id"].'</td>
	<td align="left">&nbsp;'.$row["chemical_name"].'</td>
	<td align="left">&nbsp;'.$row["chemical_formula"].'</td>
	<td align="center">'.$row["chemical_address"].'</td>
    </tr>'; 
	
}return $output;}

}
require_once('tcpdf_include.php');
class MYPDF extends TCPDF {
    //Page header
    public function Header() {
		 if($this->page==1){
            $image_file = 'images/logo_1.jpg';
        $this->Image($image_file, 28, 7, 10, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        $image_file2 ='images/sci.png';
        $this->Image($image_file2, 43, 7, 16, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        // Set font
        $this->SetFont('thsarabun', 'B', 14, '', true);
        // Title
        $this->Ln(5);
        $this->Cell(183, 5, 'รายงานทะเบียนรายการสารเคมี / ห้องปฏบัติการเคมี', 0, false, 'C', 0, '', 0, false, 'M', 'M');
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
        }else{
            
        }
        // Logo
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
$pdf->SetTitle('รายงานทะเบียนรายการสารเคมี / ห้องปฏบัติการเคมี');
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


// Set some content to print
$html = '';
$html .= '
<style>
td{
        border:1px dashed #CCC;  
}
th{
        border:1px dashed #CCC;  
}
</style>
<br><br>
    <table cellspacing="0" cellpadding="1" border="0" style="width:1100px;">  
	 
    	<tr>
		<th width="30" align="center" bgcolor="#F2F2F2">#</th>
        <th width="60" align="center" bgcolor="#F2F2F2">รหัสสารเคมี</th>
        <th width="235" bgcolor="#F2F2F2" align="center">ชื่อสารเคมี</th>
		<th width="210" bgcolor="#F2F2F2" align="center">สูตร</th>
		<th width="90" bgcolor="#F2F2F2" align="center">ที่อยู่</th>
        </tr>
	 ';
 $html .= '<tbody>'.fetch_data().'</tbody>';
 $html .= '</table>';

// Print text using writeHTMLCell()
$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
$pdf->Output('chemical.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
