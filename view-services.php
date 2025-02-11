<?php
require_once __DIR__ . "/header.php";
require_once __DIR__ . "/db_connection.php"; // Include the database connection

// Query to fetch all services
$query = "SELECT * FROM services ORDER BY id ASC";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Error fetching services: " . mysqli_error($conn));
}
$filterDaily = isset($_GET['dailyService']) ? $_GET['dailyService'] : '';
$filterOutstation = isset($_GET['outstationService']) ? $_GET['outstationService'] : '';
$filterRental = isset($_GET['rentalService']) ? $_GET['rentalService'] : '';

// Start building the SQL query
$sql = "SELECT * FROM services WHERE 1";

// Apply filters if selected
if ($filterDaily !== '') {
    $sql .= " AND daily_service = '$filterDaily'";
}
if ($filterOutstation !== '') {
    $sql .= " AND outstation_service = '$filterOutstation'";
}
if ($filterRental !== '') {
    $sql .= " AND rental_service = '$filterRental'";
}

$result = mysqli_query($conn, $sql);

?>


<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-header-title"><?= translate('service') ?></h1>
            </div>
        </div>
    </div>
    <!-- End Page Header -->

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
    <label class="form-label">Filter by Daily Services</label>
    <select class="form-select form-select-sm" name="dailyService">
        <option value="" selected>All</option>
        <option value="Yes">Yes</option>
        <option value="No">No</option>
    </select>
</div>

<div class="col-12 col-md-6">
    <label class="form-label">Filter by Outstation Services</label>
    <select class="form-select form-select-sm" name="outstationService">
        <option value="" selected>All</option>
        <option value="Yes">Yes</option>
        <option value="No">No</option>
    </select>
</div>

<div class="col-12 col-md-6">
    <label class="form-label">Filter by Rental Service</label>
    <select class="form-select form-select-sm" name="rentalService">
        <option value="" selected>All</option>
        <option value="Yes">Yes</option>
        <option value="No">No</option>
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

    <div class="table-responsive">
	<div class="d-flex justify-content-between align-items-center mb-2">
		<!-- Search Bar -->
		<div class="col-12 col-md-4">
			<div class="input-group input-group-sm">
				<div class="input-group-text">
					<i class="bi-search"></i>
				</div>
				<input type="search" class="form-control service-table-search" placeholder="Search here">
			</div>
		</div>

		<!-- Filter Button and Export Buttons -->
		<div class="d-flex align-items-center gap-2">
			<button class="btn btn-sm btn-secondary" data-bs-toggle="modal" data-bs-target="#transactionfilterModal">
				Filter <i class="bi bi-funnel-fill"></i>
			</button>
			<div class="export-buttons"></div>
		</div>
	</div>
</div>


    <!-- Table -->
    <div class="table-responsive">
        <table id="data-table" class="table table-bordered table-nowrap table-align-middle">
            <thead class="thead-light" align="left">
                <tr>
                    <th><?= translate('sr_no') ?></th>
                    <th><?= translate('service_name') ?></th>
                    <th><?= translate('number_of_seats') ?></th>
                    <th><?= translate('base_fare') ?></th>
                    <th><?= translate('minimum_fare') ?></th>
                    <th><?= translate('booking_fee') ?></th>
                    <th><?= translate('tax_percentage') ?></th>
                    <th><?= translate('price_per_minute') ?></th>
                    <th><?= translate('price_per_mile_km') ?></th>
                    <th><?= translate('mileage') ?></th>
                    <th><?= translate('daily_service') ?></th>
                    <th><?= translate('outstation_service') ?></th>
                    <th><?= translate('rental_service') ?></th>
                    <th><?= translate('provider_commission') ?></th>
                    <th><?= translate('admin_commission') ?></th>
                    <th><?= translate('driver_cash_limit') ?></th>
                    <th><?= translate('service_picture') ?></th>
                    <th><?= translate('Action') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sr_no = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    $serviceData = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8');
                    echo "<tr>
                        <td>" . $sr_no++ . "</td>
                        <td>" . htmlspecialchars($row['service_name']) . "</td>
                        <td>" . htmlspecialchars($row['number_of_seats']) . "</td>
                        <td>" . htmlspecialchars($row['base_fare']) . "</td>
                        <td>" . htmlspecialchars($row['minimum_fare']) . "</td>
                        <td>" . htmlspecialchars($row['booking_fee']) . "</td>
                        <td>" . htmlspecialchars($row['tax_percentage']) . "%</td>
                        <td>" . htmlspecialchars($row['price_per_minute']) . "</td>
                        <td>" . htmlspecialchars($row['price_per_mile_km']) . "</td>
                        <td>" . htmlspecialchars($row['mileage']) . "</td>
                        <td>" . htmlspecialchars($row['daily_service']) . "</td>
                        <td>" . htmlspecialchars($row['outstation_service']) . "</td>
                        <td>" . htmlspecialchars($row['rental_service']) . "</td>
                        <td>" . htmlspecialchars($row['provider_commission']) . "%</td>
                        <td>" . htmlspecialchars($row['admin_commission']) . "%</td>
                        <td>" . htmlspecialchars($row['driver_cash_limit']) . "</td>
                      <td>
    <a href='#' class='view-image' data-image='assets/img/" . htmlspecialchars($row['service_picture']) . "'>
        View Image
    </a>
