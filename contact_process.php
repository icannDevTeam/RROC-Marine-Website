<?php
// Global contact info
define('CONTACT_EMAIL', 'contact@rroc.com');
define('CONTACT_PHONE', '+44 123 456 7890');
// contact_process.php
// Handles contact form submission and sends email

// Set your email address here
$to = CONTACT_EMAIL;

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = strip_tags(trim($_POST['name'] ?? ''));
    $company = strip_tags(trim($_POST['company'] ?? ''));
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $phone = strip_tags(trim($_POST['phone'] ?? ''));
    $service = strip_tags(trim($_POST['service'] ?? ''));
    $message = strip_tags(trim($_POST['message'] ?? ''));

    // Validate required fields
    if ($name && $company && $email && $phone && $service && $message) {
        $entry = "Date: " . date('Y-m-d H:i:s') . "\n" .
                 "Name: $name\nCompany: $company\nEmail: $email\nPhone: $phone\nService: $service\nMessage: $message\n--------------------------\n";
        $file = __DIR__ . '/contact_submissions.txt';
        if (file_put_contents($file, $entry, FILE_APPEND | LOCK_EX) !== false) {
            echo 'success';
        } else {
            echo 'error';
        }
    } else {
        echo 'incomplete';
    }
} else {
    echo 'invalid';
}
