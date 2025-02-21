<?php require_once __DIR__ . "/header.php"; ?>
<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-header-title"><?= translate('Partner Details') ?></h1>
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
                        <th><?= translate('User Name') ?></th>
                        <th><?= translate('Mobile No') ?></th>
                        <th><?= translate('Email') ?></th>
                        <th><?= translate('License No.') ?></th>
                        <th><?= translate('Vehicle Type') ?></th>
                        <th><?= translate('Vehicle Color') ?></th>
                    </tr>
                </thead>

                <tbody id="partnerTableBody">
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
    function loadPartnerData() {
        $.ajax({
            url: "fetch_partners.php",
            type: "GET",
            dataType: "json",
            success: function(response) {
                let tableBody = "";
                response.forEach(partner => {
                    tableBody += `
                        <tr>
                            <td>${partner.partnerId}</td>
                            <td>${partner.username}</td>
                            <td>${partner.mobile}</td>
                            <td>${partner.email}</td>
                            <td>${partner.licenseNo}</td>
                            <td>${partner.vehicleType}</td>
                            <td>${partner.vehicleColor}</td>
                        </tr>`;
                });
                $("#partnerTableBody").html(tableBody);
            },
            error: function() {
                console.error("Error loading data");
            }
        });
    }

    $(document).ready(function() {
        loadPartnerData(); // Load data on page load

        // Auto-refresh every 10 seconds
        setInterval(loadPartnerData, 10000);
    });
</script>
