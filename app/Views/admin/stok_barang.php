<?= view('layout/header'); ?>

<div class="mb-4">
    <h3 class="fw-bold m-0">Daftar Stok Barang</h3>
    <p class="text-muted">Monitoring data stok barang NaCelluler</p>
</div>

<div class="card p-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th class="text-center">Stok</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($barang)): ?>
                    <tr><td colspan="5" class="text-center py-4">Belum ada data barang.</td></tr>
                <?php else: ?>
                    <?php foreach($barang as $b) : ?>
                    <tr>
                        <td class="fw-bold"><?= $b['kode_barang'] ?></td>
                        <td><?= $b['nama_barang'] ?></td>
                        <td>Rp <?= number_format($b['harga_beli'], 0, ',', '.') ?></td>
                        <td>Rp <?= number_format($b['harga_jual'], 0, ',', '.') ?></td>
                        <td class="text-center">
                            <span class="badge bg-success px-3" style="background-color: #5EEAD4 !important; color:black;">Tersedia: <?= $b['jumlah_barang'] ?></span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>