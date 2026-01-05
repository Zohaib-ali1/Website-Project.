<?php
// Enable error reporting for debugging (REMOVE in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Connect to DB
require 'db.php';

// Process POST request
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get and sanitize inputs
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Validate
    if ($name && $email && $message) {
        $stmt = $conn->prepare(
            "INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)"
        );
        $stmt->bind_param("sss", $name, $email, $message);

        if ($stmt->execute()) {
            // Redirect back to index.php with success flag
            header("Location: index.php?success=1#contact");
            exit();
        } else {
            // Redirect with error flag
            header("Location: index.php?success=0#contact");
            exit();
        }
    } else {
        // Missing fields
        header("Location: index.php?success=0#contact");
        exit();
    }
}
?>
