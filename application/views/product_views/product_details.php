<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Sweet alert 2 link -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  
  <!-- Jquery CDN -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>


  <link rel="stylesheet" href="<?php echo base_url('assets/css/product_details.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/header_design.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/footer_design.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/login_dialog.css') ?>">
  <title>test</title>
</head>

<body>
  <span class="loader"></span>
  <header>
    <a href="<?php echo base_url('home') ?>">
      <img class="logo" src="<?php echo base_url('assets/imgs/svg/logo-no-background.svg') ?>" alt="">
    </a>
    <ul>
      <li>
        <button class="login-btn open-form"><i class="fa fa-user-circle" aria-hidden="true"></i></button>
      </li>
      <li>
        <a href="<?php echo base_url('home') ?>">Home</a>
      </li>
      <li>
        <a href="<?php echo base_url('home/about') ?>">About</a>
      </li>
      <li>
        <a href="<?php echo base_url('cart') ?>">
          <i class="fa-solid fa-cart-shopping">
            <span class="cart-num"></span>
          </i>
        </a>
      </li>
    </ul>
  </header>

  <dialog class="dialog">
    <button class="close-btn">close</button>
    <div class="dialog-container">
      <!-- Login Form -->
      <?php echo form_open('login',
        ['class' => 'login-form'], 
        ['file_path' => 'product_views/product_details',
          'param'  => $id]) 
      ?>
      <h1>Login</h1>
      <label for="login-email">Email :</label>
      <input type="email" id="login-email" class="email" name="login-email">
      <?php echo form_error('login-email', '<small class="error">', '</small>') ?>

      <label for="login-password">Password :</label>
      <input type="password" id="login-password" class="password" name="login-password">
      <?php echo form_error('login-password', '<small class="error">', '</small>') ?>


      <p>Don't have an account ? <span class="create">Create One</span></p>
      <button class="login-button">Login</button>
      </form>

      <!-- Sign Up Form -->
      <?php echo form_open('signup', ['class' => 'signup-form hide'], ['file_path' => 'product_views/product_details', 'param'  => $id]) ?>
      <h1>Sign Up</h1>
      <label for="name">Name :</label>
      <input type="text" id="name" class="name" name="name">
      <?php echo form_error('name', '<small class="error">', '</small>') ?>

      <label for="email">Email :</label>
      <input type="email" id="email" class="email" name="email">
      <?php echo form_error('email', '<small class="error">', '</small>') ?>

      <label for="password">Password :</label>
      <input type="password" id="password" class="password" name="password">
      <?php echo form_error('password', '<small class="error">', '</small>') ?>

      <label for="password2">Confirm Password :</label>
      <input type="password" id="password2" class="password2" name="password2">
      <?php echo form_error('password2', '<small class="error">', '</small>') ?>

      <p>Already have an account ? <span class="login">Log in</span></p>
      <button class="login-button">Sign Up</button>
      </form>

      <!-- logged in -->
      <div class="logged-in hide">
        <h3>Logged in as : <b><?php echo $_SESSION['name'] ?></b></h3>
        <a href="<?php echo base_url('track') ?>" class="track-orders-btn">Track Your Orders</a>
        <a class="log-out-btn" href="<?php echo base_url('logout') ?>">Log out</a>
      </div>

    </div>
  </dialog>

  <div class="container">
    <div class="img-container">

    </div>
    <div class="right-side">

    </div>
  </div>
  <div class="more-products">
    <div class="category-header">
      <h1>More Clothes :</h1>
    </div>
    <div class="products-grid"></div>
  </div>

  <footer class="footer">
    <div class="footer-container">
      <div class="footer-section">
        <h4>About Us</h4>
        <p>Top Fat G is your ultimate destination for trendy and stylish clothing. Stay fashionable with us!</p>
      </div>
      <div class="footer-section">
        <h4>Quick Links</h4>
        <ul>
          <li><a href="#">Home</a></li>
          <li><a href="#">Shop</a></li>
          <li><a href="#">About</a></li>
          <li><a href="#">Contact</a></li>
        </ul>
      </div>
      <div class="footer-section">
        <h4>Follow Us</h4>
        <div class="social-icons">
          <a href="#"><i class="fa-brands fa-facebook"></i></a>
          <a href="#"><i class="fa-brands fa-twitter"></i></a>
          <a href="#"><i class="fa-brands fa-instagram"></i></a>
        </div>
      </div>
      <div class="footer-section">
        <h4>Contact Us</h4>
        <p>Email: info@topfatg.com</p>
        <p>Phone: +123-456-7890</p>
      </div>
    </div>
    <div class="footer-bottom">
      <p>&copy; 2024 Top Fat G. All rights reserved.</p>
    </div>
  </footer>


  <!-- Hidden inputs to pass to the JS -->
  <input type="hidden" class="product-id" value="<?php echo $id ?>">
  <input type="hidden" id="base-url" class="base-url" value="<?php echo base_url() ?>">
  <input type="hidden" id="error-type" value='<?php echo $this->session->flashdata('error_type') ? $this->session->flashdata('error_type') : ''  ?>'>
  <input type="hidden" id="success" value='<?php echo $this->session->flashdata('success') ?>'>
  <input type="hidden" id="failed" value='<?php echo $this->session->flashdata('failed') ?>'>
  <input type="hidden" id="inputs" value='<?php echo json_encode($this->session->flashdata('inputs')) ?>'>
  <input type="hidden" id="logged-in-session" value='<?php echo isset($_SESSION['logged_in']) ? $_SESSION['logged_in'] : '' ?>'>
  <!-- -------------------------------- -->

  <script type="module" src="<?php echo base_url('assets/js/product/product_details.js') ?>"></script>
  <script src="<?php echo base_url('assets/js/login.js') ?>"></script>
</body>

</html>