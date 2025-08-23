<!DOCTYPE html>
<html>
<head><title>Register</title></head>
<body>
<h1>Register</h1>
<?php if (!empty($msg)) echo "<p style='color:red;'>$msg</p>"; ?>
<form method="post">
    <label>Username: <input name="username" required></label><br>
    <label>Password: <input name="password" type="password" required></label><br>
    <button type="submit">Register</button>
</form>
<a href="/index.php?page=login">Back to Login</a>
</body>
</html>