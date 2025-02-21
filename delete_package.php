<?php
require_once __DIR__ . "/db.php"; // Ensure the database connection is included

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize input

    $query = "DELETE FROM packages WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Package deleted successfully!'); window.location.href='view-packages.php';</script>";
    } else {
        echo "<script>alert('Failed to delete package!'); window.location.href='view-packages.php';</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: view-packages.php"); // Redirect if no ID is provided
    exit();
}
