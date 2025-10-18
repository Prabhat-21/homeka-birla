<?php

header('Content-Type: application/json');

// Project Name
$projectName = "Test Project";

if (isset($_POST) && isset($_POST['input_phone_no']) && trim($_POST['input_phone_no']) != '') {

    $leadData = array();
    $leadData['name'] = filter_var($_POST['input_name'] ?? '', FILTER_SANITIZE_STRING);
    $leadData['mobile'] = filter_var($_POST['input_phone_no'] ?? '', FILTER_SANITIZE_STRING);
    $leadData['email'] = filter_var($_POST['input_email'] ?? '', FILTER_SANITIZE_EMAIL);
    $leadData['form'] = ucwords(strtolower(filter_var($_POST['onclick'] ?? '', FILTER_SANITIZE_STRING)));
    $leadData['comment'] = "";
    $leadData['project'] = $projectName;

    date_default_timezone_set('Asia/Kolkata');

    $leadData['url'] = $_SERVER['HTTP_REFERER'] ?? '';

    if (trim($leadData['form']) == '') {
        $leadData['form'] = "Open Form"; 
    }

    $leadData['date'] = date("d-m-Y");
    $leadData['time'] = date("h:i A");

    // echo "<pre>";
    // echo json_encode($leadData);
    // echo "</pre>";
    // exit;

    $leadData = array();
    echo json_encode(['status' => 'success', 'message' => 'Data submitted successfully.']);
    header("Location: ./thank-you/");
    exit;


} else {
    echo json_encode(['status' => 'error', 'message' => 'Required fields are missing.']);
    // header("Location: /");
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Direct access not allowed.']);
// header("Location: /");
exit;