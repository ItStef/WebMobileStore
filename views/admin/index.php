<?php $title = 'Admin Panel'; include __DIR__ . '/../partials/header.php'; ?>
<div class="dashboard">
    <h1>Admin Panel</h1>
    <?php if (!empty($msg)) echo "<div class='register-msg' style='background:#4caf50;'>$msg</div>"; ?>
    <h2>Import Devices</h2>
    <form method="post" enctype="multipart/form-data">
        <label class="custom-file-upload">
            <input type="file" name="datafile" required>
            Choose file
        </label>
        <button type="submit">Import</button>
    </form>
    <h2>Export Devices</h2>
    <a class="dashboard-link" href="/index.php?page=admin&export=json">Export as JSON</a>
    <a class="dashboard-link" href="/index.php?page=admin&export=xml">Export as XML</a>
    <div class="register-links">
        <a href="/index.php?page=dashboard">Back to dashboard</a>
    </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>