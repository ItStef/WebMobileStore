<!DOCTYPE html>
<html>
<head><title>Cart</title></head>
<body>
<h1>Your Cart</h1>
<?php if (!empty($msg)) echo "<p style='color:green;'>$msg</p>"; ?>
<?php if (empty($devices)): ?>
    <p>Cart is empty.</p>
<?php else: ?>
    <form method="post">
    <table border="1">
        <tr><th>Device</th><th>Qty</th><th>Price</th><th>Subtotal</th><th>Action</th></tr>
        <?php foreach ($devices as $d): ?>
        <tr>
            <td><?=htmlspecialchars($d['name'])?></td>
            <td><?=htmlspecialchars($d['quantity'])?></td>
            <td><?=htmlspecialchars($d['price'])?></td>
            <td><?=htmlspecialchars($d['subtotal'])?></td>
            <td>
                <button name="remove" value="<?=$d['id']?>">Remove</button>
                <button name="add_qty" value="<?=$d['id']?>">+1</button>
            </td>
        </tr>
        <?php endforeach; ?>
        <tr><td colspan="3">Total</td><td><?=htmlspecialchars($total)?></td><td></td></tr>
    </table>
    <button name="order" value="1">Place Order</button>
    </form>
<?php endif; ?>
<a href="/index.php?page=devices">Continue Shopping</a>
</body>
</html>