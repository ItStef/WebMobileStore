<!DOCTYPE html>
<html>
<head><title>Dashboard</title></head>
<body>
<h1>Welcome to the WebMobileStore Dashboard!</h1>
<ul>
    <li><a href="/index.php?page=devices">View Devices</a></li>
    <li><a href="/index.php?page=cart">Your Cart</a></li>
    <li><a href="/index.php?page=user">Your Profile</a></li>
    <li><a href="/index.php?page=logout">Logout</a></li>
</ul>
<?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
    <ul>
        <li><a href="/index.php?page=admin">Admin Panel</a></li>
        <li><a href="/index.php?page=user&action=list">User List</a></li>
    </ul>
<?php endif; ?>
</body>
</html>