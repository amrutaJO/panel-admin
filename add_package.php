<?php
require_once __DIR__ . "/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user input
    $distance = $conn->real_escape_string($_POST['distance']);
    $time = $conn->real_escape_string($_POST['time']);

    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO packages (distance_km, time_hours) VALUES (?, ?)");
    $stmt->bind_param("ds", $distance, $time);

    if ($stmt->execute()) {
        echo "<script>alert('Data inserted successfully!'); window.location.href='rental.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

