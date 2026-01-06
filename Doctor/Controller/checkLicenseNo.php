<?php
// Include database connection
include "../../Commons/Model/DatabaseConnection.php";

if(isset($_GET['license_no']) && !empty($_GET['license_no'])){
    $license_no = $_GET['license_no'];
    
    $db = new DatabaseConnection();
    $connection = $db->openConnection();
    
    if($db->checkLicenseNo($connection, $license_no)){
        echo "exists";
    } else {
        echo "available";
    }
    
    $db->closeConnection($connection);
}
?>