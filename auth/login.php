<?php
require_once __DIR__ . '/../includes/functions.php';

if (isLoggedIn())
    redirect('/CommunityLink/contributor/dashboard.php');

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = strtolower(sanitize($_POST['email']));
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && verifyPassword($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['full_name'];
        $_SESSION['user_role'] = $user['role'];
        redirect('/CommunityLink/contributor/dashboard.php');
    } else {
        $error = 'Invalid email or password.';
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Login — CommunityLink</title>
</head>

<body>
    <h2>Login to CommunityLink</h2>
    <?php if ($error): ?>
        <p style="color:red"><?= $error ?></p><?php endif ?>
    <form method="POST">
        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>
        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>
        <button type="submit">Login</button>
    </form>
    <p>Don't have account? <a href="register.php">Register →</a></p>
</body>

</html>