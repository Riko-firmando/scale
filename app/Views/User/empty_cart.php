<?= $this->extend('layout/template_user'); ?>

<?= $this->Section('content'); ?>
<div class="container" id="font-style">
    <h4 class="mx-5" style="color: #333;">Shopping Carts</h4>
    <hr style="border-top: 2px dashed #333;background-color:white;">
    <div class="empty_cart d-flex justify-content-center">
        <div class="mx-5" style="margin-top: 50px;">
            <hr>
            there are no item in your cart
            <hr>
        </div>
        <a href="<?= base_url('User'); ?>" class="btn btn-primary mt-5">continue to shop</a>
    </div>
</div>

<?= $this->endSection(); ?>