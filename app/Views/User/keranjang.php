<?= $this->extend('layout/template_user'); ?>

<?= $this->Section('content'); ?>
<div class="container" id="font-style">
    <h4 class="mx-4" style="color: #333;">Shopping Carts</h4>
    <hr style="border: 1px dashed #333;background-color:white;">

    <?php if ($keranjang == null) : ?>
        <div class="empty_cart d-flex justify-content-center">
            <div class="">
                <hr>there are no item in your cart
                <hr>
            </div>
            <a href="<?= base_url('User'); ?>" class="btn btn-primary mt-5">continue to shop</a>
        </div>
    <?php endif; ?>
    <?php if ($keranjang != null) : ?>
        <?php if (session()->getflashdata('success')) : ?>
            <div class="alert alert-success" role="alert">
                <?= session()->getflashdata('success'); ?>
            </div>
        <?php endif; ?>
        <?php if (session()->getflashdata('error')) : ?>
            <div class="alert alert-danger" role="alert">
                <?= session()->getflashdata('error'); ?>
            </div>
        <?php endif; ?>

        <div class="d-flex" id="myCart">
            <div class="list_cart">
                <?php $index = 1 ?>
                <?php foreach ($keranjang as $k) : ?>
                    <div class="cart col-7 d-flex mb-3 pb-2" id="<?= $index ?>">
                        <div class="">
                            <img src="/image/<?= $k['gambar']; ?>">
                        </div>
                        <div class="labelCart my-2">
                            <div class="d-flex">
                                <h5><?= $k['nama']; ?><h2>/</h2>
                                </h5>
                                <span style="margin-top: 10px;">Rp. <?= number_format($k['harga_jual'], 0, ',', '.'); ?></span>
                            </div>
                            <div class="viewjml d-flex">
                                <a onclick="tambah(<?= $k['id']; ?>)" class="btn btn-light border"><i class="fas fa-plus"></i></a>
                                <div id="<?= $k['id']; ?>" class="jmlbrg d-flex" style="border-radius: 5px;">
                                    <span><?= $k['jml_barang']; ?></span>
                                </div>
                                <a class="btn btn-light border" href="<?= base_url('User/kurang/' . $k['id']); ?>"><i class="fas fa-minus"></i></a>
                                <div class="show_error mx-2 d-flex" id="this<?= $k['id']; ?>" style="color: rgb(194, 55, 55);align-items: center;"></div>
                            </div>
                            <br>
                            <span>Size : <?= $k['ukuran']; ?></span><br>
                            <span>Price : Rp <?= number_format($k['total_hrg'], 0, ',', '.'); ?></span><br>
                        </div>
                        <a href="<?= base_url('User/remove/' . $k['id']); ?>" onclick="hapus(<?= $index ?>)" class="remove">Remove <i class="fas fa-times"></i></a>
                        <?php $index++ ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="inline">
                <div class="counting row-12 pb-3">
                    <h2>My Carts</h2>
                    <?php $sum = 0; ?>
                    <?php foreach ($keranjang as $k) : ?>
                        <?php $sum += $k['total_hrg']; ?>
                        <div class="hrg_group d-flex">
                            <div class="namePro">
                                <span><?= $k['nama']; ?></span>
                                <span>(x<?= $k['jml_barang']; ?>)</span>
                            </div>
                            <div class="hrgTot">
                                <span>Rp <?= number_format($k['total_hrg'], 0, ',', '.'); ?>,00 </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <h3 class="plus mt-4 mb-4" style="border-color: rgb(139, 139, 139);"><span class="p-2" style="background-color: white;">+</span></h3>
                    <div class="d-flex my-2 mb-5">
                        <div class="namePro">
                            <h5>Subtotal : </h5>
                        </div>
                        <div class="hrgTot">
                            <h5>Rp <?= number_format($sum, 0, ',', '.'); ?>,00 </h5>
                        </div>
                    </div>
                    <div class="toCheckout">
                        <input type="checkbox" class="mx-2" id="checkbox"><label for="checkbox">I Agree with the Terms & Conditions</label><br>
                        <a href="<?= base_url('User/Address_v'); ?>" class="checkoutBtn btn">Checkout</a>
                        <a href="<?= base_url('User'); ?>" class="continueShop btn">continue to shop</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>


<script>
    function hapus(id) {
        let tes = '#' + id
        // console.log(tes)
        $(tes).css('transform', 'translateX(-50px)')
        $(tes).css('opacity', '0')
    }


    function tambah(id) {
        event.preventDefault()

        let jml = '#' + id;
        let err = '#this' + id;

        // $(jml).css('background-color', 'burlywood')
        $.ajax({
            url: '<?= base_url('User/tambah?id='); ?>' + id,
            type: 'get',
            dataType: 'json',
            success: function(response) {
                if (response.error) {
                    // console.log(response.error)
                    $(jml).css('border', '2px solid rgb(194, 55, 55)')
                    $(err).html(response.error)
                } else if (response.success) {
                    window.location = '<?= base_url('user/keranjang'); ?>'
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError)
            }
        })
    }
    $(window).on('load', function() {
        let width = $(document).width();
        console.log(width)
        if (width <= 480) {
            $('.remove').html('<i class="fas fa-times"></i>');
        } else {
            $('.remove').html('Remove <i class="fas fa-times"></i>');
        }
    })

    $(window).resize(function() {
        let width = $(document).width();
        console.log(width)
        if (width <= 480) {
            $('.remove').html('<i class="fas fa-times"></i>');
        } else {
            $('.remove').html('Remove <i class="fas fa-times"></i>');
        }
    })
    $('#checkbox').click(function() {
        if ($('#checkbox').is(':checked')) {
            $('.checkoutBtn').toggleClass('toggle')
        } else {
            $('.checkoutBtn').removeClass('toggle')
        }
    })
    // $(document).ready(function() {
    // $('.checkoutBtn').css('pointer-events', 'all')
    // $('.checkoutBtn').css('background-color', 'burlywood')
    // $('.checkoutBtn').css('color', 'white')
    // } else {
    // $('.checkoutBtn').css('pointer-events', 'none')
    // $('.checkoutBtn').css('background-color', '#797579')
    // $('.checkoutBtn').css('color', 'rgb(39, 38, 38)')
    // }
    // })
</script>

<?= $this->endSection(); ?>