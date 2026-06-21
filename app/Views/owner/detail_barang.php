<?= view('layout/header'); ?>
<h3 class="fw-bold mb-4">Rincian Detail Barang (Invoice Masuk)</h3>
<div class="card p-4 border-0 shadow-sm rounded-4">
    <table class="table table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Tanggal</th><th>Invoice</th><th>Supplier</th><th>Kode</th><th>Nama Barang</th><th>Qty Beli</th><th>Harga Beli</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($detail as $d): ?>
            <tr>
                <td><?= date('d/m/y H:i', strtotime($d['tgl_pembelian'])) ?></td>
                <td class="text-primary fw-bold"><?= $d['no_invoice'] ?></td>
                <td><?= $d['supplier'] ?></td>
                <td><?= $d['kode_barang'] ?></td>
                <td><?= $d['nama_barang'] ?></td>
                <td><?= $d['qty_beli'] ?></td>
                <td>Rp <?= number_format($d['harga_beli_satuan']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?= view('layout/footer'); ?>