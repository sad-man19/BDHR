<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

if(!isset($_SESSION["isLoggedIn"])||$_SESSION["isLoggedIn"] !== true || $_SESSION["role"]!="doctor"){
    header("Location: ../../Commons/View/login.php");
    exit();
}

$path = __DIR__."/../Model/DatabaseConnection.php";

if(!file_exists($path)){
    die("Database not found");

}
include $path;
$user_id = $_SESSION["user_id"];

$db=new DatabaseConnection();
$connection = $db->openConnection();

$doctorData = $db->getDoctorDetails($connection, $user_id);//fetching
//$_SESSION("profile_data") = $patientData;

$_SESSION["profile_data"] = $doctorData;//storing

/*
echo "<pre>";
print_r($_SESSION);
exit();*/


$db->closeConnection($connection);
header("Location: ../View/profile.php");
exit();
?>