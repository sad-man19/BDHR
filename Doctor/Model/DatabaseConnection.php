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

    function getDoctorDetails($connection, $user_id){
        $sql = "SELECT doctors.*, users.name, users.gender, users.email, users.phone 
                FROM doctors 
                JOIN users ON doctors.user_id = users.id 
                WHERE doctors.user_id='".$user_id."'";
        $result = $connection->query($sql);
        if(!$result){
            die("Failed to get doctor details ". $connection->error);
        }
        return $result->fetch_assoc();
    }

    function closeConnection($connection){
    $connection->close();
}

}
?>