<?php
// Database connection details – update these as needed for your XAMPP setup.
$host = 'localhost';
$user = 'root';
$password = '';  // XAMPP default (empty)
$db = 'admin_panel';

// Create connection
$conn = new mysqli($host, $user, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL to fetch the latest record from main_dashboard table.
$sql = "SELECT * FROM main_dashboard ORDER BY updated_at DESC LIMIT 1";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    // Fetch the data if record exists.
    $data = $result->fetch_assoc();
} else {
    // No record found, so insert a default row.
    $sql_insert = "INSERT INTO main_dashboard (
        total_revenue, yearly_revenue, monthly_revenue, daily_revenue,
        total_sales, yearly_sales, monthly_sales, daily_sales,
        total_orders, yearly_orders, monthly_orders, daily_orders,
        total_partners, online_partners, offline_partners, in_commute
    ) VALUES (
        0.00, 0.00, 0.00, 0.00,
        0.00, 0.00, 0.00, 0.00,
        0, 0, 0, 0,
        0, 0, 0, 0
    )";
    if ($conn->query($sql_insert)) {
        // After inserting, try to fetch the record again.
        $result = $conn->query($sql);
        if ($result && $result->num_rows > 0) {
            $data = $result->fetch_assoc();
        } else {
            // Fallback default values if for some reason fetching still fails.
            $data = array(
                'total_revenue'   => '0.00',
                'yearly_revenue'  => '0.00',
                'monthly_revenue' => '0.00',
                'daily_revenue'   => '0.00',
                'total_sales'     => '0.00',
                'yearly_sales'    => '0.00',
                'monthly_sales'   => '0.00',
                'daily_sales'     => '0.00',
                'total_orders'    => 0,
                'yearly_orders'   => 0,
                'monthly_orders'  => 0,
                'daily_orders'    => 0,
                'total_partners'  => 0,
                'online_partners' => 0,
                'offline_partners'=> 0,
                'in_commute'      => 0
            );
        }
    } else {
        die("Error inserting default row: " . $conn->error);
    }
}
?>

<?php require_once __DIR__ . "/header.php" ?>

