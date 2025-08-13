<?php
// visit_logger.php
// Logs site visits to visits.txt
if (!empty($_SERVER['REMOTE_ADDR'])) {
    $ip = $_SERVER['REMOTE_ADDR'];
    $ua = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
    $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
    $page = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
    $date = date('Y-m-d H:i:s');
    $entry = "$date | IP: $ip | UA: $ua | Referer: $referer | Page: $page\n";
    file_put_contents('visits.txt', $entry, FILE_APPEND);
}
?>
