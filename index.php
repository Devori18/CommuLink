<?php
require_once __DIR__ . '/includes/functions.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>CommunityLink</title>
</head>
<body>
    <h1>CommuLink</h1>
    <p>Connecting community needs with skilled contributors.</p>
    <hr>
    <?php if (isLoggedIn()): ?>
        <p>Welcome back, <?= $_SESSION['user_name'] ?>!</p>
        <a href="contributor/dashboard.php">Go to Dashboard</a> |
        <a href="auth/logout.php">Logout</a>
    <?php else: ?>
        <a href="auth/login.php">Login</a> |
        <a href="auth/register.php">Register</a>
    <?php endif ?>
</body>
</html>