<?php $title = 'Edit Profile'; include __DIR__ . '/../partials/header.php'; ?>
<div class="dashboard">
    <h1>Edit Profile</h1>
    <?php if (!empty($msg)) echo "<div class='register-msg' style='background:#4caf50;'>$msg</div>"; ?>
    <form class="register-form" method="post">
        <label>New Password: <input name="password" type="password" required></label>
        <button type="submit">Change Password</button>
    </form>
    <div class="register-links">
        <a href="/index.php?page=user">Back to Profile</a>
    </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>