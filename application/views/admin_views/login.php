<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="<?php echo base_url('assets/css/admin_style.css') ?>">

  <title>Admin Login</title>
</head>
<body class="login-body">
  <?php echo form_open('admin/login', ['id' => 'login-form']) ?>
    <h1>Login</h1>
    <label for="email">Email :</label>
    <input type="text" id="email" name="email">
    <?php echo form_error('email') ?>
    
    <label for="password">Password :</label>
    <input type="password" id="password" name="password">
    <?php echo form_error('password') ?>

    <div class="error"></div>

    <button class="login-btn">Login</button>
  </form>

  <!-- Hidden variables -->
   <input type="hidden" value="<?php echo $this->session->flashdata('login_error') ?>" class="login-err">

  <script src="<?php echo base_url('assets/js/admin/login.js') ?>"></script>
</body>
</html>