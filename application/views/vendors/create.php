<?php $this->load->view('common/sidebar'); ?>

<main class="main-content">
    <div class="top-header">
        <h1 class="page-title">
            <i class="fas fa-user-tie"></i> Add Vendor
        </h1>
    </div>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-12">
                <div class="main-card">

                    <?php if(validation_errors()): ?>
                    <div class="alert alert-danger">
                        <?php echo validation_errors(); ?>
                    </div>
                    <?php endif; ?>

                    <?php echo form_open('vendor/store', ['id' => 'vendorForm']); ?>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="<?php echo set_value('name'); ?>" class="form-control"
                                placeholder="Enter full name">
                            <span class="text-danger error" id="error_name"></span>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" value="<?php echo set_value('username'); ?>"
                                class="form-control" placeholder="Enter username">
                            <span class="text-danger error" id="error_username"></span>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" value="<?php echo set_value('email'); ?>"
                                class="form-control" placeholder="Enter email address">
                            <span class="text-danger error" id="error_email"></span>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Mobile Number <span class="text-danger">*</span></label>
                            <input type="text" name="mobile_no" value="<?php echo set_value('mobile_no'); ?>"
                                class="form-control" placeholder="Enter mobile number">
                            <span class="text-danger error" id="error_mobile_no"></span>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">WhatsApp Number <span class="text-danger">*</span></label>
                            <input type="text" name="whatsapp_no" value="<?php echo set_value('whatsapp_no'); ?>"
                                class="form-control" placeholder="Enter whatsapp number">
                            <span class="text-danger error" id="error_whatsapp_no"></span>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" placeholder="Enter password">
                            <span class="text-danger error" id="error_password"></span>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Pincode</label>
                            <input type="text" name="pincode" value="<?php echo set_value('pincode'); ?>"
                                class="form-control" placeholder="Enter pincode">
                            <span class="text-danger error" id="error_pincode"></span>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Address</label>
                            <textarea name="address" class="form-control" rows="2"
                                placeholder="Enter full address"><?php echo set_value('address'); ?></textarea>
                            <span class="text-danger error" id="error_address"></span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-3">
                        <a href="<?php echo site_url('vendor'); ?>" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save Vendor</button>
                    </div>

                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
    </div>

    <?php $this->load->view('common/footer'); ?>
</main>
<script>
    function showError(id, msg) {
        document.getElementById(id).innerText = msg;
    }

    function clearError(id) {
        document.getElementById(id).innerText = "";
    }

    function validateName() {
        let name = document.querySelector('[name="name"]');
        if (name.value.trim() === '') {
            showError('error_name', "Full name is required");
            return false;
        } else {
            clearError('error_name');
            return true;
        }
    }

    function validateUsername() {
        let username = document.querySelector('[name="username"]');
        if (username.value.trim() === '') {
            showError('error_username', "Username is required");
            return false;
        } else {
            clearError('error_username');
            return true;
        }
    }

    function validateEmail() {
        let email = document.querySelector('[name="email"]');
        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email.value.trim() === '') {
            showError('error_email', "Email is required");
            return false;
        } else if (!emailRegex.test(email.value.trim())) {
            showError('error_email', "Enter valid email address");
            return false;
        } else {
            clearError('error_email');
            return true;
        }
    }

    function validateMobile() {
        let mobile = document.querySelector('[name="mobile_no"]');
        let mobileRegex = /^[6-9]\d{9}$/;
        if (mobile.value.trim() === '') {
            showError('error_mobile_no', "Mobile number is required");
            return false;
        } else if (!mobileRegex.test(mobile.value.trim())) {
            showError('error_mobile_no', "Enter valid 10-digit mobile number");
            return false;
        } else {
            clearError('error_mobile_no');
            return true;
        }
    }

    function validateWhatsapp() {
        let whatsapp = document.querySelector('[name="whatsapp_no"]');
        let whatsappRegex = /^[6-9]\d{9}$/;
        if (whatsapp.value.trim() !== '' && !whatsappRegex.test(whatsapp.value.trim())) {
            showError('error_whatsapp_no', "Enter valid WhatsApp number");
            return false;
        } else {
            clearError('error_whatsapp_no');
            return true;
        }
    }

    function validatePassword() {
        let password = document.querySelector('[name="password"]');
        if (password.value.trim() === '') {
            showError('error_password', "Password is required");
            return false;
        } else if (password.value.trim().length < 6) {
            showError('error_password', "Password must be at least 6 characters");
            return false;
        } else {
            clearError('error_password');
            return true;
        }
    }

    function validatePincode() {
        let pincode = document.querySelector('[name="pincode"]');
        let pinRegex = /^[1-9][0-9]{5}$/;
        if (pincode.value.trim() !== '' && !pinRegex.test(pincode.value.trim())) {
            showError('error_pincode', "Enter valid 6-digit pincode");
            return false;
        } else {
            clearError('error_pincode');
            return true;
        }
    }

    function validateAddress() {
        let address = document.querySelector('[name="address"]');
        if (address.value.trim() !== '' && address.value.trim().length < 5) {
            showError('error_address', "Address must be at least 5 characters");
            return false;
        } else {
            clearError('error_address');
            return true;
        }
    }

    document.querySelector('[name="name"]').addEventListener('input', validateName);
    document.querySelector('[name="username"]').addEventListener('input', validateUsername);
    document.querySelector('[name="email"]').addEventListener('input', validateEmail);
    document.querySelector('[name="mobile_no"]').addEventListener('input', validateMobile);
    document.querySelector('[name="whatsapp_no"]').addEventListener('input', validateWhatsapp);
    document.querySelector('[name="password"]').addEventListener('input', validatePassword);
    document.querySelector('[name="pincode"]').addEventListener('input', validatePincode);
    document.querySelector('[name="address"]').addEventListener('input', validateAddress);

    document.getElementById('vendorForm').addEventListener('submit', function (e) {
        let valid = true;

        if (!validateName()) valid = false;
        if (!validateUsername()) valid = false;
        if (!validateEmail()) valid = false;
        if (!validateMobile()) valid = false;
        if (!validateWhatsapp()) valid = false;
        if (!validatePassword()) valid = false;
        if (!validatePincode()) valid = false;
        if (!validateAddress()) valid = false;

        if (!valid) {
            e.preventDefault();
        }
    });
</script>
