<?= view('layout/header'); ?>
<h3 class="fw-bold mb-4">Laporan Penjualan </h3>
<div class="card p-4 border-0 shadow-sm">
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th>Tanggal</th><th>Nama Barang</th><th>Qty</th><th>Total Jual</th><th class="text-success">Laba</th><th>Admin</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($laporan as $l): ?>
            <tr>
                <td><?= date('d/m/Y', strtotime($l['tanggal'])) ?></td>
                <td><?= $l['nama_barang'] ?></td>
                <td><?= $l['jumlah_terjual'] ?></td>
                <td>Rp <?= number_format($l['total'], 0, ',', '.') ?></td>
                <td class="fw-bold text-success">Rp <?= number_format(($l['harga_satuan'] - $l['harga_beli']) * $l['jumlah_terjual'], 0, ',', '.') ?></td>
                <td><?= $l['added_by'] ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= view('layout/footer'); ?>