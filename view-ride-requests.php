<?php
require_once __DIR__ . "/header.php";
require_once __DIR__ . "/db.php"; // Include the database connection file

// Translation function for UI labels
function translate($key) {
    $translations = [
        'ride_requests'    => 'Ride Requests',
        'sr_no'            => 'Sr. No.',
        'transaction_id'   => 'Transaction ID',
        'user_name'        => 'User Name',
        'pickup_address'   => 'Pickup Address',
        'drop_address'     => 'Drop Address',
        'request_time'     => 'Request Time',
        'request_type'     => 'Request Type',
        'status'           => 'Status',
        'Actions'          => 'Actions',
        'search_here'      => 'Search here',
    ];

    return isset($translations[$key]) ? $translations[$key] : $key;
}

// Retrieve filter variables from GET request
$filterUser   = isset($_GET['userName']) ? $_GET['userName'] : '';
$filterPickup = isset($_GET['pickupAddress']) ? $_GET['pickupAddress'] : '';
$filterDrop   = isset($_GET['dropAddress']) ? $_GET['dropAddress'] : '';
$filterTime   = isset($_GET['requestTime']) ? $_GET['requestTime'] : '';
$filterType   = isset($_GET['requestType']) ? $_GET['requestType'] : '';
$filterStatus = isset($_GET['status']) ? $_GET['status'] : '';

// Build the SQL query using the correct table name "ride_request"
$sql = "SELECT * FROM ride_request WHERE 1=1";

// Apply filters if provided
if ($filterUser !== '') {
    $sql .= " AND user = '$filterUser'";
}
if ($filterPickup !== '') {
    $sql .= " AND pickup_address = '$filterPickup'";
}
if ($filterDrop !== '') {
    $sql .= " AND drop_address = '$filterDrop'";
}
if ($filterTime !== '') {
    $sql .= " AND time = '$filterTime'";
}
if ($filterType !== '') {
    $sql .= " AND type = '$filterType'";
}
if ($filterStatus !== '') {
    $sql .= " AND status = '$filterStatus'";
}

$result = $conn->query($sql);
?>

