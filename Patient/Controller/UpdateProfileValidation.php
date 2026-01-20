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

//getting data
$phone = $_POST["phone"] ??"";
$address = $_POST["address"]?? "";
$current_password = $_POST["current_password"] ?? "";
$new_password = $_POST["new_password"] ?? "";
$confirm_password = $_POST["confirm_password"] ??"";


$errors = [];
$previousValues = [];
$user_id = $_SESSION["user_id"];

//validation
if(empty($phone)){
    $errors["phone"] = "phone number is required";
}elseif(!preg_match("/^01[0-9]{9}$/", $phone)){
    $errors["phone"]="Invalid Phone number";
}else{
    $previousValues["phone"] = $phone;
}



if(empty($address)){
    $errors["address"]="Address is required";
}elseif(strlen($address)<10){
    $errors["address"]= "Address must be at least 10 characters";
}else{
    $previousValues["address"]=$address;
}


$passChange = false;
if(!empty($current_password)||!empty($new_password)|| !empty($confirm_password)){
    $passChange=true;

    if(empty($current_password)){
        $errors["current_password"]="Current pass required";
    }

    if(empty($new_password)){
        $errors["new_password"]="New pass required";
    }elseif(strlen($new_password)<6){
        $errors["new_password"]="Password must be at least 6 character";
    }

    if(empty($confirm_password)){
        $errors["confirm_password"]="password must be confirmed";
    }elseif(strlen($new_password)<6){
        $errors["confirm_password"]="Passwords do not match";
    }
}



mysqli_report(MYSQLI_REPORT_OFF);

$db=new DatabaseConnection();
$connection=$db->openConnection();
/*
if($passChange){
    if(!$db->verifyPassword($connection, $user_id, $current_password)){
        $_SESSION["updateError"]="Current password is incorrect";
        $_SESSION["previousValues"]=$previousValues;
        header("Location: ../View/edit_profile.php");
        $db->closeConnection($connection);
        exit();
    }
}*/

if($passChange){
    if(!$db->verifyPassword($connection, $user_id, $current_password)){
        $errors["current_password"] = "Current password is incorrect";
    }
}


if(count($errors)>0){
    $_SESSION["errors"] =$errors;
    $_SESSION["previousValues"]=$previousValues;
    header("Location: ../View/edit_profile.php");
    exit();

}
//query for updating
//$phoneUpdated = $db->updateUserPhone($connection, $user_id, $phone);
if (empty($errors)) {

    $result = $db->updateUserPhone($connection, $user_id, $phone);

    if ($result === false && $connection->errno == 1062) {
        $errors["phone"] = "Phone number already exists";
    }
}

$addressUpdated = $db->updatePatientAddress($connection, $user_id, $address);

if($passChange){
    $passwordUpdated = $db->updatePassword($connection, $user_id, $new_password);

}

if($phoneUpdated || $addressUpdated){
    $_SESSION["phone"]=$phone;

    $patientData = $db->getPatientDetails($connection, $user_id);
    $_SESSION["profile_data"]= $patientData;

    $_SESSION["successMsg"]="profile updated successfully";
    if($passChange){
        $_SESSION["successMsg"].=" password changed successfully";
    }

    header("Location: ../View/profile.php");
}

$db->closeConnection($connection);
exit();
?>