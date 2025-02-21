<?php 
require_once __DIR__ . "/header.php"; 
require_once "db.php"; // Database connection

$query = "SELECT * FROM transactions ORDER BY transaction_date DESC";
$result = $conn->query($query);
?>

<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-header-title d-flex align-items-center gap-3">
                    <span><?= translate('transactions') ?></span>
                </h1>
            </div>
        </div>
    </div>

    <!-- Filter & Search Row -->
    <div class="row g-3 mb-3">
        <!-- Global Search -->
        <div class="col-12 col-md-3">
            <div class="input-group input-group-sm">
                <div class="input-group-text">
                    <i class="bi-search"></i>
                </div>
                <input type="search" class="form-control billing-table-search" placeholder="Search here">
            </div>
        </div>
        <!-- Filter Modal Trigger & Export Buttons -->
        <div class="col-12 col-md-6 offset-md-3">
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-sm btn-secondary ms-md-auto" data-bs-toggle="modal"
                    data-bs-target="#transactionfilterModal">
                    Filter <i class="bi bi-funnel-fill"></i>
                </button>
                <div class="export-buttons"></div>
            </div>
        </div>
    </div>

    <!-- Filter Modal -->
    <div class="modal fade" id="transactionfilterModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="filterModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content shadow border">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">Filter</h5>
                </div>
                <div class="modal-body py-3">
                    <form class="row g-3" id="filter-form">
                        <div class="col-12 col-md-6">
                            <label class="form-label">Filter by Transaction ID</label>
                            <input type="text" name="filter_transaction_id" class="form-control form-control-sm" placeholder="Enter transaction ID">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Filter by Order ID</label>
                            <input type="text" name="filter_order_id" class="form-control form-control-sm" placeholder="Enter order ID">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Filter by User ID</label>
                            <input type="text" name="filter_user_id" class="form-control form-control-sm" placeholder="Enter user ID">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Filter by Status</label>
                            <select class="form-select form-select-sm" name="filter_status">
                                <option value="">All</option>
                                <option value="pending">Pending</option>
                                <option value="completed">Completed</option>
                                <option value="failed">Failed</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer pt-0 border-top-0">
                    <button type="button" onclick="clearAllFilters()" class="btn btn-sm btn-outline-danger me-auto"
                        data-bs-dismiss="modal">Clear all filters</button>
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="filter-form" class="btn btn-sm btn-primary">Apply Filters</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="table-responsive">
        <table id="data-table" class="table table-bordered table-nowrap table-align-middle">
            <thead class="thead-light" align="left">
                <tr>
                    <th><?= translate('transaction_id') ?></th>
                    <th><?= translate('order_id') ?></th>
                    <th><?= translate('user_id') ?></th>
                    <th><?= translate('partner_id') ?></th>
                    <th><?= translate('amount') ?></th>
                    <th><?= translate('payment method') ?></th>
                    <th><?= translate('status') ?></th>
                    <th><?= translate('date & time') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr 
                        data-transaction-id="<?= strtolower($row['transaction_id']) ?>" 
                        data-order-id="<?= strtolower($row['order_id']) ?>" 
                        data-user-id="<?= strtolower($row['user_id']) ?>" 
                        data-status="<?= strtolower($row['status']) ?>">
                        <td><?= $row['transaction_id'] ?></td>
                        <td><?= $row['order_id'] ?></td>
                        <td><?= $row['user_id'] ?></td>
                        <td><?= $row['partner_id'] ?></td>
                        <td><?= $row['amount'] ?></td>
                        <td><?= $row['payment_method'] ?></td>
                        <td><?= $row['status'] ?></td>
                        <td><?= $row['transaction_date'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . "/footer.php"; ?>

<!-- JavaScript: Filtering & Modal Handling -->
<script>
    $(document).ready(function () {
        // Global search: filter on keyup
        $(".billing-table-search").on("keyup", function () {
            filterTable();
        });

        // Modal filter form submission: apply filters and close modal
        $("#filter-form").submit(function (e) {
            e.preventDefault();
            filterTable();
            $("#transactionfilterModal").modal("hide");
        });
    });

    // Combined filtering function: applies global search and modal filter criteria
    function filterTable() {
        // Get values from global search and filter modal inputs
        var globalSearch = $(".billing-table-search").val().toLowerCase();
        var filterTransaction = $("input[name='filter_transaction_id']").val().toLowerCase();
        var filterOrder = $("input[name='filter_order_id']").val().toLowerCase();
        var filterUser = $("input[name='filter_user_id']").val().toLowerCase();
        var filterStatus = $("select[name='filter_status']").val().toLowerCase();

        $("#data-table tbody tr").each(function () {
            var $row = $(this);
            var transactionId = $row.data("transaction-id") ? $row.data("transaction-id").toString() : "";
            var orderId = $row.data("order-id") ? $row.data("order-id").toString() : "";
            var userId = $row.data("user-id") ? $row.data("user-id").toString() : "";
            var status = $row.data("status") ? $row.data("status").toString() : "";

            // Global search is performed on the complete row text
            var rowText = $row.text().toLowerCase();

            // Check each filter condition. If a filter is empty, ignore it.
            var matchesGlobal       = rowText.indexOf(globalSearch) > -1;
            var matchesTransaction  = (filterTransaction === "" || transactionId.indexOf(filterTransaction) > -1);
            var matchesOrder        = (filterOrder === "" || orderId.indexOf(filterOrder) > -1);
            var matchesUser         = (filterUser === "" || userId.indexOf(filterUser) > -1);
            var matchesStatus       = (filterStatus === "" || status === filterStatus);

            // Show row only if all filter conditions are met
            if (matchesGlobal && matchesTransaction && matchesOrder && matchesUser && matchesStatus) {
                $row.show();
            } else {
                $row.hide();
            }
        });
    }

    // Reset all filters and show all rows
    function clearAllFilters() {
        $("#filter-form")[0].reset();
        $(".billing-table-search").val("");
        filterTable();
    }
</script>
