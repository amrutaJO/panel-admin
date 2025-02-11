<?php

ob_start();

include "db.php";

$id = $_GET['id'];

$sql = "DELETE FROM `document_types` WHERE id = $id";
$result = mysqli_query($conn, $sql);
if($result) {
    header("Location: view-document-type.php");
    ob_end_flush();
} else {
    echo "Vehicle master not deleted!" . mysqli_error($conn);
}

?>