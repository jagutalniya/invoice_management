<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Invoice Management - Login</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      min-height: 100vh;
      background: linear-gradient(135deg, #0d6efd, #6c63ff);
      display: flex;
      flex-direction: column;
    }
    .navbar {
      background: #0d6efd;
    }
    .navbar-brand {
      font-weight: 600;
      color: #fff !important;
    }
    .login-section {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 30px 15px;
    }
    .login-card {
      width: 100%;
      max-width: 420px;
      border-radius: 15px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    }
    .login-card .card-header {
      background: #0d6efd;
      color: white;
      text-align: center;
      border-radius: 15px 15px 0 0;
      padding: 1.3rem;
    }
    .form-control {
      border-radius: 10px;
      padding: 10px;
    }
    .btn-login {
      border-radius: 10px;
      padding: 10px;
      font-weight: 500;
    }
    footer {
      text-align: center;
      padding: 15px 10px;
      background: #f8f9fa;
      font-size: 0.9rem;
      color: #6c757d;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg">
    <div class="container">
      <a class="navbar-brand" href="#">Invoice Management</a>
    </div>
  </nav>

  <!-- Login Section -->
  <section class="login-section">
    <div class="card login-card">
      <div class="card-header">
        <h3 class="mb-0">Login</h3>
        <small>Please login to continue</small>
      </div>
      <div class="card-body p-4">
        
        <!-- Error message -->
        <?php if (!empty($error)) { ?>
          <div class="alert alert-danger" role="alert">
            <?= $error ?>
          </div>
        <?php } ?>

        <!-- Login Form -->
        <form method="post" autocomplete="off">
          <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" id="email" name="email" 
                   class="form-control" placeholder="Enter your email" required>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" id="password" name="password" 
                   class="form-control" placeholder="Enter your password" required>
          </div>

          <div class="d-grid">
            <button type="submit" class="btn btn-primary btn-login">Login</button>
          </div>
        </form>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <p>© <?= date("Y") ?> Invoice Management System. All Rights Reserved.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
