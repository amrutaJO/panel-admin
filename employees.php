<?php require_once __DIR__ . "/header.php" ?>

<?php require_once 'db.php';

$sql = "SELECT id, partner_name, mobile_no, address, email_id, partner_type, gender, outstation_services, daily_services, upi_id, account_no, bank_name, ifsc_code, password, salary_type, salary, created_at FROM partners";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
	$partners = [];
	while ($row = $result->fetch_assoc()) {
		$partners[] = $row;
	}
} else {
	$partners = [];
}

$conn->close();
?>

<div class="content container-fluid">

	<div class="page-header">
		<div class="row align-items-center">
			<div class="col">
				<h1 class="page-header-title">
					<?= translate('view_partners') ?>
				</h1>
			</div>
		</div>
	</div>

	<!-- Searchbar and Filter -->

	<div class="employees-table-filters">
		<div class="row g-3">

			<div class="col-12 col-md-3">
				<div class="input-group input-group-sm">
					<div class="input-group-text">
						<i class="bi-search"></i>
					</div>
					<input type="search" id="search_bar" class="form-control employees-table-search"
						placeholder="<?= translate('search_here') ?>">
				</div>
			</div>

			<div class="col-12 col-md-6 offset-md-3">
				<div class="d-flex align-items-center gap-2">
					<button class="btn btn-sm btn-secondary ms-md-auto" data-bs-toggle="modal"
						data-bs-target="#partnersfilterModal">
						Filter <i class="bi bi-funnel-fill"></i>
					</button>
					<div class="export-buttons"></div>
				</div>
			</div>

		</div>
	</div>

	<!-- End of Searchbar and Filter -->


	<!-- Table to display partners -->

	<div class="table-responsive">
		<table id="employees-table" class="table table-bordered table-nowrap table-align-middle">
			<thead class="thead-light" align="left">
				<tr>
					<th><?= translate('id') ?></th>
					<th><?= translate('partner_name') ?></th>
					<th><?= translate('mobile_no') ?></th>
					<th><?= translate('email_id') ?></th>
					<th><?= translate('partner_type') ?></th>
					<th><?= translate('gender') ?></th>
					<th><?= translate('outstation_services') ?></th>
					<th><?= translate('daily_services') ?></th>
					<th><?= translate('upi_id') ?></th>
					<th><?= translate('bank_name') ?></th>
					<th><?= translate('account_no') ?></th>
					<th><?= translate('ifsc_code') ?></th>
					<th><?= translate('password') ?></th>
					<th><?= translate('salary_type') ?></th>
					<th><?= translate('salary') ?></th>
					<th><?= translate('joining_date') ?></th>
					<th><?= translate('action') ?></th>

				</tr>
			</thead>
			<tbody>

			</tbody>
		</table>
	</div>

	<!-- End of Table to display partners -->

</div>

<?php require_once __DIR__ . '/footer.php' ?>


<!-- Edit Modal -->

