<?= view('layout/header'); ?>
<div class="d-flex justify-content-between mb-4">
    <h3 class="fw-bold">Master Penjualan</h3>
    <button class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#mOut">+ Buat Invoice Keluar</button>
</div>

<!-- List Master Invoice -->
<?php foreach($master as $m): ?>
<div class="card mb-4 border-0 shadow-sm rounded-4">
    <div class="card-header bg-white border-0 py-3 d-flex justify-content-between">
        <h6 class="fw-bold m-0 text-primary"><?= $m['no_invoice'] ?> <small class="text-muted fw-normal ms-2"><?= $m['tgl_keluar'] ?></small></h6>
        <span class="badge bg-light text-dark">Oleh: <?= $m['added_by'] ?></span>
    </div>
    <div class="card-body pt-0">
        <table class="table table-sm small">
            <thead><tr><th>Nama Barang</th><th>Qty</th><th>Harga Jual</th><th>Subtotal</th></tr></thead>
            <tbody>
                <?php 
                $details = \Config\Database::connect()->table('penjualan_detail d')
                    ->join('stok_barang s', 'd.id_stok = s.id_stok')
                    ->where('id_penjualan', $m['id_penjualan'])->get()->getResultArray();
                $total_inv = 0;
                foreach($details as $d): $total_inv += $d['total_harga'];
                ?>
                <tr>
                    <td><?= $d['nama_barang'] ?></td>
                    <td><?= $d['qty_jual'] ?></td>
                    <td>Rp <?= number_format($d['harga_jual_satuan']) ?></td>
                    <td class="fw-bold">Rp <?= number_format($d['total_harga']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot><tr><td colspan="3" class="text-end fw-bold">Total Invoice:</td><td class="text-success fw-bold">Rp <?= number_format($total_inv) ?></td></tr></tfoot>
        </table>
    </div>
</div>
<?php endforeach; ?>

<!-- MODAL JUAL -->
<div class="modal fade" id="mOut" tabindex="-1">
    <div class="modal-dialog modal-lg"><div class="modal-content p-4 rounded-4">
        <form action="<?= base_url('admin/barang-keluar/save') ?>" method="post">
            <h5 class="fw-bold mb-4">Input Penjualan (Multi-Item)</h5>
            <table class="table table-sm">
                <thead><tr><th>Barang</th><th>Qty</th><th>Aksi</th></tr></thead>
                <tbody id="outRows">
                    <tr>
                        <td>
                            <select name="id_stok[]" class="form-select" required>
                                <?php foreach($stok as $s): ?>
                                <option value="<?= $s['id_stok'] ?>"><?= $s['nama_barang'] ?> (Sisa: <?= $s['jumlah_stok'] ?> | Harga: Rp <?= number_format($s['harga_jual_akhir']) ?>)</option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td><input type="number" name="qty[]" class="form-control" required></td>
                        <td>-</td>
                    </tr>
                </tbody>
            </table>
            <button type="button" class="btn btn-sm btn-outline-secondary mb-4" onclick="addOut()">+ Tambah Barang</button>
            <button type="submit" class="btn btn-success w-100 fw-bold">PROSES PENJUALAN</button>
        </form>
    </div></div>
</div>

<script>
function addOut() {
    let row = `<tr>
        <td><select name="id_stok[]" class="form-select" required><?php foreach($stok as $s): ?><option value="<?= $s['id_stok'] ?>"><?= $s['nama_barang'] ?> (Sisa: <?= $s['jumlah_stok'] ?>)</option><?php endforeach; ?></select></td>
        <td><input type="number" name="qty[]" class="form-control" required></td>
        <td><button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove()">X</button></td>
    </tr>`;
    document.getElementById('outRows').insertAdjacentHTML('beforeend', row);
}
</script>
<?= view('layout/footer'); ?>