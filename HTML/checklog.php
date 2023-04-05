<?php
    session_start();
    include("db.php");
    $strSQL = "SELECT * FROM user WHERE Email = '".mysqli_real_escape_string($con,$_POST['email'])."' 
    and password = '".mysqli_real_escape_string($con,$_POST['pass'])."'";
    $objQuery = mysqli_query($con,$strSQL);
    $objResult = mysqli_fetch_array($objQuery);
    if($objResult)
    {
        $_SESSION['username'] = $objResult['UserName'];
        header("Location:LoginMain.php");
    }
    else
    {
        echo "<script>alert('Username or Password incorrect')</script>";
        echo "<script> window.location='login.php';</script>";
    }
    mysqli_close($con);
?>



