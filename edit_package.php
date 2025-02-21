<?php
require_once __DIR__ . "/db.php";

if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $distance = $_POST['distance_km'];
    $time = $_POST['time_hours'];

    $stmt = $conn->prepare("UPDATE packages SET distance_km = ?, time_hours = ? WHERE id = ?");
    $stmt->bind_param("dii", $distance, $time, $id);

    if ($stmt->execute()) {
        header("Location: view-packages.php?msg=updated");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
    
    $stmt->close();
    $conn->close();
} elseif (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM packages WHERE id = $id");
    $row = $result->fetch_assoc();
} else {
    header("Location: view-packages.php");
    exit();
}
?>

<?php require_once __DIR__ . "/header.php"; ?>
<div class="container">
    <h2><?= translate('Edit Package') ?></h2>
    <form method="post">
        <input type="hidden" name="id" value="<?= $row['id'] ?>">
        <div class="mb-3">
            <label class="form-label"><?= translate('Distance (km)') ?></label>
            <input type="number" name="distance_km" class="form-control" value="<?= $row['distance_km'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label"><?= translate('Time (hours)') ?></label>
            <input type="number" name="time_hours" class="form-control" value="<?= $row['time_hours'] ?>" required>
        </div>
        <button type="submit" name="update" class="btn btn-primary"><?= translate('Update') ?></button>
        <a href="view-packages.php" class="btn btn-secondary"><?= translate('Cancel') ?></a>
    </form>
</div>
<?php require_once __DIR__ . "/footer.php"; ?>
