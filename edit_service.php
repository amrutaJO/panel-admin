<?php
require_once __DIR__ . "/header.php";
require_once __DIR__ . "/db_connection.php"; // Include DB connection

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $service_id = intval($_GET['id']);

    // Fetch the service details by ID
    $query = "SELECT * FROM services WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $service_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $service = $result->fetch_assoc();
    
    if (!$service) {
        echo "<script>alert('Service not found!'); window.location.href = 'view-services.php';</script>";
        exit;
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    $service_id = intval($_POST['id']);
    $service_name = trim($_POST['serviceName']);
    $number_of_seats = intval($_POST['numSeats']);
    $base_fare = floatval($_POST['baseFare']);
    $minimum_fare = floatval($_POST['minFare']);
    $booking_fee = floatval($_POST['bookingFee']);
    $tax_percentage = floatval($_POST['taxPercentage']);
    $price_per_minute = floatval($_POST['pricePerMinute']);
    $price_per_mile_km = floatval($_POST['pricePerKm']);
    $mileage = trim($_POST['mileage']);
    $daily_service = trim($_POST['dailyService']);
    $outstation_service = trim($_POST['outstationService']);
    $rental_service = trim($_POST['rentalService']);
    $provider_commission = floatval($_POST['providerCommission']);
    $admin_commission = floatval($_POST['adminCommission']);
    $driver_cash_limit = floatval($_POST['driverCashLimit']);

    // Fetch existing image
    $query = "SELECT service_picture FROM services WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $service_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $existing_picture = $row['service_picture'];

    // Handle image upload
    $service_picture = $existing_picture;
    if (!empty($_FILES['servicePicture']['name'])) {
        $target_dir = "assets/img/";
        $file_name = basename($_FILES['servicePicture']['name']);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (in_array($file_ext, $allowed_types)) {
            $new_file_name = uniqid("service_") . '.' . $file_ext;
            $target_file = $target_dir . $new_file_name;
            
            if (move_uploaded_file($_FILES['servicePicture']['tmp_name'], $target_file)) {
                $service_picture = $new_file_name;
            } else {
                echo "<script>alert('Image upload failed!');</script>";
            }
        } else {
            echo "<script>alert('Invalid file format! Allowed formats: JPG, JPEG, PNG, GIF');</script>";
        }
    }

    // Update query
    $update_query = "UPDATE services SET service_name=?, number_of_seats=?, base_fare=?, minimum_fare=?, booking_fee=?, tax_percentage=?, price_per_minute=?, price_per_mile_km=?, mileage=?, daily_service=?, outstation_service=?, rental_service=?, provider_commission=?, admin_commission=?,  driver_cash_limit=?, service_picture=? WHERE id=?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("siiiiiddsssssiisi", $service_name, $number_of_seats, $base_fare, $minimum_fare, $booking_fee, $tax_percentage, $price_per_minute, $price_per_mile_km, $mileage, $daily_service, $outstation_service, $rental_service, $provider_commission, $admin_commission,  $driver_cash_limit, $service_picture, $service_id);

    if ($stmt->execute()) {
        echo "<script>alert('Service updated successfully!'); window.location.href = 'view-services.php';</script>";
    } else {
        echo "<script>alert('Update failed!');</script>";
    }
}

require_once __DIR__ . "/footer.php";
?>
