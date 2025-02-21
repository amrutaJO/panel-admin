<?php require_once __DIR__ . "/header.php" ?>
<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-header-title"><?= translate('Vehicle Details') ?></h1>
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
                        <th>Vehicle Make</th>
                        <th>Vehicle Model</th>
                        <th>Year</th>
                        <th>License Plate Number</th>
                        <th>Insurance Details</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be loaded here dynamically via JavaScript -->
                </tbody>
            </table>
        </div>
        <div class="customer-table-footer"></div>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php' ?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fetch data from the server (get_vehicle_details.php)
        fetch('get_vehicle_details.php')
            .then(response => response.json())
            .then(data => {
                const tableBody = document.querySelector('#customer-table tbody');
                tableBody.innerHTML = ''; // Clear existing table rows

                // Loop through the data and add each row to the table
                data.forEach(row => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${row.partnerId}</td>
                        <td>${row.vehicleMake}</td>
                        <td>${row.vehicleModel}</td>
                        <td>${row.year}</td>
                        <td>${row.licensePlateNumber}</td>
                        <td>${row.insuranceDetails}</td>
                    `;
                    tableBody.appendChild(tr);
                });
            })
            .catch(error => console.error('Error fetching vehicle details:', error));
    });
</script>
