<?php
session_start();

// Include database connection
$path = __DIR__."/../Model/DatabaseConnection.php";
if(!file_exists($path)){
    die("Database File not found");
}
include $path;

// Collect form data
$email_phone = $_POST["email_phone"] ?? "";
$password = $_POST["password"] ?? "";

$errors = [];
$previousValues = [];

// Validation
if(empty($email_phone)){
    $errors["email_phone"] = "Email or Phone is required";
} else {
    $previousValues["email_phone"] = $email_phone;
}

if(empty($password)){
    $errors["password"] = "Password is required";
}

// If errors, redirect back
if(count($errors) > 0){
    $_SESSION["errors"] = $errors;
    $_SESSION["previousValues"] = $previousValues;
    Header("Location: ../View/login.php");
    exit();
}

// Check credentials
$db = new DatabaseConnection();
$connection = $db->openConnection();

// Use the loginUser method
$result = $db->loginUser($connection, $email_phone, $password);

if($result && $result->num_rows > 0){
    $user = $result->fetch_assoc();
    
    // Set session variables
    $_SESSION["isLoggedIn"] = true;
    $_SESSION["user_id"] = $user["id"];
    $_SESSION["name"] = $user["name"];
    $_SESSION["email"] = $user["email"];
    $_SESSION["phone"] = $user["phone"];
    $_SESSION["role"] = $user["role"];
    
    // Redirect based on role
    if($user["role"] == "patient"){
        Header("Location: ../../Patient/View/dashboard.php");
    } elseif($user["role"] == "doctor"){
        Header("Location: ../../Doctor/View/dashboard.php");
    }
} else {
    $_SESSION["loginErr"] = "Invalid email/phone or password!";
    $_SESSION["previousValues"] = $previousValues;
    Header("Location: ../View/login.php");
}

$db->closeConnection($connection);
?>