<?php

// ========================================
// ENABLE STRICT TYPE CHECKING
// ========================================

// Helps prevent type-related bugs
declare(strict_types=1);

// ========================================
// RETURN RESPONSE AS JSON
// ========================================

// Tells browser/API client that response is JSON
header('Content-Type: application/json');

// ========================================
// INCLUDE PHPMailer LIBRARIES
// ========================================

// Main PHPMailer class
require_once __DIR__ . '/phpmailer/PHPMailer.php';

// SMTP support class
require_once __DIR__ . '/phpmailer/SMTP.php';

// Exception handling class
require_once __DIR__ . '/phpmailer/Exception.php';

// ========================================
// IMPORT REQUIRED CLASSES
// ========================================

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// ========================================
// ALLOW ONLY POST REQUESTS
// ========================================

// Prevent direct access using GET request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    // Return JSON error response
    echo json_encode([
        'success' => false,
        'error' => 'Invalid request'
    ]);

    // Stop script execution
    exit;
}

// ========================================
// GET FORM INPUT VALUES
// ========================================

// Remove unnecessary spaces from user input
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

// ========================================
// BASIC FORM VALIDATION
// ========================================

// Check if any required field is empty
if (!$name || !$email || !$subject || !$message) {

    // Return validation error response
    echo json_encode([
        'success' => false,
        'error' => 'Please fill all fields'
    ]);

    // Stop script execution
    exit;
}

// ========================================
// CREATE PHPMailer OBJECT
// ========================================

// "true" enables exception mode
$mail = new PHPMailer(true);

try {

    // ========================================
    // SMTP SERVER CONFIGURATION
    // ========================================

    // Use SMTP for sending email
    $mail->isSMTP();

    // Gmail SMTP server
    $mail->Host = 'smtp.gmail.com';

    // Enable SMTP authentication
    $mail->SMTPAuth = true;

    // Gmail account email
    $mail->Username = 'shahizewer2025@gmail.com';

    // Gmail App Password
    $mail->Password = 'rkqz cxam tnwk tkzu';

    // Encryption method
    $mail->SMTPSecure = 'tls';

    // TLS SMTP port
    $mail->Port = 587;

    // ========================================
    // EMAIL SENDER DETAILS
    // ========================================

    // Sender email and sender name
    $mail->setFrom(
        'shahizewer2025@gmail.com',
        'Shahizewer Website'
    );

    // ========================================
    // EMAIL RECEIVER DETAILS
    // ========================================

    // Admin email that receives contact messages
    $mail->addAddress(
        'admin@shahizewer.com',
        'Admin'
    );

    // ========================================
    // EMAIL CONTENT SETTINGS
    // ========================================

    // Enable HTML email formatting
    $mail->isHTML(true);

    // Email subject line
    $mail->Subject = "New Contact Message: {$subject}";

    // Email body content
    $mail->Body = "

        <h2>New Contact Message</h2>

        <p>
            <strong>Name:</strong> {$name}
        </p>

        <p>
            <strong>Email:</strong> {$email}
        </p>

        <p>
            <strong>Subject:</strong> {$subject}
        </p>

        <p>
            <strong>Message:</strong><br>
            {$message}
        </p>

    ";

    // ========================================
    // SEND EMAIL
    // ========================================

    // Attempt to send email
    $mail->send();

    // Return success response
    echo json_encode([
        'success' => true
    ]);

} catch (Exception $e) {

    // ========================================
    // ERROR HANDLING
    // ========================================

    // Return PHPMailer error message
    echo json_encode([
        'success' => false,
        'error' => $mail->ErrorInfo
    ]);
}