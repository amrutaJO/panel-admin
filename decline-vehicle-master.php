<?php

ob_start();

include 'db.php';

$id = $_GET['id'];

if (isset($_GET['id'])) {
    
    $sql = "UPDATE `vehicle_master` SET `status` = 'declined' WHERE `id` = $id";

    if (mysqli_query($conn, $sql)) {
        header("Location: vehicle-master.php");
        ob_end_flush();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
