<?php
//session_start();

if(!isset($_SESSION["isLoggedIn"])||$_SESSION["isLoggedIn"] !== true || $_SESSION["role"]!="doctor"){
    header("Location: ../../Commons/View/login.php");
    exit();
}

$path = __DIR__."/../Model/DatabaseConnection.php";

if(!file_exists($path)){
    die("Database not found");

}
include $path;



$db=new DatabaseConnection();
$connection = $db->openConnection();
$doctor_id = $_SESSION["doctor_id"] ?? 0;



$result = null;

if ($doctor_id > 0) {
    $result = $db->getTodaysAppointments($connection, $doctor_id);
}


$db->closeConnection($connection);
//header("Location: ../View/profile.php");
//exit();
?>