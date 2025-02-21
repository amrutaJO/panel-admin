<?php
require_once __DIR__ . "/db_connection.php"; // Include DB connection

if (isset($_GET['id'])) {
    $service_id = $_GET['id'];

    // Delete query
    $delete_query = "DELETE FROM services WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $service_id);

    if ($stmt->execute()) {
        // Service deleted successfully
        echo "<script>
                alert('Service deleted successfully!');
                window.location.href = 'view-services.php'; // Redirect to the services list page
              </script>";
    } else {
        // If deletion fails
        echo "<script>alert('Failed to delete service.');</script>";
    }
} else {
    echo "<script>alert('No service selected for deletion.');</script>";
}
?>
