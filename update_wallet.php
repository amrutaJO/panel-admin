<?php
require_once "db.php"; // Include your DB connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST["user_id"];
    $total_amount = $_POST["total_amount"];
    $remaining_amount = $_POST["remaining_amount"];

    $sql = "UPDATE user_wallets SET total_amount = '$total_amount', remaining_amount = '$remaining_amount', last_updated = NOW() WHERE id = '$user_id'";
    if ($conn->query($sql) === TRUE) {
        echo "Wallet updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>
