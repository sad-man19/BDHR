<?php
session_start();

// Check if user is logged in and is doctor
if(!isset($_SESSION["isLoggedIn"]) || $_SESSION["isLoggedIn"] !== true || $_SESSION["role"] != "doctor"){
    Header("Location: ../../Commons/View/login.php");
    exit();
}
?>

<html>
    <head>
        <title>Doctor Dashboard - BDHR</title>
    </head>

<body>
    <h1>Hello, Dr. <?php echo $_SESSION["name"]; ?></h1>
    
    <form method="post" action="../../Commons/Controller/logout.php">
        <input type="submit" name="logout" value="Logout"/>
    </form>
</body>
</html>