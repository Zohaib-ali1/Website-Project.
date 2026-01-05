<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Checkout - ABIBBAS</title>
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

  <!-- ===== CHECKOUT SECTION ===== -->
  <section class="cart-container">
    <div class="container">
      <div class="section-title">
        <h2>Checkout</h2>
        <p>Please fill in your details to complete your order.</p>
        
        <?php if (isset($_GET['error'])): ?>
          <div class="contact-message contact-error" style="margin-top: 1rem;">
            <?php
            switch($_GET['error']) {
              case 'missing':
                echo 'Please fill in all required fields.';
                break;
              case 'database':
                echo 'An error occurred processing your order. Please try again.';
                break;
              default:
                echo 'An error occurred. Please try again.';
            }
            ?>
          </div>
        <?php endif; ?>
      </div>

      <div class="checkout-grid">
        <!-- Order Form -->
        <form action="checkout_process.php" method="POST" class="checkout-form">
          <h3 style="margin-bottom: 1.5rem; color: #1E1E1E;">Shipping Information</h3>
          
          <div class="form-group">
            <label for="full_name">Full Name *</label>
            <input id="full_name" name="full_name" type="text" required 
                   value="<?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : ''; ?>">
          </div>

          <div class="form-group">
            <label for="email">Email Address *</label>
            <input id="email" name="email" type="email" required 
                   value="<?php echo isset($_SESSION['user_email']) ? htmlspecialchars($_SESSION['user_email']) : ''; ?>">
          </div>

          <div class="form-group">
            <label for="phone">Phone Number *</label>
            <input id="phone" name="phone" type="tel" required placeholder="+39 1234 567890">
          </div>

          <div class="form-group">
            <label for="address">Street Address *</label>
            <input id="address" name="address" type="text" required placeholder="123 Main Street">
          </div>

          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
              <label for="city">City *</label>
              <input id="city" name="city" type="text" required placeholder="Messina">
            </div>
            <div class="form-group">
              <label for="state">State/Province *</label>
              <input id="state" name="state" type="text" required placeholder="ME">
            </div>
          </div>

          <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div class="form-group">
              <label for="zip">ZIP/Postal Code *</label>
              <input id="zip" name="zip" type="text" required placeholder="98124">
            </div>
            <div class="form-group">
              <label for="country">Country *</label>
              <input id="country" name="country" type="text" required placeholder="Italy">
            </div>
          </div>

          <h3 style="margin: 2rem 0 1.5rem; color: #1E1E1E;">Payment Information</h3>

          <div class="form-group">
            <label for="card_name">Name on Card *</label>
            <input id="card_name" name="card_name" type="text">
          </div>

          <div class="form-group">
            <label for="card_number">Card Number *</label>
            <input id="card_number" name="card_number" type="text" required placeholder="1234 5678 9012 3456" maxlength="19" 
                   oninput="this.value = this.value.replace(/\s/g, '').replace(/(.{4})/g, '$1 ').trim()">
          </div>

          <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem;">
            <div class="form-group">
              <label for="exp_month">Expiry Month *</label>
              <input id="exp_month" name="exp_month" type="text" required placeholder="MM" maxlength="2">
            </div>
            <div class="form-group">
              <label for="exp_year">Expiry Year *</label>
              <input id="exp_year" name="exp_year" type="text" required placeholder="YYYY" maxlength="4">
            </div>
            <div class="form-group">
              <label for="cvv">CVV *</label>
              <input id="cvv" name="cvv" type="text" required placeholder="123" maxlength="3">
            </div>
          </div>

          <input type="hidden" id="cart_data" name="cart_data" value="">
          <input type="hidden" id="total_amount" name="total_amount" value="">

          <button class="btn btn-primary" type="submit" style="width: 100%; margin-top: 1.5rem; padding: 1rem; font-size: 1.1rem;">
            Pay Now
          </button>
        </form>

        <!-- Order Summary -->
        <div class="checkout-summary">
          <h3 style="margin-bottom: 1.5rem; color: #1E1E1E;">Order Summary</h3>
          <div id="checkoutItems"></div>
          <div id="checkoutSummary"></div>
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
  <script>
    // Render checkout items and summary
    document.addEventListener("DOMContentLoaded", () => {
      const cart = JSON.parse(localStorage.getItem("cart")) || [];
      const checkoutItems = document.getElementById("checkoutItems");
      const checkoutSummary = document.getElementById("checkoutSummary");
      const cartDataInput = document.getElementById("cart_data");
      const totalAmountInput = document.getElementById("total_amount");

      if (cart.length === 0) {
        checkoutItems.innerHTML = '<p>Your cart is empty. <a href="products.php">Browse Products</a></p>';
        return;
      }

      let total = 0;
      checkoutItems.innerHTML = cart.map((item) => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;
        const imageSrc = item.image || '';
        return `
          <div style="display: flex; gap: 1rem; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid #D0D0D0;">
            <div style="width: 80px; height: 80px; border-radius: 8px; overflow: hidden; background: #D0D0D0;">
              ${imageSrc ? `<img src="${imageSrc}" alt="${item.name}" style="width: 100%; height: 100%; object-fit: cover;">` : ''}
            </div>
            <div style="flex: 1;">
              <h4 style="margin: 0 0 0.3rem; font-size: 0.95rem;">${item.name}</h4>
              <p style="margin: 0; color: #595959; font-size: 0.85rem;">Qty: ${item.quantity} × $${item.price.toFixed(2)}</p>
            </div>
            <div style="font-weight: bold; color: #1E1E1E;">$${itemTotal.toFixed(2)}</div>
          </div>
        `;
      }).join('');

      const subtotal = total;
      const tax = subtotal * 0.1;
      const shipping = subtotal > 50 ? 0 : 5.99;
      const grandTotal = subtotal + tax + shipping;

      checkoutSummary.innerHTML = `
        <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 2px solid #D0D0D0;">
          <div style="display: flex; justify-content: space-between; margin-bottom: 0.8rem; font-size: 0.95rem;">
            <span>Subtotal:</span>
            <span>$${subtotal.toFixed(2)}</span>
          </div>
          <div style="display: flex; justify-content: space-between; margin-bottom: 0.8rem; font-size: 0.95rem;">
            <span>Tax (10%):</span>
            <span>$${tax.toFixed(2)}</span>
          </div>
          <div style="display: flex; justify-content: space-between; margin-bottom: 0.8rem; font-size: 0.95rem;">
            <span>Shipping:</span>
            <span>${shipping === 0 ? "Free" : "$" + shipping.toFixed(2)}</span>
          </div>
          <div style="display: flex; justify-content: space-between; padding-top: 1rem; border-top: 2px solid #D0D0D0; font-size: 1.3rem; font-weight: bold; color: #1E1E1E;">
            <span>Total:</span>
            <span>$${grandTotal.toFixed(2)}</span>
          </div>
        </div>
      `;

      // Store cart data and total in hidden inputs
      cartDataInput.value = JSON.stringify(cart);
      totalAmountInput.value = grandTotal.toFixed(2);
    });
  </script>
</body>
</html>

