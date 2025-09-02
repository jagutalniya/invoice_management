<?php $this->load->view('common/sidebar'); ?>

<main class="main-content">
  <div class="top-header">
    <h1 class="page-title">
      📝 Create Invoice
    </h1>
  </div>


  <div class="container">
    <div class="card p-4">
      <form method="post" action="<?= site_url('invoice/store') ?>">

        <div class="row mb-1">
<div class="col-md-8">
    <label class="form-label">Customer <span class="text-danger">*</span></label>
    <select name="customer_id" class="form-select">
        <option value="">Select Customer</option>
        <?php if(!empty($customers)): ?>
            <?php foreach($customers as $c): ?>
                <?php if(!empty($c) && isset($c->id)): ?>
                    <option value="<?= $c->id ?>"><?= $c->name ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </select>
</div>

          <div class="col-md-4">
            <label class="form-label">Invoice Date</label>
            <input type="date" name="invoice_date" class="form-control">
          </div>
          <div class="col-md-4">
            <label class="form-label">Due Date</label>
            <input type="date" name="due_date" class="form-control">
          </div>
          <div class="col-md-4">
            <label class="form-label">Discount (₹)</label>
            <input type="number" step="0.01" name="discount" class="form-control" value="0">
          </div>
          <div class="col-md-4">
            <label class="form-label">Notes</label>
            <input type="text" name="notes" class="form-control" placeholder="Any special instructions">
          </div>
        </div>

        <div class="card mt-4">
          <div class="card-header">Invoice Items</div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table table-bordered table-hover mb-0" id="itemsTable">
                <thead>
                  <tr>
                    <th>Description</th>
                    <th width="120">Quantity</th>
                    <th width="140">Unit Price (₹)</th>
                    <th width="140">Total (₹)</th>
                    <th width="60">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td><input type="text" name="description[]" class="form-control" ></td>
                    <td><input type="number" name="quantity[]" class="form-control qty" value="1" min="1"></td>
                    <td><input type="number" name="unit_price[]" class="form-control price" value="0" step="0.01"></td>
                    <td><input type="number" name="total[]" class="form-control total" value="0" readonly></td>
                    <td class="text-center">
                      <button type="button" class="btn btn-danger btn-sm" disabled>X</button>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <button type="button" id="addRow" class="btn btn-outline-secondary btn-sm mt-2">+ Add Item</button>


        <div class="row mt-4">
          <div class="col-md-6 offset-md-6">
            <div class="card p-3">
              <div class="d-flex justify-content-between summary-box">
                <span>Subtotal:</span>
                <span id="subtotal" class="summary-value">₹0.00</span>
              </div>
              <div class="d-flex justify-content-between summary-box">
                <span>Grand Total:</span>
                <span id="grand_total" class="summary-value text-success">₹0.00</span>
                <input type="hidden" name="subtotal" id="subtotalInput">
                <input type="hidden" name="grand_total" id="grandTotalInput">
              </div>
            </div>
          </div>
        </div>

        <div class="row mt-3">
          <div class="col-md-3">
            <label class="form-label">Payment Status</label>
            <select name="status" class="form-select" required>
              <option value="unpaid">Unpaid</option>
              <option value="paid">Paid</option>
            </select>
          </div>
        </div>

        <div class="mt-4">
          <button type="submit" class="btn btn-success px-4">💾 Save Invoice</button>
          <a href="<?= site_url('invoice') ?>" class="btn btn-secondary px-4">Cancel</a>
        </div>
      </form>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <style>
  .error-text {
    color: red;
    font-size: 0.85rem;
  }
</style>

<script>
  function updateTotals() {
    let subtotal = 0;

    $('#itemsTable tbody tr').each(function () {
      let qty = parseFloat($(this).find('.qty').val()) || 0;
      let price = parseFloat($(this).find('.price').val()) || 0;
      let total = qty * price;
      $(this).find('.total').val(total.toFixed(2));
      subtotal += total;
    });

    let discount = parseFloat($('input[name="discount"]').val()) || 0;
    if (discount < 0) discount = 0;

    let grandTotal = subtotal - discount;
    if (grandTotal < 0) grandTotal = 0;

    $('#subtotal').text("₹" + subtotal.toFixed(2));
    $('#grand_total').text("₹" + grandTotal.toFixed(2));
    $('#subtotalInput').val(subtotal.toFixed(2));
    $('#grandTotalInput').val(grandTotal.toFixed(2));
  }

  function showError(input, message) {
    let errorEl = $(input).siblings(".error-text");
    if (errorEl.length === 0) {
      $(input).after(`<div class="error-text">${message}</div>`);
    } else {
      errorEl.text(message);
    }
  }

  function clearError(input) {
    $(input).siblings(".error-text").remove();
  }

  function validateField(input) {
    let name = $(input).attr("name");
    let value = $(input).val().trim();
    let valid = true;

    switch (name) {
      case "customer_id":
        if (!value) {
          showError(input, "Please select a customer");
          valid = false;
        } else clearError(input);
        break;

      case "invoice_date":
        if (!value) {
          showError(input, "Invoice date is required");
          valid = false;
        } else clearError(input);
        break;

      case "description[]":
        if (!value) {
          showError(input, "Description required");
          valid = false;
        } else clearError(input);
        break;

      case "quantity[]":
        if (value === "" || parseInt(value) < 1) {
          showError(input, "Quantity must be at least 1");
          valid = false;
        } else clearError(input);
        break;

      case "unit_price[]":
        if (value === "" || parseFloat(value) < 0) {
          showError(input, "Unit price must be 0 or more");
          valid = false;
        } else clearError(input);
        break;

      case "discount":
        if (parseFloat(value) < 0) {
          showError(input, "Discount cannot be negative");
          valid = false;
        } else clearError(input);
        break;
    }

    return valid;
  }

  $(document).on("input change", "select, input", function () {
    validateField(this);
    if ($(this).hasClass("qty") || $(this).hasClass("price") || $(this).attr("name") === "discount") {
      updateTotals();
    }
  });

  $('#addRow').click(function () {
    let row = `<tr>
          <td>
            <input type="text" name="description[]" class="form-control" required>
          </td>
          <td>
            <input type="number" name="quantity[]" class="form-control qty" value="1" min="1">
          </td>
          <td>
            <input type="number" name="unit_price[]" class="form-control price" value="0" step="0.01">
          </td>
          <td>
            <input type="number" name="total[]" class="form-control total" value="0" readonly>
          </td>
          <td class="text-center">
            <button type="button" class="btn btn-danger btn-sm removeRow">X</button>
          </td>
        </tr>`;
    $('#itemsTable tbody').append(row);
  });

  $(document).on('click', '.removeRow', function () {
    $(this).closest('tr').remove();
    updateTotals();
  });

  $('form').on('submit', function (e) {
    let valid = true;

    $(this).find("select, input").each(function () {
      if (!validateField(this)) valid = false;
    });

    if (!valid) {
      e.preventDefault();
      alert("Please fix errors before submitting!");
    }
  });

  $(document).ready(function () {
    updateTotals();
  });
</script>
