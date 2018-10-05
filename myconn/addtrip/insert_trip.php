<?php
include ("../myconn.php");
$data1 = json_decode(file_get_contents("php://input"));
mysqli_query($conn, "SET NAMES UTF8");
$carpool_id = ($data1->carpool_id);
$trip_start = ($data1->trip_start);
$trip_time = ($data1->trip_time);
$trip_end = ($data1->trip_end);
$trip_sit = ($data1->trip_sit);
$trsg_id = ($data1->trsg_id);
$btnName = ($data1->btnName);
$q = "select trip_id from tb_trip WHERE ((trip_start between '".$trip_start."' AND '".$trip_end."') or (trip_end between '".$trip_start."' AND '".$trip_end."')) 
and (carpool_id='$carpool_id') AND (trip_status < 3)";
$data = mysqli_query($conn,$q);
 if (mysqli_num_rows($data) == 0) 
{
$query = "select max(trip_id) as oc from tb_trip";
    $oc = mysqli_query($conn, $query);
    if (mysqli_num_rows($oc) > 0) {
        while ($rs = $oc->fetch_array(MYSQLI_ASSOC)) 
			$outp = $rs["oc"];
    }
    $rest = substr($outp, 1, -3);
    $dd = date("Ymd");
    if ($rest == $dd) {
        $rest2 = substr($outp, 10);
        $rest3 = intval($rest2);
        if ($rest3 < 9) {
            $trip_id = "T" . $dd . "-" . "0" . ($rest3 + 1);
        } else {
            $trip_id = "T" . $dd . "-" . ($rest3 + 1);
        }
    } else if ($rest != $dd) {
        $trip_id = "T" . $dd . "-01";
    }
    if ($btnName == 'เพิ่ม') {
        $query = "insert into tb_trip(trip_id,carpool_id,trip_start,trip_time,trip_end,trip_sit,trsg_id)
 values ('$trip_id','$carpool_id','$trip_start','$trip_time','$trip_end','$trip_sit','$trsg_id')";
        if (mysqli_query($conn, $query)) {
            echo $trip_id;
        } else {
            echo "no";
        }
    }
} else if(mysqli_num_rows($data) > 0) {
    echo 0;
}
?>