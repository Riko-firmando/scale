<?= $this->extend('layout/template_Admin'); ?>

<?= $this->Section('content'); ?>
<div class="container">
    <?php $db = \Config\Database::connect(); ?>
    <div class="d-flex justify-content-center mb-3">
        <h2 class='' id="font-style">DAFTAR PESANAN</h2>
    </div>

    <div class="row">
        <div class="col">

            <div class="orderlist d-flex flex-wrap ml-5">
                <?php foreach ($midtrans as $m) : ?>
                    <div class="order col-5 m-2 p-2" style="border-radius: 7px;border: 1px dashed #333">
                        <span>Order_id : <?= $m['order_id']; ?></span><br>
                        <span style=""><?php $user = $db->query('select * from user where id=' . $m['user_id'])->getRowArray() ?>
                            <span>Contact : <?= $user['name']; ?> (<?= $user['email']; ?>)</span>
                        </span><br>
                        <span style="text-align: start;">
                            <?php $produk = $db->query('select * from order_produk inner join barang on order_produk.barang_id=barang.id where order_produk.order_id=' . $m['order_id'])->getresultArray(); ?>
                            <div class="d-flex mt-3">
                                <div class="mr-4 ">
                                    <span>List produk : </span>
                                </div>
                                <div class="">
                                    <?php foreach ($produk as $p) : ?>
                                        <span><?= $p['nama'] . ' (' . $p['size'] . ')' . ' x' . $p['jumlah']; ?></span><br>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </span>
                        <span>
                            Total harga : Rp. <?= number_format($m['gross_amount'], 0, ',', '.'); ?>
                        </span><br>
                        <div class="d-flex">
                            <?php $alamat = $db->query('select * from user_address where user_id=' . $m['user_id'])->getRowArray(); ?>
                            <div class="mr-4 ">
                                <span>Alamat : </span>
                            </div>
                            <div class="col">
                                <span> <?= $alamat['alamat'] . ', ' . $alamat['kota'] . ', ' . $alamat['provinsi'] . ', ' . $alamat['pos']; ?></span>
                            </div>
                        </div>
                        <br>
                        <span>status pembayaran : <?php if ($m['status_code'] == 201) : ?>
                                <span class="badge rounded-pill bg-warning text-dark">pending</span>
                            <?php endif; ?>
                            <?php if ($m['status_code'] == 200) : ?>
                                <span class="badge rounded-pill bg-success">success</span>
                            <?php endif; ?>
                        </span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>


<?= $this->endSection(); ?>