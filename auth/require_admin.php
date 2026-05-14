<?php
declare(strict_types=1);


require __DIR__ . '/require_login.php';

if (($_SESSION['user']['role'] ?? '') !== 'admin') {
    header('Location: ' . BASE_URL . '/account/index.php');
    exit;
}
