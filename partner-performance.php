<?php require_once __DIR__ . "/header.php" ?>
<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-header-title"><?= translate('Partner Performance') ?></h1>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-12 col-md-3">
            <div class="input-group input-group-sm">
                <div class="input-group-text">
                    <i class="bi-search"></i>
                </div>
                <input type="search" class="form-control customer-table-search" placeholder="Search here">
            </div>
        </div>

        <div class="table-responsive">
            <table id="customer-table" class="table table-bordered table-nowrap table-align-middle">
                <thead class="thead-light" align="left">
                    <tr>
                        <th>Partner id</th>
                        <th>Driver Name</th>
                        <th>Completion Rate (%)</th>
                        <th>Cancellation Rate (%)</th>
                        <th>Average Rating</th>
                        <th>Customer Feedback</th>
                    </tr>
                </thead>
                <tbody id="performance-table-body">
                    <!-- Data will be populated here -->
                </tbody>
            </table>
        </div>
        <div class="customer-table-footer"></div>
    </div>
</div>

<script>
// Fetch performance data and update the table dynamically
function loadPerformanceData() {
    fetch('get_performance.php') // Fetch data from the backend PHP file
        .then(response => response.json())
        .then(data => {
            const tableBody = document.getElementById('performance-table-body');
            tableBody.innerHTML = ''; // Clear the table before adding new data

            // Loop through the data and add rows to the table
            data.forEach(row => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${row.partnerId}</td>
                    <td>${row.driverName}</td>
                    <td>${row.completionRate}</td>
                    <td>${row.cancellationRate}</td>
                    <td>${row.averageRating}</td>
                    <td>${row.customerFeedback}</td>
                `;
                tableBody.appendChild(tr);
            });
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
}

// Load the data when the page is ready
document.addEventListener('DOMContentLoaded', loadPerformanceData);
</script>

<?php require_once __DIR__ . '/footer.php' ?>
