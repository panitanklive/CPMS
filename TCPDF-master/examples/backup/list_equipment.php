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
	$oequ_id = $_GET["oequ_id"];
	$user_group = $_GET["user_group"]; 
	$user_id = $_GET["user_id"]; 
	$oequ_object = $_GET["oequ_object"]; 
	$equipment_id = $_GET["equipment_id"]; 
	$oequ_get1 = $_GET["oequ_get1"]; 
	$oequ_year = $_GET["oequ_year"]; 
	$oequ_order = $_GET["oequ_order"]; 
	$oequ_get2= $_GET["oequ_get2"]; 
	$user_level = $_GET["user_level"];
	if($oequ_get2!=''){
		$oequ_get2 = date('Y-m-d',strtotime($_GET["oequ_get2"]. "+1 days"));
	}else{
		
	}
	$date = date('Y-m-d');
	$i=0;
	$output ='';
	include("../../myconn/myconn.php");
        $sql=" SELECT oequ_date, oequ_id , user_id , user_name, user_lastname ,equipment_name, (oequ_detail_volume-oequ_detail_volume2) as v,equipment_unit FROM tb_oequ_detail NATURAL JOIN tb_equipment NATURAL JOIN tb_oequ NATURAL JOIN tb_user 
        where (oequ_detail_volume-oequ_detail_volume2) !=0 ";

        if($oequ_id !=""){$sql.=" AND oequ_id = '$oequ_id' ";}
        if($user_id !=""){$sql.=" AND user_id= '$user_id' ";}
		if($user_group !=""){$sql.=" AND user_group= upper('$user_group') ";}
        if($oequ_object !=""){$sql.=" AND oequ_object = '$oequ_object' ";}
        if($equipment_id !=""){$sql.=" AND equipment_id = '$equipment_id' ";}
        if($oequ_get1 !="" && $oequ_get2 !="" ){$sql.=" AND oequ_get BETWEEN '$oequ_get1' and '$oequ_get2' ";}
        if($oequ_year !=""){$sql.=" AND oequ_year = '$oequ_year' ";}
        if($user_level !=""){$sql.=" AND user_level = '$user_level' ";}
		if($oequ_order!=""){{$sql.=" order by $oequ_order ";}}
		
		$result = mysqli_query($conn,$sql);
    	if($result && $result->num_rows>0){ 
			while($row = $result->fetch_assoc()){
				 	$i++;
				 	$d = date('Y-m-d');
$output .='
  <tr>
   <td align="center">'.$i.'.</td>
	
	<td align="center">'.$row["oequ_id"].'</td>
  	<td align="left">&nbsp;&nbsp;'.$row["user_id"].' '.$row["user_name"].' '.$row["user_lastname"].'</td>
 	<td align="left">&nbsp;&nbsp;'.$row["equipment_name"].'</td>
 	<td align="center">'.$row["v"].'&nbsp;'.$row["equipment_unit"].'</td>
  </tr>';
}
/*$var = 100-$i;
for ($i1=0; $i1 < $var ; $i1++) { 
$output .='        
<tr>
    <td></td>
	<td></td>
 	<td></td>
	<td></td>
 	<td></td>
</tr>';
} */

return $output;}
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
        $this->Cell(183, 5, 'รายงานการคืนอุปกรณ์ทดลอง / ห้องปฏบัติการเคมี', 0, false, 'C', 0, '', 0, false, 'M', 'M');
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

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);


$pdf->SetCreator(PDF_CREATOR);

$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('รายงานการคืนอุปกรณ์ทดลอง/ ห้องปฏบัติการเคมี');
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



$html = oequ_id();

function oequ_id(){
	$html1 =''; 

	include("../../myconn/myconn.php");
	$query="select tb_oequ.*, tb_user.* from tb_oequ NATURAL JOIN tb_user  ";
	$result = mysqli_query($conn,$query);
		if($result && $result->num_rows>0){ 
			while($row = $result->fetch_assoc()){
			$oequ_id = $row['oequ_id'];
			$user_id = $row['user_id'];
			$user_name = $row['user_name'];
			$user_group = $row['user_group'];
			$user_tel = $row['user_tel'];
			$user_lastname = $row['user_lastname'];
			$oequ_teacher = $row['oequ_teacher'];
			$oequ_year = $row['oequ_year'];
			$oequ_object = $row['oequ_object'];
			$oequ_objectd = $row['oequ_objectd'];
			$oequ_date =  $row['oequ_date'];
			$oequ_date =substr($oequ_date,0,10);

		$_month_name = array("01"=>"มกราคม",  "02"=>"กุมภาพันธ์",  "03"=>"มีนาคม",    
		"04"=>"เมษายน",  "05"=>"พฤษภาคม",  "06"=>"มิถุนายน",    
		"07"=>"กรกฎาคม",  "08"=>"สิงหาคม",  "09"=>"กันยายน",    
		"10"=>"ตุลาคม", "11"=>"พฤศจิกายน",  "12"=>"ธันวาคม"); 
		//$vardate=date('Y-m-d');
		$yy=date('Y');
		$mm =date('m');
		$dd=date('d');
		if ($dd<10){
		$dd=substr(date('d'),1);
		}
		$date=$dd ." ".$_month_name[$mm]."  ".$yy+= 543;

			}	
	}
	$oequ_get1 = $_GET["oequ_get1"]; 
	$oequ_year = $_GET["oequ_year"]; 
	$oequ_order = $_GET["oequ_order"];
	$oequ_get2= $_GET["oequ_get2"]; 	
	if($oequ_get2!='' && $oequ_get1!=''){
		$oequ_get2 = date('Y-m-d',strtotime($_GET["oequ_get2"]));
	}else{
		$oequ_get1 ='วันที่เริ่มต้น';
		$oequ_get2 ='วันที่ปัจุบัน';
	}
	$html1 = '
<htm>
<head>

</head>	
	<style>
td{
        border:1px dashed #CCC;  
}
th{
        border:1px dashed #CCC;  
}
</style>
	
    <br> <br>
	<b>ระหว่างวันที่ :</b> '.$oequ_get1.'  ถึง '.$oequ_get2.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>ภาคเรียน :</b> '.$oequ_year.'
	<br><br>
    <table border="0" width="100%">
    	<tr>
		<th width="40" align="center" bgcolor="#F2F2F2"><b>ลำดับที่</b></th>
      
        <th width="85" bgcolor="#F2F2F2" align="center"><b>รหัสยืม</b></th>
        <th width="190" bgcolor="#F2F2F2" align="center"><b>ชื่อ-สกุล</b></th>
		<th width="215" bgcolor="#F2F2F2" align="center"><b>ชื่ออุปกรณ์</b></th>
		<th width="80" bgcolor="#F2F2F2" align="center"><b>จำนวนที่คืนแล้ว</b></th>
        </tr>
	
        ';
 $html1 .=   fetch_data(); 
 $html1 .=  '</table></div>';

 
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
