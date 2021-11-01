<!-- <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Dropdown
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#">Disabled</a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>
</nav> -->
<nav class="mb-3 " id="navigasi">
    <div class="d-flex justify-content-between align-items-center">
        <div class=" logo mx-5">
            <a class="navbar-brand" id="brand" href="">
                S c a l e
            </a>
        </div>
        <div class="nav-item pt-2">
            <ul class="d-flex">
                <li class="mx-3">
                    <a class="" href="">BARANG</a>
                </li>
                <li class="mx-3">
                    <a class="" href="">PEMBELIAN</a>
                </li>
                <li class="mx-3">
                    <a href="/Admin/create">PESAN</a>
                </li>
                <li class="mx-3">
                    <a href="/Admin/create">TAMBAH</a>
                </li>
            </ul>
        </div>
        <div class="profile">
            <a class="mx-2" href=""> <?= $_SESSION['email']; ?> </a>
            <img style="border-radius: 100%; height:30px; width: 30px;" src="image/scale.png" alt="">
        </div>
    </div>
</nav>