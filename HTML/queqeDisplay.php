<!DOCTYPE html>
<link rel="stylesheet" href="../CSS/style.css">
<div class="model">
    <img src="<?php echo $col['ImgPull'] ?>">
        <div>
            <h1><?php echo $t['Theater_name']?></h1>
            <div class="description">
                <h4><?php echo $col['MovieName']; ?>| </h4>
                <h4>EN/TH | </h4>
                <h4>2D/3D</h4>
            </div>
            <div class="time">
                <h4 onclick="location.href ='seat.php?ID=<?php echo $col['ID'] ?> &Showtime=<?php echo $t['Showtime']?>&tnumber=A'"><?php echo $t['Showtime']?></h4>
            </div>
</div>