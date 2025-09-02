<?php $this->load->view('common/sidebar'); ?>

<main class="main-content">

  <div class="top-header">
    <h1 class="page-title">
      <i class="fas fa-users"></i>
      Vendor Management
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

      <a href="<?= site_url('customers/create')?>"
        class="action-btn d-flex align-items-center p-2 rounded text-dark text-decoration-none ">
        <div class="action-icon me-2" style="background: rgba(52, 191, 163, 0.2); color: #34bfa3;">
          <i class="fas fa-user-plus"></i>
        </div>
        <span>Add Customer</span>
      </a>

      <a href="<?= site_url('vendor/create') ?>"
        class="action-btn d-flex align-items-center p-2 rounded text-dark text-decoration-none">
        <div class="action-icon me-2" style="background: rgba(67, 97, 238, 0.2); color: var(--primary);">
          <i class="fas fa-user-plus"></i>
        </div>
        <span>Add Vendor</span>
      </a>

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
        Vendor List
      </div>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table id="vendorsTable" class="table table-hover" style="width:100%">
          <thead>
            <tr>
              <th>#</th>
              <th>Full Name</th>
              <th>Email</th>
              <th>Mobile</th>
              <th>Address</th>
              <th>Pincode</th>
              <th>Created</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if(!empty($vendors)): ?>
            <?php 
              $i = 1;
              foreach($vendors as $vendor): ?>
            <tr>
              <td><?= $i++ ?></td>
              <td><?= $vendor->name ?></td>
              <td><?= $vendor->email ?></td>
              <td><?= $vendor->mobile_no ?></td>
              <td><?= $vendor->address ?></td>
              <td><?= $vendor->pincode ?></td>
              <td><?= date("d M Y", strtotime($vendor->created_at)) ?></td>
              <td class="action-buttons">
                <a href="<?= site_url('vendor/edit/'.$vendor->id) ?>" class="btn btn-sm btn-warning">
                  <i class="fas fa-edit"></i>
                </a>
                <a href="<?= site_url('vendor/delete/'.$vendor->id) ?>" class="btn btn-sm btn-danger"
                  onclick="return confirm('Are you sure you want to delete this vendor?');">
                  <i class="fas fa-trash"></i>
                </a>
              </td>
            </tr>
            <?php endforeach; ?>
            <?php else: ?>
            <tr>
              <td colspan="9" class="text-center text-muted">No vendors found.</td>
            </tr>
            <?php endif; ?>
          </tbody>
        </table>

        <nav>
          <ul class="pagination justify-content-center">
  
          </ul>
        </nav>

      </div>
    </div>
  </div>

  <?php $this->load->view('common/footer'); ?>
</main>
<script>
$(document).ready(function() {
    var table = $('#vendorsTable').DataTable({
        "paging": true,
        "pageLength": 5,
        "lengthChange": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "order": [[0, 'asc']],
    });

    $('#searchVendor').on('keyup', function() {
        table.search(this.value).draw();
    });

    $('#resetVendorFilters').on('click', function() {
        $('#searchVendor').val('');
        table.search('').draw();
    });
});
</script>
