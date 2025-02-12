<?php
require_once __DIR__ . "/header.php";
require_once __DIR__ . "/db.php"; // Include the database connection file

// Pagination settings
$itemsPerPage = 10;
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($currentPage - 1) * $itemsPerPage;

// Query to get the total number of ride requests
$totalQuery = "SELECT COUNT(*) as total FROM ride_requests";
$totalResult = $conn->query($totalQuery);
if (!$totalResult) {
    die("Query failed: " . $conn->error);
}
$totalItems = $totalResult->fetch_assoc()['total'];
$totalPages = ceil($totalItems / $itemsPerPage);

// Query to get the ride requests for the current page
$query = "SELECT * FROM ride_requests LIMIT $itemsPerPage OFFSET $offset";
$result = $conn->query($query);
if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-header-title">
                    <?= translate('ride_requests') ?>
                </h1>
            </div>
        </div>
    </div>
    <!-- End Page Header -->
    <div class="data-table-filters">
        <div class="row g-3">
            <div class="col-12 col-md-3">
                <div class="input-group input-group-sm">
                    <div class="input-group-text">
                        <i class="bi-search"></i>
                    </div>
                    <input type="search" class="form-control customer-table-search" id="searchInput" placeholder="<?= translate('search_here') ?>">
                </div>
            </div>
            <div class="col-12 col-md-6 offset-md-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="export-buttons ms-md-auto"></div>
                </div>
            </div>
        </div>
    </div>

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
                if ($result->num_rows > 0) {
                    $counter = $offset + 1;
                    while ($row = $result->fetch_assoc()) {
                        echo '<tr>';
                        echo '<td>' . $counter . '</td>';
                        echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['user']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['from_location']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['to_location']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['time']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['type']) . '</td>';
                        echo '<td>' . htmlspecialchars($row['status']) . '</td>';
                        echo '<td>
                                <div class="dropdown">
                                    <button class="btn btn-white btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><button class="btn btn-sm btn-light edit-row-btn" data-ride-request=\'' . json_encode($row) . '\'>Edit</button></li>
                                        <li><button class="btn btn-sm btn-light delete-row-btn" data-ride-request-id="' . htmlspecialchars($row['id']) . '">Delete</button></li>
                                    </ul>
                                </div>
                              </td>';
                        echo '</tr>';
                        $counter++;
                    }
                } else {
                    echo '<tr><td colspan="9" class="no-data">No data to show</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="customer-table-footer">
        <div class="pagination">
            <?php if ($currentPage > 1): ?>
                <a href="?page=<?php echo $currentPage - 1; ?>">Previous</a>
            <?php endif; ?>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?page=<?php echo $i; ?>" class="<?php echo ($i == $currentPage) ? 'active' : ''; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>
            <?php if ($currentPage < $totalPages): ?>
                <a href="?page=<?php echo $currentPage + 1; ?>">Next</a>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- End Content -->

<script>
    let sowingListTable = $('#data-table').DataTable({
        lengthChange: true,
        columnDefs: [{
            // targets: [0,],
            // orderable: false,
        }],
        order: [
            [1, 'desc'],
            [0, 'desc']
        ],
        initComplete: function (settings, json) {
            $('.dataTables_filter').hide();
            $('.data-table-footer').append($('#data-table_wrapper .row:last-child()')).find('.previous').addClass('ms-md-auto');
            $('.dataTables_info').before($('.dataTables_length').find('label').attr('class', 'd-inline-flex text-nowrap align-items-center gap-2'));
            $('.data-table-search').on('input', function () {
                sowingListTable.search(this.value).draw();
            });
            sowingListTable.buttons().container().find('.btn-secondary').removeClass('btn-secondary');
            sowingListTable.buttons().container().appendTo($('.export-buttons'));
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

    function deleteRow(button) {
        const rideRequestId = button.getAttribute('data-ride-request-id');
        if (confirm('Are you sure you want to delete this ride request?')) {
            // Perform delete operation, e.g., send an AJAX request to the server
            console.log('Deleting ride request with ID:', rideRequestId);
            // For demonstration, we'll just remove the row from the table
            const row = button.closest('tr');
            row.remove();
        }
    }

    function editRow(button) {
        const rowData = JSON.parse(button.getAttribute('data-ride-request'));

        // Populate the modal with row data
        document.getElementById('transactionId').value = rowData.id;
        document.getElementById('userName').value = rowData.user;
        document.getElementById('pickupAddress').value = rowData.from_location;
        document.getElementById('dropAddress').value = rowData.to_location;
        document.getElementById('requestTime').value = rowData.time;
        document.getElementById('requestType').value = rowData.type;
        document.getElementById('status').value = rowData.status;

        let modal = new bootstrap.Modal(document.getElementById('editRideRequestModal'));
        modal.show();
    }

    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".edit-row-btn").forEach(button => {
            button.addEventListener("click", function () {
                editRow(this);
            });
        });

        document.querySelectorAll(".delete-row-btn").forEach(button => {
            button.addEventListener("click", function () {
                deleteRow(this);
            });
        });
    });
</script>

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

<?php
require_once __DIR__ . '/footer.php';

// Close the database connection
$conn->close();
?>
