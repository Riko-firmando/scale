<?= $this->extend('layout/template_Admin'); ?>
<?= $this->Section('content'); ?>


<div class="container">
    <div class="d-flex justify-content-center mb-3">
        <h2 class='' id="font-style">DAFTAR BARANG<i class="fas fa-plus-circle"></i></h2>
    </div>
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary mb-2" id="buttonCreate" data-bs-toggle="modal" data-bs-target="#modaltambah">
        Tambah data
    </button>

    <div class="row">
        <div class="col">
            <?php if (session()->getFlashdata('pesan')) : ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('pesan'); ?>
                </div>
            <?php endif; ?>
            <table class="table " id="tabel">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">NO</th>
                        <th scope="col">Gambar</th>
                        <th scope="col">Nama</th>
                        <th scope="col">Harga modal</th>
                        <th scope="col">Harga jual</th>
                        <th scope="col">Stok</th>
                        <th scope="col">Tipe</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody id="font-style">
                    <?php $i = 1; ?>
                    <?php foreach ($barang as $k) : ?>
                        <tr>
                            <th scope="row"><?= $i++; ?></th>
                            <td>
                                <div class="col sm-2">
                                    <img src="image/<?= $k['gambar']; ?>" alt="" class="gambar">
                                </div>
                            </td>
                            <td><?= $k['nama']; ?></td>
                            <td>Rp<?= number_format($k['harga_modal'], 0, ',', '.'); ?></td>
                            <td>Rp<?= number_format($k['harga_jual'], 0, ',', '.'); ?></td>
                            <td><?= $k['stok']; ?></td>
                            <td><?= $k['tipe']; ?></td>
                            <td><a href="/Admin/ubah/<?= $k['id']; ?>" class="btn btn-warning">Ubah</a>
                                <a href="/Admin/delete/<?= $k['id']; ?>" class="btn btn-danger" onclick="return confirm('apakah anda yakin?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <form action="/Admin/test" enctype="multipart/form-data" method="POST" id="formtest">
                <input type="file" name="file">
                <input type="submit" id="push">
            </form>
        </div>
    </div>
</div>

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
                    <form class="formtambah" method="POST" action="/Admin/create" enctype="multipart/form-data">
                        <div class="form-group row my-2">
                            <label for="nama" class="col-sm-4 col-form-label">nama barang</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="nama" name="nama" autofocus value="<?= old('nama'); ?>">
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    <span id="errornama"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row my-2">
                            <label for="harga_modal" class="col-sm-4 col-form-label">harga modal</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="harga_modal" name="harga_modal" value="<?= old('harga_modal'); ?>">
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    <span id="errorharga_modal" class="riko"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row my-2">
                            <label for="harga_jual" class="col-sm-4 col-form-label">harga jual</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="harga_jual" name="harga_jual" value="<?= old('harga_jual'); ?>">
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    <span id="errorharga_jual"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row my-2">
                            <label for="stok" class="col-sm-4 col-form-label">stok</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control " id="stok" name="stok" value="<?= old('stok'); ?>">
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    <span id="errorstok"></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row mt-2">
                            <label for="tipe" class="col-sm-4 col-form-label">tipe</label>
                            <div class="col-sm-8">
                                <select class="form-select" aria-label="Default select example" name="tipe" id="tipe">
                                    <option value="dress">dress</option>
                                    <option value="baju">baju</option>
                                    <option value="celana">celana</option>
                                    <option value="aksesoris">aksesoris</option>
                                </select>
                            </div>
                        </div>
                        <input type="file" name="file">
                        <hr>
                        <div class="d-flex justify-content-end mt-3">
                            <button type="submit" class="btn btn-success btnsimpan">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.formtambah').submit(function(e) {
            event.preventDefault();
            $.ajax({
                type: 'post',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: 'json',
                beforeSend: function() {
                    $('.btnsimpan').html('Loading...');
                },
                complete: function() {
                    $('.btnsimpan').html('Simpan');
                },
                success: function(response) {
                    // if (response.error) {
                    //     if (response.error.nama) {
                    //         $('#nama').addClass('is-invalid');
                    //         $('#errornama').html(response.error.nama);
                    //     } else {
                    //         $('#nama').removeClass('is-invalid');
                    //         $('#errornama').html('');
                    //     }
                    //     if (response.error.harga_modal) {
                    //         $('#harga_modal').addClass('is-invalid');
                    //         $('#errorharga_modal').html(response.error.harga_modal);
                    //     } else {
                    //         $('#harga_modal').removeClass('is-invalid');
                    //         $('#errorharga_modal').html('');
                    //     }
                    //     if (response.error.harga_jual) {
                    //         $('#harga_jual').addClass('is-invalid');
                    //         $('#errorharga_jual').html(response.error.harga_jual);
                    //     } else {
                    //         $('#harga_jual').removeClass('is-invalid');
                    //         $('#errorharga_jual').html('');
                    //     }
                    //     if (response.error.stok) {
                    //         $('#stok').addClass('is-invalid');
                    //         $('#errorstok').html(response.error.stok);
                    //     } else {
                    //         $('#stok').removeClass('is-invalid');
                    //         $('#errorstok').html('');
                    //     }
                    // } else {
                    console.log('sukses');
                    alert(response.tipe + response.filename);
                    $('#modaltambah').modal('hide');

                    // }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError)
                }
            })
        })
        $('#formtest').submit(function(e) {
            event.preventDefault();
            $.ajax({
                type: 'post',
                url: $(this).attr('action'),
                data: $('#formtest').serialize(),
                dataType: 'json',
                beforeSend: function() {
                    $('#push').html('Loading...');
                },
                complete: function() {
                    $('#push').html('Simpan');
                },
                success: function(response) {
                    alert(response);
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError)
                }
            })
        })
    })
</script>

<!-- cara mengirim view dari contoller pake jquery -->
<!-- 
<button class="tombol">push data</button>
<div class="tampungModal"></div>

<script>
    $(document).ready(function() {
        $('.tombol').click(function() {
            $.ajax({
                url: 'Admin/modaltambah',
                dataType: 'json',
                success: function(response) {
                    console.log(response.data);
                    $('.tampungModal').html(response.data)
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError)
                }
            })

        })
    })
</script> -->



<script>
    // menampilkan gambar pada upload foto
    $('#gambar').click(function() {
        $('#gambar').change(function() {
            var _PREVIEW_URL;
            var file = this.files[0];

            _PREVIEW_URL = URL.createObjectURL(file);
            $('#thumbnail').attr('src', _PREVIEW_URL);
        })
    })
</script>

<!-- <script>
    $(document).ready(function() {
        $('#buttonCreate').click(function() {
            // e.preventDefault();
            $.ajax({
                url: 'Admin/formCreate',
                dataType: JSON,
                success: function(response) {
                    $('#modalCreate').html(response.data);
                    $('#modaltambah').modal('show');
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError)
                }
            });
        });
    });
</script> -->

<script>
    $(document).ready(function() {
        $('#tabel').DataTable();
    });
</script>


<?= $this->endSection(); ?>