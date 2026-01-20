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

    function closeConnection($connection){
    $connection->close();
}

}
?>