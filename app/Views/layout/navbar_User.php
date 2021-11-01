<!-- <nav class="d-flex" id="nav"> -->
<div class="upper-nav d-flex">
    <div class="group">
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
    <div class="user">
        <a href="<?= base_url('User/profile'); ?>">
            <span><?= $_SESSION['email']; ?></span>
            <i class="far fa-user mx-2"></i>
        </a>
    </div>
</div>
<div class="rangeTocontent"></div>
<div class="lower-nav d-flex align-items-center">
    <div class="logo">
        <a class="navbar-brand" id="brand" href="">
            S c a l e
        </a>
    </div>
    <div class="pt-2" id="nav-item">
        <ul class="d-flex">
            <li class="Home mx-3">
                <a href="/User">Home</a>
            </li>
            <li class="Collections mx-3">
                <a class="" href="" onclick="event.preventDefault()">Collections
                    <ul class="sub-menu" id="font-style">
                        <a href="<?= base_url('User/index?tipe=Dress'); ?>">
                            Dress
                        </a>
                        <a href="<?= base_url('User/index?tipe=Baju'); ?>">
                            Baju
                        </a>
                        <a href="<?= base_url('User/index?tipe=Celana'); ?>">
                            Celana
                        </a>
                        <a href="<?= base_url('User/index?tipe=Aksesoris'); ?>">
                            Aksesoris
                        </a>
                    </ul>
                </a>
            </li>
            <li class="Contact mx-3">
                <a href="/Admin/create">Contact</a>
            </li>
            <li class="About mx-3">
                <a href="/Admin/create">About Us</a>
            </li>
            <li class="cartLink mx-3">
                <a href="<?= base_url('user/keranjang'); ?>">Keranjang</a>
            </li>
            <li class="logoutLink mx-3">
                <a href="<?= base_url('Auth/logout'); ?>">Logout</a>
            </li>
        </ul>
    </div>
    <div class="tools d-flex">
            <div class="searchKey">
                <label for="keyword"><i class="fas fa-search"></i></label>
                <input type="text" id="keyword" placeholder="search">        
            </div>
            <span href="" class="search-toggle">Search
                <i class="fas fa-search">
                    <div class="search">
                        <form action="<?= base_url('User/index'); ?>" method="get" id="search">
                            <label for=""><i class="fas fa-search"></i></label>
                            <input type="text" placeholder=" " id="key" name="key">
                            <input type="submit" hidden>
                        </form>
                    </div>
                </i>
            </span>
            <a href="<?= base_url('user/keranjang'); ?>" class="cart-icon"><i class="fas fa-shopping-cart"></i></a>
        <div class="hamburgerMenu">
            <input type="checkbox">
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#keyword').keyup(function(){
            if(event.keyCode == 13){
                let key = $(this).val();
                console.log($(this).val());

                $.ajax({
                    url : '<?= base_url('User/index')?>',
                    success : function(){
                        window.location = '<?= base_url()?>' + '/User/index?key='+key;
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError)
                    }
                    
                })
            }
        })
        // toogle nav-item
        $('.hamburgerMenu input').click(function(){
            if($(this).is(':checked')){
                $('#nav-item').toggleClass('toggle');
            }else{
                $('#nav-item').removeClass('toggle');
            }
        })
    })
</script>
<!-- </nav> -->