<div class="modal fade" id="employeeEditModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
	aria-labelledby="employeeEditModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl modal-dialog-centered">
		<div class="modal-content border shadow">
			<div class="modal-header">
				<h5 class="modal-title" id="employeeEditModalLabel">Edit Partner</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">

				<form action="" method="post" class="row g-3" id="employee-form">
					<div class="col-12" style="display: none;">
						<input type="hidden" name="emp_id" value="">
					</div>

					<div class="col-12 col-md-6">
						<div class="row g-3">
							<div class="col-12">
								<input type="hidden" id="employee-form-action" name="add_employee" value="">
								<label for="" class="form-label">Partner name</label>
								<input type="text" name="emp_name" class="form-control form-control-sm" required>
							</div>

							<div class="col-12">
								<label for="" class="form-label">Mobile number</label>
								<input type="tel" name="emp_mobile" class="form-control form-control-sm"
									oninput="allowType(event, 'mobile')">
							</div>

							<div class="col-12">
								<label for="" class="form-label">Email id</label>
								<input type="email" name="emp_email" class="form-control form-control-sm">
							</div>

							<div class="col-12">
								<label for="" class="form-label">Partner Type</label>
								<select id="partner-type" name="partner_type" class="form-control form-control-sm">
									<option value="selectoption">Select Type</option>
									<option value="Full Time">Full Time</option>
									<option value="Part Time">Part Time</option>
								</select>
							</div>

							<div class="col-12">
								<label for="" class="form-label">Daily Services</label>
								<select id="daily-services" name="daily_services" class="form-control form-control-sm">
									<option value="yes">Yes</option>
									<option value="no">No</option>
								</select>
							</div>

							<div class="col-12">
								<label for="" class="form-label">Account No</label>
								<input type="text" name="account_no" class="form-control form-control-sm">
							</div>

							<div class="col-12">
								<label for="bank_name" class="form-label">Bank Name</label>
								<input type="text" name="bank_name" class="form-control form-control-sm" required>
							</div>
						</div>
					</div>

					<div class="col-12 col-md-6">
						<div class="row g-3">
							<div class="col-12">
								<label for="" class="form-label">Gender</label>
								<select name="emp_gender" class="form-control form-control-sm">
									<option value="Male">Male</option>
									<option value="Female">Female</option>
									<option value="Other">Other</option>
									<option value="No Share">No Share</option>
								</select>
							</div>

							<div class="col-12">
								<label for="" class="form-label">Address</label>
								<textarea name="emp_address" class="form-control form-control-sm" rows="5"></textarea>
							</div>

							<div class="col-12">
								<label for="" class="form-label">Outstation Services</label>
								<select id="outstation-services" name="outstation_services"
									class="form-control form-control-sm">
									<option value="yes">Yes</option>
									<option value="no">No</option>
								</select>
							</div>

							<div class="col-12">
								<label for="upi_id" class="form-label">UPI id</label>
								<input type="text" name="upi_id" class="form-control form-control-sm" required>
							</div>

							<div class="col-12">
								<label for="ifsc_code" class="form-label">IFSC Code</label>
								<input type="text" name="ifsc_code" class="form-control form-control-sm" required>
							</div>

							<div class="col-12">
								<label for="password" class="form-label">Password</label>
								<input type="password" name="password" class="form-control form-control-sm" required>
							</div>
						</div>
					</div>

					<div class="col-12 ">
						<div class="row">
							<div class="d-flex col-md-4 justify-content-between perdaymonth align-items-center">
								<input type="radio" class="d-none" name="salper" id="permonth" checked
									data-value="Month">
								<label class="px-3 py-2" for="permonth">Month</label>
								<input type="radio" class="d-none" name="salper" id="perday" data-value="Day">
								<label class="px-3 py-2" for="perday">Day</label>
							</div>
							<div class="col-md-8">
								<label for="" class="form-label" id="sal">Per <span id="salchange"></span>
									salary</label>
								<input type="text" name="emp_salary" class="form-control form-control-sm"
									oninput="allowType(event, 'number')">
							</div>
						</div>
					</div>
				</form>


			</div>
			<div class="modal-footer pt-0 border-top-0">
				<button type="reset" form="employee-form" class="btn btn-sm btn-secondary"
					data-bs-dismiss="modal">Close</button>
				<button type="submit" form="employee-form" class="btn btn-sm btn-primary">Save</button>
			</div>
		</div>
	</div>
</div>

<!-- End of Edit Modal -->


<!-- Filter Modal -->

<div class="modal fade" id="partnersfilterModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
	aria-labelledby="filterModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
		<div class="modal-content shadow border">
			<div class="modal-header">
				<h5 class="modal-title" id="filterModalLabel">Filter</h5>
			</div>
			<div class="modal-body py-3">
				<form class="row g-3" id="filter-form">

					<div class="col-12 col-md-6">
						<label class="form-label">
							Filter by Daily Services</label>
						<select class="form-select form-select-sm" name="paymode">
							<option value="" selected>All</option>
							<option value="yes">Yes</option>
							<option value="no">No</option>
						</select>
					</div>

					<div class="col-12 col-md-6">
						<label class="form-label">
							Filter by Gender </label>
						<select class="form-select form-select-sm" name="status">
							<option value="" selected>All</option>
							<option value="Male">Male</option>
							<option value="Female">Female</option>
							<option value="Other">Other</option>
							<option value="No Share">Prefer Not To Share</option>
						</select>
					</div>

					<div class="col-12 col-md-6">
						<label class="form-label">
							Filter by Partner Type </label>
						<select class="form-select form-select-sm" name="status">
							<option value="" selected>All</option>
							<option value="Full Time">Full Time</option>
							<option value="Part Time">Part Time</option>
						</select>
					</div>

					<div class="col-12 col-md-6">
						<label class="form-label">
							Filter by Salary Type </label>
						<select class="form-select form-select-sm" name="status">
							<option value="" selected>All</option>
							<option value="Daily">Daily</option>
							<option value="Monthly">Monthly</option>
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

<!-- End of Filter Modal -->


