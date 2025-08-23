<?php $title = 'User List'; include __DIR__ . '/../partials/header.php'; ?>
<div class="dashboard">
    <h1>All Users</h1>
    <table>
        <tr><th>ID</th><th>Username</th><th>Role</th></tr>
        <?php foreach ($users as $u): ?>
        <tr>
            <td><?=htmlspecialchars($u['id'])?></td>
            <td><?=htmlspecialchars($u['username'])?></td>
            <td><?=htmlspecialchars($u['role'])?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <div class="register-links">
        <a href="/index.php?page=dashboard">Back to dashboard</a>
    </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>