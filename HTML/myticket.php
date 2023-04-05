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
            <center><span class="navbar-text" style="color: yellow;"><h3>My Ticket</h3></span></center>
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
            <div class="ticketDisplay">
            <center><?php
            include("db.php");
            $strSQL = "SELECT * from `ticket` WHERE UserName = '".$_SESSION['username']."'";
            $objquery = mysqli_query($con,$strSQL);
            $movies = array();
            if (mysqli_num_rows($objquery) > 0) {
                while ($row = mysqli_fetch_assoc($objquery)) {
                    $movies[] = $row;
                }
            }
            foreach ($movies as $movie) {
                include("ticketDisplay.php");
            }
        ?></center> 
            </div>
        </body>
</html>