<?php
session_start();

// Check if user is logged in and is patient
if(!isset($_SESSION["isLoggedIn"]) || $_SESSION["isLoggedIn"] !== true || $_SESSION["role"] != "patient"){
    Header("Location: ../../Commons/View/login.php");
    exit();
}
?>

<html>
    <head>
        <title>Patient Dashboard - BDHR</title>
    </head>

<body>
    <h1>Hello, <?php echo $_SESSION["name"]; ?> (Patient)</h1>
    
    <form method="post" action="../../Commons/Controller/logout.php">
        <input type="submit" name="logout" value="Logout"/>
    </form>
</body>
</html>