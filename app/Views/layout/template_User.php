<!doctype html>
<html lang="en">

<head>
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

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="/bootstrap-5.0.2-dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- My CSS -->
    <link rel="stylesheet" href="/css/user_style.css">
    <title><?= $title; ?></title>
</head>

<body style="height: 100%;">
    <header>
        <?= $this->include('layout/navbar_User'); ?>
    </header>
    <main>
        <div class="" style="height: 50px;"></div>
        <?= $this->renderSection('content'); ?>
        <div class="push" style="height: 50px;"></div>
    </main>
    <footer>
        <div class="" style="height: 15px;"></div>
        <div class="" style="font-size: 25px;">
            <a href="" class="mx-2">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="" class="mx-2">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="" class="mx-2">
                <i class="fas fa-map-marker-alt"></i>
            </a>
            <a href="" class="mx-2" style="font-weight: bolder;">
                <i class="fab fa-instagram"></i>
            </a>
        </div>
        <p class="">Copyright ©<span id="year"></span></p>
    </footer>

    <script>
        $(window).on('load', function(e) {
            let width = $(document).width();
            $('.search').css('width', width + 'px')
        })
        $(document).ready(function() {
            var year = new Date().getFullYear();
            $('#year').html(year);

            $(window).scroll(function() {
                var wScroll = $(window).scrollTop();

                if (wScroll >= 30) {
                    $('.lower-nav').css('position', 'fixed')
                    $('.lower-nav').css('top', '0px')
                    $('.rangeTocontent').css('display', 'block')
                } else if (wScroll <= 30) {
                    $('.lower-nav').css('position', 'relative')
                    $('.rangeTocontent').css('display', 'none')
                }
            })

            $(window).resize(function(e) {
                let width = $(document).width();
                $('.search').css('width', width + 'px')
            })

            $('.search-toggle').hover(function() {
                $('#key').focus();
                // $('#search').val('');
            })

            // mengambil nilai input search//
            $('#search').submit(function() {
                $('.produk').css('display', 'none');
                $('.spinner').css('display', 'block');
                setTimeout(() => {
                    $('.spinner').css('display', 'none');
                    $('.produk').css('display', 'flex');
                }, 900);
            })
        })
    </script>


    <script src="/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>