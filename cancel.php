<?php require_once __DIR__ . "/header.php"; ?>
<?php
require_once __DIR__ . "/db.php"; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_name = $_POST['customer_name'];
    $cancellation_reason = $_POST['cancel_reason'];
    $customer_id = $_POST['customer_id'];
    $vehicle_id = $_POST['vehicle_id'];
    $driver_name = $_POST['driver_name'];
    $additional_info = $_POST['additional_info'];

    $sql = "INSERT INTO cancellations (customer_name, cancellation_reason, customer_id, vehicle_id, driver_name, additional_info)
            VALUES ('$customer_name', '$cancellation_reason', '$customer_id', '$vehicle_id', '$driver_name', '$additional_info')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Cancellation submitted successfully!');</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>


<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-header-title"><?= translate('cancellation_form') ?></h1>
            </div>
            <div class="col-auto">
                <a class="btn btn-sm btn-primary" href="view-cancellation.php">
                    <i class="bi-card-list me-1"></i>
                    <?= translate('view_cancellations') ?>
                </a>
            </div>
        </div>
    </div>
    <!-- 
    <div class="row">
        <div class="col-lg-10 offset-lg-1">
            <div class="card">
                <div class="card-body"> -->
                <form action="cancel.php" method="POST" class="row g-3" id="cancellation-form">
    <div class="col-12 col-md-6">
        <label for="customer_name" class="form-label">Customer Name</label>
        <input type="text" name="customer_name" id="customer_name" class="form-control form-control-sm" required>
    </div>

    <div class="col-12 col-md-6">
        <label for="cancel_reason" class="form-label">Cancellation Reason</label>
        <select name="cancel_reason" id="cancel_reason" class="form-control form-control-sm" required>
            <option value="" disabled selected>Select Reason</option>
            <option value="delayed">Delayed</option>
            <option value="wrong_item">Wrong Item</option>
            <option value="change_mind">Change of Mind</option>
            <option value="booked_by_mistake">Booked by Mistake</option>
            <option value="found_another_ride">Found Another Ride</option>
            <option value="price_too_high">Price Too High</option>
            <option value="other">Other</option>
        </select>
    </div>

    <div class="col-12">
        <label for="customer_id" class="form-label">Customer ID</label>
        <input type="text" name="customer_id" id="customer_id" class="form-control form-control-sm" required>
    </div>

    <div class="col-12 col-md-6">
        <label for="vehicle_id" class="form-label">Vehicle ID</label>
        <input type="text" name="vehicle_id" id="vehicle_id" class="form-control form-control-sm">
    </div>

    <div class="col-12 col-md-6">
        <label for="driver_name" class="form-label">Driver Name</label>
        <input type="text" name="driver_name" id="driver_name" class="form-control form-control-sm">
    </div>

    <div class="col-12">
        <label for="additional_info" class="form-label">Additional Info</label>
        <textarea name="additional_info" id="additional_info" class="form-control form-control-sm" rows="3"></textarea>
    </div>

    <div class="modal-footer p-0 border-top-0">
        <button type="submit" class="btn btn-sm btn-primary">Submit</button>
        <button type="reset" class="btn btn-sm btn-secondary ms-2">Reset</button>
    </div>
</form>
 <!-- </div>
            </div>
        </div>
    </div> -->

</div>
<?php require_once __DIR__ . '/footer.php'; ?>