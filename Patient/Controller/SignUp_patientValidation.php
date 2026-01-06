<?php
session_start();

// Check if user came from step 1
if(!isset($_SESSION["signup_user_id"]) || $_SESSION["signup_role"] != "patient"){
    Header("Location: ../../Commons/View/signup.php");
    exit();
}

// Include database connection
$path = __DIR__."/../../Commons/Model/DatabaseConnection.php";
if(!file_exists($path)){
    die("Database File not found");
}
include $path;

$medical_id = $_POST["medical_id"] ?? "";
$dob = $_POST["dob"] ?? "";
$address = $_POST["address"] ?? "";

$errors = [];
$previousValues = [];

// Validation
if(empty($medical_id)){
    $errors["medical_id"] = "Medical ID is required";
} else {
    $previousValues["medical_id"] = $medical_id;
}

if(empty($dob)){
    $errors["dob"] = "Date of Birth is required";
} else {
    $previousValues["dob"] = $dob;
}

if(empty($address)){
    $errors["address"] = "Address is required";
} else {
    $previousValues["address"] = $address;
}

// If errors, redirect back
if(count($errors) > 0){
    $_SESSION["errors"] = $errors;
    $_SESSION["previousValues"] = $previousValues;
    Header("Location: ../View/signup_patient.php");
    exit();
}

// Check if medical_id already exists (server-side validation)
$db = new DatabaseConnection();
$connection = $db->openConnection();

if($db->checkMedicalId($connection, $medical_id)){
    $_SESSION["signupErr"] = "Medical ID already exists!";
    $_SESSION["previousValues"] = $previousValues;
    Header("Location: ../View/signup_patient.php");
    $db->closeConnection($connection);
    exit();
}

// Insert patient details
$user_id = $_SESSION["signup_user_id"];
$result = $db->insertPatient($connection, $user_id, $medical_id, $dob, $address);

if($result){
    // Clear session variables
    unset($_SESSION["signup_user_id"]);
    unset($_SESSION["signup_role"]);
    unset($_SESSION["signup_email"]);
    
    // Redirect to login
    $_SESSION["successMsg"] = "Patient registration successful! Please login.";
    Header("Location: ../../Commons/View/login.php");
} else {
    $_SESSION["signupErr"] = "Registration failed! Please try again.";
    Header("Location: ../View/signup_patient.php");
}

$db->closeConnection($connection);
?>