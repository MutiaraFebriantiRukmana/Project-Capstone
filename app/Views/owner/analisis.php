<?= view('layout/header'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="row g-4">
    <div class="col-md-8">
        <!-- GRAFIK TREN 30 HARI -->
        <div class="card p-4 border-0 shadow-sm rounded-4 mb-4">
            <h5 class="fw-bold mb-4 text-dark">Grafik Tren Penjualan per Kategori (30 Hari Terakhir)</h5>
            <canvas id="trendChart" style="max-height: 450px;"></canvas>
            <div class="mt-3">
                <small class="text-muted d-block">* Data ditarik harian selama 1 bulan terakhir.</small>
                <small class="text-muted d-block">* Grafik menunjukkan fluktuasi penjualan kategori berdasarkan huruf depan kode barang.</small>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- PREDIKSI CARD -->
        <div class="card p-4 mb-4 border-0 shadow-sm text-white" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); border-radius: 20px;">
            <h6 class="opacity-75">Prediksi Volume Bulan Depan</h6>
            <?php if(empty($prediksi)): ?>
                <h2 class="fw-bold">0 Unit</h2>
            <?php else: ?>
                <?php foreach($prediksi as $kat => $val): ?>
                    <div class="d-flex justify-content-between border-bottom border-white border-opacity-25 mb-2 pb-1">
                        <span>Kategori <?= $kat ?>:</span> <span class="fw-bold"><?= $val ?> Unit</span>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            <small class="mt-2 d-block" style="font-size: 10px; opacity: 0.6;">*Berdasarkan Tren Regresi Linear 30 Hari</small>
        </div>

        <h6 class="fw-bold mb-3 px-2">Status Stok (SMA Analysis)</h6>
        <div style="max-height: 400px; overflow-y: auto; padding-right: 5px;">
            <?php foreach($stok as $s): ?>
            <?php 
                $bg_style = "";
                $badge_class = "";
                $text_class = "text-dark";

                if($s['status_ml'] == 'BAHAYA') {
                    $bg_style = "background-color: #fee2e2; border-left: 5px solid #ef4444;";
                    $badge_class = "bg-danger text-white";
                    $text_class = "text-danger";
                } elseif($s['status_ml'] == 'PERINGATAN') {
                    $bg_style = "background-color: #fef9c3; border-left: 5px solid #eab308;";
                    $badge_class = "bg-warning text-dark";
                } else { // AMAN
                    $bg_style = "background-color: #E0F7F1; border-left: 5px solid #5EEAD4;";
                    $badge_class = "bg-success text-white";
                }
            ?>
            <div class="p-3 mb-3 rounded-3 shadow-sm" style="<?= $bg_style ?>">
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-bold small <?= $text_class ?>"><?= $s['nama_barang'] ?></span>
                    <span class="badge rounded-pill <?= $badge_class ?>">
                        <?= ($s['sisa_hari'] >= 99) ? '>30' : $s['sisa_hari'] ?> Hari Lagi
                    </span>
                </div>
                <div class="mt-1 d-flex justify-content-between" style="font-size: 11px;">
                    <span class="text-muted">Status: <b><?= $s['status_ml'] ?></b></span>
                    <?php if($s['status_ml'] == 'BAHAYA'): ?>
                        <span class="fw-bold text-danger">PESAN SEKARANG!</span>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
    new Chart(document.getElementById('trendChart'), {
        type: 'line',
        data: {
            labels: <?= json_encode($labels) ?>,
            datasets: <?= json_encode($datasets) ?>
        },
        options: {
            responsive: true,
            interaction: { mode: 'index', intersect: false },
            plugins: { 
                legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } } 
            },
            scales: { 
                y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                x: { grid: { display: false }, ticks: { maxRotation: 45, minRotation: 45, font: { size: 10 } } }
            }
        }
    });
</script>
<?= view('layout/footer'); ?>