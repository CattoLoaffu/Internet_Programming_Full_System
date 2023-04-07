<?php
// กำหนดค่าฐานข้อมูล
include("db.php");

// ตรวจสอบการเชื่อมต่อ
if ($con->connect_error) {
  die("Connection failed: " . $con->connect_error);
}

// ตรวจสอบการกดปุ่ม submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // รับค่าจากฟอร์ม

  $Showtime = $_POST["Showtime"];
  $TimeIn = $_POST["TimeIn"];
  $MovieName = $_POST["MovieName"];


  $sql = "SELECT * FROM theater WHERE TimeIn='$TimeIn' AND Showtime='$Showtime'";
  $result = $con->query($sql);

  $result_movie = mysqli_query($con, "SELECT ImgSent FROM movie WHERE MovieName='".$row["MovieName"]."'");
  $row_movie = mysqli_fetch_assoc($result_movie);
  
}
?>
<!DOCTYPE html>
<meta charset="UTF-8">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../CSS/style.css">

<style>

body {

        background-repeat: no-repeat;
        background-size: cover;
        background-color: #f8f9fc;
}


img.img-thumbnail {
  background-color: #fff;
  padding: 5px;
  border-radius: 5px;
  box-shadow: 0px 0px 5px #ccc;
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
    <form method="post" class="btn btn-dark d-flex flex-column align-items-center" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
  <div class="d-flex justify-content-between w-100">
    <label class="" for="TimeIn">เช็ครอบฉาย:</label>
    <div class="ml-auto">
      <a href="page19.php" class="btn btn-success mr-4">เพิ่มภาพยนต์</a>
      <a href="page191.php" class="btn btn-primary">เลือกลงรอบฉาย/โรงหนัง</a>
    </div>
  </div>
  <input class="btn btn-light mb-3" type="date" id="TimeIn" name="TimeIn">
  <label for="Showtime">Select Time:</label>
  <select name="Showtime" id="Showtime" class="btn btn-light mb-3" required>
    <option value=""selected>---เลือกรอบฉาย---</option>
    <option value="09:30">09:30</option>
    <option value="11:30">11:30</option>
    <option value="13:30">13:30</option>
    <option value="15:30">15:30</option>
    <option value="19:30">19:30</option>
  </select>
  <input type="submit" value="ดูรอบฉาย" class="btn btn-outline-light">
</form>
<br>
<?php
// ตรวจสอบว่ามีผลลัพธ์จากการเรียกข้อมูลหรือไม่
if ($result->num_rows > 0) {
    // เริ่มต้นตารางและส่วนหัวของตาราง
    echo '<table class="table table-dark table-striped table-hover">';
    echo '<thead class="table-dark">';
    echo '<tr><th>ชื่อเรื่อง</th><th>วันที่</th><th>รอบฉาย</th><th>เลขโรงภาพยนต์</th><th>ชื่อโรงภาพยนต์</th><th>หมายเลขรอบฉาย</th><th>รูป</th><th><br></th></tr></thead>';
    // เริ่มต้นส่วนเนื้อหาของตาราง
    echo '<tbody>';

    // วนลูปเพื่อแสดงผลลัพธ์
    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr><td>".$row["MovieName"]."</td><td>".$row["TimeIn"]."</td><td>".$row["Showtime"]."</td><td>".$row["Theater_number"]."</td><td>".$row["Theater_name"]."</td><td>".$row["Movieshowtime"]."</td>";
        // ตรวจสอบว่ามีรูปภาพหรือไม่
        $query_img = "SELECT ImgSent FROM movie WHERE MovieName = '".$row['MovieName']."'";
        $result_img = mysqli_query($con, $query_img);
        $row_img = mysqli_fetch_assoc($result_img);
        if (!empty($row_img["ImgSent"])) {
            echo "<td><img src='uploads/".$row_img['ImgSent']."' class='img-thumbnail' style='width: 150px; height: 150px;' /></td>";
        } else {
            echo "<td>No Image</td>";
        }
        echo "<td><br><br><button class='btn btn-danger ' onclick='deleteRow(this)'>ลบ</button></td></tr>";
        echo "</tr>";
    }
    // ปิดตาราง
    echo '</tbody></table>';
}

?>
<script>
function deleteRow(btn) {
  var row = btn.parentNode.parentNode;
  var movieName = row.cells[0].textContent.trim();
  var Movieshowtime = row.cells[5].textContent.trim();
  if (confirm("คุณต้องการลบ " + movieName + " ใช่หรือไม่?")) {
    // ส่งข้อมูลไปยังไฟล์ php ที่จะลบข้อมูลในฐานข้อมูล
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        // ถ้าลบข้อมูลเรียบร้อยแล้ว ให้ลบแถวที่เลือกออกจากตาราง
        row.parentNode.removeChild(row);
        alert("ลบข้อมูล " + movieName + " เรียบร้อยแล้ว");
      }
    };
    xhttp.open("POST", "delete.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("Movieshowtime=" + Movieshowtime);
  }
}
</script>
