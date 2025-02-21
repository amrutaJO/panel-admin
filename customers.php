<?php require_once __DIR__ . "/header.php" ?>
<?php require_once "db.php"; ?>


<div class="content container-fluid">
	<!-- Page Header -->
	<div class="page-header">
		<div class="row align-items-center">
			<div class="col">
				<h1 class="page-header-title">
					<?= translate('view_users') ?>
				</h1>
			</div>
			<!-- End Col -->

			<!-- <div class="col-auto">
				<a class="btn btn-sm btn-primary" href="javascript:void(0)" onclick="addCustomer()">
					<i class="bi-plus-circle me-1"></i>
					<?= translate('Add New') ?> </a>
			</div> -->

			<!-- End Col -->
		</div>
		<!-- End Row -->
	</div>
	<!-- End Page Header -->
	<!-- <div class="data-table-filters">
		<div class="row g-3">
			<div class="col-12 col-md-3">
				<div class="input-group input-group-sm">
					<div class="input-group-text">
						<i class="bi-search"></i>
					</div>
					<input type="search" class="form-control customer-table-search" placeholder="Search here">
				</div>
			</div>
			<div class="col-12 col-md-6 offset-md-3">
				<div class="d-flex align-items-center gap-2">
					<div class="export-buttons ms-md-auto"></div>
				</div>
			</div>
		</div>
	</div>

	 -->

	 <div class="data-table-filters">
		<div class="row g-3">
			<div class="col-12 col-md-3">
				<div class="input-group input-group-sm">
					<div class="input-group-text">
						<i class="bi-search"></i>
					</div>
					<input type="search" id="searchInput" class="form-control customer-table-search" placeholder="Search here">
				</div>
			</div>
			<div class="col-12 col-md-6 offset-md-3">
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-sm btn-secondary ms-md-auto" data-bs-toggle="modal"
                    data-bs-target="#transactionfilterModal">
                    Filter <i class="bi bi-funnel-fill"></i>
                </button>
                <div class="export-buttons"></div>
            </div>
        </div>
    </div>



<!-- Filter Modal -->
<div class="modal fade" id="transactionfilterModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
		aria-labelledby="filterModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
			<div class="modal-content shadow border">
				<div class="modal-header">
					<h5 class="modal-title" id="filterModalLabel">Filter</h5>
				</div>
				<div class="modal-body py-3">
					<form class="row g-3" id="filter-form">

					<div class="col-12 col-md-6">
							<label class="form-label">Filter by User ID</label>
							<input type="text" class="form-control form-control-sm" name="user_id" placeholder="Enter User ID">
						</div>

						<div class="col-12 col-md-6">
							<label class="form-label">Filter by User Name</label>
							<input type="text" class="form-control form-control-sm" name="user_name" placeholder="Enter User Name">
						</div>

						<div class="col-12 col-md-6">
							<label class="form-label">Filter by Mobile No</label>
							<input type="text" class="form-control form-control-sm" name="mobile_no" placeholder="Enter Mobile No">
						</div>

						<div class="col-12 col-md-6">
							<label class="form-label">Filter by Email</label>
							<input type="email" class="form-control form-control-sm" name="email" placeholder="Enter Email">
						</div>

						<div class="col-12 col-md-6">
							<label class="form-label">Filter by City</label>
							<input type="text" class="form-control form-control-sm" name="city" placeholder="Enter City">
						</div>

						<div class="col-12 col-md-6">
							<label class="form-label">Filter by State</label>
							<input type="text" class="form-control form-control-sm" name="state" placeholder="Enter State">
						</div>
                    </form>
                </div>
                <div class="modal-footer pt-0 border-top-0">
				<button type="button" onclick="clearAllFilters()" class="btn btn-sm btn-outline-danger me-auto">Clear all filters</button>                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="filter-form" class="btn btn-sm btn-primary">Apply Filters</button>
                </div>
            </div>
        </div>
    </div>

	<script>
		function clearAllFilters() {
    // Select the form and reset all input fields
    document.getElementById("filter-form").reset();
}

