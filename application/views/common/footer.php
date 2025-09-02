<footer class="footer">
  <div class="container">
    <div class="row">
      <div class="col-md-3 mb-4 mb-md-0">
        <h5>InvoiceMaster</h5>
        <p>Professional invoice management system designed to streamline your billing process and improve cash
          flow.</p>
        <div class="footer-social">
          <a href="#"><i class="fab fa-facebook-f"></i></a>
          <a href="#"><i class="fab fa-twitter"></i></a>
          <a href="#"><i class="fab fa-linkedin-in"></i></a>
          <a href="#"><i class="fab fa-instagram"></i></a>
        </div>
      </div>

      <div class="col-md-3 mb-4 mb-md-0">
        <h5>Quick Links</h5>
        <ul>
          <li><a href="<?= site_url('invoice') ?>"><i class="fas fa-angle-right me-2"></i> Invoices</a></li>
          <li><a href="<?= site_url('customer') ?>"><i class="fas fa-angle-right me-2"></i> Customers</a></li>
          <li><a href="<?= site_url('invoice/receive_payment') ?>"><i class="fas fa-angle-right me-2"></i>
              Payments</a></li>
          <li><a href="<?= site_url('vendor') ?>"><i class="fas fa-angle-right me-2"></i>Vendor</a></li>
        </ul>
      </div>

      <div class="col-md-3">
        <h5>Contact Us</h5>
        <div class="footer-contact">
          <p><i class="fas fa-map-marker-alt"></i> Jagrup Talniya</p>
          <p><i class="fas fa-phone"></i>78509984303</p>
          <p><i class="fas fa-envelope"></i>jagruptalniya@gmail.com</p>
        </div>
      </div>
    </div>

    <div class="footer-bottom">
      <div class="row">
        <div class="col-md-6 text-md-start">
          <p>© 2025 InvoiceMaster. All rights reserved.</p>
        </div>
        <div class="col-md-6 text-md-end">
          <p>
            <a href="#" class="text-white-50 me-3">Privacy Policy</a>
            <a href="#" class="text-white-50">Terms of Service</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</footer>
</main>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const sidebarToggle = document.querySelector('.sidebar-toggle');
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.querySelector('.main-content');

    sidebarToggle.addEventListener('click', function () {
      sidebar.classList.toggle('active');
      mainContent.classList.toggle('active');
    });

    const buttons = document.querySelectorAll('button');
    buttons.forEach(button => {
      button.addEventListener('click', function (e) {
        if (e.target.closest('.btn') && !e.target.closest('.btn-group')) {
          const originalText = this.innerHTML;
          this.innerHTML = '<span class="loading"></span> Processing...';

          setTimeout(() => {
            this.innerHTML = originalText;
          }, 1500);
        }
      });
    });
  });
</script>

<script>
  $(document).ready(function () {
    var table = $('#invoicesTable').DataTable({
      dom: "f",
      // dom: "Bf",
      // buttons: [
      // {
      // extend: 'copy',
      // className: 'btn btn-sm btn-outline-secondary',
      // text: '<i class="fas fa-copy me-1"></i>Copy'
      // },
      // {
      // extend: 'csv',
      // className: 'btn btn-sm btn-outline-primary',
      // text: '<i class="fas fa-file-csv me-1"></i>CSV'
      // },
      // {
      // extend: 'excel',
      // className: 'btn btn-sm btn-outline-success',
      // text: '<i class="fas fa-file-excel me-1"></i>Excel'
      // },
      // {
      // extend: 'pdf',
      // className: 'btn btn-sm btn-outline-danger',
      // text: '<i class="fas fa-file-pdf me-1"></i>PDF'
      // },
      // {
      // extend: 'print',
      // className: 'btn btn-sm btn-outline-info',
      // text: '<i class="fas fa-print me-1"></i>Print'
      // }
      // ],
      responsive: true,
      ordering: true,
      order: [[0, 'asc']],
      language: {
        search: "_INPUT_",
        searchPlaceholder: "Search invoices...",

      },
      columnDefs: [
        { responsivePriority: 1, targets: 1 },
        { responsivePriority: 2, targets: 2 },
        { responsivePriority: 3, targets: 7 },
        { orderable: false, targets: [0, 7] },
        { className: "dt-nowrap", targets: [7] }
      ],
      initComplete: function () {
        this.api().columns([6]).every(function () {
          var column = this;
          var select = $('#statusFilter')
            .on('change', function () {
              var val = $.fn.dataTable.util.escapeRegex($(this).val());
              column.search(val ? '^' + val + '$' : '', true, false).draw();
            });
        });
      }
    });

    // Reset filters
    $('#resetFilters').on('click', function () {
      $('#statusFilter').val('');
      table.search('').columns().search('').draw();
    });

    // Style the export buttons
    $('.dt-buttons').addClass('btn-group');
    $('.dt-button').removeClass('dt-button');
  });
</script>


<script>
  function selectInvoice(element, invoiceId, maxAmount) {
    document.querySelectorAll('.invoice-item').forEach(item => {
      item.classList.remove('selected');
    });

    element.classList.add('selected');
    document.getElementById('invoice_' + invoiceId).checked = true;
    document.getElementById('selected_invoice_id').value = invoiceId;

    const amountInput = document.getElementById('amount');
    amountInput.max = maxAmount;
    amountInput.placeholder = maxAmount.toFixed(2);
    document.getElementById('maxAmount').textContent = maxAmount.toFixed(2);

    amountInput.value = maxAmount;

    document.getElementById('paymentForm').classList.remove('hidden');

    document.getElementById('paymentForm').scrollIntoView({ behavior: 'smooth' });
  }

  function deselectInvoice() {
    document.querySelectorAll('.invoice-item').forEach(item => {
      item.classList.remove('selected');
    });

    document.querySelectorAll('input[name="invoice_id"]').forEach(radio => {
      radio.checked = false;
    });

    document.getElementById('paymentForm').classList.add('hidden');
    document.getElementById('selected_invoice_id').value = '';

    document.querySelector('.invoice-list').scrollIntoView({ behavior: 'smooth' });
  }

  document.addEventListener('DOMContentLoaded', function () {
    const paymentForm = document.getElementById('paymentFormElement');

    if (paymentForm) {
      paymentForm.addEventListener('submit', function (e) {
        const amountInput = document.getElementById('amount');
        const maxAmount = parseFloat(amountInput.max);
        const enteredAmount = parseFloat(amountInput.value);

        if (enteredAmount > maxAmount) {
          e.preventDefault();
          alert('Payment amount cannot exceed the pending amount of ₹' + maxAmount.toFixed(2));
          amountInput.focus();
        }

        if (enteredAmount <= 0) {
          e.preventDefault();
          alert('Payment amount must be greater than zero.');
          amountInput.focus();
        }
      });
    }

    const amountInput = document.getElementById('amount');
    if (amountInput) {
      amountInput.addEventListener('input', function () {
        const maxAmount = parseFloat(this.max);
        const enteredAmount = parseFloat(this.value);

        if (enteredAmount > maxAmount) {
          this.classList.add('is-invalid');
        } else {
          this.classList.remove('is-invalid');
        }
      });
    }
  });
</script>
</body>

</html>