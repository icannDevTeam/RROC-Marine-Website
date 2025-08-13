<?php
// PTW Portal Request Handler
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $details = isset($_POST['details']) ? trim($_POST['details']) : '';
    $work = isset($_POST['work']) ? trim($_POST['work']) : '';
    $hazards = isset($_POST['hazards']) ? trim($_POST['hazards']) : '';
    $controls = isset($_POST['controls']) ? trim($_POST['controls']) : '';
    $response = [];

    if (empty($email) || empty($details)) {
        $response['status'] = 'error';
        $response['message'] = 'Email and details are required.';
    } else {
        // Save to file
        $entry = date('Y-m-d H:i:s') . " | Email: $email | Work: $work | Hazards: $hazards | Controls: $controls | Details: $details\n";
        file_put_contents('ptw_requests.txt', $entry, FILE_APPEND);

        // Send email notification
        $to = 'contact@rroc.com';
        $subject = 'New PTW Request Submitted';
        $message = "A new PTW request has been submitted:\n\n" .
            "Email: $email\nWork: $work\nHazards: $hazards\nControls: $controls\nDetails: $details\n";
        $headers = "From: noreply@rroc.com\r\nReply-To: $email\r\n";
        mail($to, $subject, $message, $headers);

        $response['status'] = 'success';
        $response['message'] = 'PTW request submitted successfully!';
    }
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
?>
