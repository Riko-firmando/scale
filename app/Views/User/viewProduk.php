<?= $this->extend('layout/template_user'); ?>

<?= $this->Section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <!-- <h3></h3> -->
            <div class="view d-flex p-1" id="font-style">
                <div class="viewImage">
                    <input type="text" id='id' name="id" value='<?= $barang['id']; ?>' hidden>
                    <img src="/image/<?= $barang['gambar']; ?>" alt="">
                </div>
                <div class="label">
                    <h2 class="col-10 border-bottom"><?= $barang['nama']; ?></h2>
                    <input type="number" id="hargaJual" value="<?= $barang['harga_jual']; ?>" hidden>
                    <h5>Price/pcs : <span>Rp <?= number_format($barang['harga_jual'], 0, ',', '.'); ?>,00 </span></h5>

                    <div class="ukuran my-2">
                        <h5>Size :</h5>
                        <!-- <input type="radio" name="size" id="size1" data-size="<?php $barang['s35'] ?>">
                        <input type="radio" name="size" id="size2" data-size="<?php $barang['s36'] ?>">
                        <input type="radio" name="size" id="size3" data-size="<?php $barang['s37'] ?>">
                        <input type="radio" name="size" id="size4" data-size="<?php $barang['s38'] ?>">
                        <input type="radio" name="size" id="size5" data-size="<?php $barang['s39'] ?>">
                        <input type="radio" name="size" id="size6" data-size="<?php $barang['s40'] ?>"> -->
                        <span id="i35">35</span><input type="number" id="35" value="<?= $barang['s35']; ?>" hidden>
                        <span id="i36">36</span><input type="number" id="36" value="<?= $barang['s36']; ?>" hidden>
                        <span id="i37">37</span><input type="number" id="37" value="<?= $barang['s37']; ?>" hidden>
                        <span id="i38">38</span><input type="number" id="38" value="<?= $barang['s38']; ?>" hidden>
                        <span id="i39">39</span><input type="number" id="39" value="<?= $barang['s39']; ?>" hidden>
                        <span id="i40">40</span><input type="number" id="40" value="<?= $barang['s40']; ?>" hidden>
                    </div>
                    <span class="">Stok : <span id="stok">
                            <?php
                            if ($barang['s35'] != 0) {
                                echo $barang['s35'];
                            } else if ($barang['s36'] != 0) {
                                echo $barang['s36'];
                            } else if ($barang['s37'] != 0) {
                                echo $barang['s37'];
                            } else if ($barang['s38'] != 0) {
                                echo $barang['s38'];
                            } else if ($barang['s39'] != 0) {
                                echo $barang['s39'];
                            } else if ($barang['s40'] != 0) {
                                echo $barang['s40'];
                            }
                            ?>
                        </span>
                    </span>
                    <div class="jml">
                        <label for="jumlah" class="">Quantity : </label>
                        <input type="number" name="jumlah" class="jumlah" min="0" oninput="validity.valid||(value='');" value="1">
                        <h4 class="mt-2">Amount of Price : <span> Rp 0</span></h4>
                    </div>
                    <div class="d-flex">
                        <a href="<?= base_url("User"); ?>" class="button">Back </a>
                        <a href='<?= base_url("User/addCart"); ?>' id="button" class="button">Add to cart</a>
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // mengubah nilai max input jumlah
    $('.jumlah').change(function() {
        var s = $('#stok').html();
        let a = parseInt(s)
        // console.log(a)
        $('.jumlah').attr('max', a)
    })

    function toRupiah(hrg) {
        var number_string = hrg.toString(),
            sisa = number_string.length % 3,
            rupiah = number_string.substr(0, sisa),
            ribuan = number_string.substr(sisa).match(/\d{3}/g);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        return rupiah
    }
    $(document).ready(function() {
        for (let x = 40; x > 34; x--) {
            var ukuran = document.getElementById(x).value;
            if (ukuran == 0) {
                var non_activ = '#i' + x
                $(non_activ).css('background-color', 'rgb(139, 139, 139)');
                $(non_activ).removeAttr('id');
            } else {
                var activ = '#i' + x
            }
        }

        var text = {}; // variabel global
        $(activ).css('background-color', '#a17a3f')
        $(activ).css('color', 'white')
        text.key = $(activ).text();

        var hrg = {};
        $('.jumlah').on('keyup mouseup', function() {
            var jml = $('.jumlah').val();
            var harga = $('#hargaJual').val();
            hrg.jmlHarga = jml * harga

            let hasil = toRupiah(hrg.jmlHarga)

            $('.jml h4 span').html('Rp ' + hasil + ',00')
            if (hrg.jmlHarga != 0) {
                $('#button').css('background-color', 'burlywood')
                $('#button').css('color', '#333')
                $('#button').css('pointer-events', 'all')
            } else {
                $('#button').css('background-color', 'rgb(148, 144, 144)')
                $('#button').css('pointer-events', 'none')
            }
        }).trigger('mouseup');

        $('#i35').click(function() {
            text.key = $(this).text();
            $(this).css('background-color', '#a17a3f')
            $(this).css('color', 'white')
            $('#i36').css('background-color', 'white')
            $('#i37').css('background-color', 'white')
            $('#i38').css('background-color', 'white')
            $('#i39').css('background-color', 'white')
            $('#i40').css('background-color', 'white')
            $('#i36').css('color', 'rgb(126, 121, 121)')
            $('#i37').css('color', 'rgb(126, 121, 121)')
            $('#i38').css('color', 'rgb(126, 121, 121)')
            $('#i39').css('color', 'rgb(126, 121, 121)')
            $('#i40').css('color', 'rgb(126, 121, 121)')
            $('.jumlah').attr('max', '<?= $barang['s35'] ?>');
            $('.jumlah').val('1')
            $('#stok').html('<?= $barang['s35']; ?>')
            hrg.jmlHarga = '<?= $barang['harga_jual']; ?>'

            $('.jml h4 span').html('Rp ' + toRupiah(hrg.jmlHarga) + ',00')
        })
        $('#i36').click(function() {
            text.key = $(this).text();
            $(this).css('background-color', '#a17a3f')
            $(this).css('color', 'white')
            $('#i35').css('background-color', 'white')
            $('#i37').css('background-color', 'white')
            $('#i38').css('background-color', 'white')
            $('#i39').css('background-color', 'white')
            $('#i40').css('background-color', 'white')
            $('#i35').css('color', 'rgb(126, 121, 121)')
            $('#i37').css('color', 'rgb(126, 121, 121)')
            $('#i38').css('color', 'rgb(126, 121, 121)')
            $('#i39').css('color', 'rgb(126, 121, 121)')
            $('#i40').css('color', 'rgb(126, 121, 121)')
            $('.jumlah').attr('max', '<?= $barang['s36'] ?>');
            $('.jumlah').val('1')
            $('#stok').html('<?= $barang['s36']; ?>')
            hrg.jmlHarga = '<?= $barang['harga_jual']; ?>'

            $('.jml h4 span').html('Rp ' + toRupiah(hrg.jmlHarga) + ',00')
        })
        $('#i37').click(function() {
            text.key = $(this).text();
            $(this).css('background-color', '#a17a3f')
            $(this).css('color', 'white')
            $('#i36').css('background-color', 'white')
            $('#i35').css('background-color', 'white')
            $('#i38').css('background-color', 'white')
            $('#i39').css('background-color', 'white')
            $('#i40').css('background-color', 'white')
            $('#i36').css('color', 'rgb(126, 121, 121)')
            $('#i35').css('color', 'rgb(126, 121, 121)')
            $('#i38').css('color', 'rgb(126, 121, 121)')
            $('#i39').css('color', 'rgb(126, 121, 121)')
            $('#i40').css('color', 'rgb(126, 121, 121)')
            $('.jumlah').attr('max', '<?= $barang['s37'] ?>');
            $('.jumlah').val('1')
            $('#stok').html('<?= $barang['s37']; ?>')
            hrg.jmlHarga = '<?= $barang['harga_jual']; ?>'
            $('.jml h4 span').html('Rp ' + toRupiah(hrg.jmlHarga) + ',00')
        })
        $('#i38').click(function() {
            text.key = $(this).text();
            $(this).css('background-color', '#a17a3f')
            $(this).css('color', 'white')
            $('#i36').css('background-color', 'white')
            $('#i37').css('background-color', 'white')
            $('#i35').css('background-color', 'white')
            $('#i39').css('background-color', 'white')
            $('#i40').css('background-color', 'white')
            $('#i36').css('color', 'rgb(126, 121, 121)')
            $('#i37').css('color', 'rgb(126, 121, 121)')
            $('#i35').css('color', 'rgb(126, 121, 121)')
            $('#i39').css('color', 'rgb(126, 121, 121)')
            $('#i40').css('color', 'rgb(126, 121, 121)')
            $('.jumlah').attr('max', '<?= $barang['s38'] ?>');
            $('.jumlah').val('1')
            $('#stok').html('<?= $barang['s38']; ?>')
            hrg.jmlHarga = '<?= $barang['harga_jual']; ?>'
            $('.jml h4 span').html('Rp ' + toRupiah(hrg.jmlHarga) + ',00')


        })
        $('#i39').click(function() {
            text.key = $(this).text();
            $(this).css('background-color', '#a17a3f')
            $(this).css('color', 'white')
            $('#i36').css('background-color', 'white')
            $('#i37').css('background-color', 'white')
            $('#i38').css('background-color', 'white')
            $('#i35').css('background-color', 'white')
            $('#i40').css('background-color', 'white')
            $('#i36').css('color', 'rgb(126, 121, 121)')
            $('#i37').css('color', 'rgb(126, 121, 121)')
            $('#i38').css('color', 'rgb(126, 121, 121)')
            $('#i35').css('color', 'rgb(126, 121, 121)')
            $('#i40').css('color', 'rgb(126, 121, 121)')
            $('.jumlah').attr('max', '<?= $barang['s39'] ?>');
            $('.jumlah').val('1')
            $('#stok').html('<?= $barang['s39']; ?>')
            hrg.jmlHarga = '<?= $barang['harga_jual']; ?>'
            $('.jml h4 span').html('Rp ' + toRupiah(hrg.jmlHarga) + ',00')

        })
        $('#i40').click(function() {
            text.key = $(this).text();
            $(this).css('background-color', '#a17a3f')
            $(this).css('color', 'white')
            $('#i36').css('background-color', 'white')
            $('#i37').css('background-color', 'white')
            $('#i38').css('background-color', 'white')
            $('#i39').css('background-color', 'white')
            $('#i35').css('background-color', 'white')
            $('#i36').css('color', 'rgb(126, 121, 121)')
            $('#i37').css('color', 'rgb(126, 121, 121)')
            $('#i38').css('color', 'rgb(126, 121, 121)')
            $('#i39').css('color', 'rgb(126, 121, 121)')
            $('#i35').css('color', 'rgb(126, 121, 121)')
            $('.jumlah').attr('max', '<?= $barang['s40'] ?>');
            $('.jumlah').val('1')
            $('#stok').html('<?= $barang['s40']; ?>')
            hrg.jmlHarga = '<?= $barang['harga_jual']; ?>'
            $('.jml h4 span').html('Rp ' + toRupiah(hrg.jmlHarga) + ',00')

        })


        $('#button').click(function() {
            var id = $('#id').val()
            var ukuran = text.key;
            var jmlBarang = $('.jumlah').val();
            var totalHrg = hrg.jmlHarga;

            createCookie("id", id, "1");
            createCookie('ukuran', ukuran, '1')
            createCookie('jml_barang', jmlBarang, '1')
            createCookie('total_hrg', totalHrg, '1')

            // $.ajax([
            //     url : '<?= base_url(); ?>' + 'User/addCart',
            //     data :['id' : id,]

            // ])
        });


    })

    function createCookie(name, value, days) {
        var expires;

        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toGMTString();
        } else {
            expires = "";
        }

        document.cookie = escape(name) + "=" +
            escape(value) + expires + "; path=/";
    }
</script>

<?= $this->endSection(); ?>