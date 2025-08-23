<?php $title = 'Register'; include __DIR__ . '/../partials/header.php'; ?>
<div class="register-container">
    <h1>Register</h1>
    <?php if (!empty($msg)) echo "<div class='register-msg'>$msg</div>"; ?>
    <form class="register-form" method="post" autocomplete="off">
        <label for="register-username">Username:</label>
        <input id="register-username" name="username" type="text" required autocomplete="username">
        <label for="register-password">Password:</label>
        <input id="register-password" name="password" type="password" required autocomplete="new-password">
        <button type="submit">Register</button>
    </form>
    <div class="register-links">
        <a href="/index.php?page=login">Back to Login</a>
    </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>