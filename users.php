<?php require_once __DIR__ . "/header.php" ?>
<div class="content container-fluid">
	<!-- Page Header -->
	<div class="page-header">
		<div class="row align-items-center">
			<div class="col">
				<h1 class="page-header-title">
					<?= translate('users') ?>
				</h1>
			</div>
			<!-- End Col -->

			<!-- End Col -->
		</div>
		<!-- End Row -->
	</div>
	<!-- End Page Header -->
	<div class="employees-table-filters">
		<div class="row g-3">
			<div class="col-12 col-md-3">
				<div class="input-group input-group-sm">
					<div class="input-group-text">
						<i class="bi-search"></i>
					</div>
					<input type="search" class="form-control employees-table-search"
						placeholder="<?= translate('search_here') ?>">
				</div>
			</div>
			<div class="col-12 col-md-6 offset-md-3">
				<div class="d-flex align-items-center gap-2">
					<span class="ms-md-auto"><?= translate('user_role') ?></span>
					<div>
						<select class="form-select form-select-sm"
							onchange="employeeListTable.column(4).search(this.value).draw()">
							<option value="" selected><?= translate('all') ?></option>
							<option value="Male"><?= translate('users') ?></option>
							<option value="Female"><?= translate('admin') ?></option>
							<option value="Other"><?= translate('partners') ?></option>
						</select>
					</div>
					<div class="export-buttons"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="table-responsive">
		<table id="data-table" class="table table-bordered table-nowrap table-align-middle">
			<thead class="thead-light" align="left">
				<tr>
					<th><?= translate('sr_no') ?></th>
					<th><?= translate('id') ?></th>
					<th><?= translate('user_name') ?></th>
					<th><?= translate('user_role') ?></th>
					<th><?= translate('mobile_number') ?></th>
					<th><?= translate('email') ?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>1</td>
					<td>001</td>
					<td>Shashikant Shirsath</td>
					<td>user</td>
					<td>9356234575</td>
					<td>abc@gmail.com</td>
				</tr>
			</tbody>
		</table>
	</div>
	<div class="employees-table-footer"></div>
</div>
<!-- End Content -->
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
			[1, 'desc'],
			[0, 'desc']
		],
		initComplete: function (settings, json) {
			$('.dataTables_filter').hide();
			$('.data-table-footer').append($('#data-table_wrapper .row:last-child()')).find('.previous').addClass('ms-md-auto');
			$('.dataTables_info').before($('.dataTables_length').find('label').attr('class', 'd-inline-flex text-nowrap mb-1 align-items-center gap-2'));
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