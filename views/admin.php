<!DOCTYPE html>
<html>
<head><title>Admin Panel</title></head>
<body>
<h1>Admin Panel</h1>
<?php if (!empty($msg)) echo "<p style='color:green;'>$msg</p>"; ?>
<h2>Import Devices</h2>
<form method="post" enctype="multipart/form-data">
    <input type="file" name="datafile" required>
    <button type="submit">Import</button>
</form>
<h2>Export Devices</h2>
<a href="/index.php?page=admin&export=json">Export as JSON</a> |
<a href="/index.php?page=admin&export=xml">Export as XML</a>
<br><br>
<a href="/index.php?page=dashboard">Back to dashboard</a>
</body>
</html>