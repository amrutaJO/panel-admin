<?php require_once 'db.php';

if (isset($_POST['add_partner'])) {
    $partner_name = $_POST['partner_name'];
    $mobile_no = $_POST['mobile_no'];
    $email_id = $_POST['email_id'];
    $partner_type = $_POST['partner_type'];
    $daily_services = $_POST['daily_services'];
    $account_no = $_POST['account_no'];
    $bank_name = $_POST['bank_name'];
    $partner_gender = $_POST['gender'];
    $address = $_POST['address'];
    $outstation_services = $_POST['outstation_services'];
    $upi_id = $_POST['upi_id'];
    $ifsc_code = $_POST['ifsc_code'];
    $password = $_POST['password']; // hash the password for security
    $salary_type = $_POST['salary_type'];
    $salary = $_POST['salary'];


    $sql = "INSERT INTO partners (partner_name, mobile_no, email_id, partner_type, daily_services, account_no, bank_name, gender, address, outstation_services, upi_id, ifsc_code, password, salary_type, salary)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssssss", $partner_name, $mobile_no, $email_id, $partner_type, $daily_services, $account_no, $bank_name, $partner_gender, $address, $outstation_services, $upi_id, $ifsc_code, $password, $salary_type, $salary);

    if ($stmt->execute()) {
        header("Location: add-partner.php");
        exit();
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<!-- Backend Processing of Add Partner Form -->

<?php require_once __DIR__ . "/header.php" ?>

<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-header-title"><?= translate('add_partner') ?></h1>
            </div>
            <div class="col-auto">
                <a class="btn btn-sm btn-primary" href="employees.php">
                    <?= translate('view_partners') ?> </a>
            </div>
        </div>
    </div>

    <form action="add-partner.php" method="POST" class="row g-3" id="partner-form">
        <div class="col-12 col-md-6">
            <div class="row g-3">
                <div class="col-12">
                    <input type="hidden" id="partner-form-action" name="add_partner" value="">
                    <label for="" class="form-label"><?= translate('partner_name') ?></label>
                    <input type="text" name="partner_name" class="form-control form-control-sm" required>
                </div>

                <div class="col-12">
                    <label for="" class="form-label"><?= translate('mobile_no') ?></label>
                    <input type="tel" name="mobile_no" class="form-control form-control-sm"
                        oninput="allowType(event, 'mobile')" required>
                </div>

                <div class="col-12">
                    <label for="" class="form-label"><?= translate('email_id') ?></label>
                    <input type="email" name="email_id" class="form-control form-control-sm" required>
                </div>

                <div class="col-12">
                    <label for="" class="form-label"><?= translate('partner_type') ?></label>
                    <select name="partner_type" id="emptype" class="form-control form-control-sm" required>
                        <option value="Full Time"><?= translate('full_time') ?></option>
                        <option value="Part Time"><?= translate('part_time') ?></option>
                    </select>
                </div>

                <div class="col-12">
                    <label for="" class="form-label"><?= translate('daily_services') ?></label>
                    <select name="daily_services" id="emptype" class="form-control form-control-sm">
                        <option value="yes"><?= translate('yes') ?></option>
                        <option value="no"><?= translate('no') ?></option>
                    </select>
                </div>

                <div class="col-12">
                    <label for="" class="form-label"><?= translate('account_no') ?></label>
                    <input type="tel" name="account_no" class="form-control form-control-sm" required>
                </div>

                <div class="col-12">
                    <label for="bank_name" class="form-label"><?= translate('bank_name') ?></label>
                    <input type="text" name="bank_name" class="form-control form-control-sm" required>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6">
            <div class="row g-3">
                <div class="col-12">
                    <label for="" class="form-label"><?= translate('gender') ?></label>
                    <select name="gender" class="form-control form-control-sm">
                        <option value="male"><?= translate('male') ?></option>
                        <option value="female"><?= translate('female') ?></option>
                        <option value="other"><?= translate('other') ?></option>
                    </select>
                </div>

                <div class="col-12">
                    <label for="" class="form-label"><?= translate('address') ?></label>
                    <textarea name="address" class="form-control form-control-sm" rows="5"></textarea>
                </div>

                <div class="col-12">
                    <label for="" class="form-label"><?= translate('outstation_services') ?></label>
                    <select name="outstation_services" id="emptype" class="form-control form-control-sm">
                        <option value="yes"><?= translate('yes') ?></option>
                        <option value="no"><?= translate('no') ?></option>
                    </select>
                </div>

                <div class="col-12">
                    <label for="upi_id" class="form-label"><?= translate('upi_id') ?></label>
                    <input type="text" name="upi_id" class="form-control form-control-sm" required>
                </div>

                <div class="col-12">
                    <label for="ifsc_code" class="form-label"><?= translate('ifsc_code') ?></label>
                    <input type="text" name="ifsc_code" class="form-control form-control-sm" required>
                </div>

                <div class="col-12">
                    <label for="password" class="form-label"><?= translate('password') ?></label>
                    <input type="password" name="password" class="form-control form-control-sm" required>
                </div>
            </div>
        </div>

        <div class="col-12 ">
            <div class="row">
                <div class="d-flex col-md-2 justify-content-between perdaymonth align-items-center">
                    <input type="radio" class="d-none" name="salary_type" value="Monthly" id="permonth" checked data-value="Month">
                    <label class="px-3 py-2 me-2" for="permonth"><?= translate('month') ?></label>
                    <input type="radio" class="d-none" name="salary_type" value="Daily" id="perday" data-value="Day">
                    <label class="px-3 py-2 ms-2" for="perday"><?= translate('day') ?></label>
                </div>
                <div class="col-md-8">
                    <label for="" class="form-label" id="sal"><?= translate('salary_per') ?> <span
                            id="salchange"></span></label>
                    <input type="text" name="salary" class="form-control form-control-sm"
                        oninput="allowType(event, 'number')" required>
                </div>
            </div>
        </div>

        <div class="modal-footer pt-0 border-top-0">
            <button type="submit" form="partner-form" class="btn btn-sm btn-primary"><?= translate('save') ?></button>
            <button type="reset" form="partner-form"
                class="btn btn-sm btn-secondary  ms-2"><?= translate('reset') ?></button>
        </div>
    </form>
</div>
<?php require_once __DIR__ . '/footer.php' ?>