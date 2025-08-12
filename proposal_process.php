// Global contact info
define('CONTACT_EMAIL', 'contact@rroc.com');
define('CONTACT_PHONE', '+44 123 456 7890');
<?php
// proposal_process.php
// Handles proposal request modal form submissions and saves to file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = strip_tags(trim($_POST['name'] ?? ''));
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $company = strip_tags(trim($_POST['company'] ?? ''));
    $message = strip_tags(trim($_POST['message'] ?? ''));

    if ($name && $email && $company && $message) {
        $entry = "Date: " . date('Y-m-d H:i:s') . "\n" .
                 "Name: $name\nEmail: $email\nCompany: $company\nMessage: $message\n--------------------------\n";
        $file = __DIR__ . '/proposal_requests.txt';
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
