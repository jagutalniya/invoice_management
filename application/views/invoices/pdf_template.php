<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice #INV-001</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <style>
    :root {
      --primary: #4361ee;
      --secondary: #3a0ca3;
      --success: #4cc9f0;
      --warning: #f72585;
      --light: #f8f9fa;
      --dark: #212529;
      --gray: #6c757d;
      --border-radius: 12px;
      --shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }

    body {
      background: linear-gradient(135deg, #f4f6f9 0%, #e9ecef 100%);
      font-family: 'Segoe UI', Tahoma, sans-serif;
      color: #333;
      min-height: 100vh;
      padding: 2rem 0;
    }

    .invoice-container {
      background: #fff;
      padding: 2.5rem;
      border-radius: var(--border-radius);
      margin: 0 auto;
      max-width: 950px;
      box-shadow: var(--shadow);
      opacity: 0;
      transform: translateY(20px);
      transition: all 0.5s ease;
    }

    .invoice-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding-bottom: 1.5rem;
      margin-bottom: 2rem;
      border-bottom: 2px solid #e9ecef;
    }

    .logo {
      font-size: 2rem;
      font-weight: 700;
      color: var(--primary);
    }

    .status-badge {
      padding: 0.5rem 1.2rem;
      border-radius: 50px;
      font-weight: 600;
      font-size: 0.9rem;
    }

    .bill-to,
    .invoice-details,
    .summary-card,
    .notes-box {
      border-radius: 8px;
      padding: 1rem 1.5rem;
      background: #f8f9fa;
    }

    .table thead th {
      background: var(--primary);
      color: white;
      padding: 0.9rem 1rem;
      font-weight: 600;
    }

    .table tbody td {
      padding: 1rem;
      vertical-align: middle;
    }

    .table-striped tbody tr:nth-of-type(odd) {
      background-color: rgba(67, 97, 238, 0.05);
    }

    .summary-item {
      display: flex;
      justify-content: space-between;
      padding: 0.6rem 0;
      border-bottom: 1px dashed #e2e8f0;
    }

    .grand-total {
      font-size: 1.2rem;
      font-weight: 700;
      color: var(--primary);
      border-top: 2px solid #e2e8f0;
      padding-top: 1rem;
      margin-top: 0.5rem;
      border-bottom: none;
    }

    .action-buttons .btn {
      border-radius: 8px;
      padding: 0.6rem 1.5rem;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .action-buttons .btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .company-info {
      color: var(--gray);
      font-size: 0.9rem;
    }

    @media print {
      body {
        background: #fff;
        padding: 0;
        margin: 0;
      }

      .invoice-container {
        box-shadow: none;
        width: 100%;
        max-width: 100%;
        padding: 0.5rem;
        transform: scale(0.95);
      }

      .action-buttons {
        display: none;
      }

      .invoice-header,
      .bill-to,
      .invoice-details,
      .table,
      .notes-box,
      .summary-card {
        page-break-inside: avoid;
      }

      .table,
      .table tr,
      .table td,
      .table th {
        page-break-inside: avoid;
      }

      body,
      .invoice-container {
        font-size: 12px;
      }
    }
  </style>
</head>

<body>
  <div class="container">
    <div class="invoice-container">
      <div class="invoice-header">
        <div>
          <div class="logo">INVOICE</div>
          <div class="company-info mt-2">
            <i class="fas fa-building me-1"></i>Jagrup Talniya<br>
            <i class="fas fa-map-marker-alt me-1"></i>Degana Nagaur<br>
            <i class="fas fa-phone me-1"></i>7850984303
          </div>
        </div>
        <div class="text-end">
          <div class="invoice-id">#
            <?= $invoice->invoice_no ?>
          </div>
          <div class="status-badge bg-<?= $invoice->status == 'paid' ? 'success' : 'warning' ?>">
            <?= ucfirst($invoice->status) ?>
          </div>
        </div>
      </div>

      <div class="row mb-4">
        <div class="col-md-5">
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
        <br>
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

      <div class="notes-box">
        <h6 class="mb-2"><i class="fas fa-sticky-note me-2"></i>Notes</h6>
        <p class="mb-0">Thank you for your business. Payment is due within 15 days of invoice date.</p>
      </div>
      <br>

      <div class="row">
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
      </div>

      <div class="text-center mt-4 pt-3 text-muted">
        <p class="mb-0">Thank you for your business!</p>
        <small>If you have any questions concerning this invoice, contact jagrupatlniya@gmail.com</small>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const container = document.querySelector('.invoice-container');
      container.style.opacity = '1';
      container.style.transform = 'translateY(0)';
    });
  </script>
</body>

</html>