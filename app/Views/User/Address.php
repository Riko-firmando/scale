<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- My CSS -->
    <link rel="stylesheet" href="/css/user_style.css">
    <!-- google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Style+Script&family=Varela+Round&display=swap" rel="stylesheet">
    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous" type="text/javascript"></script>
    <!-- sweetalert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <script src="js/jquery-3.6.0.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous" type="text/javascript"></script> -->
    <!-- fontawesome -->
    <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <title><?= $title; ?></title>
</head>

<body>
    <div class="container" id="font-style">
        <div class="row" id="content-addressview">
            <div class="pt-5" id="addressview">
                <span class="scaleLogo mx-3 mt-5 ml-4">
                    S c a l e
                    ddd</span>
                <div class="contact-address border-top border-bottom mt-1 mb-3 p-2">
                    <h6 class="">Contact information :</h6>
                    <div class="user_name d-flex">
                        <i class="fas fa-user-circle " style="font-size: 30px; color:cadetblue;"></i>
                        <span class="mx-2"><?= $user['name']; ?> (<?= $user['email']; ?>)</span><br>
                    </div>
                </div>
                <div class="" id="content-formaddress">
                    <h6 class="pl-2 ml-4">Shipping address</h6>
                    <form action="<?= isset($Address) ? base_url('User/Address?id=' . $Address['id'] . '&province=') : base_url('User/Address?province='); ?>" method="POST" id="form-address">
                        <div class="input-group col-12 my-3">
                            <div class="col-11">
                                <input type="text" id="nama" name="nama" class="form-control" value="<?= isset($Address)  ? $Address['nama'] : ''; ?>" placeholder=" ">
                                <label id="for_nama" for="nama">Nama</label>
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    <span id="errorNama"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group col-12 my-3">
                            <span id="contoh">*Jalan-kelurahan-kecamatan</span>
                            <div class="col-11">
                                <input type="text" name="alamat" class="form-control" id="alamat" placeholder=" " value="<?= isset($Address)  ? $Address['alamat'] : ''; ?>">
                                <label id="for_alamat" for="alamat">Alamat</label>
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    <span id="errorAlamat"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group col-12 my-3">
                            <div class="col-11">
                                <select class="form-control" name="provinsi" id="provinsi" <?= isset($Address) ? '' : 'disabled'; ?> value="<?= isset($Address)  ? $Address['provinsi_id'] : ''; ?>">
                                    <option value="none">Pilih provinsi</option>
                                    <?php foreach ($provinsi['rajaongkir']['results'] as $pv) {
                                        echo '<option data-provinsi="' . $pv['province'] . '" value="' . $pv['province_id'] . '">' . $pv['province'] . '</option>';
                                    } ?>
                                </select>
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    <span id="errorProvinsi"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group col-12 my-3">
                            <div class="col-7">
                                <select class="form-control" name="kota" id="kota" disabled value="<?= isset($Address)  ? $Address['kota_id'] : ''; ?>">
                                    <option value="none">Pilih kota</option>
                                </select>
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    <span id="errorKota"></span>
                                </div>
                            </div>
                            <div class="col-4">
                                <input type="text" name="code" class="form-control" id="code" placeholder="kode pos" disabled>
                            </div>
                        </div>
                        <div class="input-group col-12 my-3 mb-4">
                            <span id="contoh">*WhatsApp</span>
                            <div class="col-11 d-flex">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">+62</span>
                                </div>
                                <input type="number" id="phone" name="phone" class="form-control" placeholder=" " value="<?= isset($Address)  ? $Address['phone'] : ''; ?>">
                                <label id="for_phone" for="phone">Phone</label>
                            </div>
                            <div id="validationServer03Feedback" class="invalid-feedback">
                                <span id="errorPhone"></span>
                            </div>
                        </div>
                        <!-- <a href="keranjang" class="btn btn-dark">return to cart</a> -->
                        <div class="addressBtn">
                            <button type="submit" class="btn">Continue shipping</button>
                        </div>
                    </form>
                </div>
                <div class="" style="height: 160px;"></div>
            </div>
            <div class="col-6" id="listcarts">
                <div class="col p-1 m-1 pl-5 pt-5">
                    <div class="col">
                        <?php $total = 0; ?>
                        <?php foreach ($keranjang as $k) : ?>
                            <?php $total += $k['total_hrg']; ?>
                            <div class="row p-1" id='list-carts'>
                                <div class="image">
                                    <img src="/image/<?= $k['gambar']; ?>" alt="">
                                    <span>
                                        <h6><?= $k['jml_barang']; ?></h6>
                                    </span>
                                </div>
                                <span class="name mr-5"><?= $k['nama']; ?> (size: <?= $k['ukuran']; ?>)</span>
                                <span class="">Rp. <?= number_format($k['total_hrg'], 0, ',', '.'); ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="col">
                        <h3 class="plus" style="border-color: rgb(139, 139, 139);"><span class="p-2" style="background-color: white;">+</span></h3>
                        <div class="amount">
                            <span>Total :</span>
                            <span>Rp. <?= number_format($total, 0, ',', '.'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            $('#alamat').change(function() {
                $('#provinsi').removeAttr('disabled')
            })
            $('#provinsi').change(function() {
                $('#code').val('')
                var provID = $('#provinsi').val()

                $.ajax({
                    url: '<?= base_url('user/kota?id=') ?>' + provID,
                    type: 'get',
                    success: function(response) {
                        $('#kota').removeAttr('disabled')
                        $('#kota').html('<option value="">pilih kota</option>' + response)
                        if ($('#provinsi').val() == 'none') {
                            $('#kota').attr('disabled', 'disabled')
                        }
                    }
                })
            })

            $('#kota').change(function() {
                let kodePOS = $(this).find(':selected').data('code')
                $('#code').val(kodePOS)
            })

            $('#form-address').submit(function(e) {
                event.preventDefault()
                let provinsi = $('#provinsi').find(':selected').data('provinsi');
                let kota = $('#kota').find(':selected').data('kota');
                let pos = $('#kota').find(':selected').data('code')

                $.ajax({
                    type: 'post',
                    url: $(this).attr('action') + provinsi + '&city=' + kota + '&pos=' + pos,
                    data: new FormData(this),
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        if (response.error) {
                            if (response.error.nama) {
                                $('#nama').addClass('is-invalid');
                                $('#errorNama').html(response.error.nama);
                            } else {
                                $('#nama').removeClass('is-invalid');
                                $('#errorNama').html('');
                            }
                            if (response.error.alamat) {
                                $('#alamat').addClass('is-invalid');
                                $('#errorAlamat').html(response.error.alamat);
                            } else {
                                $('#alamat').removeClass('is-invalid');
                                $('#errorAlamat').html('');
                            }
                            if (response.error.provinsi) {
                                $('#provinsi').addClass('is-invalid');
                                $('#errorProvinsi').html(response.error.provinsi);
                            } else {
                                $('#provinsi').removeClass('is-invalid');
                                $('#errorProvinsi').html('');
                            }
                            if (response.error.kota) {
                                $('#kota').addClass('is-invalid');
                                $('#errorKota').html(response.error.kota);
                            } else {
                                $('#kota').removeClass('is-invalid');
                                $('#errorKota').html('');
                            }
                            if (response.error.phone) {
                                $('#phone').addClass('is-invalid');
                                $('#errorPhone').html(response.error.phone);
                            } else {
                                $('#phone').removeClass('is-invalid');
                                $('#errorPhone').html('');
                            }
                        } else {
                            $('#kota').removeClass('is-invalid');
                            $('#errorKota').html('');

                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: response.sukses,
                                showConfirmButton: false,
                                timer: 4000
                            })

                            // console.log($('#provinsi').find(':selected').data('provinsi'))
                            window.location = 'http://localhost:8080/User/checkout'
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError)
                    }
                })
            })
        })
    </script>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</body>

</html>