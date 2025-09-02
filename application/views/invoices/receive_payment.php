<?php $this->load->view('common/sidebar'); ?>

<main class="main-content">

  <div class="top-header">
    <h1 class="page-title">
      <i class="fas fa-file-invoice"></i>
      Receive Payment
    </h1> <a href="<?= site_url('invoice') ?>" class="btn btn-outline-secondary my-2">Back</a>
  </div>
  <div class="row justify-content-center">
    <div class="col-lg-12">
      <div class="card p-4">

        <div class="step-indicator">
          <div class="step <?= isset($customer_id) ? 'completed' : 'active' ?>">
            <div class="step-number">1</div>
            <div class="step-text">Select Customer</div>
          </div>
          <div class="step <?= isset($invoices) ? 'active' : '' ?>">
            <div class="step-number">2</div>
            <div class="step-text">Choose Invoice</div>
          </div>
          <div class="step">
            <div class="step-number">3</div>
            <div class="step-text">Receive Payment</div>
          </div>
        </div>

        <form method="get" action="<?= base_url('index.php/invoice/receive_payment') ?>" class="mb-5">
          <div class="mb-4">
            <label for="customer_id" class="form-label fw-bold">Select Customer</label>
    <select name="customer_id" class="form-select" required>
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
          <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-lg">
              <i class="fas fa-search me-2"></i>Load Invoices
            </button>
          </div>
        </form>

        <?php if(isset($invoices)): ?>
        <hr class="my-4">
        <div class="payment-summary mb-5">
          <h4 class="mb-3">Payment Summary for
            <?= $customer_name ?>
          </h4>
          <div class="row">
            <div class="col-md-6">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <span>Total Outstanding:</span>
                <strong>₹
                  <?= number_format($total_outstanding, 2) ?>
                </strong>
              </div>
              <div class="d-flex justify-content-between align-items-center mb-2">
                <span>Number of Invoices:</span>
                <strong>
                  <?= count($invoices) ?>
                </strong>
              </div>
            </div>
            <div class="col-md-6">
              <div class="d-flex justify-content-between align-items-center mb-2">
                <span>Status:</span>
                <span class="status-badge <?= $total_outstanding > 0 ? 'bg-warning' : 'bg-success' ?>">
                <?= $total_outstanding > 0 ? 'Pending Payments' : 'Fully Paid' ?>
                </span>
              </div>
            </div>
          </div>
        </div>

        <div class="invoice-list mb-4">
          <?php foreach ($invoices as $invoice): 
              $paid_percent = ($invoice->received / $invoice->grand_total) * 100;
              $status_class = $invoice->pending == 0 ? 'bg-success' : ($paid_percent > 0 ? 'bg-warning' : 'bg-danger');
              $status_text = $invoice->pending == 0 ? 'Paid' : ($paid_percent > 0 ? 'Partial' : 'Unpaid');
          ?>
          <div class="invoice-item" onclick="selectInvoice(this, <?= $invoice->id ?>, <?= $invoice->pending ?>)">
            <div class="d-flex justify-content-between align-items-start">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="invoice_id" value="<?= $invoice->id ?>"
                  id="invoice_<?= $invoice->id ?>" required>
                <label class="form-check-label fw-bold" for="invoice_<?= $invoice->id ?>">
                  Invoice #
                  <?= $invoice->invoice_no ?>
                </label>
              </div>
              <span class="status-badge <?= $status_class ?>">
                <?= $status_text ?>
              </span>
            </div>
            <div class="row mt-3">
              <div class="col-md-8">
                <div class="d-flex justify-content-between mb-1">
                  <small>Due Date:</small>
                  <small><strong>
                      <?= date('d M Y', strtotime($invoice->due_date)) ?>
                    </strong></small>
                </div>
                <div class="d-flex justify-content-between mb-1">
                  <small>Total Amount:</small>
                  <small>₹
                    <?= number_format($invoice->grand_total, 2) ?>
                  </small>
                </div>
                <div class="d-flex justify-content-between mb-1">
                  <small>Amount Paid:</small>
                  <small>₹
                    <?= number_format($invoice->received, 2) ?>
                  </small>
                </div>
                <div class="d-flex justify-content-between mb-1">
                  <small>Pending Amount:</small>
                  <small class="fw-bold text-danger">₹
                    <?= number_format($invoice->pending, 2) ?>
                  </small>
                </div>
                <div class="progress">
                  <div class="progress-bar <?= $status_class ?>" role="progressbar" style="width: <?= $paid_percent ?>%"
                    aria-valuenow="<?= $paid_percent ?>" aria-valuemin="0" aria-valuemax="100">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>

        <div id="paymentForm" class="hidden mt-5">
          <h4 class="mb-4">Payment Details</h4>
          <form method="post" action="<?= base_url('index.php/invoice/submit_payment') ?>" id="paymentFormElement">
            <input type="hidden" name="customer_id" value="<?= $customer_id ?>">
            <input type="hidden" name="invoice_id" id="selected_invoice_id">

            <div class="row mb-4">
              <div class="col-md-6 amount-input">
                <label for="amount" class="form-label fw-bold">Amount to Receive</label>
                <input type="number" step="0.01" name="amount" id="amount" class="form-control form-control-lg" required
                  placeholder="0.00">
                <div class="form-text">Maximum: ₹<span id="maxAmount">0.00</span></div>
              </div>

              <div class="col-md-6">
                <label for="payment_date" class="form-label fw-bold">Payment Date</label>
                <input type="date" name="payment_date" id="payment_date" class="form-control form-control-lg"
                  value="<?= date('Y-m-d') ?>" required>
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <label for="notes" class="form-label fw-bold">Notes (Optional)</label>
                <textarea name="notes" id="notes" rows="3" class="form-control"
                  placeholder="Any additional notes about this payment"></textarea>
              </div>
            </div>

            <div class="d-flex justify-content-between mt-4">
              <button type="button" class="btn btn-outline-secondary" onclick="deselectInvoice()">
                <i class="fas fa-arrow-left me-2"></i>Change Invoice
              </button>
              <button type="submit" class="btn btn-success btn-lg">
                <i class="fas fa-check-circle me-2"></i>Submit Payment
              </button>
            </div>
            
          </form>
        </div>
        <?php endif; ?>
        <?php $this->load->view('common/footer'); ?>