<?= view('layout/header'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="row g-3 mb-4">
    <div class="col-md-3"><div class="card p-3 text-center border-0 shadow-sm rounded-4"><small class="text-muted fw-bold">Total Produk</small><h2 class="fw-bold m-0"><?= $totalProduk ?></h2></div></div>
    <div class="col-md-3"><div class="card p-3 text-center border-0 shadow-sm rounded-4"><small class="text-muted fw-bold">Total Stok</small><h2 class="fw-bold m-0"><?= $totalStok ?></h2></div></div>
    <div class="col-md-3"><div class="card p-3 text-center border-0 shadow-sm rounded-4"><small class="text-muted fw-bold text-success">Penjualan Hari Ini</small><h4 class="fw-bold m-0 text-success">Rp <?= number_format($penjualanHariIni, 0, ',', '.') ?></h4></div></div>
    <div class="col-md-3"><div class="card p-3 text-center border-0 shadow-sm rounded-4 text-primary"><small class="fw-bold opacity-75">Keuntungan Bulan Ini</small><h4 class="fw-bold m-0">Rp <?= number_format($keuntunganBulanIni, 0, ',', '.') ?></h4></div></div>
</div>

<div class="row g-4">
    <div class="col-md-7">
        <div class="card p-4 border-0 shadow-sm rounded-4 mb-4">
            <h6 class="fw-bold mb-3">Grafik Penjualan (7 Hari)</h6>
            <canvas id="salesChart" style="max-height: 250px;"></canvas>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card p-4 border-0 shadow-sm rounded-4 mb-4">
            <h6 class="fw-bold mb-3">Stok Menipis / Perlu Restock</h6>
            <?php foreach($stokMenipis as $sm): ?>
                <div class="alert alert-<?= $sm['color_ml'] ?> py-2 px-3 border-0 rounded-3 mb-2 d-flex justify-content-between align-items-center">
                    <small class="fw-bold"><?= $sm['nama_barang'] ?></small>
                    <span class="badge bg-dark text-white"><?= $sm['jumlah_stok'] ?> Unit</span>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="card p-4 border-0 shadow-sm rounded-4">
            <h6 class="fw-bold mb-3">Penjualan Terbaru</h6>
            <?php foreach($penjualanTerbaru as $pt): ?>
                <div class="p-2 border-bottom mb-2 d-flex justify-content-between align-items-center">
                    <small><?= $pt['nama_barang'] ?></small>
                    <span class="fw-bold small text-success">Rp <?= number_format($pt['total_harga']) ?></span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<script>
    new Chart(document.getElementById('salesChart'), {
        type: 'bar',
        data: { labels: <?= json_encode($gLabels) ?>, datasets: [{ label: 'Unit', data: <?= json_encode($gSales) ?>, backgroundColor: '#5EEAD4', borderRadius: 8 }] },
        options: { plugins: { legend: { display: false } } }
    });
</script>
<?= view('layout/footer'); ?>