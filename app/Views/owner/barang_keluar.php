<?= view('layout/header'); ?>
<div class="mb-4">
    <h3 class="fw-bold">Monitoring Barang Keluar</h3>
    <p class="text-muted small">Rekap history penjualan dan perhitungan laba bersih otomatis.</p>
</div>

<div class="card p-4 border-0 shadow-sm rounded-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Invoice</th>
                    <th>Tanggal</th>
                    <th>Nama Barang</th>
                    <th class="text-center">Qty</th>
                    <th>Penanggung Jawab</th>
                    <th class="text-end">Keuntungan (Laba)</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $db = \Config\Database::connect();
                $laporan = $db->table('penjualan_detail d')
                    ->join('penjualan_master m', 'd.id_penjualan = m.id_penjualan')
                    ->join('stok_barang s', 'd.id_stok = s.id_stok')
                    ->orderBy('m.tgl_keluar', 'DESC')
                    ->select('d.*, m.no_invoice, m.tgl_keluar, m.added_by, s.nama_barang')
                    ->get()->getResultArray();

                if(empty($laporan)): ?>
                    <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada transaksi keluar.</td></tr>
                <?php else: ?>
                    <?php foreach($laporan as $l): ?>
                    <tr>
                        <td><code class="fw-bold text-primary"><?= $l['no_invoice'] ?></code></td>
                        <td><small><?= date('d/m/y H:i', strtotime($l['tgl_keluar'])) ?></small></td>
                        <td class="fw-bold"><?= $l['nama_barang'] ?></td>
                        <td class="text-center"><?= $l['qty_jual'] ?></td>
                        <td><span class="badge bg-light text-dark"><?= $l['added_by'] ?></span></td>
                        <td class="text-end fw-bold text-success">
                            Rp <?= number_format($l['laba'], 0, ',', '.') ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?= view('layout/footer'); ?>