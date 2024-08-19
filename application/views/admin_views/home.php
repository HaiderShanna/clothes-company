<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- My Style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/admin_style.css') ?>">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Jquery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">


  <!-- Data Tables -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">

  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>




  <title>Home</title>
</head>

<body class="home-body">
  <header class="home-header">
    <div>
      <button class="back-btn">
        <i class="fa fa-arrow-left" aria-hidden="true"></i> Back
      </button>
    </div>
    <h1>Administration</h1>
    <a href="<?php echo base_url('admin/logout') ?>">
      Logout <i class="fa fa-sign-out" aria-hidden="true"></i>
    </a>
  </header>

  <div class="box container">
    <div class="products-div">
      <i class="fa-solid fa-shirt"></i> Products
    </div>
    <div class="statistics-div">
      <i class="fa-solid fa-chart-line"></i> Statistics
    </div>
  </div>

  <!-- hidden variables -->
  <input type="hidden" class="base-url" value="<?php echo base_url() ?>">


  <script src="<?php echo base_url('assets/js/admin/home.js') ?>"></script>

</body>

</html>