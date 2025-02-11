<?php require_once __DIR__ . "/header.php" ?>
<div class="content container-fluid">
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="page-header-title"><?= translate('add_user') ?></h1>
            </div>
            <div class="col-auto">
                <a class="btn btn-sm btn-primary" href="customers.php">
                    <?= translate('view_users') ?>
                </a>
            </div>
        </div>
    </div>

    <form action="" class="row g-3" id="user-form">
        <div class="col-12 col-md-6">
            <div class="row g-3">
                <div class="col-12">
                    <input type="hidden" id="user-form-action" name="add_customer" value="">
                    <label for="" class="form-label required"><?= translate('user_name') ?></label>
                    <input type="text" name="cus_name" class="form-control form-control-sm" required>
                </div>
                <div class="col-12">
                    <label for="" class="form-label"><?= translate('mobile_number') ?></label>
                    <input type="tel" name="cus_mobile" class="form-control form-control-sm"
                        oninput="allowType(event, 'mobile')">
                </div>
                <div class="col-12">
                    <label for="" class="form-label"><?= translate('email_id') ?></label>
                    <input type="email" name="cus_email" class="form-control form-control-sm">
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="row g-3">
                <div class="col-12">
                    <label for="" class="form-label"><?= translate('gender') ?></label>
                    <select name="cus_gender" class="form-control form-control-sm">
                        <option value="male"><?= translate('male') ?></option>
                        <option value="female"><?= translate('female') ?></option>
                        <option value="other"><?= translate('other') ?></option>
                        <option value="noshare"><?= translate('dont_want_to_share') ?></option>
                    </select>
                </div>
                <div class="col-12">
                    <label for="" class="form-label"><?= translate('address') ?></label>
                    <textarea name="cus_address" class="form-control form-control-sm" rows="5"></textarea>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <label for="" class="form-label"><?= translate('city') ?></label>
            <select name="" class="form-control form-control-sm">
                <option value="nashik"><?= translate('nashik') ?></option>
                <option value="mumbai"><?= translate('mumbai') ?></option>
                <option value="pune"><?= translate('pune') ?></option>
                <option value="other"><?= translate('other') ?></option>
            </select>
        </div>
        <div class="col-12 col-md-6">
            <label for="" class="form-label"><?= translate('state') ?></label>
            <select name="" class="form-control form-control-sm">
                <option value="maharashtra"><?= translate('maharashtra') ?></option>
                <option value="gujarat"><?= translate('gujarat') ?></option>
                <option value="karnataka"><?= translate('karnataka') ?></option>
                <option value="other"><?= translate('other') ?></option>
            </select>
        </div>

        <div class="modal-footer pt-0 border-top-0">
            <button type="reset" form="user-form" class="btn btn-sm btn-secondary"><?= translate('reset') ?></button>
            <button type="submit" form="user-form" class="btn btn-sm btn-primary ms-2"><?= translate('save') ?></button>
        </div>
    </form>
</div>
</div>
<?php require_once __DIR__ . '/footer.php' ?>
