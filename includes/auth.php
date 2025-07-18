<?php
require_once 'config.php';
require_once 'functions.php';

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Check if user is admin
function isAdmin() {
    return isLoggedIn() && $_SESSION['role'] === 'admin';
}

// Check if user is intern
function isIntern() {
    return isLoggedIn() && $_SESSION['role'] === 'intern';
}

// Redirect if not logged in
function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: " . BASE_URL . "/auth/login.php");
        exit();
    }
}

// Redirect if not admin
function requireAdmin() {
    requireLogin();
    if (!isAdmin()) {
        header("Location: " . BASE_URL . "/intern/dashboard.php");
        exit();
    }
}

// Redirect if not intern
function requireIntern() {
    requireLogin();
    if (!isIntern()) {
        header("Location: " . BASE_URL . "/admin/dashboard.php");
        exit();
    }
}
?>