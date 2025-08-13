<?php
// view_visits.php
// Simple log viewer and downloader for visits.txt
$logFile = 'visits.txt';
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Site Visit Log Viewer</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f8f8f8; color: #222; }
        .container { max-width: 900px; margin: 40px auto; background: #fff; padding: 32px; border-radius: 12px; box-shadow: 0 4px 24px -8px #002F6C22; }
        h1 { color: #002F6C; }
        table { width: 100%; border-collapse: collapse; margin-top: 24px; }
        th, td { padding: 8px 12px; border-bottom: 1px solid #eee; }
        th { background: #A5C254; color: #002F6C; }
        tr:hover { background: #f0f8ff; }
        .download-btn { display: inline-block; margin-top: 18px; background: #A5C254; color: #002F6C; padding: 10px 18px; border-radius: 6px; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Site Visit Log Viewer</h1>
        <a class="download-btn" href="view_visits.php?download=1">Download Full Log</a>
        <table>
            <tr><th>Date</th><th>IP</th><th>User Agent</th><th>Referer</th><th>Page</th></tr>
<?php
if (isset($_GET['download'])) {
    header('Content-Type: text/plain');
    header('Content-Disposition: attachment; filename="visits.txt"');
    readfile($logFile);
    exit;
}
if (file_exists($logFile)) {
    $lines = file($logFile);
    foreach (array_reverse($lines) as $line) {
        $parts = explode(' | ', $line);
        echo '<tr>';
        foreach ($parts as $p) {
            $kv = explode(': ', $p, 2);
            if (count($kv) == 2) {
                echo '<td>' . htmlspecialchars($kv[1]) . '</td>';
            } else {
                echo '<td>' . htmlspecialchars($p) . '</td>';
            }
        }
        echo '</tr>';
    }
}
?>
        </table>
    </div>
</body>
</html>
