<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Sweet alert 2 link -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <link rel="stylesheet" href="<?php echo base_url('assets/css/about_style.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/header_design.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/footer_design.css') ?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/login_dialog.css') ?>">
</head>

<body>
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

  <!-- login dialog -->
  <dialog class="dialog">
    <button class="close-btn">close</button>
    <div class="dialog-container">
      <!-- Login Form -->
      <?php echo form_open('login', ['class' => 'login-form'], ['file_path' => 'about_views/about_page']) ?>
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
      <?php echo form_open('signup', ['class' => 'signup-form hide'], ['file_path' => 'about_views/about_page']) ?>
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
        <button class="track-orders-btn">Track Your Orders</button>
        <a class="log-out-btn" href="<?php echo base_url('logout') ?>">Log out</a>
      </div>

    </div>
  </dialog>

  <main class="about-page">
    <h1>About Us</h1>
    <section class="about-company">
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque interdum, urna nec bibendum ullamcorper, mi arcu luctus nunc, sed vehicula purus leo nec lorem. In lacinia, libero eget tincidunt sodales, orci odio lacinia libero, a facilisis nunc dolor a lacus. Sed hendrerit, sem sed lacinia tristique, tortor turpis gravida mi, ac efficitur felis metus at orci.</p>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras facilisis viverra velit, a blandit velit interdum a. Proin nec elementum nisi. Aliquam erat volutpat. Donec venenatis metus ut orci ultrices, nec bibendum metus tempor. Integer eget justo nulla. Nam vel sagittis odio, in tempor libero. Phasellus commodo, nulla at consequat faucibus, neque velit vehicula nisl, non volutpat nisi nunc sit amet odio.</p>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus euismod, nisi eu vulputate pharetra, ipsum felis venenatis justo, eu luctus tortor nisi ut mauris. Suspendisse potenti. Sed eu augue a dolor fermentum elementum et vel purus. Vivamus tincidunt, mi nec luctus commodo, arcu odio congue magna, id ullamcorper nisl nulla id nunc. Cras bibendum, sem id bibendum volutpat, lorem ipsum varius nunc, vel sodales est eros in nunc. Donec fringilla lorem sit amet ultricies vehicula. Phasellus condimentum non odio id gravida. Sed bibendum turpis in neque fermentum, non accumsan erat dignissim.</p>
    </section>

    <section class="company-vision">
      <h2>Our Vision</h2>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus euismod, nisi eu vulputate pharetra, ipsum felis venenatis justo, eu luctus tortor nisi ut mauris. Suspendisse potenti. Sed eu augue a dolor fermentum elementum et vel purus. Vivamus tincidunt, mi nec luctus commodo, arcu odio congue magna, id ullamcorper nisl nulla id nunc. Cras bibendum, sem id bibendum volutpat, lorem ipsum varius nunc, vel sodales est eros in nunc.</p>
    </section>

    <section class="company-mission">
      <h2>Our Mission</h2>
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras facilisis viverra velit, a blandit velit interdum a. Proin nec elementum nisi. Aliquam erat volutpat. Donec venenatis metus ut orci ultrices, nec bibendum metus tempor. Integer eget justo nulla. Nam vel sagittis odio, in tempor libero. Phasellus commodo, nulla at consequat faucibus, neque velit vehicula nisl, non volutpat nisi nunc sit amet odio.</p>
    </section>

    <section class="company-values">
      <h2>Our Values</h2>
      <ul>
        <li>Integrity: Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
        <li>Innovation: Vivamus euismod, nisi eu vulputate pharetra.</li>
        <li>Customer Focus: Proin nec elementum nisi.</li>
        <li>Sustainability: Aliquam erat volutpat. Donec venenatis metus ut orci ultrices.</li>
      </ul>
    </section>
  </main>

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
  <input type="hidden" id="base-url" value="<?php echo base_url() ?>">
  <input type="hidden" id="error-type" value='<?php echo $this->session->flashdata('error_type') ? $this->session->flashdata('error_type') : ''  ?>'>
  <input type="hidden" id="success" value='<?php echo $this->session->flashdata('success') ?>'>
  <input type="hidden" id="failed" value='<?php echo $this->session->flashdata('failed') ?>'>
  <input type="hidden" id="inputs" value='<?php echo json_encode($this->session->flashdata('inputs')) ?>'>
  <input type="hidden" id="logged-in-session" value='<?php echo isset($_SESSION['logged_in']) ? $_SESSION['logged_in'] : '' ?>'>
  <!-- -------------------------------- -->

  <script src="<?php echo base_url('assets/js/login.js') ?>"></script>
</body>

</html>