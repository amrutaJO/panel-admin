<?php 
require_once __DIR__ . "/header.php";
require_once __DIR__ . "/db_connection.php"; 

// Fetch FAQs
$query = "SELECT fq.id, fmt.id AS main_topic_id, fmt.topic_name AS main_topic, 
                 fst.id AS sub_topic_id, fst.sub_topic_name AS sub_topic, fq.question, fq.answer 
          FROM faq_questions fq
          JOIN faq_sub_topics fst ON fq.sub_topic_id = fst.id
          JOIN faq_main_topics fmt ON fst.main_topic_id = fmt.id";
$result = $conn->query($query);

// Fetch Main Topics
$mainTopics = mysqli_query($conn, "SELECT * FROM faq_main_topics");

// Fetch Sub Topics
$subTopics = mysqli_query($conn, "SELECT * FROM faq_sub_topics");
?>

<div class="content container-fluid">
<div class="page-header">
		<div class="row align-items-center">
			<div class="col">
				<h1 class="page-header-title d-flex align-items-center gap-3">
					<!-- <a href="reports" class="link-dark"><i class="bi-arrow-left-circle-fill align-middle"></i></a> -->
					<span><?= translate('view_faqs') ?></span>
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
					<input type="search" class="form-control reports-table-search" placeholder="<?= translate('search_here') ?>">
				</div>
			</div>
            <div class="col-12 col-md-6 offset-md-3">
			<div class="d-flex align-items-center gap-2">
            <button type="button" class="btn btn-sm btn-secondary ms-md-auto" data-bs-toggle="modal" data-bs-target="#faqFilterModal">
              Filter FAQs<i class="bi bi-funnel-fill"></i>
                    </button>
</div></div>

		</div>
	</div>
    <div class="table-responsive">
        <table id="data-table" class="table table-bordered table-nowrap table-align-middle">
            <thead align="left">
                <tr>
                    <th>S.No</th>
                    <th>Main Topic</th>
                    <th>Sub Topic</th>
                    <th>Question</th>
                    <th>Answer</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
    <?php if ($result->num_rows > 0): $s_no = 1; ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr data-main-topic-id="<?= $row['main_topic_id']; ?>" data-sub-topic-id="<?= $row['sub_topic_id']; ?>">
                <td><?= $s_no++; ?></td>
                <td><?= htmlspecialchars($row['main_topic']); ?></td>
                <td><?= htmlspecialchars($row['sub_topic']); ?></td>
                <td><?= htmlspecialchars($row['question']); ?></td>
                <td><?= htmlspecialchars($row['answer']); ?></td>
                <td>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Actions
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <button class="dropdown-item edit-faq" 
                                        data-id="<?= $row['id']; ?>"
                                        data-main-topic-id="<?= $row['main_topic_id']; ?>"
                                        data-sub-topic-id="<?= $row['sub_topic_id']; ?>"
                                        data-question="<?= htmlspecialchars($row['question']); ?>"
                                        data-answer="<?= htmlspecialchars($row['answer']); ?>">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </button>
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="delete-faq.php?id=<?= $row['id']; ?>" onclick="return confirm('Are you sure?');">
                                    <i class="bi bi-trash"></i> Delete
                                </a>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="6" class="text-center">No FAQs found</td></tr>
    <?php endif; ?>
</tbody>

        </table>
    </div>
    <div class="data-table-footer"></div>
</div>

