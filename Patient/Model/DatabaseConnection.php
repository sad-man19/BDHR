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

    function getPatientDetails($connection, $user_id){
        $sql = "SELECT patients.*, users.name, users.gender, users.email, users.phone 
                FROM patients 
                JOIN users ON patients.user_id = users.id 
                WHERE patients.user_id='".$user_id."'";
        $result = $connection->query($sql);
        if(!$result){
            die("Query failed". $connection->error);
        }
        return $result->fetch_assoc();
    }

    function updateUserPhone($connection, $user_id, $phone){
        $sql = "UPDATE users SET phone='".$phone."' WHERE id='".$user_id."'";
        $result = $connection->query($sql);
        if(!$result){
            die("Failed to update phone ". $connection->error);
        }
        return $result;
    }

    function updatePatientAddress($connection, $user_id, $address){
        $sql = "UPDATE patients SET address='".$address."' WHERE user_id='".$user_id."'";
        $result = $connection->query($sql);
        if(!$result){
            die("Failed to update address ". $connection->error);
        }
        return $result;
    }

    function updatePassword($connection, $user_id, $new_password){
        $sql = "UPDATE users SET password='".$new_password."' WHERE id='".$user_id."'";
        $result = $connection->query($sql);
        if(!$result){
            die("Failed to update password ". $connection->error);
        }
        return $result;
    }

     function verifyPassword($connection, $user_id, $password){
        $sql = "SELECT * FROM users WHERE id='".$user_id."' AND password='".$password."'";
        $result = $connection->query($sql);
        return $result->num_rows > 0;
    }

    function closeConnection($connection){
    $connection->close();
}

}
?>