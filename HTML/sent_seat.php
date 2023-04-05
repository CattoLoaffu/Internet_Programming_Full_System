
<?php
session_start();
$date = date('Y-m-d'); // Get today's date in 'YYYY-MM-DD' format
$showtime = $_POST['showtime'];
$moviename = $_POST['MovieName'];
$uname = $_SESSION['username'];
$selectedSeats = explode(',', $_POST['selectedSeatsInput']);
$_SESSION['seat'] = $selectedSeats;
// Create connection
include("db.php");

// Check connections
if (!$con) {
  die("Connection failed: " . mysqli_connect_error());
}

//ถ้า bill no เป็นค่าว่างให้เท่ากับ 1  ถ้าไม่ใช่ค่าว่าง ให้เอาเลขบิลล่าสุดไป +1

// Loop through the array of selected seats and insert each seat into the database
foreach ($selectedSeats as $seatNumber) {
  $query = "SELECT MAX(run_number) as rn FROM seat"; 
  $resultlastbill = mysqli_query($con, $query); 
  $row = mysqli_fetch_array($resultlastbill);
  $lastbill = $row['rn'];
  if($lastbill==''){
    $lastbill=1;
  }else{
    $lastbill = ($lastbill + 1);
  }
  // Insert the data into the database
  $sql = "INSERT INTO seat (run_number, Date, Showtime, Seat_number, MovieName) VALUES ('$lastbill','$date', '$showtime', '$seatNumber', '$moviename')";
  if (mysqli_query($con, $sql)) {
    echo "Seat booking for seat number $seatNumber successful";
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
  }
}

foreach ($selectedSeats as $seatNumber) {
  $query = "SELECT MAX(Receipt_number) as rn FROM ticket"; 
  $resultlastbill = mysqli_query($con, $query); 
  $row = mysqli_fetch_array($resultlastbill);
  $lastbill = $row['rn'];
  if($lastbill==''){
    $lastbill=1;
  }else{
    $lastbill = ($lastbill + 1);
  }
  // Insert the data into the database
  $sql = "INSERT INTO ticket (Receipt_number ,Date, MovieName, Seat_number,Showtime ,username) VALUES ('$lastbill','$date','$moviename','$seatNumber','$showtime','$uname')";
  if (mysqli_query($con, $sql)) {
    echo "Seat booking for seat number $seatNumber successful";
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
  }
}
echo "<script>window.location='ticketsuccess.php?Showtime=$showtime';</script>";
mysqli_close($con);

?>
