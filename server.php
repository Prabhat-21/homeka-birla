<?php
// DIAGNOSTIC MODE - This will show you what's wrong

echo "<!DOCTYPE html><html><head><title>Form Debug</title></head><body>";
echo "<h1>Form Received!</h1>";
echo "<h2>POST Data:</h2>";
echo "<pre>";
print_r($_POST);
echo "</pre>";

echo "<h2>Checking thank-you folder...</h2>";
if (file_exists('./thank-you/index.html')) {
    echo "<p style='color:green;'>✅ thank-you/index.html EXISTS</p>";
} else if (file_exists('./thank-you/')) {
    echo "<p style='color:orange;'>⚠️ thank-you folder exists but no index.html</p>";
} else {
    echo "<p style='color:red;'>❌ thank-you folder DOES NOT EXIST</p>";
}

echo "<h2>What should happen next:</h2>";
echo "<p>You should be redirected to: <a href='./thank-you/'>./thank-you/</a></p>";
echo "<p><a href='./thank-you/' style='background:#667eea;color:white;padding:10px 20px;text-decoration:none;border-radius:5px;'>Click here to go to Thank You page</a></p>";

// Now try to send data to Google Sheets
echo "<h2>Sending to Google Sheets...</h2>";

$url = "https://script.google.com/macros/s/AKfycbyT0aNEkOg296BMHorMiJbhtAPqn6S9dmuPVDfMTrUuk6kSH71qlhz3FE-1myEIEYcQ1A/exec";

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

echo "<p>Data to send:</p><pre>$data</pre>";

if (function_exists('curl_init')) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    
    echo "<p>HTTP Response Code: <strong>$httpCode</strong></p>";
    if ($error) {
        echo "<p style='color:red;'>cURL Error: $error</p>";
    }
    echo "<p>Response:</p><pre>$response</pre>";
    
    if ($httpCode == 200 || $httpCode == 302) {
        echo "<p style='color:green;'>✅ Data sent successfully!</p>";
    } else {
        echo "<p style='color:red;'>❌ Failed to send data</p>";
    }
} else {
    echo "<p style='color:red;'>❌ cURL is not enabled on this server!</p>";
}

echo "<hr>";
echo "<h2>Server Info:</h2>";
echo "<p>PHP Version: " . phpversion() . "</p>";
echo "<p>Server: " . $_SERVER['SERVER_SOFTWARE'] . "</p>";

echo "</body></html>";
?>
