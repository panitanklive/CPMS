<?php
header("Content-type:text/html; charset=UTF-8");                
header("Cache-Control: no-store, no-cache, must-revalidate");               
header("Cache-Control: post-check=0, pre-check=0", false);    

function fetch_data(){  
	$output ='';
	include("../../myconn/myconn.php");
	$i=1;
        $sql="SELECT * FROM tb_user";
		$result = mysqli_query($conn,$sql); 
			while($row = $result->fetch_assoc()){
				$output .='
				 <tr>
    <td align="center">'.$row["user_id"].'</td>
	<td align="center">'.$row["user_name"].'</td>
	<td align="center">'.$row["user_lastname"].'</td>
	<td align="center">'.$row["user_group"].'</td>
	<td align="center">'.$row["user_tel"].'</td>
	<td align="center">'.$row["user_level"].'</td>
  </tr>
		<?php $i++; }}?>     
	';
}return $output;}

if(isset($_POST["user"])){
require_once('tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

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
    <table cellspacing="0" cellpadding="1" border="0" style="width:1100px;">  
    	<tr>
        <td width="115" align="center" bgcolor="#F2F2F2">บัญชีผู้ใช้งาน</td>
        <td width="130" bgcolor="#F2F2F2" align="center">ชื่อ</td>
		<td width="130" align="center" bgcolor="#F2F2F2">นามสกุล</td>
		<td width="105" bgcolor="#F2F2F2" align="center">กลุ่มเรียน</td>
		<td width="80" bgcolor="#F2F2F2" align="center">เบอร์ติดต่อ</td>
		<td width="70" bgcolor="#F2F2F2" align="center">สถานะ</td>
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
}