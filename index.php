<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ABIBBAS - Home</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="contact.css">

</head>
<body>
  <!-- ===== HEADER / NAVBAR ===== -->
  <header>
    <div class="container nav">
      <a href="index.php" class="logo">ABIBBAS</a>
      <div class="menu-toggle" id="menuToggle">☰</div>
      <ul class="nav-links" id="navLinks">
        <li><a href="index.php">Home</a></li>
        <li><a href="products.php">Products</a></li>
        <li><a href="index.php#features">Features</a></li>
        <li><a href="index.php#contact">Contact</a></li>
        <?php if (isset($_SESSION['user_id'])): ?>
          <li><a href="#">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></a></li>
          <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
          <li><a href="login.php">Login</a></li>
          <li><a href="register.php">Register</a></li>
        <?php endif; ?>
        <li><a href="cart.php" class="cart-icon">🛒 <span class="cart-count" id="cartCount"></span></a></li>
      </ul>
    </div>
  </header>

  <!-- ===== HERO SECTION ===== -->
  <section class="hero" id="home">
    <div class="container hero-inner">
      <div>
        <h1>Style That Speaks. Fashion That Fits.</h1>
        <p>
          Discover our curated collection of premium clothing with fast shipping,
          easy returns, and secure checkout.
        </p>
        <div class="hero-buttons">
          <a href="products.php" class="btn btn-primary">Browse Products</a>
        </div>
      </div>
      <div class="hero-image">
      <a href="products.php"><img src="img/hero1.jpg"></a> 
        </div>
      </div>
    </div>
  </section>

  <!-- ===== FEATURED PRODUCTS ===== -->
  <section id="products">
    <div class="container">
      <div class="section-title">
        <h2>Featured Products</h2>
        <p>Check out our featured products. <a href="products.php">View all products →</a></p>
      </div>

      <div class="products-grid">
        <article class="product-card">
          <a href="products.php"><img src="img/white.jpg" alt="Classic White T-Shirt"></a>
          <h3>Classic White T-Shirt</h3>
          <p>Premium cotton blend with comfortable fit and timeless style.</p>
          <div class="product-price">$29.99</div>
          <button class="btn btn-primary" type="button" onclick="addToCart(1, 'Classic White T-Shirt', 29.99, 'img/white.jpg')">Add to Cart</button>
        </article>

        <article class="product-card">
          <a href="products.php"><img src="img/denim.jpg" alt="Denim Jacket"></a>
          <h3>Denim Jacket</h3>
          <p>Vintage-inspired denim jacket with modern fit and quality craftsmanship.</p>
          <div class="product-price">$79.99</div>
          <button class="btn btn-primary" type="button" onclick="addToCart(2, 'Denim Jacket', 79.99, 'img/denim.jpg')">Add to Cart</button>
        </article>

        <article class="product-card">
          <a href="products.php"><img src="img/pants.jpg" alt="Jeans"></a>
          <h3>Jeans</h3>
          <p>Jeans perfect for casual and smart-casual occasions.</p>
          <div class="product-price">$49.99</div>
          <button class="btn btn-primary" type="button" onclick="addToCart(3, 'Jeans', 49.99, 'img/pants.jpg')">Add to Cart</button>
        </article>
      </div>
    </div>
  </section>

  <!-- ===== FEATURES SECTION ===== -->
  <section id="features">
    <div class="container">
      <div class="section-title">
        <h2>Why Shop With Us?</h2>
        <p>We offer great features that make shopping easy and enjoyable.</p>
      </div>

      <div class="features-grid">
        <div class="feature-card">
          <div class="feature-icon">⚡</div>
          <h3>Fast Shipping</h3>
          <p>Most orders are processed within 24 hours and delivered quickly.</p>
        </div>

        <div class="feature-card">
          <div class="feature-icon">👕</div>
          <h3>Premium Quality</h3>
          <p>We source only the finest fabrics and materials for lasting comfort and style.</p>
        </div>

        <div class="feature-card">
          <div class="feature-icon">↩</div>
          <h3>Easy Returns</h3>
          <p>If you're not happy, return your items within 30 days—no questions asked.</p>
        </div>
      </div>
    </div>
  </section>

<section id="contact">
  <div class="container">
    <div class="section-title">
      <h2>Contact Us</h2>
      <p>Get in touch with us for any questions or support.</p>

      <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
        <div class="contact-message contact-success">Thank you! Your message has been sent.</div>
      <?php elseif (isset($_GET['success']) && $_GET['success'] == 0): ?>
        <div class="contact-message contact-error">There was an error sending your message. Please try again.</div>
      <?php endif; ?>

      <?php if (isset($_GET['login']) && $_GET['login'] == 'success'): ?>
        <div class="contact-message contact-success">Welcome back! You have successfully logged in.</div>
      <?php endif; ?>

      <?php if (isset($_GET['logout']) && $_GET['logout'] == 'success'): ?>
        <div class="contact-message contact-success">You have been successfully logged out.</div>
      <?php endif; ?>
    </div>

    <div class="contact-grid">
      <form action="contact.php" method="POST">
        <div class="form-group">
          <label for="name">Your Name</label>
          <input id="name" name="name" type="text" required>
        </div>

        <div class="form-group">
          <label for="email">Your Email</label>
          <input id="email" name="email" type="email" required>
        </div>

        <div class="form-group">
          <label for="message">Message</label>
          <textarea id="message" name="message" required></textarea>
        </div>

        <button class="btn btn-primary" type="submit">Send Message</button>
      </form>

      <div class="contact-info">
        <p><strong>Email:</strong> support@abibbas.com</p>
        <p><strong>Phone:</strong> +1 (555) 123-4567</p>
        <p><strong>Address:</strong> 123 Student Street, Web City</p>
      </div>
    </div>
  </div>
</section>

  <!-- ===== FOOTER ===== -->
  <footer>
    <div class="container footer-inner">
      <div>© 2025 ABIBBAS. All rights reserved.</div>
      <div class="footer-links">
        <a href="index.php">Home</a>
        <a href="products.php">Products</a>
        <a href="index.php#contact">Contact</a>
      </div>
    </div>
  </footer>

  <script src="script.js"></script>
</body>
</html>

