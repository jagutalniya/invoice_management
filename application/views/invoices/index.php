<?php $this->load->view('common/sidebar'); ?>

<main class="main-content">

  <div class="top-header">
    <h1 class="page-title">
      <i class="fas fa-file-invoice"></i>
      Invoice Management
    </h1>
  </div>

  <div class="stats-container ">
    <div class="quick-actions d-flex justify-content-around flex-wrap">
      <?php if($this->session->userdata('user_type') == 1 || $this->session->userdata('user_type') == 2): ?>
      <a href="<?= site_url('invoice/create') ?>"
        class="action-btn d-flex align-items-center p-2 rounded text-dark text-decoration-none">
        <div class="action-icon me-2" style="background: rgba(67, 97, 238, 0.2); color: var(--primary);">
          <i class="fas fa-file-invoice"></i>
        </div>
        <span>Create Invoice</span>
      </a>
      <?php endif; ?>

      <?php if($this->session->userdata('user_type') == 1 || $this->session->userdata('user_type') == 2): ?>
      <a href="<?= site_url('customers/create')?>"
        class="action-btn d-flex align-items-center p-2 rounded text-dark text-decoration-none ">
        <div class="action-icon me-2" style="background: rgba(52, 191, 163, 0.2); color: #34bfa3;">
          <i class="fas fa-user-plus"></i>
        </div>
        <span>Add Customer</span>
      </a>
      <?php endif; ?>

      <?php if($this->session->userdata('user_type') == 1): ?>
      <a href="<?= site_url('vendor/create') ?>"
        class="action-btn d-flex align-items-center p-2 rounded text-dark text-decoration-none">
        <div class="action-icon me-2" style="background: rgba(67, 97, 238, 0.2); color: var(--primary);">
            <i class="fas fa-user-plus"></i>
        </div>
        <span>Add Vendor</span>
      </a>
      <?php endif; ?>

      
      <a href="<?= site_url('invoice/payment_history') ?>"
        class="action-btn d-flex align-items-center p-2 rounded text-dark text-decoration-none">
        <div class="action-icon me-2" style="background: rgba(255, 193, 7, 0.2); color:   #ffc107;">
          <i class="fas fa-history"></i>
        </div>
        <span>Payment History</span>
      </a>
    </div>
  </div>

  <div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
      <div>
        <i class="fas fa-list me-2"></i>
        Recent Invoices
      </div>
      <div class="d-flex align-items-center">
        <select id="statusFilter" class="form-select status-filter">
          <option value="">All Statuses</option>
          <option value="paid">Paid</option>
          <option value="unpaid">Unpaid</option>
        </select>
        <button class="btn btn-sm btn-outline-secondary" id="resetFilters">
          <i class="fas fa-sync-alt me-1"></i>Reset
        </button>
      </div>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table id="invoicesTable" class="table table-hover" style="width:100%">
          <thead>
            <tr>
              <th>#</th>
              <th>Invoice #</th>
              <th>Customer</th>
              <th>Issued Date</th>
              <th>Due Date</th>
              <th>Amount</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if(!empty($invoices)): ?>
            <?php
                  $start = ($page - 1) * $per_page + 1;
                  $i = $start;
                  foreach($invoices as $invoice):  ?>
            <tr>
              <td>
                <?= $i++?>
              </td>
              <td>
                <?= $invoice->invoice_no ?>
              </td>
              <td>
                <?= $invoice->customer_name ?>
              </td>
              <td>
                <?= $invoice->invoice_date ?>
              </td>
              <td>
                <?= $invoice->due_date ?>
              </td>
              <td class="amount">₹
                <?= number_format((float)$invoice->subtotal_calc - (float)$invoice->discount, 2) ?>
              </td>
              <td>
                <?php if($invoice->status == 'paid'): ?>
                <span class="badge bg-success">Paid</span>
                <?php elseif($invoice->status == 'unpaid'): ?>
                <span class="badge bg-warning text-dark">Unpaid</span>
                <?php else: ?>
                <span class="badge bg-danger">Overdue</span>
                <?php endif; ?>
              </td>
              <td class="action-buttons">
                <a href="<?= site_url('invoice/view/'.$invoice->id) ?>" class="btn btn-sm btn-info">
                  <i class="fas fa-eye"></i>
                </a>
                <a href="<?= site_url('invoice/delete/'.$invoice->id) ?>" class="btn btn-sm btn-danger"
                  onclick="return confirm('Are you sure you want to delete this invoice?');">
                  <i class="fas fa-trash"></i>
                </a>
              </td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
              <td colspan="8" class="text-center text-muted">No invoices found.</td>
            </tr>
            <?php endif; ?>

          </tbody>
        </table>
        <nav>
          <ul class="pagination justify-content-center">
            <?php 
              $total_pages = ceil($total / $per_page);
              for ($p = 1; $p <= $total_pages; $p++): 
            ?>
            <li class="page-item <?= ($p == $page) ? 'active' : '' ?>">
              <a class="page-link" href="?page=<?= $p ?>">
                <?= $p ?>
              </a>
            </li>
            <?php endfor; ?>
          </ul>
        </nav>

      </div>
    </div>
  </div>

  <?php $this->load->view('common/footer'); ?>