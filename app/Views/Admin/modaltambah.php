<!-- Modal -->
<div class="modal fade" id="modaltambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <form class="user" method="POST" action="/Admin/create">
                        <?= csrf_field(); ?>
                        <div class="form-group row">
                            <label for="nama" class="col-sm-2 col-form-label">nama barang</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" id="nama" name="nama" autofocus value="<?= old('nama'); ?>">
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    <?= $validation->getError('nama'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="harga_jual" class="col-sm-2 col-form-label">harga_jual beli</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control <?= ($validation->hasError('harga_jual')) ? 'is-invalid' : ''; ?>" id="harga_jual" name="harga_jual" value="<?= old('harga_jual'); ?>">
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    <?= $validation->getError('harga_jual'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="harga_modal" class="col-sm-2 col-form-label">Harga jual</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control <?= ($validation->hasError('harga_modal')) ? 'is-invalid' : ''; ?>" id="harga_modal" name="harga_modal" value="<?= old('harga_modal'); ?>">
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    <?= $validation->getError('harga_modal'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="stok" class="col-sm-2 col-form-label">stok</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control <?= ($validation->hasError('stok')) ? 'is-invalid' : ''; ?>" id="stok" name="stok" value="<?= old('stok'); ?>">
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    <?= $validation->getError('stok'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row my-2">
                            <label for="gambar" class="col-sm-2 col-form-label">gambar</label>
                            <div class="col-sm-4">
                                <img src="/image/default.jpg" class="img-thumbnail" id="thumbnail">
                            </div>
                            <div class="col-sm-6">
                                <div class="custom-file">
                                    <input type="file" id="gambar" name="gambar">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-end mt-3">
                            <button type="submit" class="btn btn-success" onclick="e.preventDefault()">Tambah Data</button>
                        </div>
                </div>
            </div>

            </form>
        </div>
    </div>
</div>
</div>
</div>