<?= view('layout/header'); ?>
<div class="mb-4">
    <h3 class="fw-bold m-0 text-dark">Stok Barang (Central Hub)</h3>
    <p class="text-muted small">Data stok real-time, harga jual, dan analisis mesin otomatis</p>
</div>

<div class="card p-4 border-0 shadow-sm rounded-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th class="text-center">Stok</th>
                    <th>Modal (Beli)</th>
                    <th>Harga Jual</th>
                    <th class="text-center">Estimasi Habis</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($barang as $b): ?>
                <tr>
                    <!-- URUTAN DATA DIKUNCI AGAR TIDAK GESER -->
                    <td class="fw-bold text-dark"><?= $b['kode_barang'] ?></td>
                    <td><?= $b['nama_barang'] ?></td>
                    <td class="text-center"><span class="badge bg-light text-dark px-3"><?= $b['jumlah_stok'] ?> Unit</span></td>
                    <td>Rp <?= number_format($b['harga_beli_akhir'], 0, ',', '.') ?></td>
                    <td class="text-success fw-bold">Rp <?= number_format($b['harga_jual_akhir'], 0, ',', '.') ?></td>
                    <td class="text-center text-primary fw-bold">± <?= $b['sisa_hari'] ?> Hari</td>
                    <td class="text-center"><span class="badge bg-<?= $b['color_ml'] ?> rounded-pill px-3"><?= $b['status_ml'] ?></span></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= view('layout/footer'); ?>