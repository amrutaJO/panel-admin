<?php 

ob_start();

require_once __DIR__ . "/header.php";
include "db.php";

if(isset($_POST['submit'])) {
	$manufacturer_name = $_POST['manufacturer_name'];
	$color = $_POST['color'];
	$model_name = $_POST['model_name'];
	$manufacturing_year = $_POST['manufacturing_year'];
	$seat_arrangement = $_POST['seat_arrangement'];

	$sql = "INSERT INTO `vehicle_master`(`manufacturer_name`, `color`, `model_name`, `manufacturing_year`, `seat_arrangement`) 
						VALUES ('$manufacturer_name','$color','$model_name','$manufacturing_year','$seat_arrangement')";

	$result = mysqli_query($conn, $sql);

	if($result) {
		header("Location: vehicle-master.php?msg=New vehicle master added!.");
		ob_end_flush();
	} else {
		echo "Vehicle master not added" . mysqli_error($conn);
	}
}

?>

<div class="content container-fluid">
	<div class="page-header">
		<div class="row align-items-center">
			<div class="col">
				<h1 class="page-header-title d-flex align-items-center gap-3">
					<!-- <a href="reports" class="link-dark"><i class="bi-arrow-left-circle-fill align-middle"></i></a> -->
					<span><?php echo translate('add_vehicle_master'); ?></span>
				</h1>
			</div>
			<div class="col-auto">
				<a class="btn btn-sm btn-primary" href="vehicle-master.php">
					<i class="bi-card-list me-1"></i>
					<?= translate('view_vehicle_master') ?>
				</a>
			</div>
		</div>
	</div>

	<form action="" method="post" class="row g-3" id="transport-form">
		<div class="col-12 col-md-6">
			<label for="" class="form-label"><?php echo translate('manufacturer_name'); ?></label>
			<input type="text" class="form-control form-control-sm" placeholder="<?php echo translate('manufacturer_name'); ?>" name="manufacturer_name" required>
		</div>
		<div class="col-12 col-md-6">
			<label for="" class="form-label"><?php echo translate('vehicle_color'); ?></label>
			<input type="text" class="form-control form-control-sm" placeholder="<?php echo translate('color'); ?>" name="color" required>
		</div>
		<div class="col-12 col-md-6">
			<label for="" class="form-label"><?php echo translate('model_name'); ?></label>
			<input type="text" class="form-control form-control-sm" placeholder="<?php echo translate('model_name'); ?>" name="model_name" required>
		</div>
		<div class="col-12 col-md-6">
			<label for="" class="form-label"><?php echo translate('manufacturing_year'); ?></label>
			<input type="number" class="form-control form-control-sm" placeholder="<?php echo translate('manufacturing_year'); ?>" name="manufacturing_year" required>
		</div>
		<div class="col-12 col-md-6">
			<label for="" class="form-label"><?php echo translate('seat_arrangement'); ?></label>
			<input type="number" class="form-control form-control-sm" placeholder="<?php echo translate('seat_arrangement'); ?>" name="seat_arrangement" required>
		</div>

        <div class="modal-footer pt-0 border-top-0">
            <button type="reset" form="transport-form" class="btn btn-sm btn-secondary"><?php echo translate('reset'); ?></button>
            <button type="submit" form="transport-form" class="btn btn-sm btn-primary ms-2" name="submit" ><?php echo translate('save'); ?></button>
        </div>
	</form>
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
				text: '<i class="bi-clipboard2-check dropdown-item-icon"></i> ' + '<?php echo translate("Copy"); ?>'
			},
			{
				extend: 'excel',
				text: '<i class="bi-filetype-xlsx dropdown-item-icon"></i> ' + '<?php echo translate("Excel"); ?>'
			},
			{
				extend: 'csv',
				text: '<i class="bi-filetype-csv dropdown-item-icon"></i> ' + '<?php echo translate("CSV"); ?>'
			},
			{
				extend: 'pdf',
				text: '<i class="bi-filetype-pdf dropdown-item-icon"></i> ' + '<?php echo translate("PDF"); ?>'
			},
			{
				extend: 'print',
				text: '<i class="bi-printer dropdown-item-icon"></i> ' + '<?php echo translate("Print"); ?>'
			}
			]
		}]
	});
</script>
