<?php $this->load->view('common/sidebar'); ?>

<main class="main-content">
  <div class="top-header">
    <h1 class="page-title">
      <i class="fas fa-file-invoice"></i>
      Edit Customer
    </h1>
  </div>
  <div class="row justify-content-center">
    <div class="col-md-12">

        <?php echo form_open('customer/update/'.$customer->id, ['id' => 'editCustomerForm']); ?>

        <div class="mb-3">
          <label class="form-label">Name <span class="text-danger">*</span></label>
          <input type="text" name="name" 
                 value="<?php echo set_value('name', $customer->name); ?>" 
                 class="form-control">
          <span class="text-danger error" id="error_name"></span>
        </div>

        <div class="mb-3">
          <label class="form-label">Mobile No <span class="text-danger">*</span></label>
          <input type="text" name="mobile_no" 
                 value="<?php echo set_value('mobile_no', $customer->mobile_no); ?>" 
                 class="form-control">
          <span class="text-danger error" id="error_mobile_no"></span>
        </div>

        <div class="mb-3">
          <label class="form-label">Address</label>
          <textarea name="address" class="form-control" rows="3"><?php echo set_value('address', $customer->address); ?></textarea>
          <span class="text-danger error" id="error_address"></span>
        </div>

        <div class="d-flex justify-content-between">
          <button type="submit" class="btn btn-primary px-4">Update</button>
          <a href="<?php echo site_url('customer'); ?>" class="btn btn-secondary px-4">Cancel</a>
        </div>

        <?php echo form_close(); ?>
      </div>
    </div>
</div>
</main>
  <?php $this->load->view('common/footer'); ?>
<script>
  const form = document.getElementById('editCustomerForm');

  const name = document.querySelector('[name="name"]');
  const mobile = document.querySelector('[name="mobile_no"]');
  const address = document.querySelector('[name="address"]');
  const mobileRegex = /^[0-9]{10}$/;

  function validateName() {
    if (name.value.trim() === '') {
      document.getElementById('error_name').innerText = "Name is required";
      return false;
    }
    document.getElementById('error_name').innerText = "";
    return true;
  }

  function validateMobile() {
    if (mobile.value.trim() === '') {
      document.getElementById('error_mobile_no').innerText = "Mobile number is required";
      return false;
    } else if (!mobileRegex.test(mobile.value.trim())) {
      document.getElementById('error_mobile_no').innerText = "Enter valid 10-digit mobile number";
      return false;
    }
    document.getElementById('error_mobile_no').innerText = "";
    return true;
  }

  function validateAddress() {
    if (address.value.trim() !== '' && address.value.trim().length < 5) {
      document.getElementById('error_address').innerText = "Address must be at least 5 characters";
      return false;
    }
    document.getElementById('error_address').innerText = "";
    return true;
  }

  name.addEventListener("input", validateName);
  name.addEventListener("blur", validateName);

  mobile.addEventListener("input", validateMobile);
  mobile.addEventListener("blur", validateMobile);

  address.addEventListener("input", validateAddress);
  address.addEventListener("blur", validateAddress);

  form.addEventListener("submit", function (e) {
    let valid = true;

    if (!validateName()) valid = false;
    if (!validateMobile()) valid = false;
    if (!validateAddress()) valid = false;

    if (!valid) e.preventDefault();
  });
</script>
