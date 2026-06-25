<?= view('layout/header'); ?>

<div class="container-fluid">
    <h3 class="fw-bold mb-4">Laporan Keuangan</h3>

    <!-- Munculkan Pesan Error Jika Tanggal salah -->
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4">
            <i class="fa-solid fa-circle-exclamation me-2"></i> <?= session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>

    <div class="card p-4 border-0 shadow-sm rounded-4 mb-5">
        <h5 class="fw-bold mb-3">Download Laporan Pengeluaran Barang</h5>
        <form action="<?= base_url('owner/laporan/cetak') ?>" method="get" id="formCetak">
            <div class="row g-3">
                <div class="col-md-5">
                    <label class="small fw-bold">Tanggal Awal</label>
                    <input type="date" name="awal" id="tgl_awal" class="form-control p-3 border-0 bg-light" required>
                </div>
                <div class="col-md-5">
                    <label class="small fw-bold">Tanggal Akhir</label>
                    <input type="date" name="akhir" id="tgl_akhir" class="form-control p-3 border-0 bg-light" required>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-danger w-100 p-3 fw-bold rounded-3">
                        <i class="fa-solid fa-file-pdf me-2"></i> Cetak ke PDF
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Riwayat Cetak -->
    <div class="card p-4 border-0 shadow-sm rounded-4">
        <h5 class="fw-bold mb-3">Riwayat Cetak Laporan</h5>
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr><th>Pencetak</th><th>Periode Data</th><th>Waktu Cetak</th></tr>
            </thead>
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

<script>
    
    const inputAwal = document.getElementById('tgl_awal');
    const inputAkhir = document.getElementById('tgl_akhir');

    inputAwal.addEventListener('change', function() {
        if (inputAwal.value) {
            inputAkhir.min = inputAwal.value; 
            if (inputAkhir.value < inputAwal.value) {
                inputAkhir.value = inputAwal.value; 
            }
        }
    });
</script>

<?= view('layout/footer'); ?>