<?php require_once __DIR__ . '/header.php'; ?>
<?php
require_once __DIR__ . "/db.php"; // Include database connection

$sql = "SELECT * FROM cancellations ORDER BY date DESC";
$result = $conn->query($sql);
?>
<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-header-title">
                    <?= translate('view_cancellations') ?>
                </h1>
            </div>
        </div>
    </div>
    
    <div class="row g-3">
        <div class="col-12 col-md-3">
            <div class="input-group input-group-sm">
                <div class="input-group-text">
                    <i class="bi-search"></i>
                </div>
                <input type="search" class="form-control billing-table-search" placeholder="<?= translate('search_here') ?>">
            </div>
        </div>
        <div class="col-12 col-md-6 offset-md-3">
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-sm btn-secondary ms-md-auto" data-bs-toggle="modal" data-bs-target="#transactionfilterModal">
                    <?= translate('filter') ?> <i class="bi bi-funnel-fill"></i>
                </button>
                <div class="export-buttons"></div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table id="data-table" class="table table-bordered table-nowrap table-align-middle">
            <thead class="thead-light" align="left">
                <tr>
                    <th>ID</th>
                    <th><?= translate('customer_name') ?></th>
                    <th><?= translate('cancellation_reason') ?></th>
                    <th><?= translate('customer_id') ?></th>
                    <th><?= translate('vehicle_id') ?></th>
                    <th><?= translate('driver_name') ?></th>
                    <th><?= translate('date') ?></th>
                    <th><?= translate('action') ?></th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['customer_name'] ?></td>
                    <td><?= $row['cancellation_reason'] ?></td>
                    <td><?= $row['customer_id'] ?></td>
                    <td><?= $row['vehicle_id'] ?></td>
                    <td><?= $row['driver_name'] ?></td>
                    <td><?= $row['date'] ?></td>
                    <td>
                        <a href="delete-cancellation.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-danger">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>        </table>
    </div>
    <div class="data-table-footer"></div>
</div>
<?php require_once __DIR__ . '/footer.php'; ?>

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
			$('.dataTables_info').before($('.dataTables_length').find('label').attr('class', 'd-inline-flex text-nowrap mb-1 align-items-center gap-2'));
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