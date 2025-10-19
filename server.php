<?php

header('Content-Type: application/json');

// Google Apps Script Web App URL
$GOOGLE_SCRIPT_URL = "https://script.google.com/macros/s/AKfycbyx4ecY_LfnlxxlIJ3ezN7BKDIKkoxh6xxzx6hWsq37SeMWqdFpCHlNjmRN3MBwfdWqhw/exec"; // ← REPLACE THIS!

// Project Name
$projectName = "Birla Estates Kalwa";

if (isset($_POST) && isset($_POST['input_phone_no']) && trim($_POST['input_phone_no']) != '') {

    $leadData = array();
    $leadData['name'] = filter_var($_POST['input_name'] ?? '', FILTER_SANITIZE_STRING);
    $leadData['mobile'] = filter_var($_POST['input_phone_no'] ?? '', FILTER_SANITIZE_STRING);
    $leadData['email'] = filter_var($_POST['input_email'] ?? '', FILTER_SANITIZE_EMAIL);
    $leadData['form'] = ucwords(strtolower(filter_var($_POST['onclick'] ?? '', FILTER_SANITIZE_STRING)));
    $leadData['project'] = $projectName;

    date_default_timezone_set('Asia/Kolkata');

    $leadData['url'] = $_SERVER['HTTP_REFERER'] ?? '';

    if (trim($leadData['form']) == '') {
        $leadData['form'] = "Open Form"; 
    }

    $leadData['date'] = date("d-m-Y");
    $leadData['time'] = date("h:i A");

    // Send data to Google Sheets
    $ch = curl_init($GOOGLE_SCRIPT_URL);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($leadData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    // Redirect to thank you page regardless of Google Sheets response
    header("Location: ./thank-you/");
    exit;

} else {
    echo json_encode(['status' => 'error', 'message' => 'Required fields are missing.']);
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Direct access not allowed.']);
exit;

