<?php
session_start();
if(!isset($_SESSION["isLoggedIn"])||$_SESSION["isLoggedIn"] !== true || $_SESSION["role"]!="doctor"){
    header("Location: ../../Commons/View/login.php");
    exit();

} 

if(!isset($_SESSION["profile_data"])){
    Header("Location: ../Controller/profile_viewer.php");
    exit();
}




//getting data
$doctor=$_SESSION["profile_data"];
$successMsg= $_SESSION["successMsg"] ?? null;

if(isset($_SESSION["successMsg"])){
    unset($_SESSION["successMsg"]);
}
?>

<html>
    <head>
    <title>My profile</title>
    <link rel="stylesheet" href="../public/css/profile.css">
    </head>
    <body>
        <div class="profile">
            <h2>Profile Information</h2>
            <div class="profile">
            <?php if($successMsg): ?>
                <div class="success-msg">
                <?php echo $successMsg; ?>
                </div>
            <?php endif; ?>
            <table class="table">
                <tr>
                <td class="label">Name:</td>
                <td class="value"><?php echo htmlspecialchars($doctor["name"] ?? "Not found")?></td>
                </tr>
                <tr>
                <td class="label">License:</td>
                <td class="value"><?php echo htmlspecialchars($doctor["license_no"] ?? "Not found")?></td>
                </tr>
                <tr>
                <td class="label">Specialization:</td>
                <td class="value"><?php echo htmlspecialchars($doctor["specialization"] ?? "Not found")?></td>
                </tr>
                <tr>
                <td class="label">Chamber:</td>
                <td class="value"><?php echo htmlspecialchars($doctor["chamber"] ?? "Not found")?></td>
                </tr>
                <tr>
                <td class="label">Gender:</td>
                <td class="value"><?php echo htmlspecialchars($doctor["gender"] ?? "Not found")?></td>
                </tr>
                <tr>
                <td class="label">Email:</td>
                <td class="value"><?php echo htmlspecialchars($doctor["email"] ?? "Not found")?></td>
                </tr>
                <tr>
                <td class="label">Phone:</td>
                <td class="value"><?php echo htmlspecialchars($doctor["phone"] ?? "Not found")?></td>
                </tr>
                
                
            </table>
            <div class="btns">
                <a href="dashboard.php">Go to dashboard</a><br>
                <a href="edit_profile.php">Edit Profile</a>
            </div>
        </div>
    </body>
</html>