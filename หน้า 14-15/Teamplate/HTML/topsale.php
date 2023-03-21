<?php
include('conn.php');
$sql = "SELECT * FROM movie ORDER BY profit DESC;" ;
$query = mysqli_query($conn,$sql);
$Icon = "Assets/icon.png";
?>
<!DOCTYPE html>
<meta charset="UTF-8">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="CSS/style.css">
<link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
<link rel="stylesheet" href="CSS/style2.css">
<html>
<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
  text-align: left;
  padding: 8px;
}
</style>
    <head>
        <meta charset="UTF-8">
        <title>Cinevault+</title>
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
      
        <link rel='stylesheet prefetch' href='http://cdn.jsdelivr.net/jquery.slick/1.5.9/slick.css'>
      <link rel='stylesheet prefetch' href='http://cdn.jsdelivr.net/jquery.slick/1.5.9/slick.css'>
      
            <link rel="stylesheet" href="CSS/style2.css">
      
        
      </head>
<body>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="javascript:void(0)">
            <img src="<?php echo $Icon ; ?>" style="width: 30px;">
            </a>
            <span class="navbar-text" style="color: white;">Cinevault+</span>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <div class="collapse navbar-collapse" id="mynavbar">
                
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="javascript:void(0)">หน้าแรก</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0)">ลงรอบภาพยนต์</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="javascript:void(0)">ค้นหาข้อมูลผู้ใช้งาน</a>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="text" placeholder="Search">
                    <button class="btn btn-secondary" type="button">Search</button>
                </form>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="">
                    <img src="Assets/userIcon.png" style="width: 30px;">
                </a>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            </div>
            
        </div>
    </nav>
<div class="phuket" >
<h2> ภาพยนตร์ขายดีประจำปี</h2>
</div>

<div class="content" >


<table style="width:100%"  >
<tr>
  <th>ชื่อภาพยนตร์</th>
  <th>ยอดขายทั้งหมด</th>
  <th>ลิขสิทธิ์ที่จ่าย</th>
  <th>รายได้สุทธิ</th>
</tr>
  <?php foreach($query as $data){ ?>
  <tr>
    <td><?=$data['name']  ?></td>
    <td><?=$data['sale']  ?></td>
    <td><?=$data['copyright cost']  ?></td>
    <td><?=$data['profit']  ?></td>
  </tr>
  <?php } ?>
</table>
</div>
</html>