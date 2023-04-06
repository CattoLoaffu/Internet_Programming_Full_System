<!DOCTYPE html>
<link rel="stylesheet" href="../CSS/style.css">
<div class="ticket-card">
    <div>
        <?php echo "Movie name : ".$movie['MovieName']; ?>
    </div>
    <div>
        <?php echo "Showtime : ".$movie['Showtime']." | Seat :".$movie['Seat_number'];  ?>
    </div>
    <div>
        <?php echo "Date : ".$movie['Date'];?>
    </div>
    <br>
    <div class="ticketFullDetail">
        <h4 onclick="location.href ='ticketFullDetail.php?MovieName=<?php echo $movie['MovieName'] ?>&Showtime=<?php echo $movie['Showtime'] ?>&Seat=<?php echo $movie['Seat_number'] ?>&Receipt_number=<?php echo $movie['Receipt_number'] ?>'">ข้อมูลเพิ่มเติม...</h4>
    </div>
</div>