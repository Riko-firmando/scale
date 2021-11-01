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
                <div class="rnf my-5" id="font-style">
                    <h4>Result not found...</h4>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
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