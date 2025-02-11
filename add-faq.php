<?php require_once __DIR__ . "/header.php"; ?>
<?php require_once "db.php"; ?>

<?php
// Handle adding main topic and sub-topic together
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_topics'])) {
    $mainTopic = mysqli_real_escape_string($conn, $_POST['main_topic']);
    $subTopic = mysqli_real_escape_string($conn, $_POST['sub_topic']);

    // Insert Main Topic
    $queryMain = "INSERT INTO faq_main_topics (topic_name) VALUES ('$mainTopic')";
    if (mysqli_query($conn, $queryMain)) {
        $mainTopicId = mysqli_insert_id($conn); // Get the inserted Main Topic ID

        // Insert Sub Topic under the newly added Main Topic
        $querySub = "INSERT INTO faq_sub_topics (main_topic_id, sub_topic_name) VALUES ('$mainTopicId', '$subTopic')";
        if (mysqli_query($conn, $querySub)) {
            echo "<script>window.location.href = 'add-faq.php?success=1';</script>"; // Redirect to avoid resubmission
            exit();
        }
    }
}

// Handle adding question-answer
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_faq'])) {
    $question = mysqli_real_escape_string($conn, $_POST['question']);
    $answer = mysqli_real_escape_string($conn, $_POST['answer']);
    $subTopicId = intval($_POST['sub_topic_id']);

    $query = "INSERT INTO faq_questions (sub_topic_id, question, answer) VALUES ('$subTopicId', '$question', '$answer')";
    if (mysqli_query($conn, $query)) {
        echo "<script>window.location.href = 'add-faq.php?success=2';</script>"; // Redirect to avoid resubmission
        exit();
    }
}

// Fetch topics for dropdowns
$mainTopics = mysqli_query($conn, "SELECT * FROM faq_main_topics");
$subTopics = mysqli_query($conn, "SELECT * FROM faq_sub_topics");
?>

<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-header-title"><?= translate('add_faq') ?></h1>
            </div>
            <div class="col-auto">
                <a class="btn btn-sm btn-primary" href="view-faq.php">
                    <?= translate('view_faqs') ?>
                </a>
            </div>
        </div>
    </div>

    <!-- Show Success Message -->
    <?php if (isset($_GET['success'])) { ?>
        <script>
            setTimeout(() => alert("<?= $_GET['success'] == 1 ? 'Main Topic & Sub Topic Added!' : 'FAQ Added!' ?>"), 100);
        </script>
    <?php } ?>

    <!-- Add Main Topic & Sub Topic -->
    <form method="POST">
        <div class="row mb-3">
            <div class="col-12 col-md-6">
                <label class="form-label"><?= translate('main_topic') ?></label>
                <input type="text" class="form-control form-control-sm" name="main_topic" required>
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label"><?= translate('sub_topic') ?></label>
                <input type="text" class="form-control form-control-sm" name="sub_topic" required>
            </div>
            <div class="col-12 mt-2 d-flex justify-content-end">
                <button type="submit" name="save_topics" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> <?= translate('save') ?></button>
            </div>
        </div>
    </form>

    <!-- Add Question & Answer -->
    <form method="POST">
        <div class="row mb-3">
            <div class="col-12 col-md-6">
                <label class="form-label"><?= translate('select_main_topic') ?></label>
                <select class="form-control form-control-sm" name="main_topic_id" required>
                    <option value=""><?= translate('choose_main_topic') ?></option>
                    <?php while ($row = mysqli_fetch_assoc($mainTopics)) { ?>
                        <option value="<?= $row['id'] ?>"><?= $row['topic_name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label"><?= translate('select_sub_topic') ?></label>
                <select class="form-control form-control-sm" name="sub_topic_id" required>
                    <option value=""><?= translate('choose_sub_topic') ?></option>
                    <?php while ($row = mysqli_fetch_assoc($subTopics)) { ?>
                        <option value="<?= $row['id'] ?>"><?= $row['sub_topic_name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-12 mt-2">
                <label class="form-label"><?= translate('question') ?></label>
                <input type="text" class="form-control form-control-sm" name="question" required>
            </div>
            <div class="col-12 mt-2">
                <label class="form-label"><?= translate('answer') ?></label>
                <textarea class="form-control form-control-sm" name="answer" rows="3" required></textarea>
            </div>
            <div class="col-12 mt-2 d-flex justify-content-end">
                <button type="submit" name="save_faq" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> <?= translate('save') ?></button>
            </div>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>
