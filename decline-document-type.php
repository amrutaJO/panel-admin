<?php

ob_start();

include 'db.php';

$id = $_GET['id'];

if (isset($_GET['id'])) {
    
    $sql = "UPDATE `document_types` SET `status` = 'declined' WHERE `id` = $id";

    if (mysqli_query($conn, $sql)) {
        header("Location: view-document-type.php");
        ob_end_flush();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
