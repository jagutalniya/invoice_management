<?php $this->load->view('common/sidebar'); ?>

<main class="main-content">
  <div class="top-header">
    <h1 class="page-title">
      <i class="fas fa-file-invoice"></i>
      Customer Management
    </h1>
  </div>

  <div class="stats-container ">
    <div class="quick-actions d-flex justify-content-around flex-wrap">
      <a href="<?= site_url('invoice/create') ?>"
        class="action-btn d-flex align-items-center p-2 rounded text-dark text-decoration-none ">
        <div class="action-icon me-2" style="background: rgba(67, 97, 238, 0.2); color: var(--primary);">
          <i class="fas fa-file-invoice"></i>
        </div>
        <span>Create Invoice</span>
      </a>

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
        <div class="action-icon me-2" style="background: rgba(255, 193, 7, 0.2); color: #ffc107;">
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
        Customer
      </div>
      <?php
      $i = 1;
      ?>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table id="customersTable" class="table table-hover" style="width:100%">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Phone</th>
              <th>Email</th>
              <th>Address</th>
              <th>Vendor</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if(!empty($customers)): ?>
            <?php foreach($customers as $c): ?>
            <tr>
              <td>
                <?= $i++ ?>
              </td>
              <td>
                <?= $c->name ?>
              </td>
              <td>
                <?= $c->mobile_no ?>
              </td>
              <td>
                <?= $c->email ?>
              </td>
              <td>
                <?= $c->address ?>
              </td>
              <td>
                <?= $c->vendor_name ?>
              </td>
            <td>
              <div class="d-flex gap-2">
                <a href="<?= site_url('customer/edit/'.$c->id) ?>" class="btn btn-sm btn-warning" title="Edit">
                  <i class="fas fa-edit"></i>
                </a>
                <a href="<?= site_url('customer/delete/'.$c->id) ?>" class="btn btn-sm btn-danger"
                  onclick="return confirm('Are you sure you want to delete this customer?');">
                  <i class="fas fa-trash"></i>
                </a>
              </div>
            </td>
            </tr>


            <?php endforeach; ?>
            <?php else: ?>
            <tr>
              <td colspan="5" class="text-center">No customers found. <a href="<?= site_url('customers/create') ?>">Add
                  your first customer</a></td>
            </tr>
            <?php endif; ?>
          </tbody>
        </table>

      </div>
    </div>
  </div>

  <?php $this->load->view('common/footer'); ?>
<script>
  $(document).ready(function() {
      $('#customersTable').DataTable({
          "pageLength": 5,
          "lengthMenu": [5, 10, 25, 50, 100], 
      });
  });
</script>
