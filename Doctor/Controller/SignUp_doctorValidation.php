<?php
session_start();

// Check if user came from step 1
if(!isset($_SESSION["signup_user_id"]) || $_SESSION["signup_role"] != "doctor"){
    Header("Location: ../../Commons/View/signup.php");
    exit();
}

// Include database connection
$path = __DIR__."/../../Commons/Model/DatabaseConnection.php";
if(!file_exists($path)){
    die("Database File not found");
}
include $path;

$specialization = $_POST["specialization"] ?? "";
$license_no = $_POST["license_no"] ?? "";
$chamber = $_POST["chamber"] ?? "";
//$available_days = null;
$start_time = null;
$end_time = null;

$available_days = isset($_POST["avDays"]) && !empty($_POST["avDays"]) ? implode(',', $_POST["avDays"]) : NULL;

if(!empty($_POST["strTime"])){
    $start_time=$_POST["strTime"];
}

if(!empty($_POST["endTime"])){
    $end_time=$_POST["endTime"];
}

$errors = [];
$previousValues = [];

// Validation
if(empty($specialization)){
    $errors["specialization"] = "Specialization is required";
} else {
    $previousValues["specialization"] = $specialization;
}

if(empty($license_no)){
    $errors["license_no"] = "License Number is required";
} else {
    $previousValues["license_no"] = $license_no;
}

if(empty($chamber)){
    $errors["chamber"] = "Chamber Address is required";
} else {
    $previousValues["chamber"] = $chamber;
}



// If errors, redirect back
if(count($errors) > 0){
    $_SESSION["errors"] = $errors;
    $_SESSION["previousValues"] = $previousValues;
    Header("Location: ../View/signup_doctor.php");
    exit();
}

// Check if license_no already exists (server-side validation)
$db = new DatabaseConnection();
$connection = $db->openConnection();

if($db->checkLicenseNo($connection, $license_no)){
    $_SESSION["signupErr"] = "License Number already exists!";
    $_SESSION["previousValues"] = $previousValues;
    Header("Location: ../View/signup_doctor.php");
    $db->closeConnection($connection);
    exit();
}

// Insert doctor details
$user_id = $_SESSION["signup_user_id"];
$result = $db->insertDoctor($connection, $user_id, $specialization, $license_no, $chamber, $available_days, $start_time, $end_time);

if($result){
    // Clear session variables
    unset($_SESSION["signup_user_id"]);
    unset($_SESSION["signup_role"]);
    unset($_SESSION["signup_email"]);
    
    // Redirect to login
    $_SESSION["successMsg"] = "Doctor registration successful! Please login.";
    Header("Location: ../../Commons/View/login.php");
} else {
    $_SESSION["signupErr"] = "Registration failed! Please try again.";
    Header("Location: ../View/signup_doctor.php");
}

$db->closeConnection($connection);
?>