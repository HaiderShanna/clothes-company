<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/home_style.css') ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <title>Home</title>
</head>
<body>
  <span class="loader"></span>
  <header>
    <a href="<?php echo base_url('home') ?>">
      <img class="logo" src="<?php echo base_url('assets/imgs/svg/logo-no-background.svg') ?>" alt="">
    </a>
    <div class="search-container">
      <select name="" id="category" class="category">
        <option value="best-selling" selected>All</option>
        <option value="men">Men</option>
        <option value="women">Women</option>
        <option value="children">Children</option>
      </select>
      <input type="search" class="search-input" placeholder="Enter something to search for ...">
      <button class="search-btn"><i class="fa fa-search"></i></button>
    </div>
    <ul>
      <li>
        <button class="login-btn"><i class="fa fa-user-circle" aria-hidden="true"></i></button>
      </li>
      <li>
        <a href="<?php echo base_url('home/about') ?>">About</a>
      </li>
      <li>
        <a href="<?php echo base_url('home/cart') ?>"><i class="fa-solid fa-cart-shopping"></i></a>
      </li>
    </ul>
  </header>
  <div class="img-container">
    <img class="preview-img" src="<?php echo base_url('assets/imgs/background-img.jpg') ?>" alt="">
  </div>
  <div class="container">
    <div class="best-selling category-container">
      <div class="category-header">
        <h1>Best Selling :</h1>
        <button class="show-all-btn" data-category="best-selling">Show All</button>
      </div>
      <div class="products-grid"></div>
    </div>
    <div class="men-clothes category-container">
      <div class="category-header">
        <h1>Men's Clothes :</h1>
        <button class="show-all-btn" data-category="men">Show All</button>
      </div>
        <div class="products-grid"></div>
    </div>
    <div class="women-clothes category-container">
      <div class="category-header">
        <h1>Women's Clothes :</h1>
        <button class="show-all-btn" data-category="women">Show All</button>
      </div>
      <div class="products-grid"></div>
    </div>
    <div class="children-clothes category-container">
      <div class="category-header">
        <h1>Children's Clothes :</h1>
        <button class="show-all-btn" data-category="children">Show All</button>
      </div>
      <div class="products-grid"></div>
    </div>
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
  <input type="hidden" id="base-url" value="<?php echo base_url() ?>">
  <script type="module" src="<?php echo base_url('assets/js/home/home_page.js') ?>"></script>
</body>
</html>