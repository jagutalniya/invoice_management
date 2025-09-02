<?php $this->load->view('common/sidebar'); ?>

<main class="main-content">
  <div class="top-header">
    <h1 class="page-title">
      <i class="fas fa-file-invoice"></i> Add Customer
    </h1>
  </div>

  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-10 col-lg-12">
        <div class="main-card">

          <?php echo form_open('customer/store', ['id' => 'customerForm']); ?>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Select Vendor <span class="text-danger">*</span></label>
              <select name="vendor_id" class="form-control">
                <option value="">-- Select Vendor --</option>
                <?php foreach($vendors as $vendor): ?>
                  <option value="<?= $vendor->id ?>" <?= set_select('vendor_id', $vendor->id); ?>>
                    <?= $vendor->name ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <span class="text-danger error" id="error_vendor_id"></span>
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Full Name <span class="text-danger">*</span></label>
              <input type="text" name="name" value="<?= set_value('name'); ?>" class="form-control"
                placeholder="Enter full name">
              <span class="text-danger error" id="error_name"></span>
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Username <span class="text-danger">*</span></label>
              <input type="text" name="username" value="<?= set_value('username'); ?>" class="form-control"
                placeholder="Enter username">
              <span class="text-danger error" id="error_username"></span>
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Mobile No <span class="text-danger">*</span></label>
              <input type="text" name="mobile_no" value="<?= set_value('mobile_no'); ?>" class="form-control"
                placeholder="Enter mobile number">
              <span class="text-danger error" id="error_mobile_no"></span>
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">WhatsApp No</label>
              <input type="text" name="whatsapp_no" value="<?= set_value('whatsapp_no'); ?>" class="form-control"
                placeholder="Enter WhatsApp number">
              <span class="text-danger error" id="error_whatsapp_no"></span>
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" value="<?= set_value('email'); ?>" class="form-control"
                placeholder="Enter email">
              <span class="text-danger error" id="error_email"></span>
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control" placeholder="Enter password">
              <span class="text-danger error" id="error_password"></span>
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Aadhar No</label>
              <input type="text" name="aadhar_no" value="<?= set_value('aadhar_no'); ?>" class="form-control"
                placeholder="Enter Aadhar number">
              <span class="text-danger error" id="error_aadhar_no"></span>
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">PAN Card No</label>
              <input type="text" name="pan_card_no" value="<?= set_value('pan_card_no'); ?>" class="form-control"
                placeholder="Enter PAN number">
              <span class="text-danger error" id="error_pan_card_no"></span>
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">GST No</label>
              <input type="text" name="gst_no" value="<?= set_value('gst_no'); ?>" class="form-control"
                placeholder="Enter GST number">
              <span class="text-danger error" id="error_gst_no"></span>
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Pincode</label>
              <input type="text" name="pincode" value="<?= set_value('pincode'); ?>" class="form-control"
                placeholder="Enter pincode">
              <span class="text-danger error" id="error_pincode"></span>
            </div>

            <div class="col-md-6 mb-3">
              <label class="form-label">Address</label>
              <textarea name="address" class="form-control" rows="3"
                placeholder="Enter full address"><?= set_value('address'); ?></textarea>
              <span class="text-danger error" id="error_address"></span>
            </div>
          </div>

          <!-- Bank Details Accordion -->
          <div class="accordion mt-4" id="bankDetailsAccordion">
            <div class="accordion-item">
              <h2 class="accordion-header" id="headingBank">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                  data-bs-target="#collapseBank" aria-expanded="false" aria-controls="collapseBank">
                  + Bank Details
                </button>
              </h2>
              <div id="collapseBank" class="accordion-collapse collapse" aria-labelledby="headingBank"
                data-bs-parent="#bankDetailsAccordion">
                <div class="accordion-body">
                  <div class="row">
                    <div class="col-md-6 mb-3">
                      <label class="form-label">Bank Name</label>
                      <input type="text" name="bank_name" value="<?= set_value('bank_name'); ?>" class="form-control"
                        placeholder="Enter bank name">
                      <span class="text-danger error" id="error_bank_name"></span>
                    </div>

                    <div class="col-md-6 mb-3">
                      <label class="form-label">Account Holder</label>
                      <input type="text" name="bank_account_holder" value="<?= set_value('bank_account_holder'); ?>"
                        class="form-control" placeholder="Enter account holder name">
                      <span class="text-danger error" id="error_bank_account_holder"></span>
                    </div>

                    <div class="col-md-6 mb-3">
                      <label class="form-label">Account No</label>
                      <input type="text" name="account_no" value="<?= set_value('account_no'); ?>" class="form-control"
                        placeholder="Enter account number">
                      <span class="text-danger error" id="error_account_no"></span>
                    </div>

                    <div class="col-md-6 mb-3">
                      <label class="form-label">IFSC Code</label>
                      <input type="text" name="ifsc_code" value="<?= set_value('ifsc_code'); ?>" class="form-control"
                        placeholder="Enter IFSC code">
                      <span class="text-danger error" id="error_ifsc_code"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="<?= site_url('customer'); ?>" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Save Customer</button>
          </div>

          <?php echo form_close(); ?>
        </div>
      </div>
    </div>
  </div>

  <?php $this->load->view('common/footer'); ?>
