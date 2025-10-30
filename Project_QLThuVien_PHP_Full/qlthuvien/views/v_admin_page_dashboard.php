<h2 class="my-3">Tổng quan</h2>
<div class="row">
    <div class="col-md-3">
        <div class="card text-primary mb-3">
            <div class="card-body">
                <h5 class="card-title">Đầu sách</h5>
                <p class="card-text fs-1 text-center"><?= number_format($soSach, 0, ',', '.') ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-success mb-3">
            <div class="card-body">
                <h5 class="card-title">Bạn đọc</h5>
                <p class="card-text fs-1 text-center"><?= number_format($soTaiKhoan, 0, ',', '.') ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-warning mb-3">
            <div class="card-body">
                <h5 class="card-title">Chủ đề</h5>
                <p class="card-text fs-1 text-center"><?= number_format($soChuDe, 0, ',', '.') ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-danger mb-3">
            <div class="card-body">
                <h5 class="card-title">Lượt mượn</h5>
                <p class="card-text fs-1 text-center"><?= number_format($soLuotMuon, 0, ',', '.') ?></p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="card-title mb-0">Doanh thu theo tháng</h5>
                    <small class="text-muted">Biểu đồ động, có thể phóng to</small>
                </div>
                <div class="chart-card p-3 bg-white rounded">
                    <div id="myChart" class="chart-canvas"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-4 shadow-sm border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="card-title mb-0">Sách được mượn theo chủ đề</h5>
                    <small class="text-muted">Top chủ đề</small>
                </div>
                <div class="chart-card p-3 bg-white rounded">
                    <div id="myChart2" class="chart-canvas"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Chart card visuals */
    .chart-card {
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
    }

    .chart-canvas {
        width: 100%;
        min-height: 320px;
    }

    @media (max-width: 767px) {
        .chart-canvas {
            min-height: 260px;
        }
    }
</style>

<script src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    // Load once and draw both charts
    google.charts.load('current', { packages: ['corechart'] });
    google.charts.setOnLoadCallback(drawCharts);

    function drawCharts() {
        drawLineChart();
        drawPieChart();
    }

    function drawLineChart() {
        const data = google.visualization.arrayToDataTable([
            ['Tháng/Năm', 'Doanh thu'],
            <?php foreach ($incomeList as $tk): ?>['<?= $tk['Thang'] ?>/<?= $tk['Nam'] ?>', <?= $tk['DoanhThu'] ?>],
            <?php endforeach; ?>
        ]);

        const options = {
            legend: { position: 'bottom' },
            colors: ['#2E86AB'],
            chartArea: { left: 60, top: 40, width: '85%', height: '70%' },
            hAxis: { textStyle: { fontSize: 12 } },
            vAxis: { format: '#,###', textStyle: { fontSize: 12 } },
            pointSize: 6,
            curveType: 'function',
            backgroundColor: '#ffffff',
            animation: { startup: true, duration: 600, easing: 'out' }
        };

        const chart = new google.visualization.LineChart(document.getElementById('myChart'));
        chart.draw(data, options);
    }

    function drawPieChart() {
        const data = google.visualization.arrayToDataTable([
            ['Chủ đề', 'Số lượng sách'],
            <?php foreach ($thongKeSach as $tk): ?>['<?= htmlspecialchars($tk['TenChuDe'], ENT_QUOTES) ?>', <?= $tk['SoLuongSach'] ?>],
            <?php endforeach; ?>
        ]);

        const options = {
            pieHole: 0.36,
            colors: ['#2E86AB', '#F6C85F', '#FF6F61', '#6B5B95', '#88B04B', '#F7CAC9', '#92A8D1'],
            legend: { position: 'right', alignment: 'center', textStyle: { fontSize: 12 } },
            chartArea: { left: 10, top: 20, width: '85%', height: '75%' },
            backgroundColor: '#ffffff',
            animation: { startup: true, duration: 600, easing: 'out' }
        };

        const chart = new google.visualization.PieChart(document.getElementById('myChart2'));
        chart.draw(data, options);
    }

    // Redraw charts on resize (debounced)
    let resizeTimer;
    window.addEventListener('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function () {
            drawCharts();
        }, 200);
    });
</script>