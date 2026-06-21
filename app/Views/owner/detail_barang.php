<?= view('layout/header'); ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold m-0">Rincian Detail Barang (Invoice Masuk)</h3>
        <a href="<?= base_url('owner/master-barang') ?>" class="btn btn-secondary btn-sm rounded-3">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card p-4 border-0 shadow-sm rounded-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Invoice</th>
                        <th>Supplier</th>
                        <th>Kode Barang</th>
                        <th>Nama Barang</th>
                        <th class="text-center">Qty Beli</th>
                        <th>Harga Beli Satuan</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($detail)): ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted">Belum ada data detail pembelian.</td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach($detail as $d): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <small class="text-muted d-block"><?= date('d/m/Y', strtotime($d['tgl_pembelian'])) ?></small>
                                <strong><?= date('H:i', strtotime($d['tgl_pembelian'])) ?></strong>
                            </td>
                            <td><span class="badge bg-info text-dark font-monospace"><?= $d['no_invoice'] ?></span></td>
                            <td><?= $d['supplier'] ?></td>
                            <td><code><?= $d['kode_barang'] ?></code></td>
                            <td class="fw-bold"><?= $d['nama_barang'] ?? '<span class="text-danger">Item Dihapus</span>' ?></td>
                            <td class="text-center"><?= number_format($d['qty_beli']) ?></td>
                            <td>Rp <?= number_format($d['harga_beli_satuan'], 0, ',', '.') ?></td>
                            <td class="fw-bold text-success">
                                Rp <?= number_format($d['qty_beli'] * $d['harga_beli_satuan'], 0, ',', '.') ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= view('layout/footer'); ?>