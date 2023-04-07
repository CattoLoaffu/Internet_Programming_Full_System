<?php

header('Content-type: application/json');

include("db.php");
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['MovieName'])) {
    $MovieName = $_GET['MovieName'];
    $sql = "SELECT TimeIn FROM movie WHERE MovieName = '$MovieName'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);
    echo $row['TimeIn'];
}

mysqli_close($con);
?>
