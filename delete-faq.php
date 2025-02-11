<?php
require_once 'db_connection.php'; // Database connection

// Ensure the FAQ ID is set and valid
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $faqId = intval($_GET['id']); // Convert to integer

    // Delete FAQ question
    $query = "DELETE FROM faq_questions WHERE id = $faqId";
    
    if (mysqli_query($conn, $query)) {
        // Redirect to view-faq.php after successful deletion
        echo "<script>window.location.href = 'view-faq.php?success=3';</script>";
        exit();
    } else {
        // Error in query execution
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // FAQ ID is missing
    echo "Error: FAQ ID is not specified.";
}
?>
