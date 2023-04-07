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
                    <a class="nav-link active" href="javascript:void(0)" onclick="location.href ='Page10-11.php';">หน้าแรก</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="javascript:void(0)" onclick="location.href ='Page18.php';">ลงรอบภาพยนตร์</a>
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
<div class="page12">
  <div class="movie-type-table">
    <div class="movies-type">
      <?php
      include("db.php");
      
      // SQL query to retrieve movie data and calculate net income
      $sql = "SELECT sm.MovieName, SUM((sm.StanddardSales * 160)+(sm.SofaSweetSales * 180)) AS TotalSales, m.CopyrightCost,
              SUM((sm.StanddardSales * 160)+(sm.SofaSweetSales * 180)) - m.CopyrightCost AS NetIncome
              FROM sales_movie sm
              INNER JOIN movie m ON sm.MovieName = m.MovieName
              GROUP BY sm.MovieName
              ORDER BY NetIncome DESC";
      
      // Execute the query
      $result = mysqli_query($con, $sql);
      
      // Check if query is successful
      if (!$result) {
        die("Query failed: " . mysqli_error($con));
      }
      
      // Create the table header
      echo "<h3>ภาพยนตร์ขายดีประจำปี</h3>";
      echo "<table>";
      echo "<tr><th>ชื่อภาพยนตร์</th><th>ยอดขายทั้งหมด</th><th>ค่าลิขสิทธิ์ของภาพยนตร์</th><th>รายได้สุทธิ</th></tr>";
      
      // Loop through the query results and output each row
      while ($row = mysqli_fetch_assoc($result)) {
        // Create a new row in the table
        echo "<tr>";
        echo "<td>".$row["MovieName"]."</td>";
        echo "<td>".$row["TotalSales"]."</td>";
        echo "<td>".$row["CopyrightCost"]."</td>";
        echo "<td>".$row["NetIncome"]."</td>";
        echo "</tr>";
      }
      
      // Close the table
      echo "</table>";
      
      // Close the database connection
      mysqli_close($con);
      ?>
      