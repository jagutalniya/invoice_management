<?php $this->load->view('common/sidebar'); ?>

<main class="main-content">
  <div class="top-header mb-4">
    <h1 class="page-title">
      <i class="fas fa-cog"></i> Profile Settings
    </h1>
  </div>

  <div class="container mt-3">
    <div class="row justify-content-center">
      <div class="col-md-10 col-lg-12">
        <div class="card shadow-sm p-4">

          <!-- Flash Messages -->
          <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success d-flex align-items-center">
              <i class="fas fa-check-circle me-2"></i> <?= $this->session->flashdata('success'); ?>
            </div>
          <?php endif; ?>
          <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-danger d-flex align-items-center">
              <i class="fas fa-exclamation-circle me-2"></i> <?= $this->session->flashdata('error'); ?>
            </div>
          <?php endif; ?>

          <?php echo form_open('profile/update'); ?>

          <h5 class="mb-3">Personal Information</h5>

          <div class="mb-3">
            <label class="form-label">Full Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" 
                   value="<?= set_value('name', $user->name); ?>" placeholder="Enter full name" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Username <span class="text-danger">*</span></label>
            <input type="text" name="username" class="form-control" 
                   value="<?= set_value('username', $user->username); ?>" placeholder="Enter username" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Email Address <span class="text-danger">*</span></label>
            <input type="email" name="email" class="form-control" 
                   value="<?= set_value('email', $user->email); ?>" placeholder="Enter email" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Mobile No</label>
            <input type="text" name="mobile_no" class="form-control" 
                   value="<?= set_value('mobile_no', $user->mobile_no); ?>" placeholder="Enter mobile number">
          </div>

          <hr>
          <h5 class="mb-3">Change Password</h5>

          <div class="mb-3">
            <label class="form-label">Old Password</label>
            <input type="password" name="old_password" class="form-control" placeholder="Enter old password">
          </div>

          <div class="mb-3">
            <label class="form-label">New Password</label>
            <input type="password" name="new_password" class="form-control" placeholder="Enter new password">
          </div>

          <div class="mb-3">
            <label class="form-label">Confirm New Password</label>
            <input type="password" name="confirm_password" class="form-control" placeholder="Confirm new password">
          </div>

          <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="<?= site_url('invoices'); ?>" class="btn btn-secondary">
              <i class="fas fa-arrow-left"></i> Cancel
            </a>
            <button type="submit" class="btn btn-primary">
              <i class="fas fa-save"></i> Save Changes
            </button>
          </div>

          <?php echo form_close(); ?>

        </div>
      </div>
    </div>
  </div>

  <?php $this->load->view('common/footer'); ?>
</main>
<script>
document.addEventListener('DOMContentLoaded', () => {

    const form = document.querySelector('form');
    const nameInput = form.querySelector('input[name="name"]');
    const usernameInput = form.querySelector('input[name="username"]');
    const emailInput = form.querySelector('input[name="email"]');
    const mobileInput = form.querySelector('input[name="mobile_no"]');
    const oldPasswordInput = form.querySelector('input[name="old_password"]');
    const newPasswordInput = form.querySelector('input[name="new_password"]');
    const confirmPasswordInput = form.querySelector('input[name="confirm_password"]');

    const nameRegex = /^[a-zA-Z\s]{2,50}$/;
    const usernameRegex = /^[a-zA-Z0-9_]{3,20}$/;
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/;
    const mobileRegex = /^[6-9][0-9]{9}$/;
    const passwordRegex = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?#&])[A-Za-z\d@$!%*?#&]{8,20}$/;

    function validateInput(input, regex, message) {
        const errorId = input.name + '_error';
        let errorElem = document.getElementById(errorId);

        if (!errorElem) {
            errorElem = document.createElement('div');
            errorElem.id = errorId;
            errorElem.className = 'text-danger mt-1';
            input.parentNode.appendChild(errorElem);
        }

        if (!input.value.trim()) {
            errorElem.textContent = 'This field is required.';
            return false;
        }

        if (!regex.test(input.value.trim())) {
            errorElem.textContent = message;
            return false;
        }

        errorElem.textContent = '';
        return true;
    }

    // Password match validation
    function validatePasswordMatch() {
        const errorId = 'confirm_password_error';
        let errorElem = document.getElementById(errorId);

        if (!errorElem) {
            errorElem = document.createElement('div');
            errorElem.id = errorId;
            errorElem.className = 'text-danger mt-1';
            confirmPasswordInput.parentNode.appendChild(errorElem);
        }

        if (newPasswordInput.value !== confirmPasswordInput.value) {
            errorElem.textContent = "Passwords do not match.";
            return false;
        } else {
            errorElem.textContent = "";
            return true;
        }
    }

    nameInput.addEventListener('input', () => validateInput(nameInput, nameRegex, 'Only letters and spaces allowed (2-50 characters).'));
    usernameInput.addEventListener('input', () => validateInput(usernameInput, usernameRegex, 'Only letters, numbers, underscore (3-20 chars).'));
    emailInput.addEventListener('input', () => validateInput(emailInput, emailRegex, 'Enter a valid email.'));
    mobileInput.addEventListener('input', () => validateInput(mobileInput, mobileRegex, 'Enter a valid 10-digit mobile number starting 6-9.'));
    newPasswordInput.addEventListener('input', () => validateInput(newPasswordInput, passwordRegex, '8-20 chars, uppercase, lowercase, number & special char.'));
    confirmPasswordInput.addEventListener('input', validatePasswordMatch);

    form.addEventListener('submit', (e) => {
        let valid = true;

        valid &= validateInput(nameInput, nameRegex, 'Only letters and spaces allowed (2-50 characters).');
        valid &= validateInput(usernameInput, usernameRegex, 'Only letters, numbers, underscore (3-20 chars).');
        valid &= validateInput(emailInput, emailRegex, 'Enter a valid email.');
        if (mobileInput.value.trim()) {
            valid &= validateInput(mobileInput, mobileRegex, 'Enter a valid 10-digit mobile number starting 6-9.');
        }

        if (newPasswordInput.value.trim()) {
            valid &= validateInput(newPasswordInput, passwordRegex, '8-20 chars, uppercase, lowercase, number & special char.');
            valid &= validatePasswordMatch();
        }

        if (!valid) {
            e.preventDefault();
        }
    });
});
</script>
