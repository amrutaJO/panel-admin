<?php require_once __DIR__ . "/header.php"; ?>
<?php require_once __DIR__ . "/db.php"; ?>
<head><!-- Load jQuery First -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Load DataTables JavaScript -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<style>
    /* Style the filter button */
.filter-btn {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 16px;
    font-size: 14px;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
    margin-bottom:10px;
}

.filter-btn:hover {
    background-color: #0056b3;
}

/* Date Filter Box */
.date-filter-container {
    position: relative;
    top: 6px;  /* Position below the button */
    right: 10px;
    background: white;
    border-radius: 8px;
    padding: 15px;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    width: 250px;
    display: none;  /* Hidden by default */
    flex-direction: column;
    gap: 10px;
    z-index: 1000;
}

/* Labels */
.date-filter-container label {
    font-size: 14px;
    font-weight: bold;
    margin-bottom: 5px;
}

/* Inputs */
.date-filter-container input {
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
    outline: none;
    width: 100%;
}

/* Buttons inside the box */
.filter-buttons {
    display: flex;
    justify-content: space-between;
    margin-top: 10px;
}

.filter-buttons button {
    padding: 8px 12px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
}

#applyDateFilter {
    background-color: #28a745;
    color: white;
}

#applyDateFilter:hover {
    background-color: #218838;
}

#clearDateFilter {
    background-color: #dc3545;
    color: white;
}

#clearDateFilter:hover {
    background-color: #c82333;
}

/* Show the box when active */

</style>
</head>

<div class="content container-fluid">
	<div class="page-header">
		<div class="row align-items-center">
			<div class="col">
				<h1 class="page-header-title d-flex align-items-center gap-3">
					<span><?= translate('Wallet Payments', 'mr') ?></span>
				</h1>
			</div>
		</div>
	</div>
    <button id="toggleFilter" class="filter-btn">
    <i class="bi bi-funnel"></i> Filter by Date
</button>

<!-- Date Filter Box (Initially Hidden) -->
<div class="date-filter-container">
    <label for="startDate">Start Date:</label>
    <input type="date" id="startDate">
    
    <label for="endDate">End Date:</label>
    <input type="date" id="endDate">
    
    <div class="filter-buttons">
        <button id="applyDateFilter">Apply</button>
        <button id="clearDateFilter">Clear</button>
    </div>
</div>

	<div class="reports-table-filters">
    <div class="row g-3">
        <div class="col-12 col-md-6 d-flex align-items-center gap-2 search-bar-container">
            <div class="input-group input-group-sm">
                <div class="input-group-text">
                    <i class="bi-search"></i>
                </div>
                <input type="search" class="form-control reports-table-search" placeholder="<?= translate('Search here', 'mr') ?>">
            </div>
        </div>
    </div>
</div>


	<div class="table-responsive">
		<table id="data-table" class="table table-bordered table-nowrap table-align-middle">
			<thead class="thead-light " align="left">
				<tr>
					<th><?= translate('sr_no', 'mr') ?></th>
					<th><?= translate('Passenger Name', 'mr') ?></th>
					<th><?= translate('Title', 'mr') ?></th>
					<th><?= translate('Payment ID', 'mr') ?></th>
					<th><?= translate('Payment Mode', 'mr') ?></th>
					<th><?= translate('Total Amount', 'mr') ?></th>
					<th><?= translate('Paid At', 'mr') ?></th>
					<th><?= translate('Actions', 'mr') ?></th>
				</tr>
			</thead>
			<tbody>
    <?php
    $sql = "SELECT id, passenger_name, title, payment_id, payment_mode, total_amount, paid_at FROM wallet_payments"; // Change table name as per DB
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $sr_no = 1;
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $sr_no . "</td>";
            echo "<td>" . htmlspecialchars($row['passenger_name']) . "</td>";
            echo "<td>" . htmlspecialchars($row['title']) . "</td>";
            echo "<td>" . htmlspecialchars($row['payment_id']) . "</td>";
            echo "<td>" . htmlspecialchars($row['payment_mode']) . "</td>";
            echo "<td class='total-amount'>" . htmlspecialchars($row['total_amount']) . "</td>";
            echo "<td>" . htmlspecialchars($row['paid_at']) . "</td>";
            echo "<td>
                <div class='dropdown'>
                    <button class='btn btn-sm btn-white dropdown-toggle' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                        " . translate('Actions', 'mr') . "
                    </button>
                    <ul class='dropdown-menu'>
                        <li><a class='dropdown-item' href='transactions.php'>" . translate('Transactions', 'mr') . "</a></li>
                        <li><a class='dropdown-item' href='#'>" . translate('Redeems', 'mr') . "</a></li>
                    </ul>
                </div>
            </td>";
            echo "</tr>";
            $sr_no++;
        }
    } else {
        echo "<tr><td colspan='8' class='text-center'>No payments found</td></tr>";
    }
    ?>
