<?php

include("db.php");


// ตรวจสอบว่าเชื่อมต่อฐานข้อมูลสำเร็จหรือไม่
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// ถ้ามีการส่งข้อมูลและมีการกดปุ่ม Submit
if (isset($_POST['submit'])) {

    // รับค่าจากฟอร์ม
    $ID = $_POST['ID'];
    $MovieName = $_POST['MovieName'];
    $Theater_name = $_POST['Theater'];
    $Theater_number = $_POST['Theater_number'];
    $Showtime = $_POST['Showtime'];
    $TimeIn = $_POST['TimeIn'];
    $TimeOut = $_POST['TimeOut'];
    $Movieshowtime = $_POST['Movieshowtime'];
    // คำสั่ง SQL ในการแทรกข้อมูลลงในตาราง theater
    $Movieshowtime = mysqli_real_escape_string($con, $_POST['Movieshowtime']);
            $sql = "SELECT Movieshowtime FROM theater WHERE Movieshowtime = '$Movieshowtime'";
            $result = mysqli_query($con, $sql);
            if(mysqli_num_rows($result) > 0){ // ถ้ามี ID ที่ตรงกับค่าที่รับเข้ามาในตาราง
                echo "<div class='alert alert-danger' role='alert'>มีหมายเลขรอบฉายนี้อยู่แล้ว</div>";
                header("Refresh: 2; url=page191.php");
            }else{ // ถ้าไม่มี ID ที่ตรงกับค่าที่รับเข้ามาในตาราง
                $sql = "INSERT IGNORE INTO theater (ID, MovieName, Theater_name, TimeIn, TimeOut, Theater_number, Showtime, Movieshowtime) VALUES ('$ID', '$MovieName', '$Theater_name', '$TimeIn', '$TimeOut','$Theater_number','$Showtime','$Movieshowtime')";
    
    // ส่งคำสั่ง SQL ไปยังฐานข้อมูล
                if (mysqli_query($con, $sql)) {
                    echo "<div class='alert alert-success' role='alert'>เพิ่มโรงภาพยนต์เรียบร้อยแล้ว</div>";
                    header("Refresh: 2; url=page18.php");
                } else {
                    echo "ผิดพลาด: " . $sql . "<br>" . mysqli_error($con);
        }
    }
    // ปิดการเชื่อมต่อฐานข้อมูล MySQL
    mysqli_close($con);
}
?>
<!DOCTYPE html>
<meta charset="UTF-8">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../CSS/style.css">
<style>

.form-group {
    margin-bottom: 20px; /* เพิ่มระยะห่างของแต่ละกลุ่ม */
    display: flex;
    flex-direction: row; /* จัดเรียงเป็นแถวเดียว */
    justify-content: center; /* จัดให้อยู่กลางแนวตั้ง */
    align-items: center; /* จัดให้อยู่กลางแนวนอน */
    height: 80px;
    
}

label {
    width: 150px; /* เพิ่มความกว้างของ label */
    text-align: right; /* จัดให้อยู่ชิดขวา */
    margin-right: 5px; /* เพิ่มระยะห่างจากขอบขวาของ label */
    

}

input, select {
    width: 200px; /* เพิ่มความกว้างของ input และ select */
    
}
btn-primary {
        display: block;
        margin: 0 auto;
        text-align: center;
        
        
}

</style>
<html>
    <title>Cinevault+</title>
<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="javascript:void(0)">
                <img src="../Assets/Icon.png" style="width: 60px;">
            </a>
            <span class="navbar-text" style="color: white;">Cinevault+</span>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <div class="collapse navbar-collapse" id="mynavbar">

                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="javascript:void(0)" onclick="location.href ='Page10-11.php';">หน้าแรก</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0)" onclick="location.href ='Page18.php';">ลงรอบภาพยนต์</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0)" onclick="location.href ='Page20.php';">ค้นหาข้อมูลผู้ใช้งาน</a>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="text" placeholder="Search">
                    <button class="btn btn-secondary" type="button">Search</button>
                </form>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="">
                    <img src="../Assets/userIcon.png" style="width: 30px;">
                </a>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            </div>
        </div>
    </nav>
    <br>
    
<?php
// คำสั่ง SQL ในการเลือกข้อมูลจากตาราง movies

$sql = "SELECT ID, MovieName FROM movie";

// ดึงข้อมูลจากฐานข้อมูล
$result = mysqli_query($con, $sql);

