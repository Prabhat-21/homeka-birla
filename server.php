<?php
// UPDATE THIS LINE WITH YOUR GOOGLE SCRIPT URL
$url = "https://script.google.com/macros/s/AKfycbx9wUf9oNI7RELNlb1BvloFUuFOqM6cSRb8Jbx2H0Zw45TcNNsY7MocmdvcVjNdTEpPcQ/exec";

// Get form data
$data = json_encode(array(
    'name' => $_POST['input_name'] ?? '',
    'mobile' => $_POST['input_phone_no'] ?? '',
    'email' => $_POST['input_email'] ?? '',
    'form' => $_POST['onclick'] ?? 'Enquire Now',
    'project' => 'Birla Estates Kalwa',
    'date' => date("d-m-Y"),
    'time' => date("h:i A"),
    'url' => $_SERVER['HTTP_REFERER'] ?? ''
));

// Send to Google
if (function_exists('curl_init')) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_exec($ch);
    curl_close($ch);
}

// Redirect
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="refresh" content="0;url=./thank-you/">
    <script>window.location.href = './thank-you/';</script>
</head>
<body>
    Redirecting...
    <script>
        setTimeout(function() {
            window.location.href = './thank-you/';
        }, 100);
    </script>
</body>
</html>

