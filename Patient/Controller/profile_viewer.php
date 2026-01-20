<?php
session_start();

if(!isset($_SESSION["isLoggedIn"])||$_SESSION["isLoggedIn"] !== true || $_SESSION["role"]!="patient"){
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

$patientData = $db->getPatientDetails($connection, $user_id);//fetching
//$_SESSION("profile_data") = $patientData;

$_SESSION["profile_data"] = $patientData;//storing

$db->closeConnection($connection);
header("Location: ../View/profile.php");
exit();
?>