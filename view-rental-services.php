<?php 
require_once __DIR__ . "/header.php"; 
require_once __DIR__ . "/db.php"; // Ensure database connection
?>

<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-header-title d-flex align-items-center gap-3">
                    <span><?= translate('view_rental_services') ?></span>
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
                    <input type="search" class="form-control reports-table-search" placeholder="<?= translate('search_placeholder') ?>">
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table id="data-table" class="table table-bordered table-nowrap table-align-middle">
            <thead class="thead-light" align="left">
                <tr>
                    <th><?= translate('serial_no') ?></th>
                    <th><?= translate('hourly_package') ?></th>
                    <th><?= translate('base_fare') ?></th>
                    <th><?= translate('booking_fee') ?></th>
                    <th><?= translate('vehicle_type') ?></th>
                    <th><?= translate('per_km_rate') ?></th>
                    <th><?= translate('per_minute_rate') ?></th>
                    <th><?= translate('action') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM rental_services ORDER BY id DESC";
                $result = $conn->query($sql);
                $serial = 1;

                while ($row = $result->fetch_assoc()) {
                    echo "<tr id='row_{$row['id']}'>";
                    echo "<td>{$serial}</td>";
                    echo "<td>{$row['hourly_package']}</td>";
                    echo "<td>{$row['base_fare']} Rs</td>";
                    echo "<td>{$row['booking_fee']} Rs</td>";
                    echo "<td>{$row['vehicle_type']}</td>";
                    echo "<td>{$row['per_km_rate']} Rs</td>";
                    echo "<td>{$row['per_minute_rate']} Rs</td>";
                    echo "<td>
                            <div class='dropdown'>
                                <button class='btn btn-sm btn-white dropdown-toggle' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                                    " . translate('actions') . "
                                </button>
                                <ul class='dropdown-menu'>
                                    <li><a class='dropdown-item edit-btn' href='#' data-id='{$row['id']}' data-package='{$row['hourly_package']}' data-fare='{$row['base_fare']}' data-booking='{$row['booking_fee']}' data-type='{$row['vehicle_type']}' data-kmrate='{$row['per_km_rate']}' data-minrate='{$row['per_minute_rate']}'>" . translate('Edit') . "</a></li>
                                    <li><a class='dropdown-item text-danger delete-btn' href='#' data-id='{$row['id']}'>" . translate('Delete') . "</a></li>
                                </ul>
                            </div>
                          </td>";
                    echo "</tr>";
                    $serial++;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Rental Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editForm">
                    <input type="hidden" id="edit_id">
                    <div class="mb-3">
                        <label for="edit_package" class="form-label">Hourly Package</label>
                        <select id="edit_package" class="form-control">
                        <option value="">Select Package</option>
                        <option value="basic">Basic</option>
                        <option value="premium">Premium</option>
                        <option value="luxury">Luxury</option>
</select>

                    </div>
                    <div class="mb-3">
                        <label for="edit_fare" class="form-label">Base Fare (Rs)</label>
                        <input type="number" id="edit_fare" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="edit_booking" class="form-label">Booking Fee (Rs)</label>
                        <input type="number" id="edit_booking" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="edit_type" class="form-label">Vehicle Type</label>
                                <select id="edit_type" class="form-control">
                        <option value="">Select Package</option>
                        <option value="bike"><?= translate('bike') ?></option>
                        <option value="three-wheeler"><?= translate('three_wheeler') ?></option>
                        <option value="car"><?= translate('car') ?></option>
                      <option value="bike"><?= translate('bike') ?></option>
                        <option value="truck"><?= translate('truck') ?></option>
                        <option value="other"><?= translate('other') ?></option>
                                    
</select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_kmrate" class="form-label">Per KM Rate (Rs)</label>
                        <input type="number" id="edit_kmrate" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="edit_minrate" class="form-label">Per Minute Rate (Rs)</label>
                        <input type="number" id="edit_minrate" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Delete Button
        document.querySelectorAll(".delete-btn").forEach(button => {
            button.addEventListener("click", function (event) {
                event.preventDefault();
                let id = this.getAttribute("data-id");
                if (confirm("Are you sure you want to delete this service?")) {
                    fetch("delete_rental_service.php", {
                        method: "POST",
                        headers: { "Content-Type": "application/x-www-form-urlencoded" },
                        body: "id=" + id
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === "success") {
                            document.getElementById("row_" + id).remove();
                        } else {
                            alert("Failed to delete.");
                        }
                    });
                }
            });
        });

        // Edit Button
        document.querySelectorAll(".edit-btn").forEach(button => {
            button.addEventListener("click", function () {
                document.getElementById("edit_id").value = this.getAttribute("data-id");
                document.getElementById("edit_package").value = this.getAttribute("data-package");
                document.getElementById("edit_fare").value = this.getAttribute("data-fare");
                document.getElementById("edit_booking").value = this.getAttribute("data-booking");
                document.getElementById("edit_type").value = this.getAttribute("data-type");
                document.getElementById("edit_kmrate").value = this.getAttribute("data-kmrate");
                document.getElementById("edit_minrate").value = this.getAttribute("data-minrate");

                new bootstrap.Modal(document.getElementById("editModal")).show();
            });
        });

        // Edit Form Submission
        document.getElementById("editForm").addEventListener("submit", function (event) {
            event.preventDefault();

            let formData = new FormData();
            formData.append("id", document.getElementById("edit_id").value);
            formData.append("hourlyPackage", document.getElementById("edit_package").value);
            formData.append("baseFare", document.getElementById("edit_fare").value);
            formData.append("bookingFee", document.getElementById("edit_booking").value);
            formData.append("vehicleType", document.getElementById("edit_type").value);
            formData.append("perKmRate", document.getElementById("edit_kmrate").value);
            formData.append("perMinuteRate", document.getElementById("edit_minrate").value);

            fetch("edit_rental_service.php", {
                method: "POST",
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === "success") {
                    alert("Rental service updated successfully!");
                    location.reload();
                } else {
                    alert("Failed to update rental service.");
                }
            });
        });
    });
    document.getElementById("editForm").addEventListener("submit", function(event) {
    event.preventDefault();

    let formData = new FormData();
    formData.append("id", document.getElementById("edit_id").value);
    formData.append("hourly_package", document.getElementById("edit_package").value);
    formData.append("base_fare", document.getElementById("edit_fare").value);
    formData.append("booking_fee", document.getElementById("edit_booking").value);
    formData.append("vehicle_type", document.getElementById("edit_type").value);
    formData.append("per_km_rate", document.getElementById("edit_kmrate").value);
    formData.append("per_minute_rate", document.getElementById("edit_minrate").value);

    fetch("update_rental_service.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === "success") {
            alert("Rental service updated successfully!");
            location.reload(); // Refresh the page to see changes
        } else {
            alert("Update failed!");
        }
    });
});

</script>


<?php require_once __DIR__ . '/footer.php'; ?>
 