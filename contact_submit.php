<?php
// Enable strict type checking for better type safety
declare(strict_types=1);

// Return response as JSON
header('Content-Type: application/json');

// ========================================
// INCLUDE PHPMailer FILES
// ========================================

// Main PHPMailer class
require_once __DIR__ . '/phpmailer/PHPMailer.php';

// SMTP functionality
require_once __DIR__ . '/phpmailer/SMTP.php';

// Exception handling
require_once __DIR__ . '/phpmailer/Exception.php';

// ========================================
// IMPORT PHPMailer CLASSES
// ========================================

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// ========================================
// ALLOW ONLY POST REQUESTS
// ========================================

// Prevent direct browser access using GET
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    // Return JSON error response
    echo json_encode([
        'success' => false,
        'error'   => 'Invalid request'
    ]);

    exit;
}

// ========================================
// GET FORM DATA
// ========================================

// Trim removes unnecessary spaces
$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

// ========================================
// BASIC VALIDATION
// ========================================

// Check if required fields are empty
if (!$name || !$email || !$subject || !$message) {

    // Return validation error
    echo json_encode([
        'success' => false,
        'error'   => 'Please fill all fields'
    ]);

    exit;
}

// ========================================
// CREATE PHPMailer INSTANCE
// ========================================

// "true" enables exception handling
$mail = new PHPMailer(true);

try {

    // ========================================
    // SMTP CONFIGURATION
    // ========================================

    // Use SMTP server
    $mail->isSMTP();

    // Gmail SMTP server
    $mail->Host = 'smtp.gmail.com';

    // Enable SMTP authentication
    $mail->SMTPAuth = true;

    // Gmail account email
    $mail->Username = 'shahizewer2025@gmail.com';

    // Gmail App Password
    $mail->Password = 'rkqz cxam tnwk tkzu';

    // Encryption type
    $mail->SMTPSecure = 'tls';

    // SMTP port for TLS
    $mail->Port = 587;

    // ========================================
    // EMAIL SENDER & RECEIVER
    // ========================================

    // Sender email and name
    $mail->setFrom(
        'shahizewer2025@gmail.com',
        'Shahizewer Website'
    );

    // Recipient/admin email
    $mail->addAddress(
        'admin@shahizewer.com',
        'Admin'
    );

    // ========================================
    // EMAIL CONTENT
    // ========================================

    // Enable HTML email format
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

    $mail->send();

    // Return success response
    echo json_encode([
        'success' => true
    ]);

} catch (Exception $e) {

    // ========================================
    // ERROR HANDLING
    // ========================================

    // Return PHPMailer error response
    echo json_encode([
        'success' => false,
        'error'   => $mail->ErrorInfo
    ]);
}