<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-header-title"><?= translate('ride_requests') ?></h1>
            </div>
        </div>
    </div>
    <!-- End Page Header -->

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
                            <label class="form-label">Filter by User Name</label>
                            <input type="text" class="form-control form-control-sm" name="userName" placeholder="Enter user name">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Filter by Pickup Address</label>
                            <input type="text" class="form-control form-control-sm" name="pickupAddress" placeholder="Enter pickup address">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Filter by Drop Address</label>
                            <input type="text" class="form-control form-control-sm" name="dropAddress" placeholder="Enter drop address">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Filter by Request Time</label>
                            <input type="text" class="form-control form-control-sm" name="requestTime" placeholder="Enter request time">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Filter by Request Type</label>
                            <input type="text" class="form-control form-control-sm" name="requestType" placeholder="Enter request type">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Filter by Status</label>
                            <input type="text" class="form-control form-control-sm" name="status" placeholder="Enter status">
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

    <!-- Search Bar and Export Buttons -->
    <div class="table-responsive">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <!-- Search Bar -->
            <div class="col-12 col-md-4">
                <div class="input-group input-group-sm">
                    <div class="input-group-text">
                        <i class="bi-search"></i>
                    </div>
                    <input type="search" class="form-control service-table-search" placeholder="<?= translate('search_here') ?>">
                </div>
            </div>

            <!-- Filter and Export Buttons -->
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#transactionfilterModal">
                    Filter <i class="bi bi-funnel-fill"></i>
                </button>
                <div class="export-buttons"></div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="table-responsive">
        <table id="data-table" class="table table-bordered table-nowrap table-align-middle">
            <thead class="thead-light" align="left">
                <tr>
                    <th><?= translate('sr_no') ?></th>
                    <th><?= translate('transaction_id') ?></th>
                    <th><?= translate('user_name') ?></th>
                    <th><?= translate('pickup_address') ?></th>
                    <th><?= translate('drop_address') ?></th>
                    <th><?= translate('request_time') ?></th>
                    <th><?= translate('request_type') ?></th>
                    <th><?= translate('status') ?></th>
                    <th><?= translate('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sr_no = 1;
                while ($row = $result->fetch_assoc()) {
                    // Encode row data for use in the edit modal
                    $rideData = htmlspecialchars(json_encode([
                        "id"              => $row['id'],
                        "user"            => $row['user'],
                        "pickup_address"  => $row['pickup_address'],
                        "drop_address"    => $row['drop_address'],
                        "time"            => $row['time'],
                        "type"            => $row['type'],
                        "status"          => $row['status']
                    ]), JSON_UNESCAPED_SLASHES);

                    echo "<tr>
                        <td>" . htmlspecialchars($sr_no) . "</td>
                        <td>" . htmlspecialchars($row['id']) . "</td>
                        <td>" . htmlspecialchars($row['user']) . "</td>
                        <td>" . htmlspecialchars($row['pickup_address']) . "</td>
                        <td>" . htmlspecialchars($row['drop_address']) . "</td>
                        <td>" . htmlspecialchars($row['time']) . "</td>
                        <td>" . htmlspecialchars($row['type']) . "</td>
                        <td>" . htmlspecialchars($row['status']) . "</td>
                        <td>
                            <div class='dropdown'>
                                <button class='btn btn-white btn-sm dropdown-toggle' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                                    Actions
                                </button>
                                <ul class='dropdown-menu'>
                                    <li><button class='btn btn-sm btn-light edit-row-btn' data-ride-request='" . $rideData . "'>Edit</button></li>
                                    <li><button class='btn btn-sm btn-light delete-row-btn' data-ride-request-id='" . htmlspecialchars($row['id']) . "'>Delete</button></li>
                                </ul>
                            </div>
                        </td>
                    </tr>";
                    $sr_no++;
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="data-table-footer"></div>
</div>

<!-- Edit Ride Request Modal -->
<div class="modal fade" id="editRideRequestModal" tabindex="-1" aria-labelledby="editRideRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="editRideRequestModalLabel">Edit Ride Request</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="edit_ride_request.php" method="POST" id="ride-request-form">
                    <input type="hidden" name="id" id="rideRequestId">

                    <div class="row">
                        <div class="col-md-6">
                            <label for="transactionId" class="form-label">Transaction ID</label>
                            <input type="text" class="form-control" id="transactionId" name="transactionId" required>
                        </div>
                        <div class="col-md-6">
                            <label for="userName" class="form-label">User Name</label>
                            <input type="text" class="form-control" id="userName" name="userName" required>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="pickupAddress" class="form-label">Pickup Address</label>
                            <input type="text" class="form-control" id="pickupAddress" name="pickupAddress" required>
                        </div>
                        <div class="col-md-6">
                            <label for="dropAddress" class="form-label">Drop Address</label>
                            <input type="text" class="form-control" id="dropAddress" name="dropAddress" required>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="requestTime" class="form-label">Request Time</label>
                            <input type="text" class="form-control" id="requestTime" name="requestTime" required>
                        </div>
                        <div class="col-md-6">
                            <label for="requestType" class="form-label">Request Type</label>
                            <input type="text" class="form-control" id="requestType" name="requestType" required>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status</label>
                            <input type="text" class="form-control" id="status" name="status" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" name="submit" class="btn btn-primary">Save Changes</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for handling DataTable, Edit, and Delete actions -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let rideRequestTable = $('#data-table').DataTable({
            lengthChange: true,
            columnDefs: [{
                "orderable": false,
                "targets": 0
            }],
            order: [
                [1, 'asc'],
                [0, 'asc']
            ],
            initComplete: function (settings, json) {
                $('.dataTables_filter').hide();
                $('.data-table-footer').append($('#data-table_wrapper .row:last-child()')).find('.previous').addClass('ms-md-auto');
                $('.dataTables_info').before($('.dataTables_length').find('label').attr('class', 'd-inline-flex text-nowrap align-items-center gap-2'));
                $('.data-table-search').on('input', function () {
                    rideRequestTable.search(this.value).draw();
                });
                rideRequestTable.buttons().container().find('.btn-secondary').removeClass('btn-secondary');
                rideRequestTable.buttons().container().appendTo($('.export-buttons'));
            },
            buttons: [{
                extend: 'collection',
                text: '<i class="bi bi-cloud-download-fill"></i>',
                className: 'btn-sm btn-outline-primary',
                buttons: [{
                    extend: 'copy',
                    text: '<i class="bi-clipboard2-check dropdown-item-icon"></i> Copy'
                },
                {
                    extend: 'excel',
                    text: '<i class="bi-filetype-xlsx dropdown-item-icon"></i> Excel'
                },
                {
                    extend: 'csv',
                    text: '<i class="bi-filetype-csv dropdown-item-icon"></i> CSV'
                },
                {
                    extend: 'pdf',
                    text: '<i class="bi-filetype-pdf dropdown-item-icon"></i> PDF'
                },
                {
                    extend: 'print',
                    text: '<i class="bi-printer dropdown-item-icon"></i> Print'
                }
                ]
            }],
        });

        // Handle Edit button click
        document.querySelectorAll(".edit-row-btn").forEach(button => {
            button.addEventListener("click", function () {
                let rideData = JSON.parse(this.getAttribute("data-ride-request"));
                document.getElementById("rideRequestId").value = rideData.id;
                document.getElementById("transactionId").value = rideData.id;
                document.getElementById("userName").value = rideData.user;
                document.getElementById("pickupAddress").value = rideData.pickup_address;
                document.getElementById("dropAddress").value = rideData.drop_address;
                document.getElementById("requestTime").value = rideData.time;
                document.getElementById("requestType").value = rideData.type;
                document.getElementById("status").value = rideData.status;

                let modal = new bootstrap.Modal(document.getElementById("editRideRequestModal"));
                modal.show();
            });
        });

        // Handle Delete button click
        document.querySelectorAll(".delete-row-btn").forEach(button => {
            button.addEventListener("click", function () {
                const rideRequestId = this.getAttribute('data-ride-request-id');
                if (confirm('Are you sure you want to delete this ride request?')) {
                    // Send an AJAX request to delete the record
                    fetch('delete_ride_request.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `id=${rideRequestId}`
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            alert('Record deleted successfully');
                            const row = this.closest('tr');
                            row.remove();
                        } else {
                            alert('Error deleting record');
                        }
                    })
                    .catch(error => console.error('Error:', error));
                }
            });
        });
    });
</script>

<?php require_once __DIR__ . '/footer.php'; ?>
