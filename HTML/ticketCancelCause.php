<?php
include("checkSession.php");
include("db.php");
$mname = $_GET['MovieName'];
$seat = $_GET['Seat']; 
$date = $_GET['Date']; 
$sh = $_GET['Showtime'];
$ren = $_GET['Receipt_number'];
?>

<?php include("checkSession.php"); ?>
<!DOCTYPE html>
<meta charset="UTF-8">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../CSS/style.css">
<html>
    <title>Cinevault+</title>
<body>
    <div id="showing" class="card">         
        <div class="card-body">             
            <center><span class="navbar-text" style="color: yellow;"><h3>Cancelation Form</h3></span></center>
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
                  <a class="nav-link active" href="javascript:void(0)" " onclick="location.href ='LoginMain.php';">หน้าแรก </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0)" onclick="location.href ='movieSh.php';">ภาพยนตร์</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0)">
                                    <img src="../Assets/Ticketorange.png" style="width: 30px;" onclick="location.href ='myticket.php';">
                                </a>
                            </li>
                        </ul>
                        <form class="d-flex">
                            <input class="form-control me-2" type="text" placeholder="Search">
                            <button class="btn btn-secondary" type="button">Search</button>
                        </form>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <a href="logout.php">
                <img src="../Assets/logout.png" style="width: 40px;">
            </a>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            
                    </div>
                </div>
            </nav>
            <div id="ticket-info">
            <p style="color: white;">ชื่อภาพยนตร์ : </p> 
            <p style="color: orange;"><?php echo $mname ;?></p>   
            <p style="color: white;">ที่นั่งของคุณ :</p>
            <p style="color: orange;"> <?php echo $seat; ?></p>
            <p style="color: white;">ผู้จอง :</p>
            <p style="color: orange;"><?php echo $_SESSION['username'];?></p>
            <p style="color: white;">วันที่ :</p>
            <p style="color: orange;"><?php echo $date;?></p>
            <p style="color: white;">รอบ :</p>
            <p style="color: orange;"><?php echo $sh;?></p>
            </div>
            <body id="body">
        <div id="login-card-login" class="card">
        <div class="card-body">
          <br>
          <form method="post" action="ticketCancel.php">
            <div class="form-group">
              <center><textarea id="cancelform" placeholder="Cancel Cause" name="cc"></textarea></center>
            </div>
            <input type="hidden" name="mname"  id="mname" value="<?php echo $mname  ?>">
            <input type="hidden" name="seat"  id="seat" value="<?php echo $seat  ?>">
            <input type="hidden" name="date"  id="date" value="<?php echo $date  ?>">
            <input type="hidden" name="showtime"  id="showtime" value="<?php echo $sh  ?>">
            <input type="hidden" name="receiptnum"  id="receiptnum" value="<?php echo $ren  ?>">
            <br>
            <center><input type="submit" value="Submit" id="click-login" name="login" ></center>
        </form>
</body>