</tbody>

		</table>
	</div>

<script>

$(document).ready(function () {
    let sowingListTable = initDataTable();  // Initialize DataTable
    initDataTableButtons(sowingListTable);  // Initialize Export Buttons

    // Attach search functionality
    $('.reports-table-search').on('keyup', function () {
        sowingListTable.search(this.value).draw();
    });
});

// Function to initialize DataTable
function initDataTable() {
    return $('#data-table').DataTable({
        lengthChange: true,
        order: [[0, 'asc']], // Sort by Sr. No.
        initComplete: function () {
            
        $('.data-table-footer')
            .append($('#data-table_wrapper .row:last-child()'))
            .find('.previous')
            .addClass('ms-md-auto');

        $('.dataTables_info')
            .before($('.dataTables_length label')
            .addClass('d-inline-flex text-nowrap align-items-center gap-2'));
            $('.dataTables_filter').hide(); // Hide default search
        }
    });
}

// Function to handle export buttons
function initDataTableButtons(table) {
    let buttons = new $.fn.dataTable.Buttons(table, {
        buttons: [
            {
                extend: 'collection',
                text: '<i class="bi bi-cloud-download-fill"></i> Export',
                className: 'btn btn-primary btn-sm dropdown-toggle',
                attr: { id: 'export-btn' },
                buttons: [
                    { extend: 'copy', text: '<i class="bi-clipboard2-check"></i> Copy' },
                    { extend: 'excel', text: '<i class="bi-filetype-xlsx"></i> Excel' },
                    { extend: 'csv', text: '<i class="bi-filetype-csv"></i> CSV' },
                    { extend: 'pdf', text: '<i class="bi-filetype-pdf"></i> PDF' },
                    { extend: 'print', text: '<i class="bi-printer"></i> Print' }
                ]
            }
        ]
    }).container().appendTo($('.search-bar-container')); // Move button next to search bar
}


document.addEventListener("DOMContentLoaded", function () {
    let filterBox = document.querySelector(".date-filter-container");
    let toggleBtn = document.getElementById("toggleFilter");

    // Toggle filter box visibility
    toggleBtn.addEventListener("click", function (event) {
        event.stopPropagation(); // Prevent event bubbling
        filterBox.style.display = filterBox.style.display === "flex" ? "none" : "flex";
    });

    // Close filter when clicking outside
    document.addEventListener("click", function (event) {
        if (!toggleBtn.contains(event.target) && !filterBox.contains(event.target)) {
            filterBox.style.display = "none";
        }
    });
});


$(document).ready(function () {
    let table = $('#data-table').DataTable();

    $('#applyDateFilter').click(function () {
        let startDate = $('#startDate').val();
        let endDate = $('#endDate').val();

        table.draw(); // Redraw table with new filter
    });

    $('#clearDateFilter').click(function () {
        $('#startDate, #endDate').val('');
        table.draw(); // Reset filter
        $(".date-filter-container").hide(); // Hide the box

    });

    $.fn.dataTable.ext.search.push(function (settings, data) {
        let tableDate = data[5]; // Adjust based on column index of 'last_updated'
        let tableDateParsed = new Date(tableDate).getTime();
        
        let start = new Date($('#startDate').val()).getTime();
        let end = new Date($('#endDate').val()).getTime();

        if (!start && !end) return true; // Show all if no filter is selected
        if (!tableDateParsed) return false; // Skip invalid dates

        return (!start || tableDateParsed >= start) && (!end || tableDateParsed <= end);
    });
});


</script>
	<div class="data-table-footer"></div>
</div>
<?php require_once __DIR__ . '/footer.php'; ?>

