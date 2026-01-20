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


    function updateUserPhone($connection, $user_id, $phone){
        $sql = "UPDATE users SET phone='".$phone."' WHERE id='".$user_id."'";
        $result = $connection->query($sql);
        if(!$result){
            die("Failed to update phone ". $connection->error);
        }
        return $result;
    }

    function updateDoctorChamber($connection, $user_id, $chamber){
        $sql = "UPDATE doctors SET chamber='".$chamber."' WHERE user_id='".$user_id."'";
        $result = $connection->query($sql);
        if(!$result){
            die("Failed to update chamber ". $connection->error);
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

    //Fetching current date appointments
    function getTodaysAppointments($connection, $doctor_id) {

    $sql = "SELECT a.*, p.medical_id, u.name AS patient_name
            FROM appointments a
            JOIN patients p ON a.patient_id = p.id
            JOIN users u ON p.user_id = u.id
            WHERE a.doctor_id = '$doctor_id'
            AND a.appointment_date = CURDATE()
            ORDER BY a.appointment_time";

    $result = $connection->query($sql);

    if (!$result) {
        die("Failed to fetch appointments: " . $connection->error);
    }

    return $result;
}

    function updateDoctorSchedule($connection, $user_id, $available_days = NULL, $start_time = NULL, $end_time = NULL){
    // Handle NULL values properly
    $available_days_sql = ($available_days !== NULL && trim($available_days) !== '') ? "'".$available_days."'" : "NULL";
    $start_time_sql = ($start_time !== NULL && trim($start_time) !== '') ? "'".$start_time."'" : "NULL";
    $end_time_sql = ($end_time !== NULL && trim($end_time) !== '') ? "'".$end_time."'" : "NULL";

    $sql = "UPDATE doctors SET 
            available_days = $available_days_sql,
            start_time = $start_time_sql,
            end_time = $end_time_sql
            WHERE user_id = '".$user_id."'";

    $result = $connection->query($sql);
    if(!$result){
        die("Failed to update appointment schedule: " . $connection->error);
    }
    return $result;
}


/*// Method to update password
function updatePassword($connection, $user_id, $new_password){
    $sql = "UPDATE users SET password='".$new_password."' WHERE id='".$user_id."'";
    $result = $connection->query($sql);
    if(!$result){
        die("Failed to update password ". $connection->error);
    }
    return $result;
}*/

    function closeConnection($connection){
    $connection->close();
}

}
?>