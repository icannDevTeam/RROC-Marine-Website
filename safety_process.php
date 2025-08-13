<?php
// Safety Report Form Handler
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $report = isset($_POST['report']) ? trim($_POST['report']) : '';
    $name = isset($_POST['name']) ? trim($_POST['name']) : '';
    $response = [];

    if (empty($email) || empty($report)) {
        $response['status'] = 'error';
        $response['message'] = 'Email and report are required.';
    } else {
        // Save to file
        $entry = date('Y-m-d H:i:s') . " | Name: $name | Email: $email | Report: $report\n";
        file_put_contents('safety_reports.txt', $entry, FILE_APPEND);

        // Send email notification
        $to = 'contact@rroc.com';
        $subject = 'New Safety Report Submitted';
        $message = "A new safety report has been submitted:\n\n" .
            "Name: $name\nEmail: $email\nReport: $report\n";
        $headers = "From: noreply@rroc.com\r\nReply-To: $email\r\n";
        mail($to, $subject, $message, $headers);

        $response['status'] = 'success';
        $response['message'] = 'Report submitted successfully!';
    }
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>
