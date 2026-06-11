<?= view('layout/header'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold m-0 text-dark">Manajemen Stok Barang</h3>
        <p class="text-muted small">Kelola stok, harga, dan estimasi waktu kirim supplier</p>
    </div>
    <button class="btn btn-success rounded-pill px-4 fw-bold shadow-sm" style="background-color: #5EEAD4; border:none; color:black;" data-bs-toggle="modal" data-bs-target="#modalTambah">
        + Tambah Barang
    </button>
</div>

<!-- Notifikasi -->
<?php if(session()->getFlashdata('success')): ?>
    <div class="alert alert-success border-0 shadow-sm rounded-4"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>
<?php if(session()->getFlashdata('error')): ?>
    <div class="alert alert-danger border-0 shadow-sm rounded-4"><?= session()->getFlashdata('error') ?></div>
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
                    <th class="text-center">Estimasi Kirim</th> 
                    <th>Input Oleh</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($barang)): ?>
                    <tr><td colspan="8" class="text-center py-4 text-muted">Belum ada data barang. Silakan tambah data baru.</td></tr>
                <?php else: ?>
                    <?php foreach($barang as $b) : ?>
                    <tr>
                        <td class="fw-bold text-dark"><?= $b['kode_barang'] ?></td>
                        <td><?= $b['nama_barang'] ?></td>
                        <td>Rp <?= number_format($b['harga_beli'], 0, ',', '.') ?></td>
                        <td>Rp <?= number_format($b['harga_jual'], 0, ',', '.') ?></td>
                        <td class="text-center">
                            <span class="badge bg-light text-dark px-3 rounded-pill"><?= $b['jumlah_barang'] ?></span>
                        </td>
                        <td class="text-center">
                            <span class="text-muted fw-bold"><?= $b['estimasi_datang'] ?> Hari</span>
                        </td>
                        <td><span class="text-primary fw-bold"><?= $b['added_by'] ?></span></td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-outline-warning border-0" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $b['id_barang'] ?>">✏️</button>
                            <a href="<?= base_url('owner/barang-masuk/delete/'.$b['id_barang']) ?>" class="btn btn-sm btn-outline-danger border-0" onclick="return confirm('Hapus data barang ini?')">🗑️</a>
                        </td>
                    </tr>

                    <!-- MODAL EDIT -->
                    <div class="modal fade" id="modalEdit<?= $b['id_barang'] ?>" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content p-4 rounded-4 border-0 shadow-lg">
                                <h5 class="fw-bold mb-4 text-center">Edit Data Barang</h5>
                                <form action="<?= base_url('owner/barang-masuk/update/'.$b['id_barang']) ?>" method="post">
                                    <div class="mb-3 text-start">
                                        <label class="small fw-bold">Kode Barang</label>
                                        <input type="text" name="kode_barang" class="form-control rounded-3" value="<?= $b['kode_barang'] ?>" required>
                                    </div>
                                    <div class="mb-3 text-start">
                                        <label class="small fw-bold">Nama Barang</label>
                                        <input type="text" name="nama_barang" class="form-control rounded-3" value="<?= $b['nama_barang'] ?>" required>
                                    </div>
                                    <div class="row text-start">
                                        <div class="col-6 mb-3">
                                            <label class="small fw-bold">Harga Beli</label>
                                            <input type="number" name="harga_beli" class="form-control rounded-3" value="<?= (int)$b['harga_beli'] ?>" required>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label class="small fw-bold">Harga Jual</label>
                                            <input type="number" name="harga_jual" class="form-control rounded-3" value="<?= (int)$b['harga_jual'] ?>" required>
                                        </div>
                                    </div>
                                    <div class="row text-start mb-4">
                                        <div class="col-6">
                                            <label class="small fw-bold">Jumlah Stok</label>
                                            <input type="number" name="jumlah_barang" class="form-control rounded-3" value="<?= $b['jumlah_barang'] ?>" required>
                                        </div>
                                        <div class="col-6">
                                            <label class="small fw-bold">Estimasi Kirim (Hari)</label>
                                            <input type="number" name="estimasi_datang" class="form-control rounded-3" value="<?= $b['estimasi_datang'] ?>" required>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center gap-2">
                                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn fw-bold rounded-pill px-4 shadow-sm" style="background-color: #5EEAD4;">Simpan Perubahan</button>
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
<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-4 rounded-4 border-0 shadow-lg">
            <h5 class="fw-bold mb-4 text-center">Tambah Barang Masuk</h5>
            <form action="<?= base_url('owner/barang-masuk/save') ?>" method="post">
                <div class="mb-3 text-start">
                    <label class="small fw-bold">Kode Barang</label>
                    <input type="text" name="kode_barang" class="form-control rounded-3" placeholder="Contoh: HP001" required>
                </div>
                <div class="mb-3 text-start">
                    <label class="small fw-bold">Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control rounded-3" placeholder="Nama Produk" required>
                </div>
                <div class="row text-start">
                    <div class="col-6 mb-3">
                        <label class="small fw-bold">Harga Beli</label>
                        <input type="number" name="harga_beli" class="form-control rounded-3" placeholder="0" required>
                    </div>
                    <div class="col-6 mb-3">
                        <label class="small fw-bold">Harga Jual</label>
                        <input type="number" name="harga_jual" class="form-control rounded-3" placeholder="0" required>
                    </div>
                </div>
                <div class="row text-start mb-4">
                    <div class="col-6">
                        <label class="small fw-bold">Jumlah Stok</label>
                        <input type="number" name="jumlah_barang" class="form-control rounded-3" placeholder="0" required>
                    </div>
                    <div class="col-6">
                        <label class="small fw-bold">Estimasi Kirim (Hari)</label>
                        <input type="number" name="estimasi_datang" class="form-control rounded-3" placeholder="Contoh: 3" required>
                    </div>
                </div>
                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn fw-bold rounded-pill px-4 shadow-sm" style="background-color: #5EEAD4;">Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= view('layout/footer'); ?>