<?php
declare(strict_types=1);

// Include config
require __DIR__ . '/../db/app.php';



if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (empty($_SESSION['user'])) {
    header('Location: ' . BASE_URL . '/auth/login.php');
    exit;
}

