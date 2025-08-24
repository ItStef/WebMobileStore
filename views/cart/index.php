<?php $title = 'Cart'; include __DIR__ . '/../partials/header.php'; ?>
<div class="dashboard">
    <h1>Your Cart</h1>
    <?php if (!empty($msg)) echo "<div class='register-msg' style='background:#4caf50;'>$msg</div>"; ?>
    <?php if (empty($devices)): ?>
        <?php if (!isset($_SESSION['user']) && !isset($_SESSION['admin'])): ?>
            <h3>Please log in to view your cart.</h3>
        <?php endif; ?>
        <p>Cart is empty.</p>
    <?php else: ?>
        <form method="post">
        <table>
            <tr>
                <th>Image</th>
                <th>Device</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Subtotal</th>
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
                <td><?=htmlspecialchars($d['quantity'])?></td>
                <td><?=htmlspecialchars($d['price'])?></td>
                <td><?=htmlspecialchars($d['subtotal'])?></td>
                <td style="display:flex; gap:0.3em; justify-content:center;">
                    <button type="submit" name="remove" value="<?=$d['id']?>" class="cart-btn cart-btn-small">Remove</button>
                    <button type="submit" name="sub_qty" value="<?=$d['id']?>" class="cart-btn cart-btn-small">-1</button>
                    <button type="submit" name="add_qty" value="<?=$d['id']?>" class="cart-btn cart-btn-small">+1</button>
                </td>
            </tr>
            <?php endforeach; ?>
            <tr><td colspan="4">Total</td><td><?=htmlspecialchars($total)?></td><td></td></tr>
        </table>
        <button name="order" value="1" class="dashboard-link" style="margin-top:0;">Place Order</button>
        </form>
    <?php endif; ?>
    <div class="register-links">
        <a href="/index.php?page=devices">Continue Shopping</a>
    </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>