</td>
 <td>
                        <div class='dropdown'>
                                <button class='btn btn-white btn-sm dropdown-toggle' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                                    Actions
                                </button>
                                <ul class='dropdown-menu'>
                           <li> <button class='btn btn-sm btn-light edit-service-btn' data-service='$serviceData'>Edit</button></li>
                           <li> <a class='btn btn-sm  btn-light' href='delete_service.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this service?\");'>Delete</a></li>
                        </ul>
                        </div>
                           </td>  
                    </tr>";
                }
                ?>
            </tbody>
        </table>
        </div>
		<div class="data-table-footer"></div>
</div>
    </div>

</div>
<script>
document.addEventListener("DOMContentLoaded", function () {
    let serviceTable = $('#data-table').DataTable();

    // Search Functionality
    document.querySelector('.service-table-search').addEventListener('input', function () {
        serviceTable.search(this.value).draw();
    });
});
</script> 
<?php require_once __DIR__ . '/footer.php'; ?>

<!-- Edit Service Modal -->
<div class="modal fade" id="editServiceModal" tabindex="-1" aria-labelledby="editServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="editServiceModalLabel">Edit Service</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="edit_service.php" method="POST" enctype="multipart/form-data" id="service-form">
                    <input type="hidden" name="id" id="serviceId">

                    <div class="row">
                        <div class="col-md-6">
                            <label for="serviceName" class="form-label">Service Name</label>
                            <input type="text" class="form-control" id="serviceName" name="serviceName" required>
                        </div>
                        <div class="col-md-6">
                            <label for="numSeats" class="form-label">Number of Seats</label>
                            <input type="number" class="form-control" id="numSeats" name="numSeats" required>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="baseFare" class="form-label">Base Fare</label>
                            <input type="number" class="form-control" id="baseFare" name="baseFare" required>
                        </div>
                        <div class="col-md-6">
                            <label for="minFare" class="form-label">Minimum Fare</label>
                            <input type="number" class="form-control" id="minFare" name="minFare" required>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="bookingFee" class="form-label">Booking Fee</label>
                            <input type="number" class="form-control" id="bookingFee" name="bookingFee" required>
                        </div>
                        <div class="col-md-6">
                            <label for="taxPercentage" class="form-label">Tax Percentage</label>
                            <input type="number" class="form-control" id="taxPercentage" name="taxPercentage" required>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="pricePerMinute" class="form-label">Price Per Minute</label>
                            <input type="number" class="form-control" id="pricePerMinute" name="pricePerMinute" required>
                        </div>
                        <div class="col-md-6">
                            <label for="pricePerKm" class="form-label">Price Per Mile/KM</label>
                            <input type="number" class="form-control" id="pricePerKm" name="pricePerKm" required>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="mileage" class="form-label">Mileage</label>
                            <select class="form-control" id="mileage" name="mileage" required>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="dailyService" class="form-label">Daily Service</label>
                            <select class="form-control" id="dailyService" name="dailyService" required>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="outstationService" class="form-label">Outstation Service</label>
                            <select class="form-control" id="outstationService" name="outstationService" required>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="rentalService" class="form-label">Rental Service</label>
                            <select class="form-control" id="rentalService" name="rentalService" required>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="providerCommission" class="form-label">Provider Commission</label>
                            <input type="number" class="form-control" id="providerCommission" name="providerCommission" required>
                        </div>
                        <div class="col-md-6">
                            <label for="adminCommission" class="form-label">Admin Commission</label>
                            <input type="number" class="form-control" id="adminCommission" name="adminCommission" required>
                        </div>

                    </div>


                    <div class="row mt-3">
                    <div class="col-md-6">
                            <label for="driverCashLimit" class="form-label">Driver Cash Limit</label>
                            <input type="number" class="form-control" id="driverCashLimit" name="driverCashLimit" required>
                        </div>
                    </div>
                     <div class="row mt-3">
                        <div class="col-md-6">
                            <label for="servicePicture" class="form-label">Service Picture</label>
                            <input type="file" class="form-control" id="servicePicture" name="servicePicture">
                            <img id="serviceImagePreview" src="" alt="Service Picture" width="100" class="mt-2">
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


