<?php
require_once __DIR__ . "/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);

    $sql = "DELETE FROM rental_services WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error"]);
    }

    $stmt->close();
    $conn->close();
}
?>
