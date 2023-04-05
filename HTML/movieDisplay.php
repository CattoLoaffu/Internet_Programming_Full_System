<!DOCTYPE html>
<link rel="stylesheet" href="../CSS/style.css">
<div class='BP2'>
    <br><br><br>
    <img src="<?php echo $movie['ImgPull'] ?>" width='200'>
    <span class='navbar-text' style='color: white;'>
        <p>9 พฤศจิกายน 2022</p>
        <h3><?php echo $movie['MovieName'] ?></h3>
        <p><?php echo $movie['MovieLength'] ?> นาที</p>
        <button onclick="location.href ='movieDetail.php?ID=<?php echo $movie['ID'] ?>'">ดูเพิ่มเติม</button>
    </span>
</div>