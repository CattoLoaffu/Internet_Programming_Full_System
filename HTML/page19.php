<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['ImgSent'])) {
    $MovieName = $_POST['MovieName'];
    $MovieType = $_POST['MovieType'];
    $TimeIn = $_POST['TimeIn'];
    $TimeOut = $_POST['TimeOut'];
    $MovieDetails = $_POST['MovieDetails'];
    $MovieTrailer = $_POST['MovieTrailer'];
    $MovieLength = $_POST['MovieLength'];
    $ID = $_POST['ID'];
    $CopyrightCost = $_POST['CopyrightCost'];
    
    // เชื่อมต่อกับฐานข้อมูล MySQL
    
    include("db.php");
    if (!$con) {
        die('Connection failed: ' . mysqli_connect_error());
    }
    
    // ตรวจสอบว่าไฟล์รูปถูกอัพโหลดหรือไม่
    if ($_FILES['ImgSent']['error'] == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES['ImgSent']['tmp_name'];
        $file_name = $_FILES['ImgSent']['name'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_exts = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (in_array($file_ext, $allowed_exts)) {
            // สุ่มชื่อไฟล์ใหม่เพื่อไม่ให้ชื่อไฟล์ซ้ำกัน
            $new_name = uniqid() . '.' . $file_ext;
            // ย้ายไฟล์เข้าโฟลเดอร์ uploads/
            move_uploaded_file($tmp_name, 'uploads/' . $new_name);
            
            $ID = mysqli_real_escape_string($con, $_POST['ID']);
            $sql = "SELECT ID FROM movie WHERE ID = '$ID'";
            $result = mysqli_query($con, $sql);
            if(mysqli_num_rows($result) > 0){ // ถ้ามี ID ที่ตรงกับค่าที่รับเข้ามาในตาราง
                echo "<div class='alert alert-danger' role='alert'>มีเลข ID นี้อยู่แล้ว</div>";
            }else{ // ถ้าไม่มี ID ที่ตรงกับค่าที่รับเข้ามาในตาราง
                $sql = "INSERT IGNORE INTO movie (ID,MovieName,MovieType,MovieDetails,MovieTrailer,ImgSent,TimeIn,TimeOut,MovieLength,CopyrightCost)
                VALUES ('$ID','$MovieName','$MovieType','$MovieDetails','$MovieTrailer','$new_name','$TimeIn','$TimeOut','$MovieLength','$CopyrightCost')";
                $result = mysqli_query($con, $sql); // ส่งคำสั่ง SQL ไปทำงาน
                if($result){
                    echo "<div class='alert alert-success' role='alert'>อัพโหลดแล้ว</div>";
                    header("Refresh: 2; url=page18.php");
                }else{
                    echo "<div class='alert alert-danger' role='alert'>ไม่สามารถอัพโหลดได้</div>";
            }
        }
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
input {
  font-size: 20px;
  height: 40px;
  width: 100%; /* กำหนดให้ input เต็มกว้าง */
}
.form-group {
    margin-bottom: 20px; /* เพิ่มระยะห่างของแต่ละกลุ่ม */
    display: flex;
    flex-direction: row; /* จัดเรียงเป็นแถวเดียว */
    justify-content: center; /* จัดให้อยู่กลางแนวตั้ง */
    align-items: center; /* จัดให้อยู่กลางแนวนอน */
    height: 80px;
    
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

    <div class="btn btn-dark d-flex flex-column align-items-center"  >
        <div class="top">
            <div class="movie-details" style="display:flex;">
                
                <div class="genre" style="margin-left:25px;">
                <form action="" method="post" enctype="multipart/form-data">
                
                <form name="DateFilter" method="POST">
                <p style="color:#ffffff" ><label class="mr-sm-2" for="ID">เลขID:</label>
                <input type="text" name="ID" id="ID" class="form-control" required> </a>
                </p>

                <p style="color:#ffffff" >วันที่เข้าฉาย:
                <input type="date" name="TimeIn" id="TimeIn" class="form-control" value="<?php echo date('Y-m-d'); ?>" />
                
                <p style="color:#ffffff" >วันที่ออกฉาย:
                <input type="date" name="TimeOut" id="TimeOut" class="form-control" value="<?php echo date('Y-m-d'); ?>" />
                <p style="color:#ffffff" ><label for="MovieName" >ชื่อหนัง:</label>
                 <input type="text" name="MovieName" id="MovieName" class="form-control" required>
                 </p>

                <p style="color:#ffffff" ><label class="mr-sm-2" for="MovieType">หมวดหมู่:</label>
                <input type="text" name="MovieType" id="MovieType" class="form-control" required> </a>
                </p>

                <p style="color:#ffffff" ><label class="mr-sm-2" for="CopyrightCost">ค่าลิขสิทธิ์:</label>
                <input type="number" name="CopyrightCost" id="CopyrightCost" class="form-control" required> </a>
                </p>

                <p style="color:#ffffff" ><label for="ImgSent">รูปภาพ:</label>
                <input type="file" name="ImgSent" id="ImgSent" accept="image/*" required>
                </p>

                    <table>
                        <tr>
                            <td><img src="../Assets/ClockOrange.png" style="width: 25px" alt="Clock icon"></td>
                            <td>
                                &nbsp;&nbsp;<p style="color:#ffffff"><label class="mr-sm-2" for="MovieLength">ความยาวของหนัง:</label>                               
                                <input type="number" name="MovieLength" id="MovieLength" class="form-control" required> <a style="color:#ffffff">นาที</a>
                        </tr>
                    </table>
                    <br>
            <p style="color:#ffffff" ><label class="mr-sm-2" for="MovieTrailer" >ตัวอย่างหนัง:</label>
                 <input type="url" name="MovieTrailer" placeholder="https://youtube.com" pattern="https://.*" id="MovieTrailer" class="form-control" required>
                 </p>
            <p style="color:#ffffff" ><label for="MovieDetails">เรื่องย่อ:</label>
                 <textarea type="text" class="card shadow mb-4" rows="3"  name="MovieDetails" id="MovieDetails" placeholder=" รายละเอียด" style="width:100%" required></textarea>
                 </p>
            </p>
        
            <button type="submit" class="btn btn-success center">อัปโหลดข้อมูล</button>

        
        </div>

    </div>
    
</body>
</html>
