<?php $this->load->view('common/sidebar'); ?>

<main class="main-content">
  <div class="container">
    <div class="invoice-container">
      <div class="invoice-header">
        <div>
          <div class="logo">INVOICE</div>
          <div class="company-info mt-2">
            <i class="fas fa-building me-1"></i> Jagrup Talniya<br>
            <i class="fas fa-map-marker-alt me-1"></i> Degana Nagaur<br>
            <i class="fas fa-phone me-1"></i>+91 7850984303
          </div>
        </div>
        <div class="text-end">
          <div class="invoice-id">#
            <?= $invoice->invoice_no ?>
          </div>
          <span class="badge rounded-pill px-3 py-2 fw-semibold 
        <?= $invoice->status == 'paid' ? 'bg-success' : 'bg-warning text-dark' ?>">
            <?= ucfirst($invoice->status) ?>
          </span>
        </div>
      </div>

      <div class="row mb-4">
        <div class="col-md-7">
          <h5 class="mb-2"><i class="fas fa-user-circle me-2"></i>Bill To</h5>
          <div class="bill-to">
            <p class="mb-1"><strong>
                <?= $invoice->customer_name ?? 'N/A' ?>
              </strong></p>
            <p class="mb-1 text-muted">ID:
              <?= $invoice->customer_id ?>
            </p>
            <p class="mb-0"><i class="fas fa-calendar me-1"></i> Invoice Date:
              <?= date("d-m-Y", strtotime($invoice->invoice_date)) ?>
            </p>
            <p class="mb-0"><i class="fas fa-calendar-check me-1"></i> Due Date:
              <?= date("d-m-Y", strtotime($invoice->due_date)) ?>
            </p>
          </div>
        </div>
        <div class="col-md-5">
          <h5 class="mb-2"><i class="fas fa-info-circle me-2"></i>Invoice Details</h5>
          <div class="invoice-details">
            <p class="mb-1"><strong>Status:</strong>
              <?= ucfirst($invoice->status) ?>
            </p>
            <p class="mb-1"><strong>Invoice #:</strong>
              <?= $invoice->invoice_no ?>
            </p>
          </div>
        </div>
      </div>

      <h5 class="mb-3"><i class="fas fa-list me-2"></i>Invoice Items</h5>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Description</th>
              <th class="text-center">Qty</th>
              <th class="text-end">Unit Price (₹)</th>
              <th class="text-end">Total (₹)</th>
            </tr>
          </thead>
          <tbody>
            <?php $i=1; $subtotal=0; foreach ($items as $item): ?>
            <?php $line_total = $item->quantity * $item->unit_price; $subtotal += $line_total; ?>
            <tr>
              <td>
                <?= $i++ ?>
              </td>
              <td>
                <?= $item->description ?>
              </td>
              <td class="text-center">
                <?= $item->quantity ?>
              </td>
              <td class="text-end">₹
                <?= number_format($item->unit_price, 2) ?>
              </td>
              <td class="text-end">₹
                <?= number_format($line_total, 2) ?>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <div class="notes-box">
        <h6 class="mb-2"><i class="fas fa-sticky-note me-2"></i>Notes</h6>
        <p class="mb-0">Thank you for your business. Payment is due within 15 days of invoice date.</p>
      </div>

      <div class="divider"></div>

      <div class="col-md-5">
        <div class="summary-card">
          <h5 class="mb-3">Invoice Summary</h5>
          <div class="summary-item">
            <span>Subtotal:</span>
            <span>₹
              <?= number_format($subtotal, 2) ?>
            </span>
          </div>
          <div class="summary-item">
            <span>Discount:</span>
            <span>- ₹
              <?= number_format($invoice->discount, 2) ?>
            </span>
          </div>
          <div class="summary-item">
            <span>Previous Pending:</span>
            <span>+ ₹
              <?= number_format($invoice->previous_pending, 2) ?>
            </span>
          </div>
          <div class="summary-item">
            <span>Already Received:</span>
            <span>- ₹
              <?= number_format($received, 2) ?>
            </span>
          </div>
          <div class="summary-item">
            <span>Pending Amount:</span>
            <span>₹
              <?= number_format(($subtotal + $invoice->previous_pending - $invoice->discount) - $received, 2) ?>
            </span>
          </div>
          <div class="summary-item grand-total">
            <span>Grand Total:</span>
            <span>₹
              <?= number_format($subtotal + $invoice->previous_pending - $invoice->discount, 2) ?>
            </span>
          </div>
        </div>
      </div>
      <div class="row mt-5">
        <div class="col-12 col-md-7">
          <div class="action-buttons d-flex flex-wrap">

            <a href="<?= site_url('invoice/download/'.$invoice->id.'/D') ?>" class="btn btn-success mb-2 me-sm-2">
              <i class="fas fa-download me-2"></i>Download PDF
            </a>

            <a href="<?= site_url('invoice/download/'.$invoice->id.'/I') ?>" class="btn btn-success mb-2 me-sm-2">
              <i class="fas fa-eye me-2"></i>View PDF
            </a>

            <button onclick="window.print()" class="btn btn-primary mb-2 me-sm-2">
              <i class="fas fa-print me-2"></i>Print Invoice
            </button>

            <a href="<?= site_url('invoice') ?>" class="btn btn-outline-secondary mb-2 ms-3">
              Back
            </a>

          </div>
        </div>
      </div>

      <div class="text-center mt-4 pt-3 text-muted">
        <p class="mb-0">Thank you for your business!</p>
        <small>If you have any questions concerning this invoice, contact jagrupatlniya@gmail.com</small>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      document.querySelector('.invoice-container').style.opacity = '1';
      document.querySelector('.invoice-container').style.transform = 'translateY(0)';
    });
  </script>
  </div>
  </div>
  </div>

</main>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</body>

</html>