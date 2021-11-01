<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- midtrans -->
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-yoJurG7V9lLaB5zW"></script>
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
    <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script> -->
    <!-- sweetalert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <script src="js/jquery-3.6.0.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous" type="text/javascript"></script> -->
    <!-- fontawesome -->
    <link href="/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <title><?= $title; ?></title>
</head>

<body>
    <div class="view-checkout container" id="font-style">
        <div class="d-flex" id="content-checkout">
            <div class="" id="leftside">
                <span class="scaleLogo" id="" href="">
                    S c a l e
                </span>
                <div class="contact-checkout border-top border-bottom p-2">
                    <h5 class="">Contact :</h5>
                    <div class="user_name">
                        <span class=""><i class="far fa-user"></i> <?= $user['name']; ?></span><br>
                        <span><i class="far fa-envelope"></i> <?= $user['email']; ?></span> <br>
                        <span><i class="fas fa-mobile-alt"></i> +62<?= $address['phone']; ?></span>
                    </div>
                </div>
                <div class="border-bottom pl-2 pb-2">
                    <h5>Address :</h5>
                    <div class="d-flex" id="content-address">
                        <span><?= $address['alamat'] . ', ' . $address['kota'] . ', ' . $address['provinsi'] . ', ' . $address['pos']; ?></span>
                        <a href="<?= base_url('User/Address_v?id=' . $address['id']); ?>" id="change">Change</a>
                    </div>
                </div>
                <br>
                <div class="">
                    <h5 class="pl-2">Shippping method</h5>
                    <span class="pl-2 mb-2" id="berat">(Berat total : <?=  $berat ?>gram)</span>
                    <div class="radio border">
                        <label class="form-check-label" for="flexRadioDefault1">
                            <?= $cost[0]['description']; ?> (<?= $cost[0]['cost'][0]['etd']; ?> hari) <br>
                            Rp. <?= number_format($cost[0]['cost'][0]['value'], 0, ',', '.'); ?>
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="<?= $cost[0]['cost'][0]['value']; ?>" checked>
                            <span id="dot"></span>
                        </label>
                        <hr>
                        <label class="form-check-label" for="flexRadioDefault2">
                            <?= $cost[1]['description']; ?> (<?= $cost[1]['cost'][0]['etd']; ?> hari) <br>
                            Rp. <?= number_format($cost[1]['cost'][0]['value'], 0, ',', '.'); ?>
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" value="<?= $cost[1]['cost'][0]['value']; ?>">
                            <span id="dot"></span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="bg-dar" id="rightside">
                <div class="col" id="content-right"> 
                    <div class="col mb-1">
                        <?php $total = 0; ?>
                        <?php foreach ($keranjang as $k) : ?>
                            <?php $total += $k['total_hrg']; ?>
                            <div class="row p-1" id='list-carts'>
                                <div class="image" id="imgIncheckout">
                                    <img src="/image/<?= $k['gambar']; ?>" alt="">
                                    <span>
                                        <h6><?= $k['jml_barang']; ?></h6>
                                    </span>
                                </div>
                                <div class="">
                                    <span class="name"><?= $k['nama']; ?> (<?= $k['ukuran']; ?>)</span>
                                </div>
                                <div class="">
                                    <span>Rp. <?= number_format($k['total_hrg'], 0, ',', '.'); ?></span>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="col d-flex" style="flex-direction: column;">
                        <div class="">
                            <h3 class="plus"><span class="p-2" style="background-color: white;">+</span></h3>
                        </div>
                        <div class="subamount mt-1 d-flex">
                            <div class="name_cost">
                                <span>Total :</span><br>
                                <span>cost : </span>
                            </div>
                            <div class="cost">
                                <span>Rp. <?= number_format($total, 0, ',', '.'); ?></span> <br>
                                <span id="cost" data-cost="<?php $cost[0]['cost'][0]['value']; ?>">Rp. <?= number_format($cost[0]['cost'][0]['value'], 0, ',', '.'); ?></span>
                            </div>
                        </div>
                        <div class="subtotal">
                            <div class="">
                                <h3 class="plus mt-3 mb-3"><span class="p-2" style="background-color: white;">+</span></h3>
                            </div>
                            <div class="d-flex" id="subtotal">
                                <div class="">
                                    <span class="">Subtotal :</span>
                                </div>
                                <div class="">
                                    <span id="subcost" data-subtotal="<?php $cost[0]['cost'][0]['value'] + $total; ?>">Rp. <?= number_format($cost[0]['cost'][0]['value'] + $total, 0, ',', '.'); ?></span>
                                </div>
                            </div>
                        </div>
                        <hr class="mt-4">
                        <div class="payButton">
                            <button href="" id="pay-button" class="bayar btn">Bayar</button>
                        </div>
                        <!-- <hr> -->
                    </div>
                    <div class="range" style="height: 70px;"></div>
                </div>
            </div>
        </div>
    </div>

    <form id="payment-form" method="post" action="<?= base_url() ?>/snap/finish">
        <input type="hidden" name="result_type" id="result-type" value=""></div>
        <input type="hidden" name="result_data" id="result-data" value=""></div>
    </form>

    <!-- <button id="pay-button">Pay!</button> -->
    <script type="text/javascript">
        function numberFormat(cost) {
            var number_string = cost.toString(),
                sisa = number_string.length % 3,
                rupiah = number_string.substr(0, sisa),
                ribuan = number_string.substr(sisa).match(/\d{3}/g);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            return rupiah;
        }
        $(document).ready(function() {
            let hrg = {}
            let co = $('#flexRadioDefault1').val()

            hrg.subtotal = <?= $total; ?> + Number(co);
            $('#flexRadioDefault1').click(function() {
                let cost = $(this).val()
                let rupiah = numberFormat(cost);

                $('#cost').html("Rp. " + rupiah);
                $('#cost').attr('data-cost', cost)

                hrg.subtotal = <?= $total; ?> + Number(cost)
                let subtotal2 = numberFormat(hrg.subtotal);

                $('#subcost').html('Rp. ' + subtotal2)
                $('#subcost').attr('data-subtotal', hrg.subtotal)

            })
            $('#flexRadioDefault2').click(function() {
                let cost = $(this).val()
                let rupiah = numberFormat(cost);

                $('#cost').html("Rp. " + rupiah);
                $('#cost').attr('data-cost', cost)

                hrg.subtotal = <?= $total; ?> + Number(cost)
                let subtotal2 = numberFormat(hrg.subtotal);

                $('#subcost').html('Rp. ' + subtotal2)
                $('#subcost').attr('data-subtotal', hrg.subtotal)
            })



            $('#pay-button').click(function(event) {
                event.preventDefault();


                // $(this).attr("disabled", "disabled");

                $.ajax({
                    url: '<?= base_url() ?>/snap/token',
                    cache: false,
                    type: 'post',
                    data: {
                        subtotal: hrg.subtotal
                    },
                    success: function(data) {
                        //location = data;

                        console.log('token = ' + data);

                        var resultType = document.getElementById('result-type');
                        var resultData = document.getElementById('result-data');

                        function changeResult(type, data) {
                            $("#result-type").val(type);
                            $("#result-data").val(JSON.stringify(data));
                            //resultType.innerHTML = type;
                            //resultData.innerHTML = JSON.stringify(data);
                        }

                        snap.pay(data, {

                            onSuccess: function(result) {
                                changeResult('success', result);
                                console.log(result.status_message);
                                console.log(result);
                                $("#payment-form").submit();
                            },
                            onPending: function(result) {
                                changeResult('pending', result);
                                console.log(result.status_message);
                                $("#payment-form").submit();
                            },
                            onError: function(result) {
                                changeResult('error', result);
                                console.log(result.status_message);
                                $("#payment-form").submit();
                            }
                        });
                    }
                });
            });
        })
    </script>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</body>

</html>