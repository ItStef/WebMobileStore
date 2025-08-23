<?php $title = 'Dashboard'; include __DIR__ . '/../partials/header.php'; ?>
<div class="dashboard">
    <h1>Welcome to the WebMobileStore Dashboard!</h1>
    <section>
        <a class="dashboard-link" href="/index.php?page=devices">View Devices</a>
        <a class="dashboard-link" href="/index.php?page=cart">Your Cart</a>
        <a class="dashboard-link" href="/index.php?page=user">Your Profile</a>
        <a class="dashboard-link" href="/index.php?page=logout">Logout</a>
    </section>
    <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
    <section>
        <a class="dashboard-link" href="/index.php?page=admin">Admin Panel</a>
        <a class="dashboard-link" href="/index.php?page=user&action=list">User List</a>
    </section>
    <?php endif; ?>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>