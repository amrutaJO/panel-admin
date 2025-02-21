<?php
require_once "db.php"; // Database connection

$whereClauses = [];
$values = [];
$types = ""; // Store types for bind_param()

// Capture filter values and prepare SQL query
if (!empty($_POST['user_id'])) {
    $whereClauses[] = "user_id LIKE ?";
    $values[] = "%" . $_POST['user_id'] . "%";
    $types .= "s";
}
if (!empty($_POST['user_name'])) {
    $whereClauses[] = "user_name LIKE ?";
    $values[] = "%" . $_POST['user_name'] . "%";
    $types .= "s";
}
if (!empty($_POST['mobile_no'])) {
    $whereClauses[] = "user_mobile LIKE ?";
    $values[] = "%" . $_POST['mobile_no'] . "%";
    $types .= "s";
}
if (!empty($_POST['email'])) {
    $whereClauses[] = "user_email LIKE ?";
    $values[] = "%" . $_POST['email'] . "%";
    $types .= "s";
}
if (!empty($_POST['city'])) {
    $whereClauses[] = "user_city LIKE ?";
    $values[] = "%" . $_POST['city'] . "%";
    $types .= "s";
}
if (!empty($_POST['state'])) {
    $whereClauses[] = "user_state LIKE ?";
    $values[] = "%" . $_POST['state'] . "%";
    $types .= "s";
}

// Build SQL query
$sql = "SELECT * FROM users";
if (!empty($whereClauses)) {
    $sql .= " WHERE " . implode(" AND ", $whereClauses);
}

// Debug SQL Query (Optional: Uncomment to test)
// echo "SQL Query: " . $sql;
// print_r($values);

$stmt = $conn->prepare($sql);

if (!empty($values)) {
    $stmt->bind_param($types, ...$values);
}

$stmt->execute();
$result = $stmt->get_result();

$output = "";
while ($row = $result->fetch_assoc()) {
    $output .= "<tr>
        <td>{$row['user_id']}</td>
        <td>{$row['user_name']}</td>
        <td>{$row['user_mobile']}</td>
        <td>{$row['user_email']}</td>
        <td>{$row['user_gender']}</td>
        <td>{$row['user_address']}</td>
        <td>{$row['user_city']}</td>
        <td>{$row['user_state']}</td>
        <td>
            <div class='dropdown'>
                <button class='btn btn-sm btn-white dropdown-toggle' type='button' data-bs-toggle='dropdown'>
                    Action
                </button>
                <ul class='dropdown-menu'>
                    <li><a class='dropdown-item' data-bs-toggle='modal' data-bs-target='#editUserModal'>Edit</a></li>
                    <li><a class='dropdown-item text-danger delete-user-btn' href='javascript:void(0);'>Delete</a></li>
                </ul>
            </div>
        </td>
    </tr>";
}

// Debug the number of rows fetched
if ($result->num_rows === 0) {
    $output = "<tr><td colspan='9' class='text-center'>No results found</td></tr>";
}

echo $output;

$stmt->close();
$conn->close();
?>
