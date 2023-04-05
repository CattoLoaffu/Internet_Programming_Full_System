<?php include("checkSession.php"); ?>
<!DOCTYPE html>
<meta charset="UTF-8">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="../CSS/style.css">
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
    <br>
    <br>
    <br>
    <br>
    <br>
    <?php 
    include("db.php");
    $id = $_GET['ID'];
    $strSQL = "SELECT * from `movie` WHERE ID = '$id'";
    $objquery = mysqli_query($con,$strSQL);
    $col = mysqli_fetch_assoc($objquery)
    ?>
    <div class="movie">
        <div class="top">
        <div class="movie-details" style="display:flex;">
            <img src="<?php echo $col['ImgPull'] ?>" width='200' alt="Movie poster">
            <div style="margin-left:20px;">
                <p style="color:#ffffff" class="movie-release-date">09 พฤศจิกายน 2022</p>
                <h1 style="color:#ffffff"><?php echo $col['MovieName']; ?></h1>
                <p style="color:#ffffff" class="genre"><?php echo $col['MovieType']; ?></p>
                <table>
                    <tr>
                        <td><img src="../Assets/ClockOrange.png" style="width: 25px" alt="Clock icon"></td>
                        <td>
                            &nbsp;&nbsp;<p style="color:#ffffff"><?php echo $col['MovieLength']; ?> นาที</p>
                        </td>
                    </tr>
                </table>
                <br>
                <button class="view-showtimes-button" onclick="location.href ='moviequeqe.php?ID=<?php echo $col['ID'] ?>'">ดูรอบฉายทั้งหมด</button>
            </div>
        </div>
        <iframe width="560" height="315" src="<?php echo $col['MovieTrailer'] ?>" title="YouTube video player"
        frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
        allowfullscreen></iframe>
        </div>
        <br>
        <h2 style="color:#ffffff" class="title">ข้อมูลภาพยนตร์ | รอบฉาย</h2>
        <p class="movie-info" style="color:#ffffff">
        <?php echo $col['MovieDetails']; ?>
        </p>
    </div>
</body>
</html>