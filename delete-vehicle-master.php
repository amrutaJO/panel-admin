<?php

ob_start();

include "db.php";

$id = $_GET['id'];

$sql = "DELETE FROM `vehicle_master` WHERE id = $id";
$result = mysqli_query($conn, $sql);
if($result) {
    header("Location: vehicle-master.php?msg=Vehicle master deleted!");
    ob_end_flush();
} else {
    echo "Vehicle master not deleted!" . mysqli_error($conn);
}

?>