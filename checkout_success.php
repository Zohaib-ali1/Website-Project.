<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Confirmation - ABIBBAS</title>
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

  <!-- ===== SUCCESS SECTION ===== -->
  <section class="cart-container">
    <div class="container">
      <div style="max-width: 600px; margin: 0 auto; text-align: center; padding: 3rem 0;">
        <div style="font-size: 4rem; margin-bottom: 1rem;">✓</div>
        <h2 style="color: #1E1E1E; margin-bottom: 1rem;">Thank You For Your Order!</h2>
        <p style="color: #595959; font-size: 1.1rem; margin-bottom: 2rem;">
          Your order has been successfully placed. We'll send you a confirmation email shortly.
          <?php if (isset($_GET['order_id'])): ?>
            <br><strong>Order ID: #<?php echo htmlspecialchars($_GET['order_id']); ?></strong>
          <?php endif; ?>
        </p>
        <a href="index.php" class="btn btn-primary" style="display: inline-block; padding: 1rem 2rem; font-size: 1.1rem;">
          Continue Shopping
        </a>
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
  <script>
    // Clear cart after successful order
    localStorage.removeItem('cart');
    updateCartCount();
    
    // Auto-redirect to home after 5 seconds
    setTimeout(() => {
      window.location.href = 'index.php';
    }, 5000);
  </script>
</body>
</html>

