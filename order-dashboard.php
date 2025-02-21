<?php 
require_once __DIR__ . "/header.php"; 
require_once "db.php";

$message = "";

// Allowed fields (to prevent SQL injection)
$allowed_fields = [
    "total_bookings", "yearly_bookings", "monthly_bookings", "daily_bookings",
    "total_requests", "yearly_requests", "monthly_requests", "daily_requests",
    "total_ongoing_rides", "yearly_ongoing_rides", "monthly_ongoing_rides", "daily_ongoing_rides",
    "total_completed_rides", "yearly_completed_rides", "monthly_completed_rides", "daily_completed_rides",
    "total_canceled_rides", "yearly_canceled_rides", "monthly_canceled_rides", "daily_canceled_rides",
    "total_rental_rides", "yearly_rental_rides", "monthly_rental_rides", "daily_rental_rides"
];

// Handle form submission safely
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["field"], $_POST["value"])) {
    $field = $_POST["field"];
    $value = $_POST["value"];

    // Validate field name
    if (in_array($field, $allowed_fields)) {
        $query = "UPDATE order_dashboard SET `$field` = ? ORDER BY created_at DESC LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $value);

        if ($stmt->execute()) {
            $message = "Data updated successfully.";
        } else {
            $message = "Error: " . $stmt->error;
        }
    } else {
        $message = "Invalid field selected.";
    }
}

// Fetch latest order data
$result = $conn->query("SELECT * FROM order_dashboard ORDER BY created_at DESC LIMIT 1");
$order_data = $result->fetch_assoc();
?>

<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-header-title"><?= translate('order_dashboard') ?></h1>
            </div>
        </div>
    </div>

    <?php if (!empty($message)): ?>
        <div id="alertMessage" class="alert alert-info"><?= $message; ?></div>
        <script>
            setTimeout(function() {
                document.getElementById('alertMessage').style.display = 'none';
            }, 5000); // Alert disappears after 5 seconds
        </script>
    <?php endif; ?>

    <div class="row g-3">
        <?php 
        $cards = [
            "booking" => ["icon" => "bi-tags", "fields" => ["total_bookings", "yearly_bookings", "monthly_bookings", "daily_bookings"]],
            "requests" => ["icon" => "bi-list-check", "fields" => ["total_requests", "yearly_requests", "monthly_requests", "daily_requests"]],
            "ongoing_requests" => ["icon" => "bi-hourglass-split", "fields" => ["total_ongoing_rides", "yearly_ongoing_rides", "monthly_ongoing_rides", "daily_ongoing_rides"]],
            "completed_requests" => ["icon" => "bi-check-circle", "fields" => ["total_completed_rides", "yearly_completed_rides", "monthly_completed_rides", "daily_completed_rides"]],
            "canceled_requests" => ["icon" => "bi-x-circle", "fields" => ["total_canceled_rides", "yearly_canceled_rides", "monthly_canceled_rides", "daily_canceled_rides"]],
            "rental_rides" => ["icon" => "bi-car-front-fill", "fields" => ["total_rental_rides", "yearly_rental_rides", "monthly_rental_rides", "daily_rental_rides"]]
        ];

        $index = 1;
        foreach ($cards as $card_title => $card) { 
        ?>
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card">
                <div class="card-header bg-light text-primary py-2">
                    <div class="card-title d-flex justify-content-between align-items-center">
                        <span class="fs-3"><?= translate($card_title) ?></span>
                        <span><i class="bi <?= $card['icon'] ?> btn-icon icon-circle icon-soft-primary bg-gradient fs-3"></i></span>
                    </div>
                </div>
                <div class="card-body py-2">
                    <ul class="list-group list-group-flush card-text">
                        <?php foreach ($card["fields"] as $field) { ?>
                        <li class="list-group-item px-0 py-2">
                            <div class="d-flex justify-content-between">
                                <span><?= translate($field) ?></span>
                                <span><?= $order_data[$field] ?? 0 ?></span>
                            </div>
                        </li>
                        <?php } ?>
                    </ul>
                    <div class="d-flex justify-content-center">
                
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Popup for Update -->
        <div class="modal fade" id="modal<?= $index ?>" tabindex="-1" aria-labelledby="modalLabel<?= $index ?>" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel<?= $index ?>"><?= translate('update_data') ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST">
                            <label>Select Field</label>
                            <select name="field" class="form-control mb-2" required>
                                <?php foreach ($card["fields"] as $field) { ?>
                                    <option value="<?= $field ?>"><?= translate($field) ?></option>
                                <?php } ?>
                            </select>
                            <label>New Value</label>
                            <input type="number" name="value" class="form-control mb-2" required>
                            <button type="submit" class="btn btn-secondary w-100">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php $index++; } ?>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
    