<!-- 🟢 Edit FAQ Modal -->
<div class="modal fade" id="editFaqModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit FAQ</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="editFaqForm">
                    <input type="hidden" name="faq_id" id="faq_id">
                    
                    <div class="mb-3">
                        <label class="form-label">Main Topic</label>
                        <select class="form-control" name="main_topic_id" id="main_topic">
                            <option value="">Choose Main Topic</option>
                            <?php while ($row = mysqli_fetch_assoc($mainTopics)) { ?>
                                <option value="<?= $row['id'] ?>"><?= $row['topic_name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Sub Topic</label>
                        <select class="form-control" name="sub_topic_id" id="sub_topic">
                            <option value="">Choose Sub Topic</option>
                            <?php while ($row = mysqli_fetch_assoc($subTopics)) { ?>
                                <option value="<?= $row['id'] ?>"><?= $row['sub_topic_name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Question</label>
                        <input type="text" class="form-control" name="question" id="question" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Answer</label>
                        <textarea class="form-control" name="answer" id="answer" rows="3" required></textarea>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- 🟢 Filter Modal -->
<div class="modal fade" id="faqFilterModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="faqFilterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content shadow border">
            <div class="modal-header">
                <h5 class="modal-title" id="faqFilterModalLabel">Filter FAQs</h5>
            </div>
            <div class="modal-body py-3">
                <form class="row g-3" id="faq-filter-form">

                    <!-- 🟢 Filter by Main Topic -->
                    <div class="col-12">
                        <label class="form-label">Filter by Main Topic</label>
                        <select class="form-select form-select-sm" name="main_topic" id="filter-main-topic">
                            <option value="">All</option>
                            <?php 
                                $mainTopics = mysqli_query($conn, "SELECT * FROM faq_main_topics");
                                while ($row = mysqli_fetch_assoc($mainTopics)) { 
                            ?>
                                <option value="<?= $row['id'] ?>"><?= $row['topic_name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                    <!-- 🟢 Filter by Sub Topic -->
                    <div class="col-12">
                        <label class="form-label">Filter by Sub Topic</label>
                        <select class="form-select form-select-sm" name="sub_topic" id="filter-sub-topic">
                            <option value="">All</option>
                            <?php 
                                $subTopics = mysqli_query($conn, "SELECT * FROM faq_sub_topics");
                                while ($row = mysqli_fetch_assoc($subTopics)) { 
                            ?>
                                <option value="<?= $row['id'] ?>"><?= $row['sub_topic_name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>

                </form>
            </div>
            <div class="modal-footer pt-0 border-top-0">
                <button type="button" onclick="clearFaqFilters()" class="btn btn-sm btn-outline-danger me-auto" data-bs-dismiss="modal">Clear all filters</button>
                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="faq-filter-form" class="btn btn-sm btn-primary">Apply Filters</button>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>

<script>
    // 🟢 Open Edit Modal & Fill Data
    document.querySelectorAll('.edit-faq').forEach(button => {
        button.addEventListener('click', function () {
            document.getElementById('faq_id').value = this.getAttribute('data-id');
            document.getElementById('main_topic').value = this.getAttribute('data-main-topic-id');
            
            // 🟢 Load Sub Topics dynamically
            loadSubTopics(this.getAttribute('data-main-topic-id'), this.getAttribute('data-sub-topic-id'));

            document.getElementById('question').value = this.getAttribute('data-question');
            document.getElementById('answer').value = this.getAttribute('data-answer');

            var modal = new bootstrap.Modal(document.getElementById('editFaqModal'));
            modal.show();
        });
    });

    // 🟢 Function to Load Sub Topics Based on Main Topic Selection
    function loadSubTopics(mainTopicId, selectedSubTopic = null) {
        fetch(`get-subtopics.php?main_topic_id=${mainTopicId}`)
            .then(response => response.json())
            .then(data => {
                let subTopicDropdown = document.getElementById('sub_topic');
                subTopicDropdown.innerHTML = '<option value="">Choose Sub Topic</option>';

                data.forEach(subTopic => {
                    let option = document.createElement('option');
                    option.value = subTopic.id;
                    option.textContent = subTopic.sub_topic_name;
                    if (selectedSubTopic && selectedSubTopic == subTopic.id) {
                        option.selected = true;
                    }
                    subTopicDropdown.appendChild(option);
                });
            })
            .catch(error => console.error('Error:', error));
    }

    // 🟢 On Main Topic Change, Load Relevant Sub Topics
    document.getElementById('main_topic').addEventListener('change', function () {
        loadSubTopics(this.value);
    });

    // 🔵 Submit Form via AJAX
    document.getElementById('editFaqForm').addEventListener('submit', function (event) {
        event.preventDefault();

        var formData = new FormData(this);

        fetch('view-faq.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(data => {
                alert("FAQ updated successfully!");
                location.reload();
            })
            .catch(error => console.error('Error:', error));
    });
</script>

<script>
    document.querySelector('.reports-table-search').addEventListener('keyup', function() {
        let searchText = this.value.toLowerCase();
        let rows = document.querySelectorAll("#data-table tbody tr");

        rows.forEach(row => {
            let mainTopic = row.children[1].textContent.toLowerCase();
            let subTopic = row.children[2].textContent.toLowerCase();
            let question = row.children[3].textContent.toLowerCase();
            let answer = row.children[4].textContent.toLowerCase();

            if (mainTopic.includes(searchText) || subTopic.includes(searchText) || question.includes(searchText) || answer.includes(searchText)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });
</script>
<script>
    // 🟢 Filter FAQs Functionality
    document.getElementById('faq-filter-form').addEventListener('submit', function (event) {
        event.preventDefault();

        let mainTopic = document.getElementById('filter-main-topic').value;
        let subTopic = document.getElementById('filter-sub-topic').value;
        let rows = document.querySelectorAll("#data-table tbody tr");

        rows.forEach(row => {
            let rowMainTopic = row.getAttribute("data-main-topic-id");
            let rowSubTopic = row.getAttribute("data-sub-topic-id");

            if ((mainTopic === "" || rowMainTopic === mainTopic) &&
                (subTopic === "" || rowSubTopic === subTopic)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });

    function clearFaqFilters() {
        document.getElementById('filter-main-topic').value = "";
        document.getElementById('filter-sub-topic').value = "";
        document.querySelectorAll("#data-table tbody tr").forEach(row => row.style.display = "");
    }
</script>
<script>
	let sowingListTable = false;
	sowingListTable = $('#data-table').DataTable({
		lengthChange: true,
		columnDefs: [{
			targets: [0,],
			 orderable: false,
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


<?php 
// 🛠 Handle Update Logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $faq_id = intval($_POST['faq_id']);
    $main_topic_id = intval($_POST['main_topic_id']);
    $sub_topic_id = intval($_POST['sub_topic_id']);
    $question = mysqli_real_escape_string($conn, $_POST['question']);
    $answer = mysqli_real_escape_string($conn, $_POST['answer']);

    // ✅ Update Main Topic & Sub Topic
    $updateQuery = "UPDATE faq_questions 
                    SET sub_topic_id = '$sub_topic_id', 
                        question = '$question', 
                        answer = '$answer' 
                    WHERE id = '$faq_id'";
    
    if (mysqli_query($conn, $updateQuery)) {
        echo "FAQ updated successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
