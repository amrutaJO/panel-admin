<?php
require_once __DIR__ . "/db.php"; // Ensure database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hourlyPackage = $_POST['hourlyPackage'];
    $baseFare = $_POST['baseFare'];
    $bookingFee = $_POST['bookingFee'];
    $vehicleType = $_POST['vehicleType'];
    $perKmRate = $_POST['perKmRate'];
    $perMinuteRate = $_POST['perMinuteRate'];

    // Prepare and execute the SQL statement
    $sql = "INSERT INTO rental_services (hourly_package, base_fare, booking_fee, vehicle_type, per_km_rate, per_minute_rate)
            VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sddssd", $hourlyPackage, $baseFare, $bookingFee, $vehicleType, $perKmRate, $perMinuteRate);
    
    if ($stmt->execute()) {
        header("Location: add-rental-service.php?success=1"); // Redirect after success
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
