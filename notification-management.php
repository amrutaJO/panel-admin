<?php
require_once __DIR__ . "/db.php";  // Include the database connection
require_once __DIR__ . "/header.php";  
?>

<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-header-title d-flex align-items-center gap-3">
                    <span><?= translate('Notification Management','mr') ?></span>
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
                    <input type="search" class="form-control reports-table-search" placeholder="Search here">
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table id="data-table" class="table table-bordered table-nowrap table-align-middle">
            <thead class="thead-light" align="left">
                <tr>
                    <th><?= translate('id','mr') ?></th>
                    <th><?= translate('user id','mr') ?></th>
                    <th><?= translate('partner id','mr') ?></th>
                    <th><?= translate('status','mr') ?></th>
                    <th><?= translate('message','mr') ?></th>
                    <th><?= translate('created at ','mr') ?></th>
                    <th><?= translate('delivered at','mr') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT id, user_id, partner_id, status, message, created_at, delivered_at FROM notification_management";
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['user_id']}</td>
                            <td>{$row['partner_id']}</td>
                            <td>{$row['status']}</td>
                            <td>{$row['message']}</td>
                            <td>{$row['created_at']}</td>
                            <td>{$row['delivered_at']}</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>No notifications found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <div class="data-table-footer"></div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>

<script>
    let sowingListTable = false;
    sowingListTable = $('#data-table').DataTable({
        lengthChange: true,
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
