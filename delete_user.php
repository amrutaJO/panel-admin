<?php
require_once "db.php";

header("Content-Type: application/json"); // Ensure response is JSON

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['user_id'])) {
    $user_id = intval($_POST['user_id']); // Convert to integer for safety

    $query = "DELETE FROM users WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $user_id);
        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            echo json_encode(["success" => true, "message" => "User deleted successfully"]);
            exit();
        } else {
            echo json_encode(["success" => false, "error" => "Failed to execute deletion"]);
        }
    } else {
        echo json_encode(["success" => false, "error" => "Database error"]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Invalid request"]);
}
exit();
?>
