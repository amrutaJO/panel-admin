<?php
require_once __DIR__ . "/db.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "DELETE FROM cancellations WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: view-cancellation.php");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$conn->close();
?>
