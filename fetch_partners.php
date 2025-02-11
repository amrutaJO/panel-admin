<?php
require_once __DIR__ . "/config.php"; // Database connection file

header("Content-Type: application/json");

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed"]));
}

$sql = "SELECT * FROM `partner-details` ORDER BY partnerId DESC";
$result = $conn->query($sql);

$partners = [];

while ($row = $result->fetch_assoc()) {
    $partners[] = $row;
}

echo json_encode($partners);

$conn->close();
?>
