<?php
require_once __DIR__ . '/../includes/functions.php';
requireAuth(); // Must be logged in
?>
<!DOCTYPE html>
<html>
<head><title>Dashboard — CommunityLink</title></head>
<body>
<h1>Welcome, <?= $_SESSION['user_name'] ?>!</h1>
<p>Role: <?= $_SESSION['user_role'] ?> | Email: <?= $_SESSION['user_email'] ?></p>
<hr>
<ul>
  <li><a href="#">My Profile</a></li>
  <li><a href="#">Browse Opportunities</a></li>
  <li><a href="#">My Applications</a></li>
  <li><a href="../auth/logout.php">Logout</a></li>
</ul>
</body>
</html>