<?= view('layout/header'); ?>
<div class="mb-4">
    <h3 class="fw-bold">Monitoring Barang Keluar</h3>
    <p class="text-muted">History penjualan dan laba otomatis</p>
</div>
<div class="card p-4 border-0 shadow-sm rounded-4">
    <table class="table table-hover align-middle">
        <thead><tr><th>Invoice</th><th>Barang</th><th>Qty</th><th>Admin</th><th>Laba (Cuan)</th></tr></thead>
        <tbody>
            <?php foreach($laporan as $l): ?>
            <?php $laba = ($l['harga_jual_satuan'] - $l['modal']) * $l['qty_jual']; ?>
            <tr>
                <td><small class="fw-bold"><?= $l['no_invoice'] ?></small></td>
                <td><?= $l['nama_barang'] ?></td>
                <td><?= $l['qty_jual'] ?></td>
                <td><small><?= $l['added_by'] ?></small></td>
                <td class="text-success fw-bold">Rp <?= number_format($laba) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= view('layout/footer'); ?>