<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-header-title"><?= translate('dashboard') ?></h1>
            </div>
        </div>
    </div>
    <div class="row g-3">

        <!-- Revenue Card -->
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card">
                <div class="card-header bg-light text-primary py-2">
                    <div class="card-title d-flex justify-content-between align-items-center">
                        <span class="fs-3"><?= translate('revenue') ?></span>
                        <span>
                            <i class="bi-cash-stack btn-icon icon-circle icon-soft-primary bg-gradient fs-3"></i>
                        </span>
                    </div>
                </div>
                <div class="card-body py-2">
                    <ul class="list-group list-group-flush card-text">
                        <li class="list-group-item px-0 py-2">
                            <div class="d-flex justify-content-between">
                                <span><?= translate('total_revenue') ?></span>
                                <span class="rupee-after"><?= $data['total_revenue']; ?></span>
                            </div>
                        </li>
                        <li class="list-group-item px-0 py-2">
                            <div class="d-flex justify-content-between">
                                <span><?= translate('yearly_revenue') ?></span>
                                <span class="rupee-after"><?= $data['yearly_revenue']; ?></span>
                            </div>
                        </li>
                        <li class="list-group-item px-0 py-2">
                            <div class="d-flex justify-content-between">
                                <span><?= translate('monthly_revenue') ?></span>
                                <span class="rupee-after"><?= $data['monthly_revenue']; ?></span>
                            </div>
                        </li>
                        <li class="list-group-item px-0 py-2">
                            <div class="d-flex justify-content-between">
                                <span><?= translate('daily_revenue') ?></span>
                                <span class="rupee-after"><?= $data['daily_revenue']; ?></span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Sales Card -->
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card">
                <div class="card-header bg-light text-primary py-2">
                    <div class="card-title d-flex justify-content-between align-items-center">
                        <span class="fs-3"><?= translate('sales') ?></span>
                        <span>
                            <i class="bi-cash-coin btn-icon icon-circle icon-soft-primary bg-gradient fs-3"></i>
                        </span>
                    </div>
                </div>
                <div class="card-body py-2">
                    <ul class="list-group list-group-flush card-text">
                        <li class="list-group-item px-0 py-2">
                            <div class="d-flex justify-content-between">
                                <span><?= translate('total_sales') ?></span>
                                <span class="rupee-after"><?= $data['total_sales']; ?></span>
                            </div>
                        </li>
                        <li class="list-group-item px-0 py-2">
                            <div class="d-flex justify-content-between">
                                <span><?= translate('yearly_sales') ?></span>
                                <span class="rupee-after"><?= $data['yearly_sales']; ?></span>
                            </div>
                        </li>
                        <li class="list-group-item px-0 py-2">
                            <div class="d-flex justify-content-between">
                                <span><?= translate('monthly_sales') ?></span>
                                <span class="rupee-after"><?= $data['monthly_sales']; ?></span>
                            </div>
                        </li>
                        <li class="list-group-item px-0 py-2">
                            <div class="d-flex justify-content-between">
                                <span><?= translate('daily_sales') ?></span>
                                <span class="rupee-after"><?= $data['daily_sales']; ?></span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Orders Card -->
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card">
                <div class="card-header bg-light text-primary py-2">
                    <div class="card-title d-flex justify-content-between align-items-center">
                        <span class="fs-3"><?= translate('Orders') ?></span>
                        <span>
                            <i class="bi-tags btn-icon icon-circle icon-soft-primary bg-gradient fs-3"></i>
                        </span>
                    </div>
                </div>
                <div class="card-body py-2">
                    <ul class="list-group list-group-flush card-text">
                        <li class="list-group-item px-0 py-2">
                            <div class="d-flex justify-content-between">
                                <span><?= translate('Total Orders') ?></span>
                                <span><?= $data['total_orders']; ?> <small>(Booked)</small></span>
                            </div>
                        </li>
                        <li class="list-group-item px-0 py-2">
                            <div class="d-flex justify-content-between">
                                <span><?= translate('Yearly Orders') ?></span>
                                <span><?= $data['yearly_orders']; ?> <small>(Booked)</small></span>
                            </div>
                        </li>
                        <li class="list-group-item px-0 py-2">
                            <div class="d-flex justify-content-between">
                                <span><?= translate('Monthly Orders') ?></span>
                                <span><?= $data['monthly_orders']; ?> <small>(Booked)</small></span>
                            </div>
                        </li>
                        <li class="list-group-item px-0 py-2">
                            <div class="d-flex justify-content-between">
                                <span><?= translate('Daily Orders') ?></span>
                                <span><?= $data['daily_orders']; ?> <small>(Booked)</small></span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Partners Card -->
        <div class="col-12 col-sm-6 col-md-4">
            <div class="card">
                <div class="card-header bg-light text-primary py-2">
                    <div class="card-title d-flex justify-content-between align-items-center">
                        <span class="fs-3"><?= translate('partners') ?></span>
                        <span>
                            <i class="bi bi-person-badge btn-icon icon-circle icon-soft-primary bg-gradient fs-3"></i>
                        </span>
                    </div>
                </div>
                <div class="card-body py-2">
                    <ul class="list-group list-group-flush card-text">
                        <li class="list-group-item px-0 py-2">
                            <div class="d-flex justify-content-between">
                                <span><?= translate('Total Partners') ?></span>
                                <span><?= $data['total_partners']; ?></span>
                            </div>
                        </li>
                        <li class="list-group-item px-0 py-2">
                            <div class="d-flex justify-content-between">
                                <span><?= translate('Online Partners') ?></span>
                                <span><?= $data['online_partners']; ?></span>
                            </div>
                        </li>
                        <li class="list-group-item px-0 py-2">
                            <div class="d-flex justify-content-between">
                                <span><?= translate('Offline Partners') ?></span>
                                <span><?= $data['offline_partners']; ?></span>
                            </div>
                        </li>
                        <li class="list-group-item px-0 py-2">
                            <div class="d-flex justify-content-between">
                                <span><?= translate('In Commute') ?></span>
                                <span><?= $data['in_commute']; ?></span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>

<?php
// Close the database connection.
$conn->close();
?>
 