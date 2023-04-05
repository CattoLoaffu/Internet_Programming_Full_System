<?php
    session_start();
    include("db.php");
    $name = $_POST["name"];
    $email = $_POST["email"];
    $password = $_POST["pass"];
    $conpassword = $_POST["conpass"];
    $idnum = $_POST["idnum"];
    $tel = $_POST["tel"];
    $dateb = $_POST["bd"];
    $time = date("Y-m-d H:i:s");

    $strSQL = "INSERT INTO user(t_stamp ,Email, password , userName , idcard , Birthday , Phone_number) VALUES ('$time','$email','$password','$name' ,'$idnum','$dateb','$tel')";
    $objQuery = mysqli_query($con,$strSQL);
    if($objQuery)
    {
        echo "<script> alert('Register successful');</script>";
        echo "<script> window.location='index.php';</script>";
    }
    else
    {
        echo "<script> alert('Register failed)</script>";
        echo "<script> window.location='register.php';</script>";
    }
    mysqli_close($con);
?>