<script>

	$(document).on("click", ".edit-btn", function () {
		let employeeId = $(this).data("id");


		let rowData = $('#employees-table').DataTable().row($(this).closest("tr")).data();


		$("input[name='emp_name']").val(rowData.partner_name);
		$("input[name='emp_mobile']").val(rowData.mobile_no);
		$("input[name='emp_email']").val(rowData.email_id);
		$("select[name='emp_gender']").val(rowData.gender).trigger("change");
		$("textarea[name='emp_address']").val(rowData.address);
		$("input[name='emp_salary']").val(rowData.salary);
		$("input[name='bank_name']").val(rowData.bank_name);
		$("input[name='upi_id']").val(rowData.upi_id);
		$("input[name='ifsc_code']").val(rowData.ifsc_code);
		$("input[name='password']").val(rowData.password);
		$("input[name='emp_id']").val(employeeId);
		$("select[name='partner_type']").val(rowData.partner_type).trigger("change");
		$("select[name='outstation_services']").val(rowData.outstation_services).trigger("change");
		$("select[name='daily_services']").val(rowData.daily_services).trigger("change");
		$("input[name='salper']").val(rowData.salary_type);
		$("input[name='account_no']").val(rowData.account_no);

		$("#employee-form-action").val("update_employee");
	});

	let employeeListTable = false;
	employeeListTable = $('#employees-table').DataTable({
		lengthChange: true,
		pageLength: 10,
		data: <?php echo json_encode($partners); ?>,
		columns: [
			{ data: 'id' },
			{ data: 'partner_name' },
			{ data: 'mobile_no' },
			{ data: 'email_id' },
			{ data: 'partner_type' },
			{
				data: 'gender',
				render: function (data) {
					return data.charAt(0).toUpperCase() + data.slice(1);
				}
			},
			{ data: 'outstation_services' },
			{ data: 'daily_services' },
			{ data: 'upi_id' },
			{ data: 'bank_name' },
			{ data: 'account_no' },
			{ data: 'ifsc_code' },
			{ data: 'password' },
			{ data: 'salary_type' },
			{ data: 'salary' },
			{
				data: 'created_at',
				render: function (data) {
					return new Date(data).toLocaleDateString('en-GB');
				}
			},

			{
				data: null,
				orderable: false,
				searchable: false,
				render: function (data, type, row) {
					return `
					<div class="dropdown">
						<button class="btn btn-sm btn-white dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
							Actions
						</button>
						<ul class="dropdown-menu">
							<li><a class="dropdown-item edit-btn" href="#" data-id="${row.id}" data-bs-toggle="modal" data-bs-target="#employeeEditModal">Edit</a></li>
							<li><a class="dropdown-item text-danger delete-btn" href="#" data-id="${row.id}">Delete</a></li>
						</ul>
					</div>
				`;
				}
			}

		],
		order: [[0, 'asc']],
		initComplete: function () {
			$('.dataTables_filter').hide();
			$('.employees-table-footer').html($('#employees-table_wrapper .row:last-child()'));
			$('.dataTables_info').before($('.dataTables_length').find('label').addClass('d-inline-flex text-nowrap align-items-center gap-2'));
			$('.employees-table-search').on('input', function () {
				employeeListTable.search(this.value).draw();
			});
		},
		dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
			"<'row'<'col-sm-12'tr>>" +
			"<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
		buttons: [{
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
		}]
	});

	$(document).on("submit", "#employee-form", function (e) {
		e.preventDefault();
		let formData = $(this).serialize();

		$.ajax({
			type: "POST",
			url: "",
			data: formData,
			success: function (response) {
				console.log(response); // Log the response to see its structure
				if (response.success) {
					alert(response.message);
					$('#employeeEditModal').modal('hide');
					employeeListTable.ajax.reload();
				} else {
					alert("Error: " + response.message);
				}
			},
			error: function (xhr, status, error) {
				alert("An error occurred: " + xhr.responseText);
			}
		});

	});


	$(document).on("click", ".delete-btn", function () {
		let employeeId = $(this).data("id");

		if (confirm("Are you sure you want to delete this partner ?")) {
			$.ajax({
				type: "POST",
				url: "update_employees.php",
				data: { id: employeeId },
				success: function (response) {
					if (response.success) {
						alert(response.message);
						employeeListTable.ajax.reload();
					}
					else {
						alert("Error: " + response.message);
					}
				},
				error: function (xhr, status, error) {
					alert("An error occurred: " + xhr.responseText);
				}
			});
		}
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