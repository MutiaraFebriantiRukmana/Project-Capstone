<?= view('layout/header') ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Master Barang (Invoice Masuk)</h3>
    <button class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#mIn">+ Invoice Baru</button>
</div>

<div class="card p-4 border-0 shadow-sm rounded-4">
    <table class="table table-hover align-middle">
        <thead class="table-light"><tr><th>Invoice</th><th>Supplier</th><th>Grand Total</th><th>Tanggal</th><th>Oleh</th></tr></thead>
        <tbody>
            <?php foreach($pembelian as $p): ?>
            <tr>
                <td class="fw-bold text-primary"><?= $p['no_invoice'] ?></td>
                <td><?= $p['supplier'] ?></td>
                <td class="text-success fw-bold">Rp <?= number_format($p['total_bayar'], 0, ',', '.') ?></td>
                <td><?= date('d/m/y H:i', strtotime($p['tgl_pembelian'])) ?></td>
                <td><span class="badge bg-light text-dark"><?= $p['added_by'] ?></span></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- MODAL INVOICE MASUK -->
<div class="modal fade" id="mIn" tabindex="-1">
    <div class="modal-dialog modal-xl"><div class="modal-content p-4 rounded-4 border-0 shadow">
        <form action="<?= base_url('owner/master-barang/save') ?>" method="post">
            <h5 class="fw-bold mb-4 text-center">Form Pembelian (Arus Stok Masuk)</h5>
            <div class="row mb-4">
                <div class="col-6"><label class="small fw-bold">Supplier</label><input type="text" name="supplier" class="form-control bg-light border-0 p-2" required></div>
                <div class="col-6"><label class="small fw-bold">Estimasi Barang Datang (Hari)</label><input type="number" name="estimasi" class="form-control bg-light border-0 p-2" value="3" required></div>
            </div>
            
            <table class="table table-bordered"><thead class="bg-light small">
                <tr><th>Kode</th><th>Nama Barang</th><th>Qty</th><th>Harga Beli (Modal)</th><th>Harga Jual Toko</th><th>Aksi</th></tr></thead>
                <tbody id="rows">
                    <tr>
                        <td><input type="text" name="kode_barang[]" class="form-control" required></td>
                        <td><input type="text" name="nama_barang[]" class="form-control" required></td>
                        <td><input type="number" name="qty[]" class="form-control qty" oninput="calc()" required></td>
                        <td><input type="number" name="harga_beli[]" class="form-control beli" oninput="calc()" required></td>
                        <td><input type="number" name="harga_jual[]" class="form-control text-success fw-bold" required></td>
                        <td>-</td>
                    </tr>
                </tbody>
            </table>
            
            <button type="button" class="btn btn-sm btn-outline-secondary mb-4" onclick="addR()">+ Tambah Baris Barang</button>

            <!-- OTOMATIS TERISI -->
            <div class="row"><div class="col-md-5 ms-auto text-end">
                <label class="fw-bold">Total Tagihan Otomatis (Rp)</label>
                <input type="text" id="totalShow" class="form-control form-control-lg fw-bold text-end bg-light text-success border-0" readonly>
                <input type="hidden" name="total_invoice" id="totalReal">
            </div></div>

            <div class="mt-4 text-center"><button type="submit" class="btn btn-success px-5 rounded-pill fw-bold" style="background-color: #5EEAD4; color:black; border:none;">SIMPAN & UPDATE STOK PUSAT</button></div>
        </form>
    </div></div>
</div>

<script>
function calc() {
    let qtys = document.querySelectorAll('.qty');
    let belis = document.querySelectorAll('.beli');
    let grand = 0;
    for(let i=0; i<qtys.length; i++) {
        let q = parseFloat(qtys[i].value) || 0;
        let b = parseFloat(belis[i].value) || 0;
        grand += (q * b);
    }
    document.getElementById('totalShow').value = "Rp " + grand.toLocaleString('id-ID');
    document.getElementById('totalReal').value = grand;
}

function addR() {
    let row = `<tr>
        <td><input type="text" name="kode_barang[]" class="form-control" required></td>
        <td><input type="text" name="nama_barang[]" class="form-control" required></td>
        <td><input type="number" name="qty[]" class="form-control qty" oninput="calc()" required></td>
        <td><input type="number" name="harga_beli[]" class="form-control beli" oninput="calc()" required></td>
        <td><input type="number" name="harga_jual[]" class="form-control text-success fw-bold" required></td>
        <td><button type="button" class="btn btn-danger btn-sm" onclick="this.closest('tr').remove(); calc();">X</button></td>
    </tr>`;
    document.getElementById('rows').insertAdjacentHTML('beforeend', row);
}
</script>
<?= view('layout/footer') ?>