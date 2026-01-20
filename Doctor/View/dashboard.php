<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Check if user is logged in and is doctor
if(!isset($_SESSION["isLoggedIn"]) || $_SESSION["isLoggedIn"] !== true || $_SESSION["role"] != "doctor"){
    Header("Location: ../../Commons/View/login.php");
    exit();
}

include_once '../Controller/default.php';
?>

<html>
    <head>
        <title>Doctor Dashboard - BDHR</title>
        <link rel="stylesheet" href="../public/css/dashboard.css">
    </head>

<body>
    <div class="container">
        <div class="menubar">
            <h2>Doctor Dashboard</h2>
            <a href="" class="featureBtn">Today's Appointment</a><br>
            <a href="" class= "featureBtn">Create Appointment</a><br>
        </div>


        <h1>Hello, Dr. <?php echo $_SESSION["name"]; ?></h1>
        <!--h2><?php echo "Doctor ID: " . ($_SESSION['doctor_id'] ?? 'not set');?></h2-->
        <a href="../Controller/profile_viewer.php">View My Profile</a>
        
        <form method="post" action="../../Commons/Controller/logout.php">
            <input type="submit" name="logout" value="Logout"/>
        </form>



        <div class="main">
            <h2>Today's appointments</h2>
            <?php if ($result && $result->num_rows > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>Patient Name</th>
                            <th>Medical ID</th>
                            <th>Reason</th>
                            <th>Status</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <?php echo date('h:i A', strtotime($row['appointment_time'])); ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($row['patient_name']); ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($row['medical_id']); ?>
                            </td>
                            <td>
                                <?php echo htmlspecialchars($row['reason'] ?? 'Not specified'); ?>
                            </td>
                            <td>
                                <?php echo ucfirst($row['status']); ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>

                <?php else: ?>
            <p class="no-data">No appointments scheduled for today.</p>
        <?php endif; ?>
        </div>
    </div>


    
</body>
</html>