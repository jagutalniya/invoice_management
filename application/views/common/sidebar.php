<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>InvoiceMaster Pro - Professional Invoice Management</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.bootstrap5.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>
  <div class="app-container">
    <aside class="sidebar">
      <div class="sidebar-header">
        <a href="<?= site_url('invoices') ?>" class="sidebar-brand">
          <i class="fas fa-file-invoice"></i>
          <span>InvoiceMaster</span>
        </a>
      </div>

      <nav class="sidebar-nav">
        <div class="nav-item">
          <a href="<?= site_url('invoices') ?>"
            class="nav-link <?= ($this->uri->segment(1) == 'invoices') ? 'active' : '' ?>">
            <i class="fas fa-file-invoice"></i>
            <span>Invoices</span>
          </a>
        </div>
        <div class="nav-item">
          
      <?php if($this->session->userdata('user_type') == 1 || $this->session->userdata('user_type') == 2): ?>
          <a href="<?= site_url('customer') ?>"
            class="nav-link <?= ($this->uri->segment(1) == 'customer') ? 'active' : '' ?>">
            <i class="fas fa-users"></i>
            <span>Customers</span>
          </a>
        <?php endif; ?>
        </div>
        <div class="nav-item">
        <?php if($this->session->userdata('user_type') == 1): ?>
          <a href="<?= site_url('vendor') ?>" class="nav-link">
            <i class="fas fa-chart-bar"></i>
            <span>Vendors</span>
          </a>
        <?php endif; ?>
        </div>
        
        <div class="nav-item">
          <a href="<?= site_url('invoice/receive_payment') ?>"
            class="nav-link <?= ($this->uri->segment(1) == 'invoice' && $this->uri->segment(2) == 'receive_payment') ? 'active' : '' ?>">
            <i class="fas fa-money-bill-wave"></i>
            <span>Payments</span>
          </a>
        </div>


        <div class="nav-item">
          <a href="<?= base_url('profile/edit') ?>" class="nav-link">
            <i class="fas fa-cog"></i>
            <span>Settings</span>
          </a>
        </div>
      </nav>

      <div class="sidebar-footer">
        <div class="user-profile">
          <div class="user-info">
            <h5>
              <?= $this->session->userdata('name') ?>
            </h5><hr>
            <small>User Type:
              <?php if($this->session->userdata('user_type')== 1 ){
                  echo ("Admin");
                }elseif($this->session->userdata('user_type')== 2 ){
                  echo ("Vendor");
                }else{
                  echo ("Customer");
                } ?>
            </small>
          <?php if($this->session->userdata('logged_in')): ?>
          <a href="<?= site_url('auth/logout') ?>" class="btn ms-4 btn-sm btn-danger">
            Logout
          </a>
          <?php endif; ?>
          <hr>
          </div>
        </div>
      </div>
    </aside>