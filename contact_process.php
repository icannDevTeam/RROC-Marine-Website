<?php
/**
 * RROC Industrial — Contact Form Processor
 * Saves submissions to contact_submissions.txt
 * and sends an email notification.
 */

// Only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'error';
    exit;
}

// Honeypot check — bots fill hidden fields
if (!empty($_POST['honeypot'])) {
    echo 'success'; // Fool the bot
    exit;
}

// Collect & sanitize
$name    = trim(strip_tags($_POST['name'] ?? ''));
$company = trim(strip_tags($_POST['company'] ?? ''));
$email   = trim(strip_tags($_POST['email'] ?? ''));
$phone   = trim(strip_tags($_POST['phone'] ?? ''));
$service = trim(strip_tags($_POST['service'] ?? ''));
$message = trim(strip_tags($_POST['message'] ?? ''));

// Validate required fields
if (empty($name) || empty($company) || empty($email) || empty($service) || empty($message)) {
    echo 'incomplete';
    exit;
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo 'incomplete';
    exit;
}

// Build timestamp
$date = date('Y-m-d H:i:s');

// ─── Save to file ───
$entry  = "Date: {$date}\n";
$entry .= "Name: {$name}\n";
$entry .= "Company: {$company}\n";
$entry .= "Email: {$email}\n";
$entry .= "Phone: {$phone}\n";
$entry .= "Service: {$service}\n";
$entry .= "Message: {$message}\n";
$entry .= "--------------------------\n\n";

$file = __DIR__ . '/contact_submissions.txt';
$saved = file_put_contents($file, $entry, FILE_APPEND | LOCK_EX);

if ($saved === false) {
    echo 'error';
    exit;
}

// ─── Send email notification ───
$to      = 'contact@rrocindustrial.com';  // ← Change to your real email
$subject = "New RROC Enquiry: {$service} — {$name}";

$body  = "New contact form submission received:\n\n";
$body .= "Name:    {$name}\n";
$body .= "Company: {$company}\n";
$body .= "Email:   {$email}\n";
$body .= "Phone:   {$phone}\n";
$body .= "Service: {$service}\n\n";
$body .= "Message:\n{$message}\n\n";
$body .= "---\nSubmitted: {$date}\n";

$headers  = "From: noreply@" . $_SERVER['HTTP_HOST'] . "\r\n";
$headers .= "Reply-To: {$email}\r\n";
$headers .= "X-Mailer: RROC-Contact-Form\r\n";

// mail() works on most cPanel hosts out of the box
@mail($to, $subject, $body, $headers);

echo 'success';
