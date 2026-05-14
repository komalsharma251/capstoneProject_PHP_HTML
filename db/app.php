<?php
declare(strict_types=1);

// Start PHP session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Define the base URL for your project (adjust if needed)
define('BASE_URL', '/WEBSITES/shahijewer_website');
