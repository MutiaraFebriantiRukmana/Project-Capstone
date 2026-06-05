<?= view('layout/header'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold m-0 text-dark">Laporan Penjualan</h3>
    <button class="btn btn-success rounded-pill px-4 fw-bold shadow-sm" style="background-color: #5EEAD4; border:none; color:black;" data-bs-toggle="modal" data-bs-target="#addSale">+ penjualan</button>
</div>

<div class="card p-4 border-0 shadow-sm">
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th>Tanggal</th><th>Nama Barang</th><th>Qty</th><th>Total</th><th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($laporan as $l): ?>
            <tr>
                <td><?= date('d/m/Y', strtotime($l['tanggal'])) ?></td>
                <td class="fw-bold"><?= $l['nama_barang'] ?></td>
                <td><?= $l['jumlah_terjual'] ?></td>
                <td class="text-success fw-bold">Rp <?= number_format($l['total'], 0, ',', '.') ?></td>
                <td class="text-center">
                    <button class="btn btn-sm btn-outline-warning border-0" data-bs-toggle="modal" data-bs-target="#edit<?= $l['id_laporan'] ?>">✏️</button>
                    <a href="<?= base_url('admin/laporan/delete/'.$l['id_laporan']) ?>" class="btn btn-sm btn-outline-danger border-0" onclick="return confirm('Hapus transaksi ini?')">🗑️</a>
                </td>
            </tr>
            <!-- MODAL EDIT -->
            <div class="modal fade" id="edit<?= $l['id_laporan'] ?>" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered"><div class="modal-content p-4 rounded-4 border-0">
                    <h5 class="fw-bold mb-3">Edit /h5>
                    <form action="<?= base_url('admin/laporan/update/'.$l['id_laporan']) ?>" method="post">
                        <input type="number" name="jumlah_terjual" class="form-control mb-3" value="<?= $l['jumlah_terjual'] ?>" required>
                        <button type="submit" class="btn w-100 fw-bold" style="background-color: #5EEAD4;">Simpan</button>
                    </form>
                </div></div>
            </div>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- MODAL TAMBAH -->
<div class="modal fade" id="addSale" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered"><div class="modal-content p-4 rounded-4 border-0 shadow">
        <h5 class="fw-bold mb-3">Input Penjualan</h5>
        <form action="<?= base_url('admin/laporan/save') ?>" method="post">
            <select name="id_barang" class="form-select mb-2" required>
                <option value="">-- Pilih Barang --</option>
                <?php foreach($barang as $b): ?><option value="<?= $b['id_barang'] ?>"><?= $b['nama_barang'] ?> (Stok: <?= $b['jumlah_barang'] ?>)</option><?php endforeach; ?>
            </select>
            <input type="number" name="jumlah_terjual" class="form-control mb-3" placeholder="Jumlah" required>
            <button type="submit" class="btn w-100 fw-bold" style="background-color: #5EEAD4;">Tambahkan</button>
        </form>
    </div></div>
</div>
<?= view('layout/footer'); ?>