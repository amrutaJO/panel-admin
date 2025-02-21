<?php require_once __DIR__ . "/header.php" ?>
<div class="content container-fluid">
	<div class="page-header">
		<div class="row align-items-center">
			<div class="col">
				<h1 class="page-header-title d-flex align-items-center gap-3">
					<a href="reports" class="link-dark"><i class="bi-arrow-left-circle-fill align-middle"></i></a>
					<span><?= translate('dispatch_dpt')?></span>
				</h1>
			</div>
			<div class="col-auto">
				<a class="btn btn-sm btn-primary" href="javascript:void(0)" onclick="addDispatch()">
					<i class="bi-plus-circle me-1"></i>
					Add New </a>
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
					<input type="search" class="form-control reports-table-search" placeholder="Search here">
				</div>
			</div>

		</div>
	</div>
	<div class="table-responsive">
		<table id="data-table" class="table table-bordered table-nowrap table-align-middle">
			<thead class="thead-light " align="left">
				<tr>
					<th><?= translate('sr_no')?></th>
					<th><?= translate('date')?></th>
					<th><?= translate('bill_no')?></th>
					<th><?= translate('farmer_name')?></th>
					<th><?= translate('address')?></th>
					<th><?= translate('taluka')?></th>
					<th><?= translate('mobile_no')?></th>
					<th><?= translate('crop')?></th>
					<th><?= translate('variety')?></th>
					<th><?= translate('tray_size')?></th>
					<th><?= translate('qty')?></th>
					<th><?= translate('batch_no')?></th>
					<th><?= translate('sale_type')?></th>
					<th><?= translate('vehicle_no')?></th>
					<th><?= translate('payment_type')?></th>
					<th><?= translate('remark')?></th>
					<th><?= translate('extra_tray')?></th>
					<th><?= translate('loaded_tray')?></th>
				</tr>
			</thead>
			<tbody>
				<tr class="odd">
					<td>1</td>
					<td>18 Apr 2023</td>
					<td>5</td>
					<td>pandu</td>
					<td>dindori</td>
					<td>dindori</td>
					<td>+91-7789765565</td>
					<td>Flower</td>
					<td>Saint</td>
					<td>125</td>
					<td>200</td>
					<td>1522/24 weak</td>
					<td>D5</td>
					<td>Self</td>
					<td>Cash</td>
					<td>Remark</td>
					<td>5</td>
					<td>24</td>
				</tr>
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
			[1, 'desc'],
			[0, 'desc']
		],
		initComplete: function(settings, json) {
			$('.dataTables_filter').hide();
			$('.data-table-footer').append($('#data-table_wrapper .row:last-child()')).find('.previous').addClass('ms-md-auto');
			$('.dataTables_info').before($('.dataTables_length').find('label').attr('class', 'd-inline-flex text-nowrap align-items-center gap-2'));
			$('.data-table-search').on('input', function() {
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