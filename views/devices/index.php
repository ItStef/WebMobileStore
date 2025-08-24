<?php $title = 'Devices'; include __DIR__ . '/../partials/header.php'; ?>
<link rel="stylesheet" href="/styles/style.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<div class="devices-flex-container">
    <aside class="devices-filter-sidebar card">
        <form method="get" class="devices-filter-form">
            <input type="hidden" name="page" value="devices">
            <h2>Filter</h2>
            <div class="filter-group">
                <label for="brand">Brand:</label>
                <select name="brand" id="brand">
                    <option value="">All</option>
                    <?php
                    $brands = array_unique(array_map(function($d){return $d['brand'];}, $devices));
                    sort($brands);
                    foreach ($brands as $brand): ?>
                        <option value="<?=htmlspecialchars($brand)?>" <?=isset($_GET['brand']) && $_GET['brand'] === $brand ? 'selected' : ''?>><?=htmlspecialchars($brand)?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filter-group">
                <label for="os">OS:</label>
                <select name="os" id="os">
                    <option value="">All</option>
                    <?php
                    $oses = array_unique(array_map(function($d){return $d['os'];}, $devices));
                    sort($oses);
                    foreach ($oses as $os): ?>
                        <option value="<?=htmlspecialchars($os)?>" <?=isset($_GET['os']) && $_GET['os'] === $os ? 'selected' : ''?>><?=htmlspecialchars($os)?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filter-group">
                <label for="year">Year:</label>
                <select name="year" id="year">
                    <option value="">All</option>
                    <?php
                    $years = array_unique(array_map(function($d){return $d['year'];}, $devices));
                    rsort($years);
                    foreach ($years as $year): ?>
                        <option value="<?=htmlspecialchars($year)?>" <?=isset($_GET['year']) && $_GET['year'] == $year ? 'selected' : ''?>><?=htmlspecialchars($year)?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="filter-group">
                <label>Price:</label>
                <?php
                $prices = array_column($devices, 'price');
                $minPrice = floor(min($prices));
                $maxPrice = ceil(max($prices));
                $selectedMin = isset($_GET['min_price']) ? (float)$_GET['min_price'] : $minPrice;
                $selectedMax = isset($_GET['max_price']) ? (float)$_GET['max_price'] : $maxPrice;
                ?>
                <div class="price-range">
                    <input type="number" name="min_price" min="<?=$minPrice?>" max="<?=$maxPrice?>" value="<?=$selectedMin?>" class="price-input"> -
                    <input type="number" name="max_price" min="<?=$minPrice?>" max="<?=$maxPrice?>" value="<?=$selectedMax?>" class="price-input">
                </div>
            </div>
            <button type="submit" class="filter-btn">Apply</button>
        </form>
    </aside>
    <div class="devices-table-container card">
        <div class="dashboard">
            <h1>Devices</h1>
            <?php if (!empty($msg)) echo "<div class='register-msg' style='background:#4caf50;'>$msg</div>"; ?>
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
                <?php
                $filteredDevices = array_filter($devices, function($d) use ($selectedMin, $selectedMax) {
                    if (isset($_GET['brand']) && $_GET['brand'] !== '' && $d['brand'] !== $_GET['brand']) return false;
                    if (isset($_GET['os']) && $_GET['os'] !== '' && $d['os'] !== $_GET['os']) return false;
                    if (isset($_GET['year']) && $_GET['year'] !== '' && $d['year'] != $_GET['year']) return false;
                    if ($d['price'] < $selectedMin || $d['price'] > $selectedMax) return false;
                    return true;
                });
                $filteredDevices = array_values($filteredDevices); 
                usort($filteredDevices, function($a, $b) {
                    return $b['price'] <=> $a['price'];
                });
                $perPage = 7;
                $totalDevices = count($filteredDevices);
                $totalPages = max(1, ceil($totalDevices / $perPage));
                $currentPage = isset($_GET['p']) && is_numeric($_GET['p']) && $_GET['p'] > 0 ? (int)$_GET['p'] : 1;
                if ($currentPage > $totalPages) $currentPage = $totalPages;
                $start = ($currentPage - 1) * $perPage;
                $devicesToShow = array_slice($filteredDevices, $start, $perPage);
                foreach ($devicesToShow as $d): ?>
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
                    <td>
                        <span id="price-display-<?=$d['id']?>">
                            <?=htmlspecialchars($d['price'])?>
                            <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
                                <a href="#" class="edit-price-link" onclick="showEditPrice(<?=$d['id']?>, <?=htmlspecialchars(json_encode($d['price']))?>); return false;">
                                    <i class="fa fa-pen edit-price-icon" title="Edit Price"></i>
                                </a>
                            <?php endif; ?>
                        </span>
                        <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
                        <form id="edit-price-form-<?=$d['id']?>" method="post" action="?page=devices&action=edit_price" class="edit-price-form">
                            <input type="hidden" name="device_id" value="<?=$d['id']?>">
                            <input type="number" name="new_price" step="0.01" min="0" value="<?=htmlspecialchars($d['price'])?>" class="edit-price-input">
                            <button type="submit" class="edit-price-btn"><i class="fa fa-check"></i></button>
                            <button type="button" class="cancel-edit-btn" onclick="hideEditPrice(<?=$d['id']?>)"><i class="fa fa-times"></i></button>
                        </form>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (isset($_SESSION['user']) && ($_SESSION['user']['role'] === 'user' || $_SESSION['user']['role'] === 'admin')): ?>
                            <form method="post" class="add-to-cart-form">
                                <button type="submit" name="add_to_cart" value="<?=$d['id']?>" class="add-to-cart-btn">Add to Cart</button>
                            </form>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'admin'): ?>
                            <form method="post" action="?page=devices&action=delete" class="delete-device-form" onsubmit="return confirm('Are you sure you want to delete this device?');">
                                <input type="hidden" name="device_id" value="<?=$d['id']?>">
                                <button type="submit" class="delete-device-btn" title="Delete">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
            <?php if ($totalPages > 1): ?>
            <div class="pagination">
                <?php
                $query = $_GET;
                for ($i = 1; $i <= $totalPages; $i++) {
                    $query['p'] = $i;
                    $url = '?' . http_build_query($query);
                    $active = $i == $currentPage ? 'active' : '';
                    echo "<a href='$url' class='$active'>$i</a> ";
                }
                ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<script>
function showEditPrice(id, price) {
    document.getElementById('price-display-' + id).style.display = 'none';
    document.getElementById('edit-price-form-' + id).style.display = 'inline';
    document.querySelector('#edit-price-form-' + id + ' input[name="new_price"]').focus();
}
function hideEditPrice(id) {
    document.getElementById('edit-price-form-' + id).style.display = 'none';
    document.getElementById('price-display-' + id).style.display = 'inline';
}
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.edit-price-form').forEach(function(form) {
        form.style.display = 'none';
    });
    var minRange = document.getElementById('minPriceRange');
    var maxRange = document.getElementById('maxPriceRange');
    var minInput = document.querySelector('input[name="min_price"]');
    var maxInput = document.querySelector('input[name="max_price"]');
    if (minRange && maxRange && minInput && maxInput) {
        minRange.addEventListener('input', function() {
            minInput.value = minRange.value;
        });
        maxRange.addEventListener('input', function() {
            maxInput.value = maxRange.value;
        });
        minInput.addEventListener('input', function() {
            minRange.value = minInput.value;
        });
        maxInput.addEventListener('input', function() {
            maxRange.value = maxInput.value;
        });
    }
});
</script>
<?php include __DIR__ . '/../partials/footer.php'; ?>