<?php
require_once __DIR__ . "/db.php";

if (isset($_GET['main_topic_id'])) {
    $main_topic_id = intval($_GET['main_topic_id']);
    $query = "SELECT id, sub_topic_name FROM faq_sub_topics WHERE main_topic_id = $main_topic_id";
    $result = mysqli_query($conn, $query);

    $subTopics = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $subTopics[] = $row;
    }

    echo json_encode($subTopics);
}
?>
