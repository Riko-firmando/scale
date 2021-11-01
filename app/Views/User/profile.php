<?= $this->extend('layout/template_user'); ?>

<?= $this->Section('content'); ?>
<div class="container" id="font-style">
    <h4 id="text" class="" style="color: #333;">My Profile</h4>
    <hr id="line" style="border-top: 2px dashed #333;background-color:white;">
    <div class="d-flex" id="content-profile">
        <div class="profile d-flex">
            <div class="contact-profile">
                <h5>Contact :</h5>
                <span><i class="fas fa-user"></i> <?= $user['name']; ?></span> <br>
                <span><i class="fas fa-envelope"></i> <?= $user['email']; ?></span>
            </div>
            <!-- <hr> -->
            <div class="address">
                <h5>Address : </h5>
                <div class="d-flex">
                    <div class=""> 
                    <i class="fas fa-map-marker-alt">&ensp;</i> 
                    </div>
                    <span> <?= $address['alamat'] . ', ' . $address['kota'] . ', ' . $address['provinsi'] . ', ' . $address['pos']; ?> </span><br>
                </div>
            </div>
            <a href="<?= base_url('Auth/logout'); ?>" class="btn btn-secondary mt-1">Logout</a>
        </div>
        <div class="orderTable">
            <h4 class="border-bottom mb-3 pb-1" style="color: #333;padding-left:23px;">Order</h4>
            <!-- <hr style="border-top: 2px solid #333;background-color:white;"> -->
        <?php if($bank_tf != null) : ?>
            <h5>Bank transfer</h5>
            <table class="bankTf table table-striped mb-4">
                <thead class="table" id="font-style">
                    <tr>
                        <th>Total harga</th>
                        <th>Bank</th>
                        <th>Virtual Account</th>
                        <th>Batas waktu</th>
                        <th>Cara bayar</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bank_tf as $m) : ?>
                        <tr>
                            <td>Rp <?= number_format($m['gross_amount'],0,',','.') ; ?></td>
                            <td style="text-align: center;"><?= $m['bank']; ?></td>
                            <td style="text-align: center;"><?= ($m['va_number'] != '-')? $m['va_number'] : $m['payment_code']; ?></td>
                            <td><?= $m['transaction_time']; ?></td>
                            <td style="text-align: center;"><a href="<?= $m['pdf_url']; ?>" target="_blank">PDF</a></td>
                            <td><?php if ($m['status_code'] == 201) : ?>
                                <span class="badge rounded-pill bg-warning text-dark">pending</span>
                                <?php endif; ?>
                                <?php if ($m['status_code'] == 200) : ?>
                                    <span class="badge rounded-pill bg-success">success</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="mobile mb-4">
                <?php foreach($bank_tf as $m):  ?>
                <div class="orderlist d-flex p-2 mb-2">
                    <div class="">
                        <span>ID : <?= $m['order_id']; ?></span> <br>
                        <span>Total : <?= $m['gross_amount']; ?></span> <br>
                        <span>VA : <?= $m['va_number']; ?></span> <br>
                        <span>pay before : <?= $m['transaction_time']; ?></span>
                    </div>
                    <div class="">
                        <span>
                            <a href="<?= $m['pdf_url']; ?>" target="_blank">how to pay!</a>
                        </span>
                        <?php if ($m['status_code'] == 201) : ?>
                        <span class="badge rounded-pill bg-warning text-dark" id="status">pending</span>
                            <?php endif; ?>
                        <?php if ($m['status_code'] == 200) : ?>
                            <span class="badge rounded-pill bg-success" id="status">success</span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <?php if($cStore != null) : ?>                      
            <h5>indomaret / alfamart</h5>
            <table class="cstore table table-striped mb-4">
                <thead class="table" id="font-style">
                    <tr>
                        <th>Total harga</th>
                        <th>kode bayar</th>
                        <th>Batas waktu</th>
                        <th>Cara bayar</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody> 
                    <?php foreach ($cStore as $m) : ?>
                        <tr>
                            <td>Rp <?= number_format($m['gross_amount'],0,',','.') ; ?></td>
                            <td style="text-align: center;"><?= $m['payment_code']; ?></td>
                            <td><?= $m['transaction_time']; ?></td>
                            <td style="text-align: center;"><a href="<?= $m['pdf_url']; ?>" target="_blank">PDF</a></td>
                            <td><?php if ($m['status_code'] == 201) : ?>
                                <span class="badge rounded-pill bg-warning text-dark">pending</span>
                                <?php endif; ?>
                                <?php if ($m['status_code'] == 200) : ?>
                                    <span class="badge rounded-pill bg-success">success</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="mobile mb-4">
                <?php foreach($cStore as $m):  ?>
                <div class="orderlist d-flex p-2 mb-2">
                    <div class="">
                        <span>ID : <?= $m['order_id']; ?></span> <br>
                        <span>Total : <?= $m['gross_amount']; ?></span> <br>
                        <span>payment code : <?= $m['payment_code']; ?></span> <br>
                        <span>pay before : <?= $m['transaction_time']; ?></span>
                    </div>
                    <div class="">
                        <span>
                            <a href="<?= $m['pdf_url']; ?>" target="_blank">how to pay!</a>
                        </span>
                        <?php if ($m['status_code'] == 201) : ?>
                        <span class="badge rounded-pill bg-warning text-dark" id="status">pending</span>
                            <?php endif; ?>
                        <?php if ($m['status_code'] == 200) : ?>
                            <span class="badge rounded-pill bg-success" id="status">success</span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>                            
        <?php if($onlinePay != null) : ?>
            <h5>gopay / shoppepay</h5>
            <table class="onlinepay table table-striped">
                <thead class="table" id="font-style">
                    <tr>
                        <!-- <th>kode bayar</th> -->
                        <th>Total harga</th>
                        <th>Batas waktu</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($onlinePay as $m) : ?>
                        <tr>
                            <td>Rp <?= number_format($m['gross_amount'],0,',','.') ; ?></td>
                            <td><?= $m['transaction_time']; ?></td>
                            <td><?php if ($m['status_code'] == 201) : ?>
                                <span class="badge rounded-pill bg-warning text-dark">pending</span>
                                <?php endif; ?>
                                <?php if ($m['status_code'] == 200) : ?>
                                    <span class="badge rounded-pill bg-success">success</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="mobile mb-4">
                <?php foreach($onlinePay as $m):  ?>
                <div class="orderlist d-flex p-2 mb-2">
                    <div class="">
                        <span>ID : <?= $m['order_id']; ?></span> <br>
                        <span>Total : <?= $m['gross_amount']; ?></span> <br>
                        <span>pay before : <?= $m['transaction_time']; ?></span>
                    </div>
                    <div class="">
                        <span>
                            <a href="<?= $m['pdf_url']; ?>" target="_blank">how to pay!</a>
                        </span>
                        <?php if ($m['status_code'] == 201) : ?>
                        <span class="badge rounded-pill bg-warning text-dark" id="status">pending</span>
                            <?php endif; ?>
                        <?php if ($m['status_code'] == 200) : ?>
                            <span class="badge rounded-pill bg-success" id="status">success</span>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>