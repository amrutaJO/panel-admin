<?php
include 'db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $vehicle_name = $_POST["vehicle_name"];
    $vehicle_no = $_POST["vehicle_no"];
    $vehicle_model = $_POST["vehicle_model"];
    $driver_name = $_POST["driver_name"];
    $driver_mobile_number = $_POST["driver_mobile_number"];

    $sql = "UPDATE vehicles SET 
            vehicle_name = '$vehicle_name', 
            vehicle_number = '$vehicle_no', 
            vehicle_model = '$vehicle_model', 
            driver_name = '$driver_name', 
            driver_mobile_number = '$driver_mobile_number'
            WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        echo "Vehicle updated successfully!";
    } else {
        echo "Error updating vehicle: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>
