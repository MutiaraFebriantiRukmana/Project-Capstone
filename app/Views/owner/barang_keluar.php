<?= view('layout/header'); ?>

<div class="mb-4">
    <h3 class="fw-bold m-0 text-dark">Monitoring Barang Keluar</h3>
    <p class="text-muted small">Daftar barang keluar berdasarkan transaksi admin</p>
</div>

<div class="card p-4 border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Tanggal</th>
                    <th>Barang</th>
                    <th class="text-center">Qty</th>
                    <th>Admin</th>
                    <th>Keuntungan</th>
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($laporan as $l) : ?>
                <?php 
                    $laba = ($l['harga_satuan'] - $l['modal']) * $l['jumlah_terjual'];
                    $row_class = ($l['status'] == 'Dihapus') ? 'table-danger opacity-75' : (($l['status'] == 'Diedit') ? 'table-warning' : '');
                ?>
                <tr class="<?= $row_class ?>">
                    <td><?= date('d/m/Y', strtotime($l['tanggal'])) ?></td>
                    <td><span class="fw-bold"><?= $l['nama_barang'] ?></span></td>
                    <td class="text-center"><?= $l['jumlah_terjual'] ?></td>
                    <td><?= $l['added_by'] ?></td>
                    <td class="fw-bold text-success">
                        <?= ($l['status'] == 'Dihapus') ? 'Rp 0' : 'Rp ' . number_format($laba, 0, ',', '.') ?>
                    </td>
                    <td class="text-center">
                        <?php if($l['status'] == 'Terjual'): ?>
                            <span class="badge bg-success rounded-pill px-3">Selesai</span>
                        <?php elseif($l['status'] == 'Diedit'): ?>
                            <span class="badge bg-warning text-dark rounded-pill px-3">Diedit</span>
                        <?php else: ?>
                            <span class="badge bg-danger rounded-pill px-3">Dibatalkan/Dihapus</span>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= view('layout/footer'); ?>