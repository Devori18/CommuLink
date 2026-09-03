<?php
require_once __DIR__ . '/../includes/functions.php';

$error = $success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = sanitize($_POST['full_name']);
    $email = strtolower(sanitize($_POST['email']));
    $password = $_POST['password'];
    $role = $_POST['role'] ?? 'CONTRIBUTOR';

    if (empty($full_name) || empty($email) || empty($password)) {
        $error = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } else {
        try {
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->rowCount() > 0) {
                $error = 'Email already registered.';
            } else {
                $hash = hashPassword($password);
                $stmt = $pdo->prepare("INSERT INTO users (email, password_hash, full_name, role) VALUES (?, ?, ?, ?)");
                $stmt->execute([$email, $hash, $full_name, $role]);
                $success = 'Account created! <a href="login.php">Login here</a>.';
            }
        } catch (PDOException $e) {
            $error = 'Error: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Register — CommunityLink</title>
</head>

<body>
    <h2>Create Your Account</h2>
    <?php if ($error): ?>
        <p style="color:red"><?= $error ?></p><?php endif ?>
    <?php if ($success): ?>
        <p style="color:green"><?= $success ?></p><?php endif ?>
    <form method="POST">
        <label>Full Name:</label><br>
        <input type="text" name="full_name" required><br><br>
        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>
        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>
        <label>Role:</label><br>
        <select name="role">
            <option value="CONTRIBUTOR">Contributor / Volunteer</option>
            <option value="ORG_ADMIN">Organization</option>
            <option value="SCHOOL_ADMIN">School</option>
        </select><br><br>
        <button type="submit">Register</button>
    </form>
    <p>Already have account? <a href="login.php">Login →</a></p>
</body>

</html>