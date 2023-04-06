<?php
    include("db.php");
    include("checkSession.php");
    $uname = $_SESSION['username'];
    $mname = $_GET['MovieName'];
    $st = $_GET['Showtime'];
    $seat = $_GET['Seat'];
    $ren = $_GET['Receipt_number'];
    $strSQL = "SELECT * FROM `ticket` WHERE username = '".$uname."'AND Showtime = '".$st."'";
    $query = mysqli_query($con,$strSQL);
    $row = mysqli_fetch_assoc($query);

    $str = "SELECT * FROM `movie` WHERE MovieName = '".$mname."'";
    $jquery = mysqli_query($con,$str);
    $col = mysqli_fetch_assoc($jquery);
?>
<!DOCTYPE html>
<meta charset="UTF-8">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../CSS/style.css">
<html>

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
                  <a class="nav-link active" href="javascript:void(0)" " onclick="location.href ='LoginMain.php';">หน้าแรก </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0)" onclick="location.href ='movieSh.php';"style="color: orange;">ภาพยนตร์</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="javascript:void(0)">
                                    <img src="../Assets/Ticket.png" style="width: 30px;" onclick="location.href ='myticket.php';">
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
    <br><br><br><br><br><br>
    <title>Cinevault+</title>
    </head>
        <div id="ticket-info">
            <img src="../Assets/remove.png" width=30px boder=2 align=right onclick="location.href ='ticketCancelCause.php?MovieName=<?php echo $row['MovieName'];?>&Seat=<?php echo $seat; ?>&Date=<?php echo $row['Date'];?>&Showtime=<?php echo $row['Showtime'];?>&Receipt_number=<?php echo $row['Receipt_number'] ?>'">
            <img src="<?php echo $col['ImgPull'];?>" width=200px boder=2 align=right  style="padding-right: 20px;">
            <h1 style="color: white;">จองที่นั่งสำเร็จ</h1>
            <p style="color: white;">ชื่อภาพยนตร์ : </p> 
            <p style="color: orange;"><?php echo $row['MovieName'];?></p>   
            <p style="color: white;">ที่นั่งของคุณ :</p>
            <p style="color: orange;"> <?php echo $seat; ?></p>
            <p style="color: white;">ผู้จอง :</p>
            <p style="color: orange;"><?php echo $row['UserName'];?></p>
            <p style="color: white;">วันที่ :</p>
            <p style="color: orange;"><?php echo $row['Date'];?></p>
            <p style="color: white;">รอบ :</p>
            <p style="color: orange;"><?php echo $row['Showtime'];?></p>
        </div>
       
        <div id="qr-code"><br>
           <img src="../Assets/QR.png" alt="QR code">
            <p style="color: white;">สแกน Qr code หน้าโรงหนังเพื่อรับตั๋วภาพยนตร์</p>
        
</html>

