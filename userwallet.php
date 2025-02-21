
<?php
require_once __DIR__ . "/header.php";
require_once __DIR__ . "/db.php";
?>
<head>
<!-- jQuery (Always Load First) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Moment.js (Required for Date Formatting) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

<!-- Daterangepicker JS -->
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<!-- Daterangepicker CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<style>.drp-calendar .year-box {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    padding: 10px;
    max-width: 500px;
    background: white;
    border: 1px solid #ddd;
    border-radius: 5px;
}

.drp-calendar .year-box span {
    width: 45px;
    margin: 5px;
    padding: 5px;
    text-align: center;
    cursor: pointer;
    border-radius: 4px;
    background: #f8f9fa;
    transition: background 0.2s;
}

.drp-calendar .year-box span:hover {
    background: #007bff;
    color: white;
}
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
					<span><?= translate('user_wallets', 'mr') ?></span>
				</h1>
			</div>
		</div>
	</div>
        <!-- Filter Button -->
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
			<div class="col-12 col-md-6 d-flex align-items-center gap-2 search-bar-container" >
				<div class="input-group input-group-sm">
					<div class="input-group-text">
						<i class="bi-search"></i>
					</div>
					<input type="search" class="form-control reports-table-search" placeholder="<?= translate('search_here', 'mr') ?>">
				</div>
			</div>
		</div>
	</div>


	<!-- Table -->
	<div class="table-responsive">
        <table id="data-table" class="table table-bordered table-nowrap table-align-middle">
            <thead class="thead-light" align="left">
                <tr>
                    <th><?= translate('sr_no', 'mr') ?></th>
                    <th><?= translate('user_name', 'mr') ?></th>
                    <th><?= translate('total_amount', 'mr') ?></th>
                    <th><?= translate('remaining_amount', 'mr') ?></th>
                    <th><?= translate('used_amount', 'mr') ?></th>
                    <th><?= translate('last_updated', 'mr') ?></th>
                    <th><?= translate('actions', 'mr') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM user_wallets ORDER BY id ASC";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    $sr_no = 1;
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr data-id='" . $row['id'] . "'>
                            <td>" . $sr_no++ . "</td>
                            <td>" . htmlspecialchars($row['user_name']) . "</td>
                            <td class='total-amount'>" . htmlspecialchars($row['total_amount']) . "</td>
                            <td class='remaining-amount'>" . htmlspecialchars($row['remaining_amount']) . "</td>
                            <td class='used-amount'>" . htmlspecialchars($row['used_amount']) . "</td>
                            <td>" . htmlspecialchars($row['last_updated']) . "</td>
                            <td>
                                <div class='dropdown'>
                                    <button class='btn btn-sm btn-white dropdown-toggle' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                                        " . translate('actions', 'mr') . "
                                    </button>
                                    <ul class='dropdown-menu'>
                                        <li><a class='dropdown-item' href='transactions.php'>" . translate('transactions', 'mr') . "</a></li>
                                        <li><a class='dropdown-item' href='#'>" . translate('redeems', 'mr') . "</a></li>
                                        <li><a class='dropdown-item add-amount' href='#'>" . translate('add_amount', 'mr') . "</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>" . translate('no_data_available', 'mr') . "</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
	</div>
	<!-- Bootstrap Modal -->
<div class="modal fade" id="addAmountModal" tabindex="-1" aria-labelledby="addAmountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addAmountModalLabel">Add Amount</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addAmountForm">
                    <input type="hidden" id="userId">
                    <div class="mb-3">
                        <label for="amountInput" class="form-label">Enter Amount</label>
                        <input type="number" class="form-control" id="amountInput" min="1" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Amount</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="export-buttons mb-3"></div>

	<script>
$(document).ready(function () {
    let sowingListTable = initDataTable(); // Initialize DataTable
    initDataTableButtons(sowingListTable); // Initialize Export Buttons

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
    }).container().appendTo($('.search-bar-container')); // Proper placement
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



$(document).ready(function () {
    let selectedRow;

    $(".add-amount").click(function () {
        selectedRow = $(this).closest("tr"); // Get the selected row
        let userId = selectedRow.data("id"); // Get user ID

        $("#userId").val(userId); // Store user ID in modal form
        $("#amountInput").val(""); // Clear previous value
        $("#addAmountModal").modal("show"); // Show modal
    });

    // Handle form submission
    $("#addAmountForm").submit(function (e) {
        e.preventDefault();

        let userId = $("#userId").val();
        let addAmount = parseFloat($("#amountInput").val());

        if (!addAmount || addAmount <= 0) {
            alert("Please enter a valid amount.");
            return;
        }

        let totalAmountCell = selectedRow.find(".total-amount");
        let remainingAmountCell = selectedRow.find(".remaining-amount");

        let newTotal = parseFloat(totalAmountCell.text()) + addAmount;
        let newRemaining = parseFloat(remainingAmountCell.text()) + addAmount;

        // AJAX Request
        $.ajax({
            url: "update_wallet.php",
            type: "POST",
            data: { user_id: userId, total_amount: newTotal, remaining_amount: newRemaining },
            success: function (response) {
                console.log("Database updated:", response);
                totalAmountCell.text(newTotal);
                remainingAmountCell.text(newRemaining);
                $("#addAmountModal").modal("hide"); // Hide modal
            },
            error: function () {
                alert("Failed to update database.");
            }
        });
    });
});

</script>
</body>

	<div class="data-table-footer"></div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>

