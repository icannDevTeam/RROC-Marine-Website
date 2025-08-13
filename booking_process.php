<?php
// Meeting/Booking Form Handler
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['meetingEmail']) ? trim($_POST['meetingEmail']) : '';
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $date = isset($_POST['date']) ? trim($_POST['date']) : '';
    $response = [];

    if (empty($email)) {
        $response['status'] = 'error';
        $response['message'] = 'Email is required.';
    } else {
        // Save to file
        $entry = date('Y-m-d H:i:s') . " | Name: $name | Email: $email | Date: $date\n";
        file_put_contents('bookings.txt', $entry, FILE_APPEND);

        // Send email notification
        $to = 'contact@rroc.com';
        $subject = 'New Meeting/Booking Request';
        $message = "A new meeting/booking has been requested:\n\n" .
            "Name: $name\nEmail: $email\nDate: $date\n";
        $headers = "From: noreply@rroc.com\r\nReply-To: $email\r\n";
        mail($to, $subject, $message, $headers);

        $response['status'] = 'success';
        $response['message'] = 'Booking submitted successfully!';
    }
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>
