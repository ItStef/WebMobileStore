<?php $title = 'Admin Panel'; include __DIR__ . '/../partials/header.php'; ?>
<div class="admin-flex">
    <div class="dashboard admin-left">
        <h1>Admin Panel</h1>
        <?php if (!empty($msg)) echo "<div class='register-msg' style='background:#4caf50;'>$msg</div>"; ?>

        <section style="margin-bottom:2em;">
            <h2 style="margin-bottom:0.5em;">Import Devices</h2>
            <form method="post" enctype="multipart/form-data" class="register-form" style="align-items:center;">
                <label class="custom-file-upload">
                    <input type="file" name="datafile" accept=".json,.xml,application/json,text/xml" required>
                    <span id="file-chosen">No file chosen</span>
                </label>
                <button type="submit"><i class="fa fa-upload"></i> Import</button>
            </form>
        </section>

        <section>
            <h2 style="margin-bottom:0.5em;">Export Devices</h2>
            <a class="dashboard-link" href="/index.php?page=admin&export=json">Export as JSON</a>
            <a class="dashboard-link" href="/index.php?page=admin&export=xml">Export as XML</a>
            <div class="register-links">
                <a href="/index.php?page=dashboard">Back to dashboard</a>
            </div>
        </section>
    </div>
    <div class="admin-charts">
        <section>
            <h2>Devices by Operating System</h2>
            <canvas id="osPieChart" width="250" height="250"></canvas>
        </section>
        <section style="margin-top:2em;">
            <h2>Total Units Sold per Device</h2>
            <canvas id="soldBarChart" width="400" height="200"></canvas>
        </section>
    </div>
</div>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// File upload label
document.addEventListener('DOMContentLoaded', function() {
    var input = document.querySelector('input[type=\"file\"][name=\"datafile\"]');
    var label = document.getElementById('file-chosen');
    if(input && label) {
        input.addEventListener('change', function(){
            label.textContent = this.files[0] ? this.files[0].name : \"No file chosen\";
        });
    }
});

// Pie chart: Devices by OS
fetch('/index.php?page=charts&chart=os')
    .then(r => r.json())
    .then(data => {
        new Chart(document.getElementById('osPieChart'), {
            type: 'pie',
            data: {
                labels: data.labels,
                datasets: [{
                    data: data.counts,
                    backgroundColor: ['#b91d47','#00aba9','#2b5797','#e8c3b9','#1e7145','#c93','#393','#339','#933','#999']
                }]
            },
            options: {
                responsive: false,
                plugins: {
                    legend: { display: true },
                    title: { display: true, text: 'Devices by Operating System' }
                }
            }
        });
    });

// Bar chart: Units sold per device
fetch('/index.php?page=charts&chart=sold')
    .then(r => r.json())
    .then(data => {
        new Chart(document.getElementById('soldBarChart'), {
            type: 'bar',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Units Sold',
                    data: data.counts,
                    backgroundColor: '#339'
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    title: { display: true, text: 'Total Units Sold per Device' }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    });
</script>
<style>
.admin-flex {
    display: flex;
    flex-direction: row;
    align-items: flex-start;
    justify-content: flex-start;
    gap: 3em;
    margin-top: 2em;
    width: 100%;
    max-width: 1200px;
    margin-left: auto;
    margin-right: auto;
}
.admin-left {
    flex: 1 1 350px;
    min-width: 320px;
    max-width: 420px;
}
.admin-charts {
    flex: 2 1 600px;
    min-width: 350px;
    max-width: 700px;
    background: #2d2046;
    border-radius: 10px;
    padding: 2em 2em 2em 2em;
    box-shadow: 0 4px 24px rgba(0,0,0,0.10);
}
.admin-charts section {
    margin-bottom: 2.5em;
}
@media (max-width: 1000px) {
    .admin-flex {
        flex-direction: column;
        gap: 2em;
    }
    .admin-charts, .admin-left {
        max-width: 98vw;
        width: 100%;
    }
}
/* Make the pie chart smaller */
#osPieChart {
    max-width: 250px !important;
    max-height: 250px !important;
    margin: 0 auto;
    display: block;
}
</style>
<?php include __DIR__ . '/../partials/footer.php'; ?>