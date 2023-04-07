<?php
// เชื่อมต่อฐานข้อมูล
include("db.php");
// ตรวจสอบการเชื่อมต่อ
if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}

// รับค่าพารามิเตอร์จาก Ajax
$Movieshowtime = $_POST['Movieshowtime'];

// ลบข้อมูลในฐานข้อมูล
$sql = "DELETE FROM theater WHERE Movieshowtime = '".$Movieshowtime."'";
if (mysqli_query($con, $sql)) {
  echo "Record deleted successfully";
} else {
  echo "Error deleting record: " . mysqli_error($con);
}

// ปิดการเชื่อมต่อ
mysqli_close($con);
?>