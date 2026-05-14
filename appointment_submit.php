<?php
declare(strict_types=1);

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include database and capture PDO
require_once __DIR__ . '/db/app.php';
$db = require_once __DIR__ . '/db/database.php'; // $db is PDO object

// Include PHPMailer
require_once __DIR__ . '/phpmailer/PHPMailer.php';
require_once __DIR__ . '/phpmailer/SMTP.php';
require_once __DIR__ . '/phpmailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Only process POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: appointment.php");
    exit;
}

// Get and sanitize form data
$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$phone   = trim($_POST['phone'] ?? '');
$date    = trim($_POST['date'] ?? '');
$time    = trim($_POST['time'] ?? '');
$message = trim($_POST['message'] ?? '');

// Basic validation
if (!$name || !$email || !$phone || !$date || !$time) {
    header("Location: appointment.php?error=Please+fill+all+fields");
    exit;
}

// Convert 12-hour time (e.g., 10:00 AM) to 24-hour format for MySQL TIME
$time_24 = date("H:i:s", strtotime($time));

try {
    // Save to database
    $stmt = $db->prepare("
        INSERT INTO appointments 
        (full_name, email, phone, appointment_date, appointment_time, message) 
        VALUES (?,?,?,?,?,?)
    ");
    $stmt->execute([$name, $email, $phone, $date, $time_24, $message]);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

// Send email to admin
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'shahizewer2025@gmail.com'; // Your Gmail
    $mail->Password   = 'rkqz cxam tnwk tkzu';      // Gmail App Password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('shahizewer2025@gmail.com', 'Shahizewer Website');
    $mail->addAddress('admin@shahizewer.com', 'Admin');

    $mail->isHTML(true);
    $mail->Subject = "New Appointment Booked";
    $mail->Body = "
        <h2>New Appointment</h2>
        <p><strong>Name:</strong> {$name}</p>
        <p><strong>Email:</strong> {$email}</p>
        <p><strong>Phone:</strong> {$phone}</p>
        <p><strong>Date:</strong> {$date}</p>
        <p><strong>Time:</strong> {$time}</p>
        <p><strong>Message:</strong> {$message}</p>
    ";

    $mail->send();

    // Redirect back with success
    header("Location: appointment.php?success=1");
    exit;
} catch (Exception $e) {
    // Redirect back with error (you can log $mail->ErrorInfo if needed)
    header("Location: appointment.php?error=Email+could+not+be+sent");
    exit;
}
