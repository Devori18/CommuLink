<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', isset($_SERVER['HTTPS']));
ini_set('session.use_strict_mode', 1);


?>