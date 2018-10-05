<?php
header("Content-type: text/html; charset=utf-8");
header("Access-Control-Allow-Origin: *");
//$conn=mysqli_connect("localhost","root","123456","carpool_new");
$conn=mysqli_connect("localhost","root","","carpool_new");
date_default_timezone_set("Asia/Bangkok");
mysqli_set_charset($conn, "utf8");
?>  