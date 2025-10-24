<?php
/**
 * Diagnostic Script for Birla Estates Kalwa Form System
 * Upload this file as diagnostic.php and visit it in your browser
 * It will check your server configuration and test Google Sheets connection
 */

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Form System Diagnostics</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
        }
        .section {
            background: white;
            padding: 25px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .section h2 {
            color: #333;
            border-bottom: 2px solid #667eea;
            padding-bottom: 10px;
            margin-top: 0;
        }
        .test {
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            border-left: 4px solid;
        }
        .pass {
            background: #d4edda;
            border-color: #28a745;
            color: #155724;
        }
        .fail {
            background: #f8d7da;
            border-color: #dc3545;
            color: #721c24;
        }
        .warn {
            background: #fff3cd;
            border-color: #ffc107;
            color: #856404;
        }
        .info {
            background: #d1ecf1;
            border-color: #17a2b8;
            color: #0c5460;
        }
        .test strong {
            display: block;
            margin-bottom: 5px;
        }
        code {
            background: #f4f4f4;
            padding: 2px 6px;
            border-radius: 3px;
            font-family: 'Courier New', monospace;
        }
        .status-icon {
            font-size: 20px;
            margin-right: 10px;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }
        .button:hover {
            background: #5568d3;
        }
        pre {
            background: #f4f4f4;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🔍 Form System Diagnostics</h1>
        <p>Birla Estates Kalwa - System Health Check</p>
    </div>

    <?php
    $allPassed = true;
    
    // Test 1: PHP Version
    echo '<div class="section">';
    echo '<h2>1. Server Configuration</h2>';
    
    $phpVersion = phpversion();
    $phpOk = version_compare($phpVersion, '7.0.0', '>=');
    echo '<div class="test ' . ($phpOk ? 'pass' : 'fail') . '">';
    echo '<span class="status-icon">' . ($phpOk ? '✅' : '❌') . '</span>';
    echo '<strong>PHP Version</strong>';
    echo 'Current: ' . $phpVersion . ' ';
    echo $phpOk ? '(OK)' : '(Need 7.0+)';
    echo '</div>';
    if (!$phpOk) $allPassed = false;
    
    // Test 2: cURL
    $curlEnabled = function_exists('curl_version');
    echo '<div class="test ' . ($curlEnabled ? 'pass' : 'fail') . '">';
    echo '<span class="status-icon">' . ($curlEnabled ? '✅' : '❌') . '</span>';
    echo '<strong>cURL Extension</strong>';
    echo $curlEnabled ? 'Enabled' : 'Disabled - REQUIRED for Google Sheets integration!';
    echo '</div>';
    if (!$curlEnabled) $allPassed = false;
    
    // Test 3: JSON
    $jsonEnabled = function_exists('json_encode');
    echo '<div class="test ' . ($jsonEnabled ? 'pass' : 'fail') . '">';
    echo '<span class="status-icon">' . ($jsonEnabled ? '✅' : '❌') . '</span>';
    echo '<strong>JSON Extension</strong>';
    echo $jsonEnabled ? 'Enabled' : 'Disabled - REQUIRED!';
    echo '</div>';
    if (!$jsonEnabled) $allPassed = false;
    
    // Test 4: allow_url_fopen
    $urlFopen = ini_get('allow_url_fopen');
    echo '<div class="test ' . ($urlFopen ? 'pass' : 'warn') . '">';
    echo '<span class="status-icon">' . ($urlFopen ? '✅' : '⚠️') . '</span>';
    echo '<strong>allow_url_fopen</strong>';
    echo $urlFopen ? 'Enabled' : 'Disabled (cURL will handle it)';
    echo '</div>';
    
    echo '</div>';
    
    // Test 5: File Checks
    echo '<div class="section">';
    echo '<h2>2. File System Checks</h2>';
    
    $serverPhp = file_exists('server.php');
    echo '<div class="test ' . ($serverPhp ? 'pass' : 'fail') . '">';
    echo '<span class="status-icon">' . ($serverPhp ? '✅' : '❌') . '</span>';
    echo '<strong>server.php exists</strong>';
    echo $serverPhp ? 'Found' : 'Missing - Upload server.php!';
    echo '</div>';
    if (!$serverPhp) $allPassed = false;
    
    $thankYou = file_exists('thank-you') || file_exists('thank-you/index.html');
    echo '<div class="test ' . ($thankYou ? 'pass' : 'warn') . '">';
    echo '<span class="status-icon">' . ($thankYou ? '✅' : '⚠️') . '</span>';
    echo '<strong>thank-you folder</strong>';
    echo $thankYou ? 'Found' : 'Not found - Users will see 404 after submission';
    echo '</div>';
    
    $scriptJs = file_exists('assets/js/script.js');
    echo '<div class="test ' . ($scriptJs ? 'pass' : 'warn') . '">';
    echo '<span class="status-icon">' . ($scriptJs ? '✅' : '⚠️') . '</span>';
    echo '<strong>script.js exists</strong>';
    echo $scriptJs ? 'Found' : 'Not found - Form validation may not work';
    echo '</div>';
    
    echo '</div>';
    
    // Test 6: Google Sheets Connection
    if ($curlEnabled && file_exists('server.php')) {
        echo '<div class="section">';
        echo '<h2>3. Google Sheets Connection Test</h2>';
        
        // Extract URL from server.php
        $serverContent = file_get_contents('server.php');
        preg_match('/\$GOOGLE_SCRIPT_URL\s*=\s*["\']([^"\']+)["\']/', $serverContent, $matches);
        $googleUrl = isset($matches[1]) ? $matches[1] : '';
        
        if ($googleUrl) {
            echo '<div class="test info">';
            echo '<span class="status-icon">ℹ️</span>';
            echo '<strong>Google Apps Script URL Found</strong>';
            echo '<code style="font-size: 11px; display: block; margin-top: 5px;">' . htmlspecialchars($googleUrl) . '</code>';
            echo '</div>';
            
            // Test connection
            echo '<div class="test info">';
            echo '<span class="status-icon">🔄</span>';
            echo '<strong>Testing connection...</strong>';
            
            $testData = array(
                'name' => 'Diagnostic Test',
                'mobile' => '9999999999',
                'email' => 'test@diagnostic.com',
                'form' => 'System Test',
                'project' => 'Birla Estates Kalwa',
                'date' => date('d-m-Y'),
                'time' => date('h:i A'),
                'url' => 'http://diagnostic-test'
            );
            
            $ch = curl_init($googleUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($testData));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curlError = curl_error($ch);
            curl_close($ch);
            
            echo '</div>';
            
            $connectionOk = ($httpCode >= 200 && $httpCode < 400);
            echo '<div class="test ' . ($connectionOk ? 'pass' : 'fail') . '">';
            echo '<span class="status-icon">' . ($connectionOk ? '✅' : '❌') . '</span>';
            echo '<strong>Connection Status</strong>';
            echo 'HTTP Code: ' . $httpCode . '<br>';
            if ($curlError) {
                echo 'Error: ' . htmlspecialchars($curlError) . '<br>';
            }
            if ($response) {
                echo '<details style="margin-top: 10px;">';
                echo '<summary style="cursor: pointer;">View Response</summary>';
                echo '<pre>' . htmlspecialchars($response) . '</pre>';
                echo '</details>';
            }
            echo '</div>';
            
            if (!$connectionOk) $allPassed = false;
            
        } else {
            echo '<div class="test fail">';
            echo '<span class="status-icon">❌</span>';
            echo '<strong>Google Apps Script URL Not Found</strong>';
            echo 'Check server.php and ensure $GOOGLE_SCRIPT_URL is set correctly';
            echo '</div>';
            $allPassed = false;
        }
        
        echo '</div>';
    }
    
    // Test 7: Form Field Check
    if (file_exists('index.html')) {
        echo '<div class="section">';
        echo '<h2>4. Form Field Validation</h2>';
        
        $htmlContent = file_get_contents('index.html');
        
        $hasPhoneField = (strpos($htmlContent, 'name="input_phone_no"') !== false);
        echo '<div class="test ' . ($hasPhoneField ? 'pass' : 'fail') . '">';
        echo '<span class="status-icon">' . ($hasPhoneField ? '✅' : '❌') . '</span>';
        echo '<strong>Phone field (name="input_phone_no")</strong>';
        echo $hasPhoneField ? 'Found' : 'Missing - Forms will not submit properly!';
        echo '</div>';
        if (!$hasPhoneField) $allPassed = false;
        
        $hasNameField = (strpos($htmlContent, 'name="input_name"') !== false);
        echo '<div class="test ' . ($hasNameField ? 'pass' : 'warn') . '">';
        echo '<span class="status-icon">' . ($hasNameField ? '✅' : '⚠️') . '</span>';
        echo '<strong>Name field (name="input_name")</strong>';
        echo $hasNameField ? 'Found' : 'Missing';
        echo '</div>';
        
        $hasEmailField = (strpos($htmlContent, 'name="input_email"') !== false);
        echo '<div class="test ' . ($hasEmailField ? 'pass' : 'warn') . '">';
        echo '<span class="status-icon">' . ($hasEmailField ? '✅' : '⚠️') . '</span>';
        echo '<strong>Email field (name="input_email")</strong>';
        echo $hasEmailField ? 'Found' : 'Missing';
        echo '</div>';
        
        $hasOnclickField = (strpos($htmlContent, 'name="onclick"') !== false);
        echo '<div class="test ' . ($hasOnclickField ? 'pass' : 'warn') . '">';
        echo '<span class="status-icon">' . ($hasOnclickField ? '✅' : '⚠️') . '</span>';
        echo '<strong>Form type field (name="onclick")</strong>';
        echo $hasOnclickField ? 'Found' : 'Missing';
        echo '</div>';
        
        $hasFormAction = (strpos($htmlContent, 'action="server.php"') !== false);
        echo '<div class="test ' . ($hasFormAction ? 'pass' : 'fail') . '">';
        echo '<span class="status-icon">' . ($hasFormAction ? '✅' : '❌') . '</span>';
        echo '<strong>Form action to server.php</strong>';
        echo $hasFormAction ? 'Found' : 'Missing - Forms will not submit!';
        echo '</div>';
        if (!$hasFormAction) $allPassed = false;
        
        echo '</div>';
    }
    
    // Summary
    echo '<div class="section">';
    echo '<h2>📊 Summary</h2>';
    
    if ($allPassed) {
        echo '<div class="test pass">';
        echo '<span class="status-icon">🎉</span>';
        echo '<strong>All Critical Tests Passed!</strong>';
        echo 'Your form system should be working correctly. Test it by submitting a form.';
        echo '</div>';
    } else {
        echo '<div class="test fail">';
        echo '<span class="status-icon">⚠️</span>';
        echo '<strong>Issues Found</strong>';
        echo 'Please fix the failed tests above. Refer to the IMPLEMENTATION_GUIDE.md for help.';
        echo '</div>';
    }
    
    echo '<div style="margin-top: 20px;">';
    echo '<a href="test-form.html" class="button">Test Form</a> ';
    echo '<a href="index.html" class="button">Main Site</a> ';
    echo '<a href="?" class="button">Refresh Tests</a>';
    echo '</div>';
    
    echo '</div>';
    
    // Footer
    echo '<div style="text-align: center; color: #666; margin-top: 30px; font-size: 14px;">';
    echo '<p>Delete this file (diagnostic.php) after testing</p>';
    echo '<p>Last check: ' . date('Y-m-d H:i:s') . '</p>';
    echo '</div>';
    ?>

</body>
</html>
