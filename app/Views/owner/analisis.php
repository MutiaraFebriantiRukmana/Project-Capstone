<?= view('layout/header'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="row">
    <!-- KOLOM KIRI: DUA GRAFIK -->
    <div class="col-md-9">
        
        <!-- GRAFIK 1: DATA AKTUAL -->
        <div class="card p-4 border-0 shadow-sm rounded-4 mb-4" style="background-color: #ffffff;">
            <h5 class="fw-bold text-dark"><i class="fa-solid fa-chart-line me-2 text-primary"></i>Tren Penjualan Real (30 Hari Terakhir)</h5>
            <p class="small text-muted mb-4">Menampilkan fluktuasi penjualan harian yang benar-benar terjadi di toko.</p>
            <canvas id="chartLalu" style="max-height: 300px;"></canvas>
        </div>

        <!-- GRAFIK 2: DATA PREDIKSI -->
        <div class="card p-4 border-0 shadow-sm rounded-4 mb-4" style="background-color: #f8fafc; border: 1px dashed #cbd5e1 !important;">
            <h5 class="fw-bold text-primary"><i class="fa-solid fa-wand-magic-sparkles me-2"></i>Proyeksi Prediksi Harian (30 Hari Kedepan)</h5>
            <p class="small text-muted mb-4">Estimasi penjualan harian berdasarkan Tren Regresi Linear periode sebelumnya.</p>
            <canvas id="chartDepan" style="max-height: 300px;"></canvas>
        </div>

    </div>

    <!-- KOLOM KANAN: STATUS STOK (SMA) -->
    <div class="col-md-3">
        <h6 class="fw-bold mb-3 px-2">Status Stok (SMA Analysis)</h6>
        <div style="max-height: 650px; overflow-y: auto; padding-right: 5px;">
            <?php foreach($stok as $s): ?>
            <?php 
                $bg_style = ""; $badge_class = ""; $text_class = "text-dark";
                if($s['status_ml'] == 'BAHAYA') {
                    $bg_style = "background-color: #fee2e2; border-left: 5px solid #ef4444;";
                    $badge_class = "bg-danger text-white"; $text_class = "text-danger";
                } elseif($s['status_ml'] == 'PERINGATAN') {
                    $bg_style = "background-color: #fef9c3; border-left: 5px solid #eab308;";
                    $badge_class = "bg-warning text-dark";
                } else { 
                    $bg_style = "background-color: #E0F7F1; border-left: 5px solid #5EEAD4;";
                    $badge_class = "bg-success text-white";
                }
            ?>
            <div class="p-3 mb-3 rounded-3 shadow-sm" style="<?= $bg_style ?>">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-bold small <?= $text_class ?>"><?= $s['nama_barang'] ?></span>
                    <span class="badge rounded-pill <?= $badge_class ?>">
                        <?= ($s['sisa_hari'] >= 99) ? '>30' : $s['sisa_hari'] ?> Hari
                    </span>
                </div>
                <div class="mt-1 d-flex justify-content-between" style="font-size: 11px;">
                    <span class="text-muted">Status: <b><?= $s['status_ml'] ?></b></span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
    // Konfigurasi Umum
    const commonOptions = {
        responsive: true,
        interaction: { mode: 'index', intersect: false },
        plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, padding: 15 } } },
        scales: { 
            y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
            x: { grid: { display: false }, ticks: { font: { size: 9 } } }
        }
    };

    // Render Grafik 1 (Lalu)
    new Chart(document.getElementById('chartLalu'), {
        type: 'line',
        data: {
            labels: <?= json_encode($labelsLalu) ?>,
            datasets: <?= json_encode($datasetsLalu) ?>
        },
        options: commonOptions
    });

    // Render Grafik 2 (Prediksi Kedepan)
    new Chart(document.getElementById('chartDepan'), {
        type: 'line',
        data: {
            labels: <?= json_encode($labelsDepan) ?>,
            datasets: <?= json_encode($datasetsDepan) ?>
        },
        options: commonOptions
    });
</script>

<?= view('layout/footer'); ?>