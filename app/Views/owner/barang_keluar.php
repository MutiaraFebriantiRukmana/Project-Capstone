<?= view('layout/header'); ?>
<h3 class="fw-bold mb-4">Monitoring Barang Keluar</h3>
<div class="card p-4 border-0 shadow-sm">
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th>Tanggal</th><th>Barang</th><th>Qty Keluar</th><th>Admin</th><th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($laporan as $l): ?>
            <tr class="<?= ($l['status'] == 'Dihapus') ? 'table-danger' : '' ?>">
                <td><?= date('d/m/Y', strtotime($l['tanggal'])) ?></td>
                <td><?= $l['nama_barang'] ?></td>
                <td><?= $l['jumlah_terjual'] ?></td>
                <td><?= $l['added_by'] ?></td>
                <td>
                    <span class="badge rounded-pill <?= ($l['status'] == 'Dihapus') ? 'bg-danger' : 'bg-success' ?>">
                        <?= ($l['status'] == 'Dihapus') ? 'Dibatalkan/Dihapus' : 'Selesai' ?>
                    </span>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= view('layout/footer'); ?>