<?php
session_start();

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Connect to DB
require 'db.php';

// Process POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validate
    if ($email && $password) {
        // Check if user exists
        $stmt = $conn->prepare("SELECT id, full_name, email, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['full_name'];
                $_SESSION['user_email'] = $user['email'];
                
                // Redirect to index.php with success flag
                header("Location: index.php?login=success");
                exit();
            } else {
                // Invalid password
                header("Location: login.php?error=invalid");
                exit();
            }
        } else {
            // User not found
            header("Location: login.php?error=notfound");
            exit();
        }
    } else {
        // Missing fields
        header("Location: login.php?error=missing");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - ABIBBAS</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="login.css">
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

  <!-- ===== LOGIN SECTION ===== -->
  <section class="auth-page">
    <div class="container">
      <div class="auth-card">
        <h2>Login</h2>
        
        <?php if (isset($_GET['error'])): ?>
          <div class="login-message login-error">
            <?php
            switch($_GET['error']) {
              case 'invalid':
                echo 'Invalid email or password. Please try again.';
                break;
              case 'notfound':
                echo 'No account found with this email. Please register.';
                break;
              case 'missing':
                echo 'Please fill in all fields.';
                break;
              default:
                echo 'An error occurred. Please try again.';
            }
            ?>
          </div>
        <?php endif; ?>

        <?php if (isset($_GET['success'])): ?>
          <div class="login-message login-success">
            Registration successful! Please login with your credentials.
          </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
          <div class="form-group">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" placeholder="Enter your email" required>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" placeholder="Enter your password" required>
          </div>
          <button class="btn btn-primary" type="submit" style="width: 100%;">Login</button>
        </form>
        <div class="auth-link">
          Don't have an account? <a href="register.php">Register here</a>
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

