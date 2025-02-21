<?php
require_once 'db.php';

header('Content-Type: application/json');
$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['emp_id'])) {
        // Collecting data from POST
        $emp_id = $_POST['emp_id'];
        $emp_name = $_POST['emp_name'];
        $emp_mobile = $_POST['emp_mobile'];
        $emp_email = $_POST['emp_email'];
        $emp_gender = $_POST['emp_gender'];
        $emp_address = $_POST['emp_address'];
        $outstation_services = $_POST['outstation_services'];
        $daily_services = $_POST['daily_services'];
        $upi_id = $_POST['upi_id'];
        $bank_name = $_POST['bank_name'];
        $account_no = $_POST['account_no'];
        $ifsc_code = $_POST['ifsc_code'];
        $password = $_POST['password'];
        $salary_type = $_POST['salper'];
        $salary = $_POST['emp_salary'];

        // Prepare the SQL statement
        $sql = "UPDATE partners SET 
                    partner_name = ?, 
                    mobile_no = ?, 
                    email_id = ?, 
                    gender = ?, 
                    address = ?, 
                    outstation_services = ?, 
                    daily_services = ?, 
                    upi_id = ?, 
                    bank_name = ?, 
                    account_no = ?, 
                    ifsc_code = ?, 
                    password = ?, 
                    salary_type = ?, 
                    salary = ? 
                WHERE id = ?";

        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            $response = ["success" => false, "message" => "Failed to prepare statement: " . $conn->error];
            echo json_encode($response);
            exit();
        }

        $stmt->bind_param("sssssssssssssdi", $emp_name, $emp_mobile, $emp_email, $emp_gender, $emp_address, $outstation_services, $daily_services, $upi_id, $bank_name, $account_no, $ifsc_code, $password, $salary_type, $salary, $emp_id);

        if ($stmt->execute()) {
            $response = ["success" => true, "message" => "Employee updated successfully!"];
        } else {
            $response = ["success" => false, "message" => "Failed to update employee: " . $stmt->error];
        }

        $stmt->close();
    } elseif (isset($_POST['id'])) {
        $id = $_POST['id'];

        $stmt = $conn->prepare("DELETE FROM partners WHERE id = ?");
        if ($stmt === false) {
            $response = ["success" => false, "message" => "Failed to prepare delete statement: " . $conn->error];
            echo json_encode($response);
            exit();
        }

        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            $response = ['success' => true, 'message' => 'Employee deleted successfully.'];
        } else {
            $response = ['success' => false, 'message' => 'Failed to delete employee: ' . $stmt->error];
        }

        $stmt->close();
    } else {
        $response = ["success" => false, "message" => "Invalid request!"];
    }
} else {
    $response = ["success" => false, "message" => "Invalid request method!"];
}

$conn->close();

echo json_encode($response);
exit();