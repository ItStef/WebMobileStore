<?php $title = 'Login'; include __DIR__ . '/../partials/header.php'; ?>
<div class="login-container">
    <h1>Login</h1>
    <?php if (!empty($msg)) echo "<div class='login-msg'>$msg</div>"; ?>
    <form class="login-form" method="post" autocomplete="off">
        <label for="login-username">Username:</label>
        <input id="login-username" name="username" type="text" required autocomplete="username">
        <label for="login-password">Password:</label>
        <input id="login-password" name="password" type="password" required autocomplete="current-password">
        <button type="submit">Login</button>
    </form>
    <div class="login-links">
        <a href="/index.php?page=register">Register</a>
    </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>