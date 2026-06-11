<?= view('layout/header'); ?>

<div class="mb-4">
    <h3 class="fw-bold m-0 text-dark">Laporan Penjualan</h3>
    <p class="text-muted small">Rekapitulasi penjualan dan keuntungan NaCelluler</p>
</div>

<div class="card p-4 border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Tanggal</th>
                    <th>Barang</th>
                    <th class="text-center">Qty</th>
                    <th>Admin</th>
                    <th>Keuntungan</th> <!-- Kolom Baru -->
                    <th class="text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($laporan)): ?>
                    <tr><td colspan="6" class="text-center py-4 text-muted">Belum ada data barang keluar hari ini.</td></tr>
                <?php else: ?>
                    <?php foreach($laporan as $l) : ?>
                    <?php 
                        // HITUNG KEUNTUNGAN
                        $untung_per_unit = $l['harga_satuan'] - $l['modal'];
                        $total_keuntungan = $untung_per_unit * $l['jumlah_terjual'];
                        
                        $baris_class = '';
                        $status_txt = 'Selesai';
                        $status_class = 'bg-success';

                        if($l['status'] == 'Dihapus'){
                            $baris_class = 'table-danger opacity-75';
                            $status_txt = 'Dibatalkan';
                            $status_class = 'bg-danger';
                            $total_keuntungan = 0; 
                        } elseif($l['status'] == 'Diedit'){
                            $baris_class = 'table-warning';
                            $status_txt = 'Diedit';
                            $status_class = 'bg-warning text-dark';
                        }
                    ?>
                    <tr class="<?= $baris_class ?>">
                        <td><?= date('d/m/Y', strtotime($l['tanggal'])) ?></td>
                        <td>
                            <span class="fw-bold d-block"><?= $l['nama_barang'] ?></span>
                            <small class="text-muted"><?= $l['kode_barang'] ?></small>
                        </td>
                        <td class="text-center"><?= $l['jumlah_terjual'] ?></td>
                        <td><?= $l['added_by'] ?></td>
                        <td class="fw-bold <?= ($l['status'] == 'Dihapus') ? 'text-muted' : 'text-success' ?>">
                            Rp <?= number_format($total_keuntungan, 0, ',', '.') ?>
                        </td>
                        <td class="text-center">
                            <span class="badge rounded-pill <?= $status_class ?>"><?= $status_txt ?></span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- INFO TOTAL KEUNTUNGAN HARI INI -->
<div class="row mt-4">
    <div class="col-md-4">
        <div class="card p-3 border-0 shadow-sm" style="background-color: #5EEAD4;">
            <small class="text-dark fw-bold">Total Keuntungan Terdeteksi</small>
            <?php 
                $grand_total_untung = 0;
                foreach($laporan as $lp) {
                    if($lp['status'] != 'Dihapus') {
                        $grand_total_untung += ($lp['harga_satuan'] - $lp['modal']) * $lp['jumlah_terjual'];
                    }
                }
            ?>
            <h3 class="fw-bold m-0">Rp <?= number_format($grand_total_untung, 0, ',', '.') ?></h3>
        </div>
    </div>
</div>

<?= view('layout/footer'); ?>