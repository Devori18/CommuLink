<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/session.php';

function redirect($url) {
    header("Location: $url");
    exit();
}

function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data))); 
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function requireAuth() {
    if (!isLoggedIn()) {
        redirect('/auth/login.php');
    }
}

function isRole($role) {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === $role;
}

function hashPassword($pw) {
    return password_hash($pw, PASSWORD_DEFAULT);
}

function verifyPassword($pw, $hash) {
    return password_verify($pw, $hash);
}
?>