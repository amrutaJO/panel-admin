<?php
require_once "db.php";

$response = ["success" => false, "message" => "Invalid request"];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_id'])) {
    $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
    $user_name = mysqli_real_escape_string($conn, $_POST['user_name']);
    $user_mobile = mysqli_real_escape_string($conn, $_POST['user_mobile']);
    $user_email = mysqli_real_escape_string($conn, $_POST['user_email']);
    $user_gender = mysqli_real_escape_string($conn, $_POST['user_gender']);
    $user_address = mysqli_real_escape_string($conn, $_POST['user_address']);
    $user_city = mysqli_real_escape_string($conn, $_POST['user_city']);
    $user_state = mysqli_real_escape_string($conn, $_POST['user_state']);


    $query = "UPDATE users 
              SET user_name='$user_name', user_mobile='$user_mobile', user_email='$user_email', 
                  user_gender='$user_gender', user_address='$user_address', user_city='$user_city', user_state='$user_state'
              WHERE user_id='$user_id'";

    if (mysqli_query($conn, $query)) {
        $response = ["success" => true, "message" => "User updated successfully"];
    } else {
        $response["message"] = "Database error: " . mysqli_error($conn);
    }
}

echo json_encode($response);
?>
