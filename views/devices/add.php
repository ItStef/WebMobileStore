<?php $title = 'Add Device'; include __DIR__ . '/../partials/header.php'; ?>
<div class="dashboard">
    <h1>Add Device</h1>
    <?php if (!empty($msg)) echo "<div class='register-msg' style='background:#4caf50;'>$msg</div>"; ?>
    <form class="register-form" method="post" enctype="multipart/form-data">
        <label>Name: <input name="name" type="text" class="input-wide" required></label>
        <label>Brand: <input name="brand" type="text" class="input-wide" required></label>
        <label>OS: <input name="os" type="text" class="input-wide" required></label>
        <label>Year: <input name="year" type="number" class="input-wide" required></label>
        <label>Price: <input name="price" type="number" step="0.01" class="input-wide" required></label>
        <label class="custom-file-upload">
            <span>Image:</span>
            <input name="image" type="file" id="image-upload" class="input-wide">
        </label>
        <button type="submit">Add</button>
    </form>
    <div class="register-links">
        <a href="/index.php?page=devices">Back to Devices</a>
    </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>