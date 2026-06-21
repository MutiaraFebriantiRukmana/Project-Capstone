<?= view('layout/header') ?>
<div class="card p-4 border-0 shadow-sm rounded-4 mb-4">
    <h5 class="fw-bold mb-3">Download Laporan Pengeluaran Barang</h5>
    <?php 
        $role = session()->get('role'); 
        $target_url = base_url($role . '/laporan/cetak');
    ?>
    <form action="<?= $target_url ?>" method="get" target="_blank">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="small fw-bold">Tanggal Awal</label>
                <input type="date" name="awal" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="small fw-bold">Tanggal Akhir</label>
                <input type="date" name="akhir" class="form-control" required>
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button type="submit" class="btn btn-danger w-100 fw-bold"><i class="fa fa-print me-2"></i> Cetak ke PDF</button>
            </div>
        </div>
    </form>
</div>

<div class="card p-4 border-0 shadow-sm rounded-4">
    <h6 class="fw-bold mb-3">Riwayat Cetak Laporan</h6>
    <div class="table-responsive">
        <table class="table table-sm small">
            <thead class="table-light"><tr><th>Pencetak</th><th>Periode Data</th><th>Waktu Cetak</th></tr></thead>
            <tbody>
                <?php foreach($logs as $l): ?>
                <tr>
                    <td><span class="badge bg-info text-dark"><?= $l['nama_pencetak'] ?></span></td>
                    <td><?= date('d/m/y', strtotime($l['tgl_awal'])) ?> s/d <?= date('d/m/y', strtotime($l['tgl_akhir'])) ?></td>
                    <td><?= date('d/m/y H:i', strtotime($l['tgl_cetak'])) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?= view('layout/footer') ?>