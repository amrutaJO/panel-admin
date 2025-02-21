<?php
require_once __DIR__ . "/header.php";
require_once __DIR__ . "/db.php";


$sql = "SELECT * FROM all_users ";
$result = $conn->query($sql);
?>

<div class="content container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-header-title">
                    <?= translate('users') ?>
                </h1>
            </div>
        </div>
    </div>
    <!-- End Page Header -->

    <!-- Users Table Filters -->
    <div class="employees-table-filters">
        <div class="row g-3">
            <!-- Global Search -->
            <div class="col-12 col-md-3">
                <div class="input-group input-group-sm">
                    <div class="input-group-text">
                        <i class="bi-search"></i>
                    </div>
                    <input type="search" class="form-control employees-table-search" placeholder="<?= translate('search_here') ?>">
                </div>
            </div>
            <!-- User Role Filter -->
            <div class="col-12 col-md-6 offset-md-3">
                <div class="d-flex align-items-center gap-2">
                    <span class="ms-md-auto"><?= translate('user_role') ?></span>
                    <div>
                        <select class="form-select form-select-sm" onchange="userListTable.column(3).search(this.value).draw()">
                            <option value="" selected><?= translate('all') ?></option>
                            <option value="user"><?= translate('users') ?></option>
                            <option value="admin"><?= translate('admin') ?></option>
                            <option value="partner"><?= translate('partners') ?></option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Table -->
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
                <?php
                if ($result->num_rows > 0) {
                    // Output data of each row
                    $sr_no = 1;
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$sr_no}</td>";
                        echo "<td>{$row["id"]}</td>";
                        echo "<td>{$row["user_name"]}</td>";
                        echo "<td>{$row["user_role"]}</td>";
                        echo "<td>{$row["mobile_number"]}</td>";
                        echo "<td>{$row["email"]}</td>";
                        echo "</tr>";
                        $sr_no++;
                    }
                } else {
                    echo "<tr><td colspan='6'>No users found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php 
$conn->close();
require_once __DIR__ . '/footer.php'; 
?>

<!-- JavaScript to handle table functionalities -->
<script>
    let userListTable = $('#data-table').DataTable({
        lengthChange: true,
        order: [
            [1, 'desc'],
            [0, 'desc']
        ],
        initComplete: function (settings, json) {
            $('.dataTables_filter').hide();
            $('.data-table-footer').append($('#data-table_wrapper .row:last-child()')).find('.previous').addClass('ms-md-auto');
            $('.dataTables_info').before($('.dataTables_length').find('label').attr('class', 'd-inline-flex text-nowrap mb-1 align-items-center gap-2'));
            $('.data-table-search').on('input', function () {
                userListTable.search(this.value).draw();
            });
            userListTable.buttons().container().find('.btn-secondary').removeClass('btn-secondary');
            userListTable.buttons().container().appendTo($('.export-buttons'));
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



