<?php require_once __DIR__ . "/header.php" ?>
<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-header-title"><?= translate('Partner Earnings') ?></h1>
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
                        <th>Partner Id</th>
                        <th>Fare Amount</th>
                        <th>Commission</th>
                        <th>Bonus</th>
                        <th>Tips</th>
                    </tr>
                </thead>
                <tbody id="earning-table-body">
                    <!-- Data will be populated dynamically -->
                </tbody>
            </table>
        </div>
        <div class="customer-table-footer"></div>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php' ?>

<script>
// Function to load the earnings data
function loadEarningsData() {
    fetch('fetch-earnings.php')  // Call the backend PHP file
        .then(response => response.json())  // Parse the JSON response
        .then(data => {
            const tableBody = document.getElementById('earning-table-body');
            tableBody.innerHTML = '';  // Clear the existing table data

            data.forEach(row => {
                // Create a new row
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${row.partnerId}</td>
                    <td>₹${row.fareAmount}</td>
                    <td>₹${row.commission}</td>
                    <td>₹${row.bonus}</td>
                    <td>₹${row.tips}</td>
                `;
                tableBody.appendChild(tr);  // Add the new row to the table
            });
        })
        .catch(error => {
            console.error('Error fetching data:', error);
        });
}

// Load earnings data when the page loads
document.addEventListener('DOMContentLoaded', loadEarningsData);
</script>
