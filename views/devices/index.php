<?php $title = 'Devices'; include __DIR__ . '/../partials/header.php'; ?>
<div class="dashboard">
    <h1>Devices</h1>
    <?php if (!empty($msg)) echo "<div class='register-msg' style='background:#4caf50;'>$msg</div>"; ?>
    <form method="post">
        <table>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Brand</th>
                <th>OS</th>
                <th>Year</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
            <?php foreach ($devices as $d): ?>
            <tr>
                <td class="device-img-box">
                    <?php if (!empty($d['image']) && file_exists(__DIR__ . '/../../public/images/' . $d['image'])): ?>
                        <img src="/images/<?=htmlspecialchars($d['image'])?>" alt="Device Image" class="device-img">
                    <?php else: ?>
                        <span class="no-img">No image</span>
                    <?php endif; ?>
                </td>
                <td><?=htmlspecialchars($d['name'])?></td>
                <td><?=htmlspecialchars($d['brand'])?></td>
                <td><?=htmlspecialchars($d['os'])?></td>
                <td><?=htmlspecialchars($d['year'])?></td>
                <td><?=htmlspecialchars($d['price'])?></td>
                <td>
                    <button type="submit" name="add_to_cart" value="<?=$d['id']?>" class="add-to-cart-btn">Add to Cart</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </form>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>