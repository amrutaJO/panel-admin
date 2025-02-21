<?php
include 'db.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_name = ucfirst(strtolower($_POST['user_name'])); // Capitalize first letter
    $user_mobile = $_POST['user_mobile'];
    $user_email = $_POST['user_email'];
    $user_gender = ucfirst(strtolower($_POST['user_gender']));
    $user_address = ucfirst(strtolower($_POST['user_address']));
    $user_city = ucfirst(strtolower($_POST['user_city']));
    $user_state = ucfirst(strtolower($_POST['user_state']));

    // Insert into users table
    $sql = "INSERT INTO users (user_name, user_mobile, user_email, user_gender, user_address, user_city, user_state) 
            VALUES ('$user_name', '$user_mobile', '$user_email', '$user_gender', '$user_address', '$user_city', '$user_state')";

    if (mysqli_query($conn, $sql)) {
        echo "User added successfully!";
        header("Location: add-user.php"); // Redirect back to form
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
