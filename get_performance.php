<?php
// Database connection
$host = 'localhost';
$dbname = 'admin-panel';
$username = 'root';
$password = '';  // Update with your actual DB password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL query to fetch all partner performance data
    $stmt = $pdo->prepare("SELECT * FROM `partner_performance`");
    $stmt->execute();

    // Fetch all rows as an associative array
    $performance_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the performance data as JSON
    echo json_encode($performance_data);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
