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
  // Retrieve data for the third pie chart (best-selling movie genres of the week)
  $sql = "SELECT MovieType FROM sales_movie";
  $result = mysqli_query($con, $sql);
  if (!$result) {
    die("Query failed: " . mysqli_error($con));
  }
  $movieTypes = array();
  while ($row = mysqli_fetch_assoc($result)) {
    $types = explode(",", $row['MovieType']);
    foreach($types as $type) {
      $type = trim($type);
      if(!empty($type)) {
        if(isset($movieTypes[$type])) {
          $movieTypes[$type]++;
        } else {
          $movieTypes[$type] = 1;
        }
      }
    }
  }
  // Sort the movieTypes array in descending order based on ticket sales count
  arsort($movieTypes);
?>
<h3>ประเภทภาพยนตร์ขายดี</h3>
<table>
  <tr>
    <th>ประเภทภาพยนตร์</th>
    <th>ยอดขายตั๋วภาพยนตร์</th>
  </tr>
  <?php foreach ($movieTypes as $type => $count) { ?>
  <tr>
    <td><?php echo $type; ?></td>
    <td><?php echo $count; ?></td>
  </tr>
  <?php } ?>
</table>
