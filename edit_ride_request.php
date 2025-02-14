<?php
require_once __DIR__ . "/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $user = $_POST['userName'];
    $pickup_address = $_POST['pickupAddress'];
    $drop_address = $_POST['dropAddress'];
    $time = $_POST['requestTime'];
    $type = $_POST['requestType'];
    $status = $_POST['status'];

    $sql = "UPDATE ride_request
            SET user = ?, 
                pickup_address = ?, 
                drop_address = ?, 
                time = ?, 
                type = ?, 
                status = ?
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssi", $user, $pickup_address, $drop_address, $time, $type, $status, $id);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to update data."]);
    }
}
?>
