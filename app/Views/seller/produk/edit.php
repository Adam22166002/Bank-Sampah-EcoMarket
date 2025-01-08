<?= $this->extend('template/index'); ?>

<?= $this->section('page-content'); ?>
<div class="container-fluid">
    <div class="row py-4">
        <div class="col-md-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4 class="m-0 font-weight-bold text-primary">Form Edit Produk</h4>
                </div>
                <div class="card-body">
                    <?php if (session('errors')) : ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php foreach (session('errors') as $error) : ?>
                                <?= $error ?><br>
                            <?php endforeach ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif ?>

                    <form action="<?= base_url('seller/produk/update/' . $produk['produk_id']) ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <input type="hidden" name="_method" value="PUT">
                        
                        <div class="mb-3">
                            <label for="nama_produk" class="form-label">Nama Produk</label>
                            <input type="text" 
                                   class="form-control <?= session('errors.nama_produk') ? 'is-invalid' : '' ?>" 
                                   id="nama_produk" 
                                   name="nama_produk" 
                                   value="<?= old('nama_produk', $produk['nama_produk']) ?>" 
                                   required>
                            <div class="invalid-feedback">
                                <?= session('errors.nama_produk') ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Spesifikasi Produk</label>
                            <textarea class="form-control <?= session('errors.deskripsi') ? 'is-invalid' : '' ?>" 
                                      id="deskripsi" 
                                      name="deskripsi" 
                                      rows="3" 
                                      required><?= old('deskripsi', $produk['deskripsi']) ?></textarea>
                            <div class="invalid-feedback">
                                <?= session('errors.deskripsi') ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="harga_produk" class="form-label">Harga Produk</label>
                            <div class="input-group">
                                <span class="input-group-text">Point</span>
                                <input type="number" 
                                       class="form-control <?= session('errors.harga_produk') ? 'is-invalid' : '' ?>" 
                                       id="harga_produk" 
                                       name="harga_produk" 
                                       value="<?= old('harga_produk', $produk['harga_produk']) ?>" 
                                       required>
                                <div class="invalid-feedback">
                                    <?= session('errors.harga_produk') ?>
                                </div>
                            </div>
                            <small class="text-muted">1 Point = Rp 100</small>
                        </div>

                        <div class="mb-3">
                            <label for="stok" class="form-label">Stok</label>
                            <input type="number" 
                                   class="form-control <?= session('errors.stok') ? 'is-invalid' : '' ?>" 
                                   id="stok" 
                                   name="stok" 
                                   value="<?= old('stok', $produk['stok']) ?>" 
                                   required>
                            <div class="invalid-feedback">
                                <?= session('errors.stok') ?>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="foto_produk" class="form-label">Foto Produk</label>
                            <input type="file" 
                                   class="form-control <?= session('errors.foto_produk') ? 'is-invalid' : '' ?>" 
                                   id="foto_produk" 
                                   name="foto_produk"
                                   accept="image/*"
                                   onchange="previewImg()">
                            <div class="invalid-feedback">
                                <?= session('errors.foto_produk') ?>
                            </div>
                            <div class="mt-1">
                                <img src="<?= base_url('uploads/fotoProduk/' . $produk['foto_produk']) ?>" 
                                     class="img-thumbnail img-preview" 
                                     width="100">
                            </div>
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah foto</small>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="<?= base_url('seller') ?>" class="btn btn-danger me-md-2">Kembali</a>
                            <button type="submit" class="btn btn-primary">Update Produk</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewImg() {
    const foto = document.querySelector('#foto_produk');
    const imgPreview = document.querySelector('.img-preview');
    
    const fileFoto = new FileReader();
    fileFoto.readAsDataURL(foto.files[0]);
    
    fileFoto.onload = function(e) {
        imgPreview.src = e.target.result;
    }
}
</script>
<?= $this->endSection(); ?>