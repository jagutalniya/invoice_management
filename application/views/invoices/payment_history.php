<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment History - InvoiceMaster Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --primary-dark: #3a56d4;
            --secondary: #6c757d;
            --success: #4cc9f0;
            --info: #17a2b8;
            --warning: #ffc107;
            --danger: #dc3545;
            --light: #f8f9fa;
            --dark: #212529;
            --sidebar-width: 280px;
            --header-height: 70px;
            --card-radius: 12px;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fb;
            color: #333;
            overflow-x: hidden;
            line-height: 1.6;
        }

        /* Layout */
        .app-container {
            display: flex;
            min-height: 100vh;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: var(--sidebar-width);
            transition: var(--transition);
            padding: 20px;
        }

        .header {
            background: white;
            padding: 15px 25px;
            border-radius: var(--card-radius);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-title {
            display: flex;
            align-items: center;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0;
        }

        .page-title i {
            margin-right: 10px;
            color: var(--primary);
            font-size: 1.8rem;
        }

        .card {
            background: white;
            border-radius: var(--card-radius);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 25px;
            border: none;
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            padding: 20px 25px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-header i {
            margin-right: 10px;
            color: var(--primary);
        }

        .card-body {
            padding: 25px;
        }

        .form-select {
            border-radius: 8px;
            padding: 10px 15px;
            border: 1px solid #ddd;
            transition: var(--transition);
        }

        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
        }

        .table {
            border-collapse: separate;
            border-spacing: 0;
            width: 100%;
        }

        .table th {
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
            font-weight: 600;
            padding: 12px 15px;
        }

        .table td {
            padding: 12px 15px;
            vertical-align: middle;
            border-top: 1px solid #dee2e6;
        }

        .table tr:hover {
            background-color: rgba(67, 97, 238, 0.05);
        }

        .amount {
            font-weight: 500;
            color: var(--dark);
        }

        .customer-name {
            color: var(--primary);
            font-weight: 500;
        }

        .no-data {
            text-align: center;
            padding: 40px;
            color: var(--secondary);
        }

        .no-data i {
            font-size: 3rem;
            margin-bottom: 15px;
            color: #dee2e6;
        }

        .filter-container {
            background: #f8fbff;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        /* Responsive table styles */
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        /* Mobile-specific styles */
        @media screen and (max-width: 1200px) {
            .main-content {
                padding: 15px;
            }

            .card-body {
                padding: 20px;
            }
        }

        @media screen and (max-width: 992px) {
            .main-content {
                margin-left: 0;
                width: 100%;
            }

            .sidebar.active+.main-content {
                margin-left: 260px;
                width: calc(100% - 260px);
            }

            .header {
                padding: 12px 20px;
            }

            .card-header {
                padding: 15px 20px;
            }
        }

        @media screen and (max-width: 768px) {
            .header {
                flex-direction: column;
                align-items: flex-start;
            }

            .header-actions {
                margin-top: 15px;
                width: 100%;
            }

            .header-actions .btn {
                width: 100%;
            }

            .card-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .filter-container {
                padding: 12px;
            }

            .table th,
            .table td {
                padding: 10px 8px;
                font-size: 0.9rem;
            }

            .table th:nth-child(2),
            .table td:nth-child(2) {
                min-width: 150px;
            }

            .table th:nth-child(3),
            .table td:nth-child(3) {
                min-width: 120px;
            }

            .table th:nth-child(4),
            .table td:nth-child(4) {
                min-width: 120px;
            }

            .table th:nth-child(5),
            .table td:nth-child(5) {
                min-width: 100px;
            }

            .no-data {
                padding: 20px;
            }

            .no-data i {
                font-size: 2.5rem;
            }

            .alert {
                padding: 12px 15px;
            }
        }

        @media screen and (max-width: 576px) {
            .main-content {
                padding: 10px;
            }

            .header {
                padding: 10px 15px;
                margin-bottom: 15px;
            }

            .page-title {
                font-size: 1.5rem;
            }

            .card {
                border-radius: 10px;
                margin-bottom: 15px;
            }

            .card-header,
            .card-body {
                padding: 15px;
            }

            .filter-container {
                padding: 10px;
            }

            .table {
                font-size: 0.85rem;
            }

            .table th,
            .table td {
                padding: 8px 6px;
            }

            .customer-name i,
            .table td i {
                margin-right: 5px;
            }

            .no-data h4 {
                font-size: 1.2rem;
            }

            .no-data p {
                font-size: 0.9rem;
            }

            tfoot tr td {
                font-size: 0.9rem;
            }
        }

        @media screen and (max-width: 400px) {
            .page-title {
                font-size: 1.3rem;
            }

            .page-title i {
                font-size: 1.5rem;
            }

            .table {
                font-size: 0.8rem;
            }

            .table th,
            .table td {
                padding: 6px 4px;
            }

            .badge {
                font-size: 0.75rem;
            }
        }
    </style>
</head>

<body>
    <div class="app-container">

        <?php $this->load->view('common/sidebar'); ?>

        <main class="main-content">
            <div class="header">
                <h1 class="page-title">
                    <i class="fas fa-history"></i>
                    Payment History
                </h1>
                <div class="header-actions">
                    <a href="<?php echo site_url('invoice'); ?>" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Back
                    </a>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div>
                                    <i class="fas fa-filter"></i>
                                    Filter Payments
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="filter-container">
                                    <form method="get" action="<?php echo site_url('invoice/payment_history'); ?>">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <label class="form-label fw-bold">Select Customer:</label>
                                                <select name="customer_id" class="form-select"
                                                    onchange="this.form.submit()">
                                                    <option value="">-- All Customers --</option>
                                                    <?php if(!empty($customers)): ?>
                                                    <?php foreach($customers as $c): ?>
                                                    <?php if(!empty($c) && isset($c->id)): ?>
                                                    <option value="<?= $c->id ?>" <?=(isset($customer_id) &&
                                                        $customer_id==$c->id) ? 'selected' : '' ?>>
                                                        <?= $c->name ?>
                                                    </option>
                                                    <?php endif; ?>
                                                    <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </select>

                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <?php if($customer_name): ?>
                                <div class="alert alert-info mt-3">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Showing payments for: <strong>
                                        <?php echo $customer_name; ?>
                                    </strong>
                                </div>
                                <?php endif; ?>

                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Customer Name</th>
                                                <th>Invoice No</th>
                                                <th>Date</th>
                                                <th class="text-end">Amount (₹)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(!empty($payments)): ?>
                                            <?php $i = 1; foreach($payments as $p): ?>
                                            <tr>
                                                <td>
                                                    <?= $i++ ?>
                                                </td>
                                                <td>
                                                    <span class="customer-name">
                                                        <i class="fas fa-user me-2"></i>
                                                        <?php echo $p->customer_name; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-light text-dark">
                                                        <?php echo $p->invoice_no; ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <i class="fas fa-calendar-day me-2 text-muted"></i>
                                                    <?php echo date($p->payment_date); ?>
                                                </td>
                                                <td class="text-end amount">
                                                    ₹
                                                    <?php echo number_format($p->amount, 2); ?>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                            <?php else: ?>
                                            <tr>
                                                <td colspan="6">
                                                    <div class="no-data">
                                                        <i class="fas fa-receipt"></i>
                                                        <h4>No payments found</h4>
                                                        <p>There are no payment records to display.</p>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php endif; ?>
                                        </tbody>
                                        <?php if(!empty($payments)): ?>
                                        <tfoot>
                                            <tr class="fw-bold">
                                                <td colspan="4" class="text-end">Total:</td>
                                                <td class="text-end">
                                                    ₹
                                                    <?php 
                                                        $total = 0;
                                                        foreach($payments as $p) {
                                                            $total += $p->amount;
                                                        }
                                                        echo number_format($total, 2); 
                                                    ?>
                                                </td>
                                            </tr>
                                        </tfoot>
                                        <?php endif; ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php $this->load->view('common/footer'); ?>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebarToggle = document.querySelector('.sidebar-toggle');
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main-content');

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function () {
                    sidebar.classList.toggle('active');
                    mainContent.classList.toggle('active');
                });
            }
        });
    </script>
</body>

</html>