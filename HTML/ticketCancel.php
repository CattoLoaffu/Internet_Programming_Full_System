<?php
include("checkSession.php");
include("db.php");
$mname = $_GET['MovieName'];
$seat = $_GET['Seat']; 
$date = $_GET['Date']; 
$sh = $_GET['Showtime'];

$strSQL = "DELETE FROM `seat` WHERE MovieName = '".$mname."' AND Seat_number ='".$seat."' AND Date ='".$date."' AND Showtime ='".$sh."'";
$query = mysqli_query($con,$strSQL);

$strSQL = "DELETE FROM `ticket` WHERE UserName='".$_SESSION['username']."'AND MovieName = '".$mname."' AND Seat_number ='".$seat."' AND Date ='".$date."' AND Showtime ='".$sh."'";
$query = mysqli_query($con,$strSQL);

echo "<script>alert('Cancelation Successful')</script>";
echo "<script> window.location='myticket.php';</script>";
?>