//following code for applying filter 

document.getElementById("filter-form").addEventListener("submit", function (e) {
    e.preventDefault(); // Prevent form submission

    let formData = new FormData(this); // Get form data

    fetch("filter_users.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        document.querySelector("#data-table tbody").innerHTML = data; // Update table
        var modal = bootstrap.Modal.getInstance(document.getElementById('transactionfilterModal'));
        modal.hide(); // Close modal
    })
    .catch(error => console.error("Error:", error));
});



//following code for searchbar


document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("searchInput");
    const tableRows = document.querySelectorAll("#data-table tbody tr");

    searchInput.addEventListener("keyup", function () {
        const query = searchInput.value.toLowerCase();

        tableRows.forEach(row => {
            const rowText = row.textContent.toLowerCase();
            if (rowText.includes(query)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
});


	</script>
	<!-- End Filter Modal -->
	



	<!-- EDIT USER MODAL -->
	<div class="modal fade" id="editUserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
		aria-labelledby="editUserModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
			<div class="modal-content border shadow">
				<div class="modal-header">
					<h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form id="edit-user-form" class="row g-3">
						<input type="hidden" id="edit-user-id" name="user_id">

						<div class="col-12 col-md-6">
							<div class="row g-3">
								<div class="col-12">
									<label class="form-label required">User Name</label>
									<input type="text" name="user_name" id="edit-user-name"
										class="form-control form-control-sm" required>
								</div>
								<div class="col-12">
									<label class="form-label">Mobile Number</label>
									<input type="tel" name="user_mobile" id="edit-user-mobile"
										class="form-control form-control-sm">
								</div>
								<div class="col-12">
									<label class="form-label">Email ID</label>
									<input type="email" name="user_email" id="edit-user-email"
										class="form-control form-control-sm">
								</div>
							</div>
						</div>

						<div class="col-12 col-md-6">
							<div class="row g-3">
								<div class="col-12">
									<label class="form-label">Gender</label>
									<select name="user_gender" id="edit-user-gender"
										class="form-control form-control-sm">
										<option value="noshare">Prefer not to say</option>
										<option value="male">Male</option>
										<option value="female">Female</option>
										<option value="other">Other</option>
									</select>
								</div>
								<div class="col-12">
									<label class="form-label">Address</label>
									<textarea name="user_address" id="edit-user-address"
										class="form-control form-control-sm" rows="3"></textarea>
								</div>
							</div>
						</div>

						<div class="col-12 col-md-6">
							<label class="form-label">City</label>
							<select name="user_city" id="edit-user-city" class="form-control form-control-sm">
								<option value="nashik">Nashik</option>
								<option value="mumbai">Mumbai</option>
								<option value="pune">Pune</option>
								<option value="other">Other</option>
							</select>
						</div>

						<div class="col-12 col-md-6">
							<label class="form-label">State</label>
							<select name="user_state" id="edit-user-state" class="form-control form-control-sm">
								<option value="maharashtra">Maharashtra</option>
								<option value="gujarat">Gujarat</option>
								<option value="karnataka">Karnataka</option>
								<option value="other">Other</option>
							</select>
						</div>
					</form>
				</div>

				<div class="modal-footer pt-0 border-top-0">
					<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
					<button type="submit" form="edit-user-form" class="btn btn-sm btn-primary">Save Changes</button>
				</div>
			</div>
		</div>
	</div>


	<!-- EDIT USER MODAL -->


	<div class="table-responsive">
		<table id="data-table" class="table table-bordered table-nowrap table-align-middle">
			<thead class="thead-light" align="left">
				<tr>
					<!-- <th><?= translate('sr_no') ?></th> -->
					<th><?= translate('user_id') ?></th>
					<th><?= translate('user_name') ?></th>
					<th><?= translate('mobile_no') ?></th>
					<th><?= translate('email_id') ?></th>
					<th><?= translate('gender') ?></th>
					<th><?= translate('address') ?></th>
					<th><?= translate('city') ?></th>
					<th><?= translate('state') ?></th>
					<th><?= translate('action') ?></th> <!-- Ensure "Action" column is included -->
				</tr>
			</thead>
			<tbody>
				<?php
				$sr_no = 1;

				$query = "SELECT * FROM users";
				$result = mysqli_query($conn, $query);
				while ($row = mysqli_fetch_assoc($result)) {
					?>
					<tr class="odd">
						<!-- <td><?php echo $row['id'] ?></td> -->
						<td> <?php echo $row['user_id'] ?></td>
						<td> <?php echo $row['user_name'] ?></td>
						<td> <?php echo $row['user_mobile'] ?></td>
						<td> <?php echo $row['user_email'] ?></td>
						<td> <?php echo $row['user_gender'] ?></td>
						<td> <?php echo $row['user_address'] ?></td>
						<td> <?php echo $row['user_city'] ?></td>
						<td> <?php echo $row['user_state'] ?></td>
						<td>
							<div class='dropdown'>
								<button class='btn btn-sm btn-white dropdown-toggle' type='button' data-bs-toggle='dropdown'
									aria-expanded='false'>
									Action
								</button>
								<ul class='dropdown-menu'>
									<li><a class='dropdown-item' data-id="<?php echo $row['user_id']; ?>"
											data-user_name="<?php echo $row['user_name']; ?>"
											data-user_mobile="<?php echo $row['user_mobile']; ?>"
											data-user_email="<?php echo $row['user_email']; ?>"
											data-user_gender="<?php echo $row['user_gender']; ?>"
											data-user_address="<?php echo $row['user_address']; ?>"
											data-user_city="<?php echo $row['user_city']; ?>"
											data-user_state="<?php echo $row['user_state']; ?>" 
											data-bs-toggle='modal'
											data-bs-target="#editUserModal">Edit</a></li>
									<li>
										<a class='dropdown-item text-danger delete-user-btn'
											data-id="<?php echo $row['user_id']; ?>" href="javascript:void(0);">
											Delete
										</a>
									</li>
								</ul>
							</div>
						</td>

					</tr>
					<?php
					$sr_no++;
				}
				?>
			</tbody>
		</table>
	</div>
	<div class="customer-table-footer"></div>
</div>
<!-- End Content -->
<?php require_once __DIR__ . '/footer.php' ?>


<script>
	let sowingListTable = false;
	sowingListTable = $('#data-table').DataTable({
		lengthChange: true,
		columnDefs: [{
			// targets: [0,],
			// orderable: false,
		}],
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




<script>
	document.addEventListener("DOMContentLoaded", function () {
		document.querySelectorAll(".dropdown-item[data-bs-target='#editUserModal']").forEach(item => {
			item.addEventListener("click", function () {
				let userId = this.getAttribute("data-id");
				let userName = this.getAttribute("data-user_name");
				let userMobile = this.getAttribute("data-user_mobile");
				let userEmail = this.getAttribute("data-user_email");
				let userGender = this.getAttribute("data-user_gender");
				let userAddress = this.getAttribute("data-user_address");
				let userCity = this.getAttribute("data-user_city");
				document.querySelector("#edit-user-form input[name='cus_name']").value = userName;
				document.querySelector("#edit-user-form input[name='cus_mobile']").value = userMobile;
				document.querySelector("#edit-user-form input[name='cus_email']").value = userEmail;
				document.querySelector("#edit-user-form select[name='cus_gender']").value = userGender;
				document.querySelector("#edit-user-form textarea[name='cus_address']").value = userAddress;
				document.querySelector("#edit-user-form textarea[name='cus_city']").value = userCity;

				// Optional: Store user ID in a hidden field for update logic
				let form = document.querySelector("#edit-user-form");
				if (!document.querySelector("#edit-user-form input[name='user_id']")) {
					let input = document.createElement("input");
					input.type = "hidden";
					input.name = "user_id";
					input.value = userId;
					form.appendChild(input);
				} else {
					document.querySelector("#edit-user-form input[name='user_id']").value = userId;
				}
			});
		});
	});

</script>

<script>
	document.addEventListener("DOMContentLoaded", function () {
		document.querySelectorAll(".dropdown-item[data-bs-target='#editUserModal']").forEach(item => {
			item.addEventListener("click", function () {
				let userId = this.getAttribute("data-id");
				let userName = this.getAttribute("data-user_name");
				let userMobile = this.getAttribute("data-user_mobile");
				let userEmail = this.getAttribute("data-user_email");
				let userGender = this.getAttribute("data-user_gender");
				let userAddress = this.getAttribute("data-user_address");
				let userCity = this.getAttribute("data-user_city");
				let userState = this.getAttribute("data-user_state");

				document.getElementById("edit-user-id").value = userId;
				document.getElementById("edit-user-name").value = userName;
				document.getElementById("edit-user-mobile").value = userMobile;
				document.getElementById("edit-user-email").value = userEmail;
				document.getElementById("edit-user-gender").value = userGender;
				document.getElementById("edit-user-address").value = userAddress;
				document.getElementById("edit-user-city").value = userCity;
				document.getElementById("edit-user-state").value = userState;
			});
		});

		// Handle Edit Form Submission via AJAX
		document.getElementById("edit-user-form").addEventListener("submit", function (e) {
			e.preventDefault();

			let formData = new FormData(this);

			fetch("edit_user.php", {
				method: "POST",
				body: formData
			})
				.then(response => response.json())
				.then(data => {
					if (data.success) {
						alert("User updated successfully!");
						location.reload(); // Reload to update the table
					} else {
						alert("Error updating user: " + data.message);
					}
				})
				.catch(error => console.error("Error:", error));
		});
	});

</script>

<!-- js for handling delete functionality -->

<script>


	document.addEventListener("DOMContentLoaded", function () {
		document.querySelectorAll(".delete-user-btn").forEach(button => {
			button.addEventListener("click", function () {
				let userId = this.getAttribute("data-id");

				if (confirm("Are you sure you want to delete this user?")) {
					fetch("delete_user.php", {
						method: "POST",
						headers: { "Content-Type": "application/x-www-form-urlencoded" },
						body: `user_id=${userId}`
					})
						.then(response => response.json())
						.then(data => {
							if (data.success) {
								alert("User deleted successfully!");
								location.reload(); // Refresh to update UI
							} else {
								alert("Error deleting user: " + data.message);
							}
						})
						.catch(error => console.error("Error:", error));
				}
			});
		});
	});

</script>


<script>
	document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".dropdown-item[data-bs-target='#editUserModal']").forEach(item => {
        item.addEventListener("click", function () {
            let userId = this.getAttribute("data-id");
            let userName = this.getAttribute("data-user_name");
            let userMobile = this.getAttribute("data-user_mobile");
            let userEmail = this.getAttribute("data-user_email");
            let userGender = this.getAttribute("data-user_gender");
            let userAddress = this.getAttribute("data-user_address");
            let userCity = this.getAttribute("data-user_city");
            let userState = this.getAttribute("data-user_state");

            // Set values in the modal form
            document.querySelector("#edit-user-form input[name='user_name']").value = userName;
            document.querySelector("#edit-user-form input[name='user_mobile']").value = userMobile;
            document.querySelector("#edit-user-form input[name='user_email']").value = userEmail;
            document.querySelector("#edit-user-form select[name='user_gender']").value = userGender;
            document.querySelector("#edit-user-form textarea[name='user_address']").value = userAddress;
            document.querySelector("#edit-user-form input[name='user_city']").value = userCity;
            document.querySelector("#edit-user-form input[name='user_state']").value = userState;

            // Ensure user_id is properly stored in a hidden field
            let userIdInput = document.querySelector("#edit-user-form input[name='user_id']");
            if (!userIdInput) {
                let input = document.createElement("input");
                input.type = "hidden";
                input.name = "user_id";
                input.value = userId;
                document.querySelector("#edit-user-form").appendChild(input);
            } else {
                userIdInput.value = userId;
            }
        });
    });
});

</script>



