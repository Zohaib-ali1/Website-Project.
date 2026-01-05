<?php
// Start session
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
    // Get and sanitize inputs
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Validate
    if ($full_name && $email && $password && $confirm_password) {
        // Check if passwords match
        if ($password !== $confirm_password) {
            header("Location: register.php?error=passwordmismatch");
            exit();
        }

        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            header("Location: register.php?error=emailexists");
            exit();
        }

        // Validate password length
        if (strlen($password) < 6) {
            header("Location: register.php?error=passwordshort");
            exit();
        }

        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $full_name, $email, $hashed_password);

        if ($stmt->execute()) {
            // Redirect to login page with success flag
            header("Location: login.php?success=1");
            exit();
        } else {
            // Database error
            header("Location: register.php?error=database");
            exit();
        }
    } else {
        // Missing fields
        header("Location: register.php?error=missing");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - ABIBBAS</title>
  <link rel="stylesheet" href="styles.css">
  <link rel="stylesheet" href="register.css">
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

  <!-- ===== REGISTER SECTION ===== -->
  <section class="auth-page">
    <div class="container">
      <div class="auth-card">
        <h2>Create Account</h2>
        
        <?php if (isset($_GET['error'])): ?>
          <div class="register-message register-error">
            <?php
            switch($_GET['error']) {
              case 'passwordmismatch':
                echo 'Passwords do not match. Please try again.';
                break;
              case 'emailexists':
                echo 'An account with this email already exists. Please login.';
                break;
              case 'passwordshort':
                echo 'Password must be at least 6 characters long.';
                break;
              case 'missing':
                echo 'Please fill in all fields.';
                break;
              case 'database':
                echo 'An error occurred. Please try again later.';
                break;
              default:
                echo 'An error occurred. Please try again.';
            }
            ?>
          </div>
        <?php endif; ?>

        <form action="register.php" method="POST">
          <div class="form-group">
            <label for="full_name">Full Name</label>
            <input id="full_name" name="full_name" type="text" placeholder="Enter your full name" required>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input id="email" name="email" type="email" placeholder="Enter your email" required>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input id="password" name="password" type="password" placeholder="Create a password (min 6 characters)" required>
          </div>
          <div class="form-group">
            <label for="confirm_password">Confirm Password</label>
            <input id="confirm_password" name="confirm_password" type="password" placeholder="Confirm your password" required>
          </div>
          <button class="btn btn-primary" type="submit" style="width: 100%;">Register</button>
        </form>
        <div class="auth-link">
          Already have an account? <a href="login.php">Login here</a>
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

