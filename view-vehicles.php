<?php require_once __DIR__ . "/header.php" ?>
<?php include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_vehicle"])) {
	$id = $_POST["id"];
	$vehicle_name = $_POST["vehicle_name"];
	$vehicle_no = $_POST["vehicle_no"];
	$vehicle_model = $_POST["vehicle_model"];
	$driver_name = $_POST["driver_name"];
	$driver_mobile_number = $_POST["driver_mobile_number"];

	// Update Query
	$sql = "UPDATE vehicles SET 
            vehicle_name = '$vehicle_name', 
            vehicle_number = '$vehicle_no', 
            vehicle_model = '$vehicle_model', 
            driver_name = '$driver_name', 
            driver_mobile_number = '$driver_mobile_number'
            WHERE id = $id";

	if (mysqli_query($conn, $sql)) {
		$message = "Vehicle updated successfully!";
	} else {
		$message = "Error updating vehicle: " . mysqli_error($conn);
	}
}

// Fetch all vehicles for the dropdown
$vehicleOptions = "";
$vehicleQuery = "SELECT id, vehicle_name FROM new_vehicles";
$vehicleResult = mysqli_query($conn, $vehicleQuery);
while ($row = mysqli_fetch_assoc($vehicleResult)) {
	$vehicleOptions .= '<option value="' . $row["vehicle_name"] . '">' . $row["vehicle_name"] . '</option>';
}
?>

<div class="content container-fluid">

	<div class="page-header">
		<div class="row align-items-center">
			<div class="col">
				<h1 class="page-header-title d-flex align-items-center gap-3">
					<span><?= translate('view_vehicles') ?></span>
				</h1>
			</div>
		</div>
	</div>

	<div class="reports-table-filters">
		<div class="row g-3">
			<div class="col-12 col-md-3">
				<div class="input-group input-group-sm">
					<div class="input-group-text">
						<i class="bi-search"></i>
					</div>
					<input type="search" id="search_bar" class="form-control reports-table-search"
						placeholder="<?= translate('search_here') ?>">
				</div>
			</div>

			<div class="col-12 col-md-6 offset-md-3">
				<div class="d-flex align-items-center gap-2">
					<button class="btn btn-sm btn-secondary ms-md-auto" data-bs-toggle="modal"
						data-bs-target="#vehiclefilterModal">
						Filter <i class="bi bi-funnel-fill"></i>
					</button>
					<div class="export-buttons"></div>
				</div>
			</div>

		</div>
	</div>

	<!-- VEHICLE EDIT MODAL -->

	<div class="modal modal-sm fade" id="editVehicleModal" data-bs-backdrop="static" data-bs-keyboard="false"
		tabindex="-1" aria-labelledby="transportAddModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
			<div class="modal-content border shadow-lg">
				<div class="modal-header">
					<h5 class="modal-title">Edit Vehicle</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<!-- Update Vehicle Form -->
					<form method="post" class="row g-3" id="transport-form">
						<input type="hidden" name="id" id="vehicle_id">
						<input type="hidden" name="update_vehicle" value="1">

						<div class="col-12 col-md-6">
							<label for="vehicle_name" class="form-label">Vehicle Name</label>
							<select name="vehicle_name" id="vehicle_name" class="form-control form-control-sm">
								<option value="">Select Vehicle</option>
								<?= $vehicleOptions; ?>
							</select>
						</div>

						<div class="col-12 col-md-6">
							<label for="vehicle_no" class="form-label">Vehicle No.</label>
							<input type="text" name="vehicle_no" id="vehicle_no" class="form-control form-control-sm">
						</div>
						<div class="col-12 col-md-6">
							<label for="vehicle_model" class="form-label">Vehicle Model</label>
							<input type="text" name="vehicle_model" id="vehicle_model"
								class="form-control form-control-sm">
						</div>
						<div class="col-12 col-md-6">
							<label for="driver_name" class="form-label">Partner Name</label>
							<input type="text" name="driver_name" id="driver_name" class="form-control form-control-sm">
						</div>
						<div class="col-12 col-md-6">
							<label for="driver_mobile_number" class="form-label">Partner Mobile Number</label>
							<input type="text" name="driver_mobile_number" id="driver_mobile_number"
								class="form-control form-control-sm">
						</div>

						<div class="modal-footer pt-0 border-top-0">
							<button type="submit" class="btn btn-sm btn-primary">Save</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- END OF VEHICLE EDIT MODAL -->

	<!-- VEHICLE FILTER MODAL -->

	<div class="modal fade" id="vehiclefilterModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
		aria-labelledby="filterModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
			<div class="modal-content shadow border">
				<div class="modal-header">
					<h5 class="modal-title" id="filterModalLabel">Filter</h5>
				</div>
				<div class="modal-body py-3">
					<form class="row g-3" id="filter-form">

						<div class="col-12 col-md-12">
							<label class="form-label">
								Filter by Vehicle Type</label>
							<select class="form-select form-select-sm" name="vehicle_type">
								<option value="" selected>All</option>
								<option value="Bike">Bike</option>
								<option value="Three-Wheeler">Three-Wheeler</option>
								<option value="Car">Car</option>
								<option value="Pickup">Pickup</option>
								<option value="Truck">Truck</option>
								<option value="Electric">Electric</option>
								<option value="Other">Other</option>
							</select>
						</div>

					</form>
				</div>
				<div class="modal-footer pt-0 border-top-0">
					<button type="reset" form="filter-form" class="btn btn-sm btn-outline-danger me-auto">Clear all
						filters</button>
					<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="submit" form="filter-form" class="btn btn-sm btn-primary">Apply Filters</button>
				</div>
			</div>
		</div>
	</div>

	<!-- END OF VEHICLE FILTER MODAL -->


	<div class="table-responsive">
		<table id="data-table" class="table table-bordered table-nowrap table-align-middle">
			<thead class="thead-light " align="left">
				<tr>

					<th><?= translate('sr_no') ?></th>
					<th><?= translate('vehicle_name') ?></th>
					<th><?= translate('vehicle_no') ?></th>
					<th><?= translate('vehicle_model_no') ?></th>
					<th><?= translate('driver_name') ?></th>
					<th><?= translate('mobile_no') ?></th>
					<th><?= translate('action') ?></th>
				</tr>
			</thead>
			<tbody>

				<?php
				$sql = "SELECT * FROM vehicles";
				$result = mysqli_query($conn, $sql);
				while ($row = mysqli_fetch_assoc($result)) {

					?>
					<tr class="odd">
						<td><?php echo $row['id'] ?></td>
						<td><?php echo $row['vehicle_name'] ?></td>
						<td><?php echo $row['vehicle_number'] ?></td>
						<td><?php echo $row['vehicle_model'] ?></td>
						<td><?php echo $row['driver_name'] ?></td>
						<td><?php echo $row['driver_mobile_number'] ?></td>
						<td>
							<div class="dropdown">
								<button class="btn btn-sm btn-white dropdown-toggle" type="button" data-bs-toggle="dropdown"
									aria-expanded="false">
									Actions
								</button>
								<ul class="dropdown-menu">
									<li>
										<a class="dropdown-item edit-btn" href="#" data-id="<?php echo $row['id']; ?>"
											data-vehicle_name="<?php echo $row['vehicle_name']; ?>"
											data-vehicle_no="<?php echo $row['vehicle_number']; ?>"
											data-vehicle_model="<?php echo $row['vehicle_model']; ?>"
											data-driver_name="<?php echo $row['driver_name']; ?>"
											data-driver_mobile_number="<?php echo $row['driver_mobile_number']; ?>"
											data-bs-toggle="modal" data-bs-target="#editVehicleModal">
											Edit
										</a>
									</li>
									<li>
										<a class="dropdown-item text-danger delete-btn" href="#"
											data-id="<?php echo $row['id']; ?>">Delete</a>
									</li>
								</ul>
							</div>
						</td>
					</tr>

					<?php
				}
				?>
			</tbody>
		</table>
	</div>

	<div class="data-table-footer"></div>
