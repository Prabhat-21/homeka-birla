<?php
$GOOGLE_SCRIPT_URL = "https://script.google.com/macros/s/AKfycbyT0aNEkOg296BMHorMiJbhtAPqn6S9dmuPVDfMTrUuk6kSH71qlhz3FE-1myEIEYcQ1A/exec";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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

    if (function_exists('curl_init')) {
        $ch = curl_init($GOOGLE_SCRIPT_URL);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        curl_exec($ch);
        curl_close($ch);
    }

    header("Location: ./thank-you/");
    exit();
}
?>
