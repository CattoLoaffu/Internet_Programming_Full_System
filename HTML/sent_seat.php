
<?php
session_start();
$date = date('Y-m-d'); // Get today's date in 'YYYY-MM-DD' format
$showtime = $_POST['showtime'];
$moviename = $_POST['MovieName'];
$movietype = $_POST['MovieType'];
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

  $query = "SELECT MAX(Receipt_number) as rn FROM ticket"; 
  $resultlastbill = mysqli_query($con, $query); 
  $row = mysqli_fetch_array($resultlastbill);
  $lastbill = $row['rn'];
  if($lastbill==''){
    $lastbill=1;
  }else{
    $lastbill = ($lastbill + 1);
  }
  $string = implode(", ", $selectedSeats);
  // Insert the data into the database
  $sql = "INSERT INTO ticket (Receipt_number ,Date, MovieName, Seat_number,Showtime ,username) VALUES ('$lastbill','$date','$moviename','$string','$showtime','$uname')";
  if (mysqli_query($con, $sql)) {
    echo "Seat booking for seat number $seatNumber successful";
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
  }


  $query = "SELECT MAX(Receipt_number) as rn FROM buy_history"; 
  $resultlastbill = mysqli_query($con, $query); 
  $row = mysqli_fetch_array($resultlastbill);
  $lastbill = $row['rn'];
  if($lastbill==''){
    $lastbill=1;
  }else{
    $lastbill = ($lastbill + 1);
  }
  $str = "INSERT INTO buy_history (Receipt_number,Date,Theater_number,Showtime,MovieName,Seat_number,UserName) VALUES ('$lastbill','$date','','$showtime','$moviename','$string','$uname')";
  if (mysqli_query($con, $str)) {
    echo "Seat booking successful";
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($con);
  }



// Get inputs from user
$normalSeatsSelected = $_POST["normalInput"];
$specialSeatsSelected = $_POST["sofaInput"];
$date = date('Y-m-d');

$normalSeatsSelected = intval($normalSeatsSelected);
$specialSeatsSelected = intval($specialSeatsSelected);
// Calculate sales
$standardSales = $normalSeatsSelected;
$sofaSweetSales = $specialSeatsSelected;
$standardSalesPrice = $standardSales * 160;
$sofaSweetSalesPrice = $sofaSweetSales * 180;
$summary = $standardSales + $sofaSweetSales;
$profit = $standardSalesPrice + $sofaSweetSalesPrice;

// Check if record already exists for the given date
$sql = "SELECT * FROM sales WHERE Date = '$date'";
$result = $con->query($sql);

if ($result->num_rows > 0) {
  // Record already exists, update it
  $row = $result->fetch_assoc();
  $totalStandardSales = $row["StanddardSales"] + $standardSales;
  $totalSofaSweetSales = $row["SofaSweetSales"] + $sofaSweetSales;
  $totalSummary = $totalStandardSales + $totalSofaSweetSales;
  $totalProfit = $row["Profit"] + $profit;

  $sql = "UPDATE sales SET StanddardSales = $totalStandardSales, SofaSweetSales = $totalSofaSweetSales, Summary = $totalSummary, Profit = $totalProfit WHERE Date = '$date'";
  
  if ($con->query($sql) === TRUE) {
    echo "Record updated successfully";
  } else {
    echo "Error updating record: " . $con->error;
  }
} else {
  // Record does not exist, insert it
  $sql = "INSERT INTO sales (Date, StanddardSales, SofaSweetSales, Summary, Profit)
          VALUES ('$date', $standardSales, $sofaSweetSales, $summary, $profit)";
  
  if ($con->query($sql) === TRUE) {
    echo "Record created successfully";
  } else {
    echo "Error creating record: " . $con->error;
  }
}


$query = "SELECT MAX(Receipt_number) as rn FROM sales_movie"; 
  $resultlastbill = mysqli_query($con, $query); 
  $row = mysqli_fetch_array($resultlastbill);
  $lastbill = $row['rn'];
  if($lastbill==''){
    $lastbill=1;
  }else{
    $lastbill = ($lastbill + 1);
  }

$sql = "INSERT INTO `sales_movie` (Receipt_number, Date, MovieName, StanddardSales, SofaSweetSales, Summary, Profit, MovieType) VALUES ('$lastbill','$date','$moviename', '$standardSales', '$sofaSweetSales', '$summary', '$profit' ,'$movietype')";
$query = mysqli_query($con,$sql);


// Close connection
echo "<script>window.location='ticketsuccess.php?Showtime=$showtime';</script>";
mysqli_close($con);

?>
