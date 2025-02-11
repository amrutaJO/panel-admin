<?php 

ob_start();

require_once __DIR__ . "/header.php";
include "db.php";

// update vehicle master
if(isset($_POST['update_vehicle'])) {
    $id = $_POST['id'];
	$manufacturer_name = $_POST['manufacturer_name'];
	$color = $_POST['color'];
	$model_name = $_POST['model_name'];
	$manufacturing_year = $_POST['manufacturing_year'];
	$seat_arrangement = $_POST['seat_arrangement'];
    $status = $_POST['status'];

	$sql = "UPDATE `vehicle_master` SET `manufacturer_name`='$manufacturer_name',`color`='$color',
            `model_name`='$model_name',`manufacturing_year`='$manufacturing_year',
			`seat_arrangement`='$seat_arrangement', `status`='$status' WHERE id = $id";

	$result = mysqli_query($conn, $sql);

	if($result) {
		header("Location: vehicle-master.php");
		ob_end_flush();
	} else {
		echo "Vehicle master not updated! " . mysqli_error($conn);
	}
}


?>
<div class="content container-fluid">
	<div class="page-header">
		<div class="row align-items-center">
			<div class="col">
				<h1 class="page-header-title d-flex align-items-center gap-3">
					<!-- <a href="reports" class="link-dark"><i class="bi-arrow-left-circle-fill align-middle"></i></a> -->
					<span><?= translate('view_vehicle_master') ?></span>
				</h1>
			</div>
			<!-- <div class="col-auto">
				<a class="btn btn-sm btn-primary" href="javascript:void(0)" onclick="addTransport()">
					<i class="bi-plus-circle me-1"></i>
					<?= translate('Add_Vehicle_Master') ?> </a>
			</div> -->
		</div>
	</div>

	<!-- Search Bar -->
    <div class="reports-table-filters">
    <div class="row g-3">
        <div class="col-12 col-md-3">
            <div class="input-group input-group-sm">
                <div class="input-group-text">
                  <i class="bi-search"></i>
                </div>
                    <input type="search" class="form-control reports-table-search" id="search-input"
					 placeholder="<?= translate('search_here') ?>">
                </div>
            </div>  
        </div>
    </div>

	<div class="table-responsive">
		<table id="data-table" class="table table-bordered table-nowrap table-align-middle">
			<thead class="thead-light " align="left">
				<tr>
					<th><?= translate('sr_no') ?></th>
					<th><?= translate('manufacturer_name') ?></th>
					<th><?= translate('color') ?></th>
					<th><?= translate('model_name') ?></th>
					<th><?= translate('manufacturing_year') ?></th>
					<th><?= translate('seating_arrangement') ?></th>
					<th><?= translate('status') ?></th>
					<th><?= translate('action') ?></th>
				</tr>
			</thead>
			<tbody>

				<?php 
					$count = 1;

					$sql = "SELECT * FROM `vehicle_master`";
					$result = mysqli_query($conn, $sql);
					while($row = mysqli_fetch_assoc($result)) {
						?>
							<tr class="odd">
							  	<td> <?php echo $count++; ?> </td>
								<td> <?php echo $row['manufacturer_name'] ?> </td>
								<td> <?php echo $row['color'] ?> </td>
								<td> <?php echo $row['model_name'] ?> </td>
								<td> <?php echo $row['manufacturing_year'] ?> </td>
								<td> <?php echo $row['seat_arrangement'] ?> </td>
								<td> <?php echo $row['status'] ?> </td>
								<td>
									<div class="dropdown">
										<button class="btn btn-sm btn-white dropdown-toggle" 
											type="button" data-bs-toggle="dropdown"
											aria-expanded="false">
											<?= translate('actions') ?>
										</button>
										<ul class="dropdown-menu">
                                        	<li><a class="dropdown-item" href="javascript:void(0)" 
											 onclick="editDocument(<?php echo $row['id']; ?>, '<?php echo $row['manufacturer_name']; ?>',
											 '<?php echo $row['color']; ?>', '<?php echo $row['model_name']; ?>', 
											 '<?php echo $row['manufacturing_year']; ?>','<?php echo $row['seat_arrangement']; ?>',
											 '<?php echo $row['status']; ?>')"> <?= translate('edit') ?> 
											</a></li>
											<li><a class="dropdown-item" href="delete-vehicle-master.php?id=<?php echo $row['id'] ?>">
												 <?= translate('delete') ?> 
											</a></li>
											<li><a class="dropdown-item" href="decline-vehicle-master.php?id=<?php echo $row['id'] ?>">
												 <?= translate('decline') ?> 
											</a></li>
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

