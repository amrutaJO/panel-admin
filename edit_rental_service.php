<?php
require_once __DIR__ . "/db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $hourlyPackage = $_POST['hourlyPackage'];
    $baseFare = floatval($_POST['baseFare']);
    $bookingFee = floatval($_POST['bookingFee']);
    $vehicleType = $_POST['vehicleType'];
    $perKmRate = floatval($_POST['perKmRate']);
    $perMinuteRate = floatval($_POST['perMinuteRate']);

    $sql = "UPDATE rental_services 
            SET hourly_package = ?, 
                base_fare = ?, 
                booking_fee = ?, 
                vehicle_type = ?, 
                per_km_rate = ?, 
                per_minute_rate = ? 
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sddsddi", $hourlyPackage, $baseFare, $bookingFee, $vehicleType, $perKmRate, $perMinuteRate, $id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error"]);
    }

    $stmt->close();
    $conn->close();
}
?>
