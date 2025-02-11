<?php
// Database connection
$host = 'localhost';
$dbname = 'admin-panel';
$username = 'root';
$password = '';  // Update with your actual DB password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL query to fetch all earnings
    $stmt = $pdo->prepare("SELECT * FROM `partner-earning`");
    $stmt->execute();

    // Fetch all rows as an associative array
    $earnings = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the earnings as JSON
    echo json_encode($earnings);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
