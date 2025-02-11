<?php require_once __DIR__ . "/header.php"; ?>
<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-header-title"><?= translate('Partner Availability') ?></h1>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-12 col-md-3">
            <div class="input-group input-group-sm">
                <div class="input-group-text">
                    <i class="bi-search"></i>
                </div>
                <input type="search" id="searchInput" class="form-control customer-table-search" placeholder="Search here">
            </div>
        </div>

        <div class="table-responsive">
            <table id="customer-table" class="table table-bordered table-nowrap table-align-middle">
                <thead class="thead-light" align="left">
                    <tr>
                        <th><?= translate('Partner Id') ?></th>
                        <th><?= translate('Current Location') ?></th>
                        <th><?= translate('Status') ?></th>
                        <th><?= translate('Schedule') ?></th>
                    </tr>
                </thead>

                <tbody id="availabilityTableBody">
                    <!-- Data will be dynamically loaded here -->
                </tbody>
            </table>
        </div>
        <div class="customer-table-footer"></div>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>

<!-- jQuery for AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function loadAvailabilityData() {
        $.ajax({
            url: "fetch_availability.php",
            type: "GET",
            dataType: "json",
            success: function(response) {
                let tableBody = "";
                response.forEach(partner => {
                    tableBody += `
                        <tr>
                            <td>${partner.partnerId}</td>
                            <td>${partner.currentLocation}</td>
                            <td>${partner.status}</td>
                            <td>${partner.schedule}</td>
                        </tr>`;
                });
                $("#availabilityTableBody").html(tableBody);
            },
            error: function() {
                console.error("Error loading data");
            }
        });
    }

    $(document).ready(function() {
        loadAvailabilityData(); // Load data on page load

        // Auto-refresh every 10 seconds
        setInterval(loadAvailabilityData, 10000);
    });
</script>