<!-- JavaScript to Handle Edit Button Click -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".edit-service-btn").forEach(button => {
        button.addEventListener("click", function () {
            let serviceData = JSON.parse(this.getAttribute("data-service"));

            document.getElementById("serviceId").value = serviceData.id;
            document.getElementById("serviceName").value = serviceData.service_name;
            document.getElementById("numSeats").value = serviceData.number_of_seats;
            document.getElementById("baseFare").value = serviceData.base_fare;
            document.getElementById("minFare").value = serviceData.minimum_fare;
            document.getElementById("bookingFee").value = serviceData.booking_fee;
            document.getElementById("taxPercentage").value = serviceData.tax_percentage;
            document.getElementById("pricePerMinute").value = serviceData.price_per_minute;
            document.getElementById("pricePerKm").value = serviceData.price_per_mile_km;
           setDropdownValue("mileage", serviceData.mileage);
           setDropdownValue("dailyService", serviceData.daily_service);
           setDropdownValue("outstationService", serviceData.outstation_service);
           setDropdownValue("rentalService", serviceData.rental_service);

function setDropdownValue(dropdownId, value) {
    let dropdown = document.getElementById(dropdownId);
    for (let option of dropdown.options) {
        if (option.value.trim().toLowerCase() === value.trim().toLowerCase()) {
            option.selected = true;
            break;
        }
    }
}
            document.getElementById("providerCommission").value = serviceData.provider_commission;
            document.getElementById("adminCommission").value = serviceData.admin_commission;
            document.getElementById("driverCashLimit").value = serviceData.driver_cash_limit;



            // Set image preview
            if (serviceData.service_picture) {
    document.getElementById("serviceImagePreview").src = "assets/img/" + serviceData.service_picture;
} else {
    document.getElementById("serviceImagePreview").src = "assets/img/default.png"; // Placeholder
}


            let modal = new bootstrap.Modal(document.getElementById("editServiceModal"));
            modal.show();
        });
    });
});
</script>

<script>
   function initializeDataTable() {
    if ($.fn.DataTable.isDataTable('#data-table')) {
        $('#data-table').DataTable().destroy(); // Destroy existing instance
    }

    $('#data-table').DataTable({
        lengthChange: true,
        order: [
            [1, 'asc'],  // Order by service_name or another column
            [0, 'asc']   // Keep serial numbers in order
        ],
        columnDefs: [{
            "orderable": false, "targets": 0 // Disable sorting on Sr. No column
        }],
        initComplete: function(settings, json) {
            $('.dataTables_filter').hide();
            $('.data-table-footer').append($('#data-table_wrapper .row:last-child()')).find('.previous').addClass('ms-md-auto');
            $('.dataTables_info').before($('.dataTables_length').find('label').attr('class', 'd-inline-flex text-nowrap align-items-center gap-2'));
            $('.data-table-search').on('input', function() {
                $('#data-table').DataTable().search(this.value).draw();
            });
        },
        buttons: [
            {
                extend: 'collection',
                text: '<i class="bi bi-cloud-download-fill"></i>',
                className: 'btn-sm btn-outline-primary',
                buttons: [
                    { extend: 'copy', text: '<i class="bi-clipboard2-check dropdown-item-icon"></i> Copy' },
                    { extend: 'excel', text: '<i class="bi-filetype-xlsx dropdown-item-icon"></i> Excel' },
                    { extend: 'csv', text: '<i class="bi-filetype-csv dropdown-item-icon"></i> CSV' },
                    { extend: 'pdf', text: '<i class="bi-filetype-pdf dropdown-item-icon"></i> PDF' },
                    { extend: 'print', text: '<i class="bi-printer dropdown-item-icon"></i> Print' }
                ]
            }
        ]
    });
}

// Call this function when data is loaded or updated
initializeDataTable();

</script>

<!-- Image Preview Modal -->
<div class="modal fade" id="imagePreviewServiceModal" tabindex="-1" aria-labelledby="imagePreviewServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imagePreviewServiceModalLabel">Service Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="previewServiceImage" src="" alt="Service Image" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<script>document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".view-image").forEach(link => {
        link.addEventListener("click", function (event) {
            event.preventDefault();
            let imageUrl = this.getAttribute("data-image");
            document.getElementById("previewServiceImage").src = imageUrl;
            let modal = new bootstrap.Modal(document.getElementById("imagePreviewServiceModal"));
            modal.show();
        });
    });
});


</script>
