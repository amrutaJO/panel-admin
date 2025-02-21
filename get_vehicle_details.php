<?php
// Database connection
$host = 'localhost';
$dbname = 'admin-panel';
$username = 'root';
$password = '';  // Update with your actual DB password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL query to fetch all vehicle details
    $stmt = $pdo->prepare("SELECT * FROM `vehicle-details`");
    $stmt->execute();

    // Fetch all rows as an associative array
    $vehicle_details = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the vehicle details as JSON
    echo json_encode($vehicle_details);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
