<?php
include("checkSession.php");
include("db.php");
$cc = mysqli_real_escape_string($con,$_POST['cc']);
$mname = mysqli_real_escape_string($con,$_POST['mname']);
$seat = mysqli_real_escape_string($con,$_POST['seat']); 
$date = mysqli_real_escape_string($con,$_POST['date']);
$sh = mysqli_real_escape_string($con,$_POST['showtime']);
$ren = mysqli_real_escape_string($con,$_POST['receiptnum']);
$uname = $_SESSION['username'];

$query = "SELECT MAX(Receipt_number) as rn FROM cancel_ticket"; 
  $resultlastbill = mysqli_query($con, $query); 
  $row = mysqli_fetch_array($resultlastbill);
  $lastbill = $row['rn'];
  if($lastbill==''){
    $lastbill=1;
  }else{
    $lastbill = ($lastbill + 1);
  }


$renum = "".$lastbill;

$strSQL = "DELETE FROM `seat` WHERE MovieName = '".$mname."' AND Seat_number ='".$seat."' AND Date ='".$date."' AND Showtime ='".$sh."'";
$query = mysqli_query($con,$strSQL);

$strSQL = "DELETE FROM `ticket` WHERE UserName='".$_SESSION['username']."'AND MovieName = '".$mname."' AND Seat_number ='".$seat."' AND Date ='".$date."' AND Showtime ='".$sh."'";
$query = mysqli_query($con,$strSQL);

$strSQL = "INSERT INTO `cancel_ticket` (Receipt_number , Date , MovieName, UserName , Seat_number , Showtime , Cancel_cause ) VALUE ('$lastbill','$date','$mname','$uname','$seat','$sh','$cc')";
$query = mysqli_query($con,$strSQL);

$strSQL = "DELETE FROM `sales_movie` WHERE Reciept_number = '".$ren."'";
$query = mysqli_query($con,$strSQL);

echo "<script>alert('Cancelation Successful')</script>";
echo "<script> window.location='myticket.php';</script>";
?>
