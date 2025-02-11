<?php
require_once __DIR__ . "/header.php";
require_once __DIR__ . "/db_connection.php";  // Include the db_connection.php file

// Insert data if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect form data
    $serviceName = $_POST['serviceName'];
    $numSeats = $_POST['numSeats'];
    $baseFare = $_POST['baseFare'];
    $minFare = $_POST['minFare'];
    $bookingFee = $_POST['bookingFee'];
    $taxPercentage = $_POST['taxPercentage'];
    $pricePerMinute = $_POST['pricePerMinute'];
    $pricePerKm = $_POST['pricePerKm'];
    $mileage = $_POST['mileage'];
    $dailyService = $_POST['dailyService'];
    $outstationService = $_POST['outstationService'];
    $rentalService = $_POST['rentalService'];
    $providerCommission = $_POST['providerCommission'];
    $adminCommission = $_POST['adminCommission'];
    $driverCashLimit = $_POST['driverCashLimit'];
    $servicePicture = $_FILES['servicePicture']['name'];

    // Handle file upload 
    if ($_FILES['servicePicture']['error'] == 0) {
        $targetDir = 'assets/img/';
        $targetFile = $targetDir . basename($servicePicture);
        move_uploaded_file($_FILES['servicePicture']['tmp_name'], $targetFile);
    }

    // Insert the data into the database using mysqli
    $sql = "INSERT INTO services (service_name, number_of_seats, base_fare, minimum_fare, booking_fee, tax_percentage, price_per_minute, price_per_mile_km, mileage, daily_service, outstation_service, rental_service, provider_commission, admin_commission, driver_cash_limit, service_picture) 
            VALUES ('$serviceName', '$numSeats', '$baseFare', '$minFare', '$bookingFee', '$taxPercentage', '$pricePerMinute', '$pricePerKm', '$mileage', '$dailyService', '$outstationService', '$rentalService', '$providerCommission', '$adminCommission', '$driverCashLimit', '$servicePicture')";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Service added successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}

?>

<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-header-title"><?= translate('add_service') ?></h1>
            </div>

            <div class="col-auto">
				<a class="btn btn-sm btn-primary" href="view-services.php">
					<i class="bi-card-list me-1"></i>
					<?= translate('View Services') ?>
				</a>
			</div>

        </div>

    </div>

    <form action="" method="POST" enctype="multipart/form-data" class="row g-3" id="service-form">
        <div class="col-12 col-md-6">
            <label for="serviceName" class="form-label"><?= translate('service_name') ?></label>
            <input type="text" class="form-control form-control-sm" id="serviceName" name="serviceName" placeholder="<?= translate('service_name') ?>" required>
        </div>

        <div class="col-12 col-md-6">
            <label for="numSeats" class="form-label"><?= translate('number_of_seats') ?></label>
            <input type="number" class="form-control form-control-sm" id="numSeats" name="numSeats" placeholder="<?= translate('number_of_seats') ?>" required>
        </div>

        <div class="col-12 col-md-4">
            <label for="baseFare" class="form-label"><?= translate('base_fare') ?></label>
            <input type="number" class="form-control form-control-sm" id="baseFare" name="baseFare" placeholder="<?= translate('base_fare') ?>" required>
        </div>

        <div class="col-12 col-md-4">
            <label for="minFare" class="form-label"><?= translate('minimum_fare') ?></label>
            <input type="number" class="form-control form-control-sm" id="minFare" name="minFare" placeholder="<?= translate('minimum_fare') ?>" required>
        </div>

        <div class="col-12 col-md-4">
            <label for="bookingFee" class="form-label"><?= translate('booking_fee') ?></label>
            <input type="number" class="form-control form-control-sm" id="bookingFee" name="bookingFee" placeholder="<?= translate('booking_fee') ?>" required>
        </div>

        <div class="col-12 col-md-4">
            <label for="taxPercentage" class="form-label"><?= translate('tax_percentage') ?></label>
            <input type="number" class="form-control form-control-sm" id="taxPercentage" name="taxPercentage" placeholder="<?= translate('tax_percentage') ?>" required>
        </div>

        <div class="col-12 col-md-4">
            <label for="pricePerMinute" class="form-label"><?= translate('price_per_minute') ?></label>
            <input type="number" class="form-control form-control-sm" id="pricePerMinute" name="pricePerMinute" placeholder="<?= translate('price_per_minute') ?>" required>
        </div>

        <div class="col-12 col-md-4">
            <label for="pricePerKm" class="form-label"><?= translate('price_per_mile_km') ?></label>
            <input type="number" class="form-control form-control-sm" id="pricePerKm" name="pricePerKm" placeholder="<?= translate('price_per_mile_km') ?>" required>
        </div>

        <div class="col-12 col-md-4">
            <label for="mileage" class="form-label"><?= translate('mileage') ?></label>
            <select class="form-control form-control-sm" id="mileage" name="mileage" required>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>

        <div class="col-12 col-md-4">
            <label for="dailyService" class="form-label"><?= translate('daily_service') ?></label>
            <select class="form-control form-control-sm" id="dailyService" name="dailyService" required>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>

        <div class="col-12 col-md-4">
            <label for="outstationService" class="form-label"><?= translate('outstation_service') ?></label>
            <select class="form-control form-control-sm" id="outstationService" name="outstationService" required>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>

        <div class="col-12 col-md-4">
            <label for="rentalService" class="form-label"><?= translate('rental_service') ?></label>
            <select class="form-control form-control-sm" id="rentalService" name="rentalService" required>
                <option value="Yes">Yes</option>
                <option value="No">No</option>
            </select>
        </div>

        <div class="col-12 col-md-4">
            <label for="providerCommission" class="form-label"><?= translate('provider_commission') ?></label>
            <input type="number" class="form-control form-control-sm" id="providerCommission" name="providerCommission" placeholder="<?= translate('provider_commission') ?>" required>
        </div>

        <div class="col-12 col-md-4">
            <label for="adminCommission" class="form-label"><?= translate('admin_commission') ?></label>
            <input type="number" class="form-control form-control-sm" id="adminCommission" name="adminCommission" placeholder="<?= translate('admin_commission') ?>" required>
        </div>

        <div class="col-12 col-md-6">
            <label for="driverCashLimit" class="form-label"><?= translate('driver_cash_limit') ?></label>
            <input type="number" class="form-control form-control-sm" id="driverCashLimit" name="driverCashLimit" placeholder="<?= translate('driver_cash_limit') ?>" required>
        </div>

        <div class="col-12 col-md-6">
            <label for="servicePicture" class="form-label"><?= translate('service_picture') ?></label>
            <input type="file" class="form-control form-control-sm" id="servicePicture" name="servicePicture" required>
        </div>

        <div class="modal-footer pt-0 border-top-0">
            <button type="submit" form="service-form" class="btn btn-sm btn-primary"><?= translate('save') ?></button>
            <button type="reset" form="service-form" class="btn btn-sm btn-secondary ms-2" data-bs-dismiss="modal">
                <?= translate('reset') ?>
            </button>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/footer.php' ?>
