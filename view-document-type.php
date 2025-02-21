<?php 

ob_start();

require_once __DIR__ . "/header.php"; 
include "db.php";

// Update Document Type
if(isset($_POST['update_document'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    
    // Check if a new file is uploaded
    if (!empty($_FILES['preview_image']['name'])) {
        $file_name = $_FILES['preview_image']['name'];
        $tempname = $_FILES['preview_image']['tmp_name'];
        $folder = 'images/' . $file_name;
        
        // Move the uploaded file
        if (move_uploaded_file($tempname, $folder)) {
            // Update query with preview image
            $sql = "UPDATE `document_types` SET `name`='$name', `description`='$description', `status`='$status', `preview_image`='$file_name' WHERE `id`='$id'";
        } else {
            echo "Error uploading the file!";
            exit;
        }
    } else {
        // Update query without preview image
        $sql = "UPDATE `document_types` SET `name`='$name', `description`='$description', `status`='$status' WHERE `id`='$id'";
    }
    
    if (mysqli_query($conn, $sql)) {
        header("Location: view-document-type.php"); 
        ob_end_flush();
    } else {
        header("Location: view-document-type.php?error=" . mysqli_error($conn)); // Redirect with error message
        exit();
    }
    
}

?>
<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-header-title d-flex align-items-center gap-3">
                    <span><?= translate('document_management')?></span>
                </h1>
            </div>
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
                    <input type="search" class="form-control reports-table-search" id="search-input" placeholder="<?= translate('search_here') ?>">
                </div>
            </div>  
        </div>
    </div>
    
    <div class="table-responsive">
        <table id="data-table" class="table table-bordered table-nowrap table-align-middle">
            <thead class="thead-light " align="left">
                <tr>    
                    <th><?= translate('sr_no')?></th>
                    <th><?= translate('id')?></th>
                    <th><?= translate('name')?></th>
                    <th><?= translate('created')?></th>
                    <th><?= translate('status')?></th>
                    <th><?= translate('action')?></th>
                </tr>
            </thead>
            <tbody>

            <?php 
                $count = 1;
                $sql = "SELECT * FROM `document_types`";
                $result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <tr class="odd">
                            <td> <?php echo $count++; ?> </td>
                            <td> <?php echo $row['id'] ?> </td>
                            <td> <?php echo $row['name'] ?> </td>
                            <td> <?php echo date('d-m-Y', strtotime($row['created_at'])); ?> </td>
                            <td> <?php echo $row['status'] ?> </td>
                            <td>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-white dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"> <?php echo translate('action') ?> </button>
                                    <ul class="dropdown-menu">
                                        <!-- <li><a class="dropdown-item" href="javascript:void(0)" onclick="editDocument(<?php echo $row['id']; ?>, '<?php echo $row['description']; ?>', '<?php echo $row['preview_image']; ?>', '<?php echo $row['name']; ?>', '<?php echo $row['status']; ?>', 'view')"> <?php echo translate('view') ?> </a></li> -->
                                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="editDocument(<?php echo $row['id']; ?>, '<?php echo $row['description']; ?>', '<?php echo $row['preview_image']; ?>', '<?php echo $row['name']; ?>', '<?php echo $row['status']; ?>')"> <?php echo translate('edit') ?> </a></li>
                                        <li><a class="dropdown-item" href="delete-document-type.php?id=<?php echo $row['id'] ?>"> <?php echo translate('delete') ?> </a></li>
                                        <li><a class="dropdown-item" href="decline-document-type.php?id=<?php echo $row['id'] ?>"> <?php echo translate('decline') ?> </a></li>
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
<div class="modal fade" id="documentModal" tabindex="-1" data-bs-backdrop="static" aria-labelledby="documentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle"> <?php echo translate('edit_document_types') ?> </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" enctype="multipart/form-data" id="documentForm">  
                    <input type="hidden" id="id" name="id">
                    
                    <div class="col-12 mb-2">  
                        <label class="form-label mb-0"><?php echo translate('document_name') ?></label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    
                    <div class="col-12 mb-2">
                        <label class="form-label mb-0"><?php echo translate('upload_preview_image') ?></label>
                        <input class="form-control form-control-sm" type="file" id="preview_image" name="preview_image" onchange="previewNewImage(event)">
                        <img id="preview_image_display" src="" alt="Preview Image" style="max-width: 100%; height:100px; margin-top: 5px; display: none;">
                    </div>
                    
                    <div class="col-12 mb-2"> 
                        <label class="form-label mb-0"><?php echo translate('description') ?></label>
                        <textarea class="form-control form-control-sm" name="description" id="description" placeholder="Description" style="height: 100px" required></textarea>    
                    </div>
                    
                    <div class="col-12 mb-2"> 
                        <label class="form-label mb-0"><?php echo translate('status') ?></label>
                        <select class="form-select" id="status" name="status">
                            <option value="active">Active<?php echo translate('active') ?></option>
                            <option value="declined"><?php echo translate('declined') ?></option>
                        </select>
                    </div>

                    <div class="modal-footer p-0 border-top-0">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal"><?php echo translate('close') ?></button>
                        <button type="submit" name="update_document" class="btn btn-sm btn-primary" id="updateBtn"><?php echo translate('update') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function editDocument(id, description, preview_image, name, status) {
    document.getElementById('id').value = id;
    document.getElementById('name').value = name;
    document.getElementById('status').value = status;
    document.getElementById('description').value = description;

    // Display existing image preview
    if (preview_image) {
        document.getElementById('preview_image_display').src = 'images/' + preview_image;
        document.getElementById('preview_image_display').style.display = 'block';
    } else {
        document.getElementById('preview_image_display').style.display = 'none';
    }

    $('#documentModal').modal('show');
}

// if another image selected then showing that
function previewNewImage(event) {
    let reader = new FileReader();
    reader.onload = function() {
        let output = document.getElementById('preview_image_display');
        output.src = reader.result;  // Showing new selected image
        output.style.display = 'block';
    };
    reader.readAsDataURL(event.target.files[0]); // Reading selected file
};


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