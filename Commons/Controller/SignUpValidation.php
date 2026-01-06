<?php
session_start();

$path = __DIR__."/../Model/DatabaseConnection.php";
if(!file_exists($path)){
    die("Database File not found");
}
include $path;

$name = $_POST["name"] ?? "";
$gender = $_POST["gender"] ?? "";
$email = $_POST["email"] ?? "";
$phone = $_POST["phone"] ?? "";
$role = $_POST["role"] ?? "";
$password = $_POST["password"] ?? "";
$confirmPassword = $_POST["confirmPassword"] ?? "";

$errors = [];
$previousValues = [];

// Validation
if(empty($name)){
    $errors["name"] = "Name is required";
} else {
    $previousValues["name"] = $name;
}

if(empty($gender)){
    $errors["gender"] = "Gender is required";
} else {
    $previousValues["gender"] = $gender;
}

if(empty($email)){
    $errors["email"] = "Email is required";
} elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $errors["email"] = "Invalid email format";
} else {
    $previousValues["email"] = $email;
}

if(empty($phone)){
    $errors["phone"] = "Phone is required";
} elseif(!preg_match("/^01[0-9]{9}$/", $phone)){
    $errors["phone"] = "Invalid phone number(must be 11 digit)";
} else {
    $previousValues["phone"] = $phone;
}

if(empty($role)){
    $errors["role"] = "Role is required";
} else {
    $previousValues["role"] = $role;
}

if(empty($password)){
    $errors["password"] = "Password is required";
} elseif(strlen($password) < 6){
    $errors["password"] = "Password must be at least 6 characters";
}

if(empty($confirmPassword)){
    $errors["confirmPassword"] = "Confirm Password is required";
} elseif($password !== $confirmPassword){
    $errors["confirmPassword"] = "Passwords do not match";
}

//if errors, redirect back
if(count($errors) > 0){
    $_SESSION["errors"] = $errors;
    $_SESSION["previousValues"] = $previousValues;
    Header("Location: ../View/signup.php");
} else {
    //check if user exist
    $db = new DatabaseConnection();
    $connection = $db->openConnection();
    
    if($db->checkExistingUser($connection, $email, $phone)){
        $_SESSION["signupErr"] = "Email or phone already exists!";
        $_SESSION["previousValues"] = $previousValues;
        Header("Location: ../View/signup.php");
    } else {
        $user_id = $db->insertUser($connection, $name, $gender, $email, $phone, $role, $password);
        
        if($user_id){
            //storing sessionn
            $_SESSION["signup_user_id"] = $user_id;
            $_SESSION["signup_role"] = $role;
            $_SESSION["signup_email"] = $email;
            
            //role based signup
            if($role == "patient"){
                Header("Location: ../../Patient/View/signup_patient.php");
            } else {
                Header("Location: ../../Doctor/View/signup_doctor.php");
            }
        } else {
            $_SESSION["signupErr"] = "Sign up failed!";
            $_SESSION["previousValues"] = $previousValues;
            Header("Location: ../View/signup.php");
        }
    }
    
    $db->closeConnection($connection);
}
?>