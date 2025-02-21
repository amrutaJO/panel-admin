<?php require_once __DIR__ . "/header.php"?>;
<?php include 'db.php';

// Insert into new_vehicles from transport-form
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['vehicle_name']) && !isset($_POST['driver_name'])) {
    $vehicle_name = trim($_POST['vehicle_name']);
    $vehicle_type = trim($_POST['vehicle_type']);
    $vehicle_no = trim($_POST['vehicle_no']);
    $vehicle_model = trim($_POST['vehicle_model']);

    if (!empty($vehicle_name) && !empty($vehicle_no) && !empty($vehicle_model)) {
        $stmt = $conn->prepare("INSERT INTO new_vehicles (vehicle_name, vehicle_type, vehicle_number, vehicle_model) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $vehicle_name, $vehicle_type, $vehicle_no, $vehicle_model);
        if ($stmt->execute()) {
            echo "<script>alert('Vehicle added successfully!');</script>";
        } else {
            echo "<script>alert('Error: Vehicle already exists or something went wrong.');</script>";
        }
        $stmt->close();
    }
}

$vehicles = [];
$result = $conn->query("SELECT vehicle_name FROM new_vehicles");
while ($row = $result->fetch_assoc()) {
    $vehicles[] = $row;
}

$vehicle_details = null;
$selected_vehicle_name = isset($_POST['vehicle_name']) ? $_POST['vehicle_name'] : "";
if (!empty($selected_vehicle_name)) {
    $stmt = $conn->prepare("SELECT vehicle_model, vehicle_number FROM new_vehicles WHERE vehicle_name = ?");
    $stmt->bind_param("s", $selected_vehicle_name);
    $stmt->execute();
    $result = $stmt->get_result();
    $vehicle_details = $result->fetch_assoc();
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['driver_name'])) {
    $vehicle_name = $_POST['vehicle_name'];
    $vehicle_model = $_POST['vehicle_model'];
    $vehicle_no = $_POST['vehicle_no'];
    $driver_name = $_POST['driver_name'];
    $driver_mobile = $_POST['driver_mobile_number'];

    if (!empty($vehicle_name) && !empty($driver_name) && !empty($driver_mobile)) {
        $stmt = $conn->prepare("INSERT INTO vehicles (vehicle_name, vehicle_model, vehicle_number, driver_name, driver_mobile_number) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $vehicle_name, $vehicle_model, $vehicle_no, $driver_name, $driver_mobile);
        if ($stmt->execute()) {
            echo "<script>alert('Vehicle assigned successfully!');</script>";
        } else {
            echo "<script>alert('Error: Something went wrong.');</script>";
        }
        $stmt->close();
    }
}
?>


<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-header-title"><?= translate('add_vehicle') ?></h1>
            </div>
            <div class="col-auto">
                <a class="btn btn-sm btn-primary" href="view-vehicles.php">
                    <?= translate('view_vehicles') ?>
                </a>
            </div>
        </div>
    </div>

    <!-- Add New Vehicle Modal -->

    <div class="modal modal-sm fade" id="vehicleAddModal" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="transportAddModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content border shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title" id="customerAddModalLabel">Add New Vehicle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post" class="row g-3" id="transport-form">
                        <div class="col-12 ">
                            <label for="" class="form-label">Vehicle Name</label>
                            <input type="text" name="vehicle_name" class="form-control form-control-sm"
                                placeholder="Vehicle Name">
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="" class="form-label">Vehicle Type</label>
                            <div class="input-group input-group-sm w-100">
                                <select name="vehicle_type" class="form-control form-control-sm">
                                    <option value="Bike">Bike</option>
                                    <option value="Three-Wheeler">Three-wheeler</option>
                                    <option value="Car">Car</option>
                                    <option value="Pickup">Pickup</option>
                                    <option value="Truck">Truck</option>
                                    <option value="Electric">Electric</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="" class="form-label">Vehicle No.</label>
                            <input type="text" name="vehicle_no" class="form-control form-control-sm"
                                placeholder="Vehicle Number">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="" class="form-label">Vehicle Model</label>
                            <input type="text" name="vehicle_model" class="form-control form-control-sm"
                                placeholder="Vehicle Model">
                        </div>

                        <div class="modal-footer pt-0 border-top-0">
                            <button type="button" class="btn btn-sm btn-secondary"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-sm btn-primary">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- End New Vehicle Modal -->

    <form action="" class="row g-3" id="vehicle-form" method="post">
        <div class="col-12 col-md-6">
            <label for="" class="form-label"><?= translate('vehicle_name') ?></label>
            <div class="input-group input-group-sm w-100">
                <select name="vehicle_name" class="form-control form-control-sm" id="vehicleSelect"
                    onchange="this.form.submit()">
                    <option value=""><?= translate('select') ?></option>
                    <?php foreach ($vehicles as $vehicle): ?>
                        <option value="<?= htmlspecialchars($vehicle['vehicle_name']) ?>" <?= (isset($selected_vehicle_name) && $selected_vehicle_name == $vehicle['vehicle_name']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($vehicle['vehicle_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button class="btn p-0 border-0" type="button" data-bs-toggle="modal" data-bs-target="#vehicleAddModal">
                    <i class="bi bi-plus-circle-fill p-1 ms-1 text-primary"></i>
                </button>
            </div>
        </div>
        

        <div class="col-12 col-md-6">
            <label for="" class="form-label"><?= translate('vehicle_model') ?></label>
            <input type="text" name="vehicle_model" class="form-control form-control-sm" readonly
                placeholder="<?= translate('vehicle_model') ?>"
                value="<?= isset($vehicle_details) ? htmlspecialchars($vehicle_details['vehicle_model']) : '' ?>">
        </div>
        <div class="col-12 col-md-6">
            <label for="" class="form-label"><?= translate('vehicle_no') ?></label>
            <input type="text" name="vehicle_no" class="form-control form-control-sm" readonly
                placeholder="<?= translate('vehicle_no') ?>"
                value="<?= isset($vehicle_details) ? htmlspecialchars($vehicle_details['vehicle_number']) : '' ?>">
        </div>

        <div class="col-12 col-md-6">
            <label for="" class="form-label"><?= translate('driver_name') ?></label>
            <input type="text" name="driver_name" class="form-control form-control-sm" placeholder="<?= translate('driver_name') ?>">
        </div>
        <div class="col-12 col-md-6">
            <label for="" class="form-label"><?= translate('driver_mobile_number') ?></label>
            <input type="tel" name="driver_mobile_number" class="form-control form-control-sm"
                placeholder="<?= translate('driver_mobile_number') ?>">
        </div>

        <div class="modal-footer pt-0 border-top-0">
            <button type="reset" form="vehicle-form" class="btn btn-sm btn-secondary"><?= translate('Reset') ?></button>
            <button type="submit" form="vehicle-form"
                class="btn btn-sm btn-primary ms-2"><?= translate('Save') ?></button>
        </div>
    </form>
    <!-- End of New Card -->
</div>
</div>
<?php require_once __DIR__ . '/footer.php' ?>