</div>
<?php require_once __DIR__ . '/footer.php' ?>

<script>
	let sowingListTable = false;
	sowingListTable = $('#data-table').DataTable({
		lengthChange: true,
		columnDefs: [{
			// targets: [0,],
			// orderable: false,
		}],
		order: [
			[0, 'asc']
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
</script>

<script>
	$(document).ready(function () {
		$(".edit-btn").on("click", function () {
			var id = $(this).data("id");
			var vehicle_name = $(this).data("vehicle_name");
			var vehicle_no = $(this).data("vehicle_no");
			var vehicle_model = $(this).data("vehicle_model");
			var driver_name = $(this).data("driver_name");
			var driver_mobile_number = $(this).data("driver_mobile_number");

			// Set values in modal form
			$("#vehicle_id").val(id);
			$("#vehicle_no").val(vehicle_no);
			$("#vehicle_model").val(vehicle_model);
			$("#driver_name").val(driver_name);
			$("#driver_mobile_number").val(driver_mobile_number);

			// Set selected vehicle name in dropdown
			$("#vehicle_name").val(vehicle_name);

			// Show modal
			$("#editVehicleModal").modal("show");
		});

		// Search functionality
		$('#search_bar').on('input', function () {
			var searchTerm = $(this).val().toLowerCase();
			$('#data-table tbody tr').filter(function () {
				$(this).toggle($(this).text().toLowerCase().indexOf(searchTerm) > -1);
			});
		});
	});
</script>

<script>
	document.getElementById('search_bar').addEventListener('keypress', function (event) {
		if (event.key === 'Enter') {
			PerformSearch();
		}
	});

	function PerformSearch() {
		const query = document.getElementById('search_bar').value;
	}
</script>