<!-- View/Edit Modal -->
<div class="modal fade" id="vehicleModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="vehicleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"> <?= translate('edit_vehicle_master') ?> </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="vehicleForm">  
                    <input type="hidden" id="id" name="id">
                    
                    <div class="col-12 mb-2">
						<label for="" class="form-label mb-0"><?= translate('manufacturer_name') ?></label>
						<input type="text" class="form-control form-control-sm" id="manufacturer_name" name="manufacturer_name" required>
					</div>
					<div class="row">
						<div class="col-6 mb-2">
							<label for="" class="form-label mb-0"><?= translate('color') ?></label>
							<input type="text" class="form-control form-control-sm" id="color" name="color" required>
						</div>
						<div class="col-6 mb-2">
							<label for="" class="form-label mb-0"><?= translate('model_name') ?></label>
							<input type="text" class="form-control form-control-sm" id="model_name" name="model_name" required>
						</div>
					</div>
					<div class="row">
						<div class="col-6 mb-2">
							<label for="" class="form-label mb-0"><?= translate('manufacturing_year') ?></label>
							<input type="number" class="form-control form-control-sm" id="manufacturing_year" name="manufacturing_year" required>
						</div>
						<div class="col-6 mb-2">
							<label for="" class="form-label mb-0"><?= translate('seat_arrangement') ?></label>
							<input type="number" class="form-control form-control-sm" id="seat_arrangement" name="seat_arrangement" required>
						</div>
					</div>
					<div class="col-12 mb-2">
                        <label class="form-label mb-0"><?= translate('status') ?></label>
                        <select class="form-select" id="status" name="status">
                            <option value="active"><?= translate('active') ?></option>
                            <option value="declined"><?= translate('declined') ?></option>
                        </select>
                    </div>
                    <div class="modal-footer p-0 border-top-0">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal"><?= translate('close') ?></button>
                        <button type="submit" name="update_vehicle" class="btn btn-sm btn-primary" id="updateBtn"><?= translate('update') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function editDocument(id, manufacturer_name, color, model_name, manufacturing_year, seat_arrangement, status) {
    document.getElementById('id').value = id;
    document.getElementById('manufacturer_name').value = manufacturer_name;
    document.getElementById('color').value = color;
    document.getElementById('model_name').value = model_name;
	document.getElementById("manufacturing_year").value = manufacturing_year;
	document.getElementById('seat_arrangement').value = seat_arrangement;
	document.getElementById('status').value = status;
    
    $('#vehicleModal').modal('show');
}
</script>


<?php require_once __DIR__ . '/footer.php' ?>

<script>
	let table = $('#data-table').DataTable({
        lengthChange: true,
        order: [
            [1, 'desc'],
            [0, 'desc']
        ],
		initComplete: function (settings, json) {
            $('.dataTables_filter').hide();
            $('.data-table-footer').append($('#data-table_wrapper .row:last-child()'))
                .find('.previous').addClass('ms-md-auto');
            $('.dataTables_info').before($('.dataTables_length').find('label')
                .attr('class', 'd-inline-flex text-nowrap mb-1 align-items-center gap-2'));

            // Custom search input event
            $('#search-input').on('input', function () {
                table.search(this.value).draw(); // Dynamically filter table data
            });
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