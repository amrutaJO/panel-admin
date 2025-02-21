<?php 
require_once __DIR__ . "/header.php"; 
require_once __DIR__ . "/db.php"; 

// Handle package update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_package"])) {
    $id = $_POST['package_id'];
    $distance = $_POST['distance'];
    $time = $_POST['time'];

    $updateQuery = "UPDATE packages SET distance_km = ?, time_hours = ? WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("dsi", $distance, $time, $id);

    if ($stmt->execute()) {
        echo "<script>alert('Package updated successfully'); window.location.href='rental.php';</script>";
    } else {
        echo "<script>alert('Error updating package');</script>";
    }
}

$query = "SELECT id, distance_km, time_hours FROM packages"; 
$result = $conn->query($query); 
?>

<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-header-title d-flex align-items-center gap-3">
                    <span><?= translate('View Packages') ?></span>
                </h1>
            </div>
        </div>
    </div>
    
    <div class="table-responsive">
        <table id="data-table" class="table table-bordered table-nowrap table-align-middle">
            <thead class="thead-light" align="left">
                <tr>
                    <th><?= translate('Serial No') ?></th>
                    <th><?= translate('Distance (km)') ?></th>
                    <th><?= translate('Time (hours)') ?></th>
                    <th><?= translate('Action') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['distance_km']}</td>
                                <td>{$row['time_hours']}</td>
                                <td>
                                    <div class='dropdown'>
                                        <button class='btn btn-sm btn-white dropdown-toggle' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                                            " . translate('Actions') . "
                                        </button>
                                        <ul class='dropdown-menu'>
                                            <li><a class='dropdown-item' href='#' onclick='openEditModal({$row['id']}, \"{$row['distance_km']}\", \"{$row['time_hours']}\")'>" . translate('Edit') . "</a></li>
                                            <li><a class='dropdown-item text-danger' href='delete_package.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this package?\")'>" . translate('Delete') . "</a></li>
                                        </ul>
                                    </div>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center'>" . translate('No packages found') . "</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= translate('Edit Package') ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="">
                <div class="modal-body">
                    <input type="hidden" id="package_id" name="package_id">
                    <div class="mb-3">
                        <label class="form-label"><?= translate('Distance (KM)') ?></label>
                        <input type="number" id="distance" name="distance" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label"><?= translate('Time (Hours)') ?></label>
                        <input type="text" id="time" name="time" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="update_package" class="btn btn-primary"><?= translate('Save Changes') ?></button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= translate('Close') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openEditModal(id, distance, time) {
    document.getElementById('package_id').value = id;
    document.getElementById('distance').value = distance;
    document.getElementById('time').value = time;
    var editModal = new bootstrap.Modal(document.getElementById('editModal'));
    editModal.show();
}
</script>

<?php require_once __DIR__ . '/footer.php'; ?>
