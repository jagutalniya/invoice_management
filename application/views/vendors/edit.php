<?php $this->load->view('common/sidebar'); ?>

<main class="main-content">
  <div class="top-header">
    <h1 class="page-title">
      <i class="fas fa-user-edit"></i> Edit Vendor
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

          <?php echo form_open('vendor/update/'.$vendor->id, ['id' => 'vendorForm']); ?>

          <div class="mb-3">
            <label class="form-label">Full Name <span class="text-danger">*</span></label>
            <input type="text" name="name" value="<?= set_value('name', $vendor->name) ?>" class="form-control"
              placeholder="Enter full name" required>
            <small class="text-danger" id="nameError"></small>
          </div>

          <div class="mb-3">
            <label class="form-label">Username <span class="text-danger">*</span></label>
            <input type="text" name="username" value="<?= set_value('username', $vendor->username) ?>" class="form-control"
              placeholder="Enter username" required>
            <small class="text-danger" id="usernameError"></small>
          </div>

          <div class="mb-3">
            <label class="form-label">Email <span class="text-danger">*</span></label>
            <input type="email" name="email" value="<?= set_value('email', $vendor->email) ?>" class="form-control"
              placeholder="Enter email address" required>
            <small class="text-danger" id="emailError"></small>
          </div>

          <div class="mb-3">
            <label class="form-label">Mobile Number <span class="text-danger">*</span></label>
            <input type="text" name="mobile_no" value="<?= set_value('mobile_no', $vendor->mobile_no) ?>" class="form-control"
              placeholder="Enter mobile number" required>
            <small class="text-danger" id="mobileError"></small>
          </div>

          <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea name="address" class="form-control" rows="3"
              placeholder="Enter full address"><?= set_value('address', $vendor->address) ?></textarea>
            <small class="text-danger" id="addressError"></small>
          </div>

          <div class="mb-3">
            <label class="form-label">Pincode</label>
            <input type="text" name="pincode" value="<?= set_value('pincode', $vendor->pincode) ?>" class="form-control"
              placeholder="Enter pincode">
            <small class="text-danger" id="pincodeError"></small>
          </div>

          <div class="d-flex justify-content-end gap-2">
            <a href="<?= site_url('vendor') ?>" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Update Vendor</button>
          </div>

          <?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </div>

  <?php $this->load->view('common/footer'); ?>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const form = document.getElementById('vendorForm');

  const nameInput = form.name;
  const usernameInput = form.username;
  const emailInput = form.email;
  const mobileInput = form.mobile_no;
  const pincodeInput = form.pincode;

  const usernameRegex = /^[a-zA-Z0-9_]{3,20}$/;
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  const mobileRegex = /^[6-9]\d{9}$/;
  const pincodeRegex = /^[1-9][0-9]{5}$/;

  function validateName() {
    if(nameInput.value.trim() === '') {
      document.getElementById('nameError').textContent = 'Full name is required.';
      return false;
    } else {
      document.getElementById('nameError').textContent = '';
      return true;
    }
  }

  function validateUsername() {
    if(!usernameRegex.test(usernameInput.value)) {
      document.getElementById('usernameError').textContent = 'Username must be 3-20 chars, alphanumeric or underscore.';
      return false;
    } else {
      document.getElementById('usernameError').textContent = '';
      return true;
    }
  }

  function validateEmail() {
    if(!emailRegex.test(emailInput.value)) {
      document.getElementById('emailError').textContent = 'Enter a valid email address.';
      return false;
    } else {
      document.getElementById('emailError').textContent = '';
      return true;
    }
  }

  function validateMobile() {
    if(!mobileRegex.test(mobileInput.value)) {
      document.getElementById('mobileError').textContent = 'Enter a valid 10-digit mobile number starting with 6-9.';
      return false;
    } else {
      document.getElementById('mobileError').textContent = '';
      return true;
    }
  }

  function validatePincode() {
    if(pincodeInput.value && !pincodeRegex.test(pincodeInput.value)) {
      document.getElementById('pincodeError').textContent = 'Enter a valid 6-digit pincode.';
      return false;
    } else {
      document.getElementById('pincodeError').textContent = '';
      return true;
    }
  }

  nameInput.addEventListener('input', validateName);
  usernameInput.addEventListener('input', validateUsername);
  emailInput.addEventListener('input', validateEmail);
  mobileInput.addEventListener('input', validateMobile);
  pincodeInput.addEventListener('input', validatePincode);

  form.addEventListener('submit', function(e) {
    let valid = true;
    valid &= validateName();
    valid &= validateUsername();
    valid &= validateEmail();
    valid &= validateMobile();
    valid &= validatePincode();

    if(!valid) {
      e.preventDefault();
    }
  });
});
</script>
