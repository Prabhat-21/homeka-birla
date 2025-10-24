<?php
// Prevent any output before headers
ob_start();

// Error reporting (disable in production)
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// Google Apps Script Web App URL
$GOOGLE_SCRIPT_URL = "https://script.google.com/macros/s/AKfycbyT0aNEkOg296BMHorMiJbhtAPqn6S9dmuPVDfMTrUuk6kSH71qlhz3FE-1myEIEYcQ1A/exec";

// Project Name
$projectName = "Birla Estates Kalwa";

// Check if this is a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode(['status' => 'error', 'message' => 'Only POST requests are allowed.']);
    exit;
}

// Check if required phone field exists
if (!isset($_POST['input_phone_no']) || trim($_POST['input_phone_no']) == '') {
    header("HTTP/1.1 400 Bad Request");
    echo json_encode(['status' => 'error', 'message' => 'Phone number is required.']);
    exit;
}

// Prepare lead data
$leadData = array();
$leadData['name'] = isset($_POST['input_name']) ? filter_var($_POST['input_name'], FILTER_SANITIZE_STRING) : '';
$leadData['mobile'] = isset($_POST['input_phone_no']) ? filter_var($_POST['input_phone_no'], FILTER_SANITIZE_STRING) : '';
$leadData['email'] = isset($_POST['input_email']) ? filter_var($_POST['input_email'], FILTER_SANITIZE_EMAIL) : '';
$leadData['form'] = isset($_POST['onclick']) ? ucwords(strtolower(filter_var($_POST['onclick'], FILTER_SANITIZE_STRING))) : 'Open Form';
$leadData['project'] = $projectName;

// Set timezone and get date/time
date_default_timezone_set('Asia/Kolkata');
$leadData['date'] = date("d-m-Y");
$leadData['time'] = date("h:i A");

// Get referrer URL
$leadData['url'] = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

// If form field is empty, set default
if (trim($leadData['form']) == '') {
    $leadData['form'] = "Open Form";
}

// Send data to Google Sheets
try {
    $ch = curl_init($GOOGLE_SCRIPT_URL);
    
    if ($ch === false) {
        throw new Exception('Failed to initialize cURL');
    }
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($leadData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_TIMEOUT, 30); // 30 second timeout
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    
    curl_close($ch);
    
    // Log the response for debugging (optional)
    if ($curlError) {
        error_log("cURL Error: " . $curlError);
    }
    
    if ($httpCode >= 400) {
        error_log("Google Sheets API returned HTTP code: " . $httpCode);
    }
    
} catch (Exception $e) {
    error_log("Exception in form submission: " . $e->getMessage());
}

// Clear any output buffers
ob_end_clean();

// Redirect to thank you page (always redirect, even if Google Sheets fails)
header("Location: ./thank-you/");
exit;
?>

