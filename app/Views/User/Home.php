<?= $this->extend('layout/template_user'); ?>

<?= $this->Section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h3><span id="tipe-koleksi"><?= $tipe; ?></span></h3>
            <div class="barang d-flex flex-wrap justify-content-center">
                <div class="spinner">
                    <div class="spinner-grow text-muted"></div>
                    <div class="spinner-grow text-warning"></div>
                    <div class="spinner-grow text-info"></div>
                    <div class="spinner-grow text-success"></div>
                    <div class="spinner-grow text-danger"></div>
                </div>
                <?php if (!isset($barang)) : ?>
                    <div class="rnf my-5" id="font-style">
                        <h4>Result not found...</h4>
                    </div>
                <?php endif; ?>
                <?php if (isset($barang)) : ?>
                    <?php foreach ($barang as $k) : ?>
                        <a href="<?= base_url('User/viewProduk/' . $k['id'] . ''); ?>" id="font-style" class="produk" style="display: none;">
                            <div class="card m-2" id="">
                                <div class="image">
                                    <img src="/image/<?= $k['gambar']; ?>" class="gambar" alt="">
                                </div>
                                <div class="label p-2">
                                    <span><?= $k['nama']; ?></span> <br>
                                    <span id="harga">Rp. <?= number_format($k['harga_jual'], 0, ',', '.'); ?></span>
                                    <br>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('footer').css('display', 'none')
        $('.rnf').css('display', 'none');
        setTimeout(() => {
            $('.spinner').css('display', 'none');
            $('.produk').css('display', 'flex');
            $('.rnf').css('display', 'flex');
            $('footer').css('display', 'block')
        }, 900);

    })

    $(document).ready(function() {
        $('.rnf').css('display', 'none');
        $('.spinner').css('display', 'block');
        setTimeout(() => {
            $('.spinner').css('display', 'none');
            $('.rnf').css('display', 'flex');
        }, 900);
    })
</script>

<?= $this->endSection(); ?>