// ตรวจสอบว่ามีข้อมูลหรือไม่
if (mysqli_num_rows($result) > 0) {
    // แสดงฟอร์ม
    echo "<form method='post' class='btn btn-dark flex-column align-items-center' style='width: 40%; margin-left: 30%; margin-right: 0;'>"; 
    echo "<div class='form-group row'>";
    echo "<label for='ID' class='col-sm-2 control-label'>ID:</label>";
    echo "<div class='col-sm-10'>";
    echo "<input type='text' id='ID' name='ID' class='form-control';>";
    echo "</div>";
    echo "</div>";
    echo "<div class='form-group row'>";
    echo "<label for='MovieName' class='col-sm-2 control-label'>Movie Name:</label>";
    echo "<div class='col-sm-10'>";
    echo "<select id='MovieName' name='MovieName' class='form-control' onchange='getMovieID()'>";
    while($row = mysqli_fetch_array($result)) {
        echo "<option value='" . $row["MovieName"] . "'>" . $row["MovieName"] . "</option>";
    }
    echo "</select>";
    echo "</div>";
    echo "</div>";
    echo "<div class='form-group row'>";
    echo "<label for='Theater_number' class='col-sm-2 control-label'>TheaterNumber:</label>";
    echo "<div class='col-sm-10'>";
    echo "<input type='text' id='Theater_number' name='Theater_number' class='form-control' required>";
    echo "</div>";
    echo "</div>";
    echo "<div class='form-group row'>";
    echo "<label for='Theater' class='col-sm-2 control-label'>Theater:</label>";
    echo "<div class='col-sm-10'>";
    echo "<input type='text' id='Theater' name='Theater' class='form-control' required>";
    echo "</div>";
    echo "</div>";
    echo "<div class='form-group row'>";
    echo "<label for='Movieshowtime' class='col-sm-2 control-label'>Movieshowtime:</label>";
    echo "<div class='col-sm-10'>";
    echo "<input type='text' id='Movieshowtime' name='Movieshowtime' class='form-control' required>";
    echo "</div>";
    echo "</div>";
    echo "<div class='form-group row'>";
    echo "<label for='Showtime' class='col-sm-2 control-label' required>Select Time:</label>";
    echo "<div class='col-sm-10'>";
    echo "<select name='Showtime' id='Showtime' class='form-control' required>";
    echo "<option value=''>---เลือกรอบฉาย---</option>";
    echo "<option value='09:30'>09:30</option>";
    echo "<option value='11:30'>11:30</option>";
    echo "<option value='13:30'>13:30</option>";
    echo "<option value='15:30'>15:30</option>";
    echo "<option value='19:30'>19:30</option>";
    echo "</select>";
    echo "</div>";
    echo "</div>";
    echo "<div class='form-group row'>";
    echo "<label for='TimeIn' class='col-sm-2 control-label'>TimeIn:</label>";
    echo "<div class='col-sm-10'>";
    echo "<input type='text' id='TimeIn' name='TimeIn' class='form-control' required>";
    echo "</div>";
    echo "</div>";
    echo "<div class='form-group row'>";
    echo "<label for='TimeOut' class='col-sm-2 control-label'>TimeOut:</label>";
    echo "<div class='col-sm-10'>";
    echo "<input type='text' id='TimeOut' name='TimeOut' class='form-control' required>";
    echo "</div>";
    echo "</div>";
    echo "<div class='form-group row'>";
    echo "<div class='col-sm-offset-2 col-sm-10'>";
    echo "<input type='submit' name='submit' value='เพิ่มรอบฉาย/โรงภาพยนตร์' class='btn btn-primary'>";
    echo "</div>";
    echo "</div>";
    echo "</form>";
    } else {
    echo "0 results";
    }
    ?>
<?php
echo "<script>";
echo "function getMovieID() {";
echo "  var MovieName = document.getElementById('MovieName').value;";
echo "  var xmlhttp = new XMLHttpRequest();";
echo "  xmlhttp.onreadystatechange = function() {";
echo "    if (this.readyState == 4 && this.status == 200) {";
echo "      document.getElementById('ID').value = this.responseText;";
echo "      getTimeIn();"; // เรียกใช้ฟังก์ชัน getTimeIn()
echo "      getTimeOut();"; // เรียกใช้ฟังก์ชัน getTimeOut()
echo "    }";
echo "  };";
echo "  xmlhttp.open('GET', 'getMovieID.php?MovieName=' + MovieName, true);";
echo "  xmlhttp.send();";
echo "}";
echo "function getTimeIn() {"; // เพิ่มฟังก์ชัน getTimeIn()
echo "  var MovieName = document.getElementById('MovieName').value;";
echo "  var xmlhttp = new XMLHttpRequest();";
echo "  xmlhttp.onreadystatechange = function() {";
echo "    if (this.readyState == 4 && this.status == 200) {";
echo "      document.getElementById('TimeIn').value = this.responseText;";
echo "    }";
echo "  };";
echo "  xmlhttp.open('GET', 'getTimeIn.php?MovieName=' + MovieName, true);";
echo "  xmlhttp.send();";
echo "}";
echo "function getTimeOut() {"; // เพิ่มฟังก์ชัน getTimeOut()
echo "  var MovieName = document.getElementById('MovieName').value;";
echo "  var xmlhttp = new XMLHttpRequest();";
echo "  xmlhttp.onreadystatechange = function() {";
echo "    if (this.readyState == 4 && this.status == 200) {";
echo "      document.getElementById('TimeOut').value = this.responseText;";
echo "    }";
echo "  };";
echo "  xmlhttp.open('GET', 'getTimeOut.php?MovieName=' + MovieName, true);";
echo "  xmlhttp.send();";
echo "}";
echo "</script>";


// ปิดการเชื่อมต่อฐานข้อมูล
mysqli_close($con);

?>