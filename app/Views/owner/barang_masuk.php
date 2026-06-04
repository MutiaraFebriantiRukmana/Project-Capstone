<?= view('layout/header'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold m-0">Manajemen Stok Barang</h3>
        <p class="text-muted">Kelola data stok barang di konter Anda</p>
    </div>
    <button class="btn btn-success rounded-pill px-4 fw-bold shadow-sm" style="background-color: #5EEAD4; border:none; color:black;" data-bs-toggle="modal" data-bs-target="#modalTambah">
        + Tambah Barang
    </button>
</div>

<!-- Alert Pesan Error/Sukses -->
<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger border-0 shadow-sm rounded-4"><?= session()->getFlashdata('error') ?></div>
<?php endif; ?>
<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success border-0 shadow-sm rounded-4"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<div class="card p-4 border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th class="text-center">Stok</th>
                    <th>Input Oleh</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($barang)): ?>
                    <tr><td colspan="7" class="text-center py-4">Belum ada data barang.</td></tr>
                <?php else: ?>
                    <?php foreach($barang as $b) : ?>
                    <tr>
                        <td class="fw-bold"><?= $b['kode_barang'] ?></td>
                        <td><?= $b['nama_barang'] ?></td>
                        <td>Rp <?= number_format($b['harga_beli'], 0, ',', '.') ?></td>
                        <td>Rp <?= number_format($b['harga_jual'], 0, ',', '.') ?></td>
                        <td class="text-center"><span class="badge bg-light text-dark px-3 rounded-pill"><?= $b['jumlah_barang'] ?></span></td>
                        <td><span class="text-primary fw-bold"><?= $b['added_by'] ?></span></td> <!-- @ Dihapus -->
                        <td class="text-center">
                            <!-- Tombol Edit -->
                            <button class="btn btn-sm btn-outline-warning border-0" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $b['id_barang'] ?>">
                                <i class="fa fa-pencil"></i> ✏️
                            </button>
                            <!-- Tombol Hapus -->
                            <a href="<?= base_url('owner/barang-masuk/delete/'.$b['id_barang']) ?>" class="btn btn-sm btn-outline-danger border-0" onclick="return confirm('Hapus data ini?')">
                                🗑️
                            </a>
                        </td>
                    </tr>

                    <!-- MODAL EDIT  -->
                    <div class="modal fade" id="modalEdit<?= $b['id_barang'] ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content p-4 rounded-4 border-0 shadow-lg">
                                <h5 class="fw-bold mb-4">Edit Data Barang</h5>
                                <form action="<?= base_url('owner/barang-masuk/update/'.$b['id_barang']) ?>" method="post">
                                    <div class="mb-3">
                                        <label class="small fw-bold">Kode Barang</label>
                                        <input type="text" name="kode_barang" class="form-control" value="<?= $b['kode_barang'] ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="small fw-bold">Nama Barang</label>
                                        <input type="text" name="nama_barang" class="form-control" value="<?= $b['nama_barang'] ?>" required>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col"><label class="small fw-bold">Harga Beli</label><input type="number" name="harga_beli" class="form-control" value="<?= (int)$b['harga_beli'] ?>" required></div>
                                        <div class="col"><label class="small fw-bold">Harga Jual</label><input type="number" name="harga_jual" class="form-control" value="<?= (int)$b['harga_jual'] ?>" required></div>
                                    </div>
                                    <div class="mb-4">
                                        <label class="small fw-bold">Jumlah Stok</label>
                                        <input type="number" name="jumlah_barang" class="form-control" value="<?= $b['jumlah_barang'] ?>" required>
                                    </div>
                                    <div class="d-flex justify-content-end gap-2">
                                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn fw-bold rounded-pill px-4" style="background-color: #5EEAD4;">Update Data</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL TAMBAH -->
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4 rounded-4 border-0 shadow-lg">
            <h5 class="fw-bold mb-4">Tambah Barang Masuk</h5>
            <form action="<?= base_url('owner/barang-masuk/save') ?>" method="post">
                <div class="mb-3">
                    <label class="small fw-bold">Kode Barang</label>
                    <input type="text" name="kode_barang" class="form-control" placeholder="HP001" required>
                </div>
                <div class="mb-3">
                    <label class="small fw-bold">Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control" placeholder="Samsung A12" required>
                </div>
                <div class="row mb-3">
                    <div class="col"><label class="small fw-bold">Harga Beli</label><input type="number" name="harga_beli" class="form-control" required></div>
                    <div class="col"><label class="small fw-bold">Harga Jual</label><input type="number" name="harga_jual" class="form-control" required></div>
                </div>
                <div class="mb-4">
                    <label class="small fw-bold">Jumlah Stok</label>
                    <input type="number" name="jumlah_barang" class="form-control" required>
                </div>
                <div class="d-flex justify-content-end gap-2">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn fw-bold rounded-pill px-4" style="background-color: #5EEAD4;">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= view('layout/footer'); ?>