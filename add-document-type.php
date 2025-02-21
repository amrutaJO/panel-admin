<?php 

ob_start();

require_once __DIR__ . "/header.php";
include "db.php";

if(isset($_POST['submit'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];

    // File upload variables
    $file_name = $_FILES['preview_image']['name'];
    $tempname = $_FILES['preview_image']['tmp_name'];
    $folder = 'C:\xampp1\htdocs\panel-admin-paarsh\panel-admin\assets\img' . $file_name;

    // SQL Query to insert into the database
    $sql = "INSERT INTO `document_types`(`name`, `preview_image`, `description`) 
            VALUES ('$name', '$file_name', '$description')";

    mysqli_query($conn, $sql);
    if (move_uploaded_file($tempname, $folder)) {
        header("Location: view-document-type.php?msg=Document type added!");
        ob_end_flush();
    } else {
        echo "Error uploading the file!";
    }
}
?>

<div class="content container-fluid">
	<div class="page-header">
		<div class="row align-items-center">
			<div class="col">
				<h1 class="page-header-title d-flex align-items-center gap-3">
					<!-- <a href="reports" class="link-dark"><i class="bi-arrow-left-circle-fill align-middle"></i></a> -->
					<span> <?= translate('add_document_type')  ?> </span>
				</h1>
			</div>
			<div class="col-auto">
				<a class="btn btn-sm btn-primary" href="view-document-type.php">
					<i class="bi-card-list me-1"></i>
					<?= translate('see_document_types') ?> </a>
			</div>
		</div>
	</div>

	<form action="" method="post" class="row g-3" id="transport-form" enctype="multipart/form-data">
		<div class="col-12 col-md-6">

			<label for="" class="form-label"> <?= translate('document_name') ?> </label>
			<input type="text" class="form-control form-control-sm" name="name" placeholder="<?= translate('name') ?>" required>

		</div>
		<div class="col-12 col-md-6">

			<label for="formFileMultiple" class="form-label"> <?= translate('upload_preview_image') ?> </label>
            <input class="form-control form-control-sm" type="file" id="formFileMultiple" name="preview_image" multiple required>

		</div>
		<div class="col-12 col-md-6">

			<label for="" class="form-label"> <?= translate('description') ?> </label>
            <textarea class="form-control form-control-sm" name="description" placeholder="<?= translate('description') ?>" id="floatingTextarea2" style="height: 100px" required></textarea>
			
		</div>

        <div class="modal-footer pt-0 border-top-0">
            <button type="reset" form="user-form" class="btn btn-sm btn-secondary"> <?= translate('reset') ?></button>
            <button type="submit" name="submit" class="btn btn-sm btn-primary ms-2"> <?= translate('save') ?> </button>
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