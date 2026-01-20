<?php

class DatabaseConnection{
   
    function openConnection(){
        $db_host="localhost";
        $db_user = "root";
        $db_password = "";
        $db_name = "bdhr_db";

        $connection = new mysqli($db_host, $db_user, $db_password, $db_name);
        if($connection->connect_error){
            die("Failed to connect database ". $connection->connect_error);
        }
        return $connection;
    }

    function checkExistingUser($connection, $email, $phone){
        $sql = "SELECT * FROM users WHERE email='".$email."' OR phone='".$phone."'";
        $result = $connection->query($sql);
        return $result->num_rows > 0;
    }

    function insertUser($connection, $name, $gender, $email, $phone, $role, $password){
        $sql = "INSERT INTO users (name, gender, email, phone, role, password) VALUES('".$name."', '".$gender."', '".$email."', '".$phone."', '".$role."', '".$password."')";
        $result = $connection->query($sql);
        if(!$result){
            die("Failed to insert user ". $connection->error);
        }
        return $connection->insert_id;
    }

    function checkMedicalId($connection, $medical_id){
        $sql = "SELECT * FROM patients WHERE medical_id='".$medical_id."'";
        $result = $connection->query($sql);
        return $result->num_rows > 0;
    }

    function checkLicenseNo($connection, $license_no){
        $sql = "SELECT * FROM doctors WHERE license_no='".$license_no."'";
        $result = $connection->query($sql);
        return $result->num_rows > 0;
    }

    function insertPatient($connection, $user_id, $medical_id, $dob, $address){
        $sql = "INSERT INTO patients (user_id, medical_id, dob, address) VALUES('".$user_id."', '".$medical_id."', '".$dob."', '".$address."')";
        $result = $connection->query($sql);
        if(!$result){
            die("Failed to insert patient ". $connection->error);
        }
        return $result;
    }

    function insertDoctor($connection, $user_id, $specialization, $license_no, $chamber){
        $sql = "INSERT INTO doctors (user_id, specialization, license_no, chamber) VALUES('".$user_id."', '".$specialization."', '".$license_no."', '".$chamber."')";
        $result = $connection->query($sql);
        if(!$result){
            die("Failed to insert doctor ". $connection->error);
        }
        return $result;
    }

    //login
    function loginUser($connection, $email_phone, $password){
    $sql = "SELECT * FROM users WHERE email='".$email_phone."' AND password='".$password."'";
    $result = $connection->query($sql);
    return $result;
}
    function getDoctorId($connection, $user_id){
    $sql = "SELECT id FROM doctors WHERE user_id = '$user_id' LIMIT 1";
    $result = $connection->query($sql);
    if($result && $result->num_rows > 0){
        $row = $result->fetch_assoc();
        return $row['id']; // return doctor_id
    }
    return 0; // fallback
}


    function closeConnection($connection){
        $connection->close();
    }
}

?>