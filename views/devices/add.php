<?php $title = 'Add Device'; include __DIR__ . '/../partials/header.php'; ?>
<div class="dashboard">
    <h1>Add Device</h1>
    <?php if (!empty($msg)) echo "<div class='register-msg' style='background:#4caf50;'>$msg</div>"; ?>
    <form class="register-form" method="post" enctype="multipart/form-data">
        <label>Name: <input name="name" required></label>
        <label>Brand: <input name="brand" required></label>
        <label>OS: <input name="os" required></label>
        <label>Year: <input name="year" type="number" required></label>
        <label>Price: <input name="price" type="number" step="0.01" required></label>
        <label class="custom-file-upload">
            <span>Image:</span>
            <input name="image" type="file" id="image-upload">
        </label>
        <button type="submit">Add</button>
    </form>
    <div class="register-links">
        <a href="/index.php?page=devices">Back to Devices</a>
    </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>