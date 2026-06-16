<?= view('layout/header') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Master Barang (Invoice Masuk)</h3>
    <button class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#modalInvoice">+ Invoice Baru</button>
</div>

<div class="card p-4 border-0 shadow-sm rounded-4">
    <table class="table table-hover align-middle">
        <thead><tr><th>Invoice</th><th>Supplier</th><th>Total</th><th>Tanggal</th><th>Oleh</th></tr></thead>
        <tbody>
            <?php foreach($pembelian as $p): ?>
            <tr>
                <td class="fw-bold text-primary"><?= $p['no_invoice'] ?></td>
                <td><?= $p['supplier'] ?></td>
                <td>Rp <?= number_format($p['total_bayar']) ?></td>
                <td><?= date('d/m/y H:i', strtotime($p['tgl_pembelian'])) ?></td>
                <td><span class="badge bg-light text-dark"><?= $p['added_by'] ?></span></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- MODAL INVOICE -->
<div class="modal fade" id="modalInvoice" tabindex="-1">
    <div class="modal-dialog modal-xl"><div class="modal-content p-4 rounded-4 border-0">
        <form action="<?= base_url('owner/master-barang/save') ?>" method="post">
            <h5 class="fw-bold mb-4">Input Invoice Masuk</h5>
            <div class="row mb-4">
                <div class="col-md-4"><label class="small fw-bold">Supplier</label><input type="text" name="supplier" class="form-control" required></div>
                <div class="col-md-4"><label class="small fw-bold">Estimasi Datang (Hari)</label><input type="number" name="estimasi" class="form-control" value="3" required></div>
                <div class="col-md-4"><label class="small fw-bold">Total Tagihan Invoice (Rp)</label><input type="number" name="total_invoice" class="form-control fw-bold" required></div>
            </div>
            <table class="table table-bordered"><thead class="bg-light"><tr><th>Kode</th><th>Nama Barang</th><th>Qty</th><th>Harga Beli Satuan</th><th>Aksi</th></tr></thead>
                <tbody id="rows">
                    <tr>
                        <td><input type="text" name="kode_barang[]" class="form-control" required></td>
                        <td><input type="text" name="nama_barang[]" class="form-control" required></td>
                        <td><input type="number" name="qty[]" class="form-control" required></td>
                        <td><input type="number" name="harga_beli[]" class="form-control" required></td>
                        <td>-</td>
                    </tr>
                </tbody>
            </table>
            <button type="button" class="btn btn-sm btn-outline-secondary mb-4" onclick="addR()">+ Tambah Item</button>
            <div class="text-center"><button type="submit" class="btn btn-success px-5 rounded-pill fw-bold">SIMPAN INVOICE & UPDATE STOK</button></div>
        </form>
    </div></div>
</div>

<script>
function addR() {
    let html = `<tr>
        <td><input type="text" name="kode_barang[]" class="form-control" required></td>
        <td><input type="text" name="nama_barang[]" class="form-control" required></td>
        <td><input type="number" name="qty[]" class="form-control" required></td>
        <td><input type="number" name="harga_beli[]" class="form-control" required></td>
        <td><button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove()">X</button></td>
    </tr>`;
    document.getElementById('rows').insertAdjacentHTML('beforeend', html);
}
</script>
<?= view('layout/footer') ?>