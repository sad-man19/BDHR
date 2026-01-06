<?php
// Include database connection
include "../../Commons/Model/DatabaseConnection.php";

if(isset($_GET['medical_id']) && !empty($_GET['medical_id'])){
    $medical_id = $_GET['medical_id'];
    
    $db = new DatabaseConnection();
    $connection = $db->openConnection();
    
    if($db->checkMedicalId($connection, $medical_id)){
        echo "exists";
    } else {
        echo "available";
    }
    
    $db->closeConnection($connection);
}
?>