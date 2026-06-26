<?= view('layout/header'); ?>
<div class="d-flex justify-content-between mb-4">
    <h3 class="fw-bold">Master Penjualan (Arus Keluar)</h3>
    <button class="btn btn-primary rounded-pill px-4 shadow-sm fw-bold" data-bs-toggle="modal" data-bs-target="#mOut">+ Buat Invoice Keluar</button>
</div>

<!-- Alert Pesan -->
<?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success border-0 shadow-sm rounded-4"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>
<?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger border-0 shadow-sm rounded-4"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>

<!-- List Master Invoice -->
<?php if(empty($penjualan)): ?>
    <div class="card p-5 text-center border-0 shadow-sm rounded-4">
        <p class="text-muted m-0">Belum ada riwayat penjualan.</p>
    </div>
<?php else: ?>
    <?php foreach($penjualan as $m): ?>
    <div class="card mb-4 border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
            <h6 class="fw-bold m-0 text-primary">
                <i class="fa-solid fa-file-invoice me-2"></i><?= $m['no_invoice'] ?> 
                <small class="text-muted fw-normal ms-3"><i class="fa-regular fa-clock me-1"></i> <?= date('d/m/Y H:i', strtotime($m['tgl_keluar'])) ?></small>
            </h6>
            <span class="badge bg-light text-dark p-2 px-3 rounded-pill">Oleh: <?= $m['added_by'] ?></span>
        </div>
        <div class="card-body pt-0">
            <div class="table-responsive">
                <table class="table table-sm table-hover small">
                    <thead class="table-light">
                        <tr><th>Nama Barang</th><th class="text-center">Qty</th><th>Harga Jual</th><th class="text-end">Subtotal</th></tr>
                    </thead>
                    <tbody>
                        <?php 
                        $db = \Config\Database::connect();
                        $details = $db->table('penjualan_detail d')
                            ->join('stok_barang s', 'd.id_stok = s.id_stok')
                            ->where('id_penjualan', $m['id_penjualan'])->get()->getResultArray();
                        $total_inv = 0;
                        foreach($details as $d): $total_inv += $d['total_harga'];
                        ?>
                        <tr>
                            <td><?= $d['nama_barang'] ?></td>
                            <td class="text-center"><?= $d['qty_jual'] ?></td>
                            <td>Rp <?= number_format($d['harga_jual_satuan'], 0, ',', '.') ?></td>
                            <td class="fw-bold text-end">Rp <?= number_format($d['total_harga'], 0, ',', '.') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-end fw-bold py-3">Total Invoice :</td>
                            <td class="text-success fw-bold text-end py-3" style="font-size: 1.1rem;">Rp <?= number_format($total_inv, 0, ',', '.') ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
<?php endif; ?>

<!-- MODAL JUAL -->
<div class="modal fade" id="mOut" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content p-4 rounded-4 border-0 shadow-lg">
            <form action="<?= base_url('admin/barang-keluar/save') ?>" method="post">
                <?= csrf_field(); ?> 
                
                <h5 class="fw-bold mb-4"><i class="fa-solid fa-cart-plus me-2 text-primary"></i>Input Penjualan (Multi-Item)</h5>
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <thead>
                            <tr class="small text-muted">
                                <th width="70%">Barang</th>
                                <th width="20%">Qty</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="outRows">
                            <tr>
                                <td>
                                    <select name="id_stok[]" class="form-select bg-light border-0" required>
                                        <option value="">-- Pilih Barang --</option>
                                        <?php foreach($stok as $s): ?>
                                        <option value="<?= $s['id_stok'] ?>">
                                            <?= $s['nama_barang'] ?> (Stok: <?= $s['jumlah_stok'] ?> | Rp <?= number_format($s['harga_jual_akhir'], 0, ',', '.') ?>)
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </td>
                                <td><input type="number" name="qty[]" class="form-control bg-light border-0" min="1" value="1" required></td>
                                <td class="text-center">-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary mb-4 rounded-pill px-3" onclick="addOut()">+ Tambah Item</button>
                <hr>
                <div class="d-flex justify-content-between gap-2 mt-2">
                    <button type="button" class="btn btn-light w-50 fw-bold rounded-pill" data-bs-dismiss="modal">BATAL</button>
                    <button type="submit" class="btn btn-success w-50 fw-bold rounded-pill shadow-sm">PROSES PENJUALAN</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function addOut() {
    let row = `<tr>
        <td>
            <select name="id_stok[]" class="form-select bg-light border-0" required>
                <option value="">-- Pilih Barang --</option>
                <?php foreach($stok as $s): ?>
                <option value="<?= $s['id_stok'] ?>"><?= $s['nama_barang'] ?> (Stok: <?= $s['jumlah_stok'] ?>)</option>
                <?php endforeach; ?>
            </select>
        </td>
        <td><input type="number" name="qty[]" class="form-control bg-light border-0" min="1" value="1" required></td>
        <td><button type="button" class="btn btn-danger btn-sm rounded-3" onclick="this.closest('tr').remove()"><i class="fa-solid fa-xmark"></i></button></td>
    </tr>`;
    document.getElementById('outRows').insertAdjacentHTML('beforeend', row);
}
</script>
<?= view('layout/footer'); ?>