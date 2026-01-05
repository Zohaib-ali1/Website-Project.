<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products - ABIBBAS</title>
  <link rel="stylesheet" href="styles.css">
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

  <!-- ===== PRODUCTS SECTION ===== -->
  <section style="padding-top: 2rem;">
    <div class="container">
      <div class="section-title">
        <h2>All Products</h2>
        <p>Browse our complete collection of clothing and fashion items.</p>
      </div>

      <div class="products-grid">
        <article class="product-card">
          <img src="img/white.jpg" alt="Classic White T-Shirt">
          <h3>Classic White T-Shirt</h3>
          <p>Premium cotton blend with comfortable fit and timeless style. Size M</p>
          <div class="product-price">$29.99</div>
          <button class="btn btn-primary" type="button" onclick="addToCart(1, 'Classic White T-Shirt', 29.99, 'img/white.jpg')">Add to Cart</button>
        </article>

        <article class="product-card">
          <img src="img/denim.jpg" alt="Denim Jacket">
          <h3>Denim Jacket</h3>
          <p>Vintage-inspired denim jacket with modern fit and quality craftsmanship. Size M</p>
          <div class="product-price">$79.99</div>
          <button class="btn btn-primary" type="button" onclick="addToCart(2, 'Denim Jacket', 79.99, 'img/denim.jpg')">Add to Cart</button>
        </article>

        <article class="product-card">
          <img src="img/pants.jpg" alt="Jeans">
          <h3>Jeans</h3>
          <p>Jeans perfect for casual and smart-casual occasions. Size M</p>
          <div class="product-price">$49.99</div>
          <button class="btn btn-primary" type="button" onclick="addToCart(3, 'Jeans', 49.99, 'img/pants.jpg')">Add to Cart</button>
        </article>

        <article class="product-card">
          <img src="img/hood.jpg" alt="Hooded Sweatshirt">
          <h3>Hooded Sweatshirt</h3>
          <p>Cozy and comfortable hoodie made from premium cotton blend. Size M</p>
          <div class="product-price">$59.99</div>
          <button class="btn btn-primary" type="button" onclick="addToCart(4, 'Hooded Sweatshirt', 59.99, 'img/hoodie.jpg')">Add to Cart</button>
        </article>

        <article class="product-card">
          <img src="img/sneakers.jpg" alt="Leather Sneakers">
          <h3>Leather Sneakers</h3>
          <p>Classic leather sneakers with modern comfort and durable construction. Size 42</p>
          <div class="product-price">$89.99</div>
          <button class="btn btn-primary" type="button" onclick="addToCart(5, 'Leather Sneakers', 89.99, 'img/sneakers.jpg')">Add to Cart</button>
        </article>

        <article class="product-card">
          <img src="img/coat.jpg" alt="Wool Coat">
          <h3>Wool Coat</h3>
          <p>Elegant wool coat perfect for cooler weather with timeless design. Size M</p>
          <div class="product-price">$129.99</div>
          <button class="btn btn-primary" type="button" onclick="addToCart(6, 'Wool Coat', 129.99, 'img/coat.jpg')">Add to Cart</button>
        </article>
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

