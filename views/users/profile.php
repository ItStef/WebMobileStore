<?php $title = 'Profile'; include __DIR__ . '/../partials/header.php'; ?>
<div class="dashboard">
    <h1>Your Profile</h1>
    <p>Username: <?=htmlspecialchars($user['username'])?></p>
    <p>Role: <?=htmlspecialchars($user['role'])?></p>
    <div class="register-links">
        <a href="/index.php?page=user&action=edit">Change Password</a>
    </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>