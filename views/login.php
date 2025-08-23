<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>
<h1>Login</h1>
<?php if (!empty($msg)) echo "<p style='color:red;'>$msg</p>"; ?>
<form method="post">
    <label>Username: <input name="username" required></label><br>
    <label>Password: <input name="password" type="password" required></label><br>
    <button type="submit">Login</button>
</form>
<a href="/index.php?page=register">Register</a>
</body>
</html>