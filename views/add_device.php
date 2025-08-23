<!DOCTYPE html>
<html>
<head><title>Add Device</title></head>
<body>
<h1>Add Device</h1>
<?php if (!empty($msg)) echo "<p style='color:green;'>$msg</p>"; ?>
<form method="post" enctype="multipart/form-data">
    <label>Name: <input name="name" required></label><br>
    <label>Brand: <input name="brand" required></label><br>
    <label>OS: <input name="os" required></label><br>
    <label>Year: <input name="year" type="number" required></label><br>
    <label>Price: <input name="price" type="number" step="0.01" required></label><br>
    <label>Image: <input name="image" type="file"></label><br>
    <button type="submit">Add</button>
</form>
<a href="/index.php?page=devices">Back to Devices</a>
</body>
</html>