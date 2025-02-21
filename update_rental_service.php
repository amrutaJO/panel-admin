<?php
require_once __DIR__ . "/db.php"; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];
    $package = $_POST['hourly_package'];
    $fare = $_POST['base_fare'];
    $booking_fee = $_POST['booking_fee'];
    $vehicle_type = $_POST['vehicle_type'];
    $per_km_rate = $_POST['per_km_rate'];
    $per_minute_rate = $_POST['per_minute_rate'];

    $sql = "UPDATE rental_services 
            SET hourly_package=?, base_fare=?, booking_fee=?, vehicle_type=?, per_km_rate=?, per_minute_rate=? 
            WHERE id=?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sddsdsi", $package, $fare, $booking_fee, $vehicle_type, $per_km_rate, $per_minute_rate, $id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update data."]);
    }
}
?>