</main>

<script>
document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById("customerForm");

  const fields = {
    vendor_id: { required: true, message: "Please select vendor" },
    name: { required: true, message: "Full name is required" },
    username: { required: true, message: "Username is required" },
    mobile_no: {
      required: true,
      regex: /^[6-9]\d{9}$/,
      message: "Enter valid 10-digit mobile number"
    },
    whatsapp_no: {
      required: false,
      regex: /^[6-9]\d{9}$/,
      message: "Enter valid WhatsApp number"
    },
    email: {
      required: false,
      regex: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
      message: "Enter valid email address"
    },
    password: {
      required: true,
      minLength: 6,
      message: "Password must be at least 6 characters"
    },
    aadhar_no: {
      required: false,
      regex: /^\d{12}$/,
      message: "Enter valid 12-digit Aadhaar number"
    },
    pan_card_no: {
      required: false,
      regex: /^[A-Z]{5}[0-9]{4}[A-Z]{1}$/,
      message: "Enter valid PAN card number"
    },
    gst_no: {
      required: false,
      regex: /^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/,
      message: "Enter valid GST number"
    },
    pincode: {
      required: false,
      regex: /^[1-9][0-9]{5}$/,
      message: "Enter valid 6-digit pincode"
    },
    bank_name: {
      required: false,
      regex: /^[a-zA-Z\s]{3,}$/,
      message: "Enter valid bank name"
    },
    bank_account_holder: {
      required: false,
      regex: /^[a-zA-Z\s]{3,}$/,
      message: "Enter valid account holder name"
    },
    account_no: {
      required: false,
      regex: /^\d{9,18}$/,
      message: "Enter valid account number"
    },
    ifsc_code: {
      required: false,
      regex: /^[A-Z]{4}0[A-Z0-9]{6}$/,
      message: "Enter valid IFSC code"
    }
  };

  function showError(inputName, message) {
    const errorEl = document.getElementById("error_" + inputName);
    if (errorEl) errorEl.innerText = message;
  }

  function clearError(inputName) {
    const errorEl = document.getElementById("error_" + inputName);
    if (errorEl) errorEl.innerText = "";
  }

  function validateField(input) {
    const name = input.name;
    const rules = fields[name];
    if (!rules) return true;

    let value = input.value.trim();

    if (rules.required && value === "") {
      showError(name, rules.message);
      return false;
    }

    if (!rules.required && value !== "") {
      if (rules.regex && !rules.regex.test(value)) {
        showError(name, rules.message);
        return false;
      }
      if (rules.minLength && value.length < rules.minLength) {
        showError(name, rules.message);
        return false;
      }
    }

    if (rules.required && rules.regex && !rules.regex.test(value)) {
      showError(name, rules.message);
      return false;
    }

    if (rules.required && rules.minLength && value.length < rules.minLength) {
      showError(name, rules.message);
      return false;
    }

    clearError(name);
    return true;
  }

  const bankFields = ["bank_name", "bank_account_holder", "account_no", "ifsc_code"];

  function checkBankFieldsRequired() {
    const anyFilled = bankFields.some(name => {
      const input = form.querySelector(`[name="${name}"]`);
      return input && input.value.trim() !== "";
    });

    bankFields.forEach(name => {
      if (fields[name]) fields[name].required = anyFilled;
    });
  }

  Object.keys(fields).forEach(name => {
    const input = form.querySelector(`[name="${name}"]`);
    if (input) {
      input.addEventListener("input", () => {
        if (bankFields.includes(name)) checkBankFieldsRequired();
        validateField(input);
      });
      if (input.tagName === "SELECT") {
        input.addEventListener("change", () => validateField(input));
      }
    }
  });

  form.addEventListener("submit", function (e) {
    checkBankFieldsRequired();

    let valid = true;
    let firstErrorField = null;

    Object.keys(fields).forEach(name => {
      const input = form.querySelector(`[name="${name}"]`);
      if (input && !validateField(input)) {
        valid = false;
        if (!firstErrorField) firstErrorField = input;
      }
    });

    if (!valid) {
      e.preventDefault();
      firstErrorField.focus();
    }
  });
});

</script>

