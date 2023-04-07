<!DOCTYPE html>
<meta charset="UTF-8">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../CSS/style.css">
<style>

    
</style>
<html>
  <title>Cinevault+</title>
<body>
  <nav class="navbar navbar-expand-sm navbar-dark bg-dark fixed-top">
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
    <div class="Page21">
        <div class="user-info">
            <div class="user-picture">
              <img src="../Assets/เพิ่มรูป.JPG" alt="User Picture">
            </div>
            <div class="user-details">
            <?php
                session_start();
                include("db.php");
                $rno=$_GET['userName'];
                $sql="SELECT * FROM `user` WHERE UserName='".mysqli_real_escape_string($con,$rno)."'";
                $result=$con->query($sql);
                $row=$result->fetch_assoc();    
                            
                $name=$row['UserName'];
                $dateb=$row['Birthday'];
                $idnum=$row['IDcard'];
                $email=$row['Email'];

                echo $name."<br>";
                echo "<b><u>Date of Birth:</u></b> ".$dateb."<br>";
                echo "<b><u>ID Card Number:</u></b> ".$idnum."<br>";
                echo "<b><u>Email Address:</u></b> ".$email."<br>";
              ?>
            </div>
          </div>
          <div class="purchase-history">
            <h3>Purchase History</h3>
            <?php
            $i=0;
            $strSQL="SELECT * FROM `buy_history` WHERE UserName='".mysqli_real_escape_string($con,$rno)."'";
            $obj=mysqli_query($con,$strSQL);
          echo "<center><table></center>";
          echo "<tr><th><center>Date</center></th>";
          echo "<th><center>MovieName</center></th>";
          echo "<th><center>Seat</center></th>";
          echo "</tr>";
          if (mysqli_num_rows($obj) > 0) {
          while ($col = mysqli_fetch_assoc($obj)) {
            $i++;
                if ($i % 2 == 0) {
                    echo "<tr>";
                } else {
                    echo "<tr>";
                }
              echo "<td>" . $col["Date"] . "</td><td>" . $col["MovieName"] . "</td>";
              echo "<td>" . $col["Seat_number"] . "</td>";  
            }
          }
    echo "</table>";
    mysqli_close($con);

?>
          </div>
          <br><br>
          <center><a href="page20.php" class="btn btn-primary">Go Back</a></center>

    </div>
</body>
</html>

</body>
</html>
