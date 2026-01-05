<?php
session_start();

// Connect to DB
require 'db.php';

// Process POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $city = trim($_POST['city'] ?? '');
    $state = trim($_POST['state'] ?? '');
    $zip = trim($_POST['zip'] ?? '');
    $country = trim($_POST['country'] ?? '');
    $card_name = trim($_POST['card_name'] ?? '');
    $card_number = trim($_POST['card_number'] ?? '');
    $exp_month = trim($_POST['exp_month'] ?? '');
    $exp_year = trim($_POST['exp_year'] ?? '');
    $cvv = trim($_POST['cvv'] ?? '');
    $cart_data = $_POST['cart_data'] ?? '[]';
    $total_amount = floatval($_POST['total_amount'] ?? 0);

    // Validate required fields
    if ($full_name && $email && $phone && $address && $city && $state && $zip && $country && 
        $card_name && $card_number && $exp_month && $exp_year && $cvv && $total_amount > 0) {
        
        // Get user ID if logged in
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;

        // Insert order into database
        $stmt = $conn->prepare(
            "INSERT INTO orders (user_id, full_name, email, phone, address, city, state, zip, country, 
             card_name, card_number, exp_month, exp_year, cvv, cart_data, total_amount, status) 
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')"
        );
        
        // Mask card number for security (store only last 4 digits)
        $masked_card = substr($card_number, -4);
        $masked_card = str_repeat('*', max(0, strlen($card_number) - 4)) . $masked_card;
        
        // Mask CVV for security (never store actual CVV)
        $masked_cvv = '***';
        
        $stmt->bind_param("issssssssssssssd", 
            $user_id, 
            $full_name, 
            $email, 
            $phone, 
            $address, 
            $city, 
            $state, 
            $zip, 
            $country, 
            $card_name, 
            $masked_card, 
            $exp_month, 
            $exp_year, 
            $masked_cvv, 
            $cart_data, 
            $total_amount
        );

        if ($stmt->execute()) {
            $order_id = $conn-> insert_id;
            
            // Clear cart from localStorage (will be handled by JavaScript redirect)
            // Redirect to success page
            header("Location: checkout_success.php?order_id=" . $order_id);
            exit();
        } else {
            // Database error
            header("Location: checkout.php?error=database");
            exit();
        }
    } else {
        // Missing fields
        header("Location: checkout.php?error=missing");
        exit();
    }
} else {
    // Not a POST request
    header("Location: checkout.php");
    exit();
}
?>