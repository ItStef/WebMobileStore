<!DOCTYPE html>
<html>
<head><title>Devices</title></head>
<body>
<h1>Device List</h1>
<table border="1">
    <tr><th>Name</th><th>Brand</th><th>OS</th><th>Year</th><th>Price</th><th>Image</th></tr>
    <?php foreach ($devices as $d): ?>
    <tr>
        <td><?=htmlspecialchars($d['name'])?></td>
        <td><?=htmlspecialchars($d['brand'])?></td>
        <td><?=htmlspecialchars($d['os'])?></td>
        <td><?=htmlspecialchars($d['year'])?></td>
        <td><?=htmlspecialchars($d['price'])?></td>
        <td><?php if (!empty($d['image'])): ?>
            <img src="/public/images/<?=htmlspecialchars($d['image'])?>" width="50">
        <?php endif; ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
    <a href="/index.php?page=devices&action=add">Add Device</a>
<?php endif; ?>
</body>
</html>