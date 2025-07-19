<?php
define('BASE_URL', 'http://localhost/seat-reservation-system');

session_start();

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isLoggedIn() && $_SESSION['role'] === 'admin';
}

function isIntern() {
    return isLoggedIn() && $_SESSION['role'] === 'intern';
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: " . BASE_URL . "/login.php");
        exit();
    }
}

function requireAdmin() {
    requireLogin();
    if (!isAdmin()) {
        header("Location: " . BASE_URL . "/intern/intern_dashboard.php");
        exit();
    }
}

function requireIntern() {
    requireLogin();
    if (!isIntern()) {
        header("Location: " . BASE_URL . "/admin/admin_panel.php");
        exit();
    }
}
?>
