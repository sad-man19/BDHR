<?php
session_start();
if(!isset($_SESSION["isLoggedIn"])||$_SESSION["isLoggedIn"] !== true || $_SESSION["role"]!="patient"){
    header("Location: ../../Commons/View/login.php");
    exit();

} 

if(!isset($_SESSION["profile_data"])){
    header("Location: ../Controller/profile_viewer.php");
    exit();
}

//getting data
$patient=$_SESSION["profile_data"];

?>

<html>
    <head>
    <title>My profile</title>
    <link rel="stylesheet" href="../public/css/profile.css">
    </head>
    <body>
        <div class="profile">
            <h2>Profile Information</h2>
            <table class="table">
                <tr>
                <td class="label">Medical ID:</td>
                <td class="value"><?php echo htmlspecialchars($patient["medical_id"] ?? "Not found")?></td>
                </tr>
                <tr>
                <td class="label">Name:</td>
                <td class="value"><?php echo htmlspecialchars($patient["name"] ?? "Not found")?></td>
                </tr>
                <tr>
                <td class="label">Gender:</td>
                <td class="value"><?php echo htmlspecialchars($patient["gender"] ?? "Not found")?></td>
                </tr>
                <tr>
                <td class="label">Date of Birth:</td>
                <td class="value"><?php echo htmlspecialchars($patient["dob"] ?? "Not found")?></td>
                </tr>
                <tr>
                <td class="label">Email:</td>
                <td class="value"><?php echo htmlspecialchars($patient["email"] ?? "Not found")?></td>
                </tr>
                <tr>
                <td class="label">Phone:</td>
                <td class="value"><?php echo htmlspecialchars($patient["phone"] ?? "Not found")?></td>
                </tr>
                <tr>
                <td class="label">Address:</td>
                <td class="value"><?php echo htmlspecialchars($patient["address"] ?? "Not found")?></td>
                </tr>
            </table>
            <div class="btns">
                <a href="dashboard.php">Go to dashboard</a><br>
                <a href="">Edit Profile</a>
            </div>
        </div>
    </body>
</html>