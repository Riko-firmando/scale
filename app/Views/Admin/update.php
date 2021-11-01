<?= $this->extend('/layout/template_Admin'); ?>
<?= $this->Section('content'); ?>


<div class="container">
    <div class="row">
        <div class="col-7">
            <div class="d-flex justify-content-center mb-3">
                <h2 class='' id="font-style">Tambah Barang</i></h2>
            </div>
            <form class="formtambah" method="POST" action="/Admin/saveUpdate/<?= $barang['id']; ?>" enctype="multipart/form-data">
                <div class="form-group row my-2">
                    <label for="nama" class="col-sm-4 col-form-label">Nama Barang</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="nama" name="nama" autofocus value="<?= $barang['nama']; ?>">
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            <span id="errornama"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group row my-2">
                    <label for="harga_modal" class="col-sm-4 col-form-label">Harga Modal</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="harga_modal" name="harga_modal" value="<?= $barang['harga_modal']; ?>">
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            <span id="errorharga_modal" class="riko"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group row my-2">
                    <label for="harga_jual" class="col-sm-4 col-form-label">Harga Jual</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="harga_jual" name="harga_jual" value="<?= $barang['harga_jual']; ?>">
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            <span id="errorharga_jual"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group row my-2">
                    <label for="35" class="col-sm-4 col-form-label">Stok</label>
                    <div class="col-sm-8 d-flex" id="ukuran">
                        <input type="number" class="form-control" id="stok" name="35" value="<?= $barang['s35']; ?>">
                        <input type="number" class="form-control" id="stok" name="36" value="<?= $barang['s36']; ?>">
                        <input type="number" class="form-control" id="stok" name="37" value="<?= $barang['s37']; ?>">
                        <input type="number" class="form-control" id="stok" name="38" value="<?= $barang['s38']; ?>">
                        <input type="number" class="form-control" id="stok" name="39" value="<?= $barang['s39']; ?>">
                        <input type="number" class="form-control" id="stok" name="40" value="<?= $barang['s40']; ?>">
                    </div>
                </div>
                <div class="form-group row my-2">
                    <label for="berat" class="col-sm-4 col-form-label">Berat</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="berat" name="berat" value="<?= $barang['berat']; ?>" placeholder="satuan gram">
                        <div id="validationServer03Feedback" class="invalid-feedback">
                            <span id="errorberat"></span>
                        </div>
                    </div>
                </div>
                <div class="form-group row my-3">
                    <label for="tipe" class="col-sm-4 col-form-label">Tipe</label>
                    <div class="col-sm-8">
                        <select class="form-control" aria-label="Default select example" name="tipe" id="tipe">
                            <option value="Dress">Dress</option>
                            <option value="Baju">Baju</option>
                            <option value="Celana">Celana</option>
                            <option value="Aksesoris">Aksesoris</option>
                        </select>
                        <input type="text" id="selectTipe" value="<?= $barang['tipe']; ?>" style="display: none;">
                    </div>
                </div>
                <div class="form-group row my-2">
                    <label for="gambar" class="col-sm-4 col-form-label">Gambar</label>
                    <div class="col-sm-4">
                        <img src="/image/<?= $barang['gambar']; ?>" class="img-thumbnail" id="thumbnail">
                    </div>
                    <div class="col-sm-4">
                        <div class="custom-file">
                            <input type="file" id="gambar" name="gambar" value="<?= $barang['gambar']; ?>">
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end row my-2 mr-3">
                    <button type="submit" class="btn btn-success btnsimpan">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        // selected option tipe
        var tipe = $('#selectTipe').val();
        $('#tipe').val(tipe);

        // menampilkan gambar pada upload foto
        $('#gambar').click(function() {
            $('#gambar').change(function() {
                var _PREVIEW_URL;
                var file = this.files[0];

                _PREVIEW_URL = URL.createObjectURL(file);
                $('#thumbnail').attr('src', _PREVIEW_URL);
            })
        })

        $('.formtambah').submit(function(e) {
            event.preventDefault();
            $.ajax({
                type: 'post',
                url: $(this).attr('action'),
                data: new FormData(this),
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                beforeSend: function() {
                    $('.btnsimpan').html('Loading...');
                },
                complete: function() {
                    $('.btnsimpan').html('Simpan');
                },
                success: function(response) {
                    if (response.error) {
                        if (response.error.nama) {
                            $('#nama').addClass('is-invalid');
                            $('#errornama').html(response.error.nama);
                        } else {
                            $('#nama').removeClass('is-invalid');
                            $('#errornama').html('');
                        }
                        if (response.error.harga_modal) {
                            $('#harga_modal').addClass('is-invalid');
                            $('#errorharga_modal').html(response.error.harga_modal);
                        } else {
                            $('#harga_modal').removeClass('is-invalid');
                            $('#errorharga_modal').html('');
                        }
                        if (response.error.harga_jual) {
                            $('#harga_jual').addClass('is-invalid');
                            $('#errorharga_jual').html(response.error.harga_jual);
                        } else {
                            $('#harga_jual').removeClass('is-invalid');
                            $('#errorharga_jual').html('');
                        }
                        if (response.error.stok) {
                            $('#stok').addClass('is-invalid');
                            $('#errorstok').html(response.error.stok);
                        } else {
                            $('#stok').removeClass('is-invalid');
                            $('#errorstok').html('');
                        }
                    } else {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: 'produk berhasil diupdate',
                            showConfirmButton: false,
                            timer: 4000
                        })
                        window.location = 'http://localhost:8080/Admin'

                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError)
                }
            })
        })
    })
</script>

<?= $this->endSection(); ?>