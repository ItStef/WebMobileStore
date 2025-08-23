<!DOCTYPE html>
<html>
<head>
    <title><?= isset($title) ? htmlspecialchars($title) : 'WebMobileStore' ?></title>
    <link rel="stylesheet" href="styles/style.css">
    <meta charset="utf-8">
</head>
<body>
<nav class="navbar">
    <div class="nav-title"><a href="/index.php?page=dashboard" style="color:inherit;text-decoration:none;">WebMobileStore</a></div>
    <div class="nav-links">
        <a href="/index.php?page=devices">Devices</a>
        <a href="/index.php?page=cart" class="cart-link">Cart</a>
        <?php if (isset($_SESSION['user'])): ?>
            <a href="/index.php?page=user">Profile</a>
            <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                <a href="/index.php?page=admin">Admin</a>
                <a href="/index.php?page=devices&action=add">Add Device</a>
            <?php endif; ?>
            <a href="/index.php?page=logout">Logout</a>
        <?php else: ?>
            <a href="/index.php?page=login">Login</a>
            <a href="/index.php?page=register">Register</a>
        <?php endif; ?>
    </div>
</nav>
<main></main>