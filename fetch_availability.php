<?php
require_once __DIR__ . "/config.php"; // Database connection file

header("Content-Type: application/json");

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die(json_encode(["error" => "Database connection failed"]));
}

$sql = "SELECT * FROM `partner-availability` ORDER BY partnerId DESC";
$result = $conn->query($sql);

$availability = [];

while ($row = $result->fetch_assoc()) {
    $availability[] = $row;
}

echo json_encode($availability);

$conn->close();
?>
