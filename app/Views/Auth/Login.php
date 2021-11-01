<?= $this->extend('/layout/template_Auth'); ?>
<?= $this->section('content'); ?>


<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-lg-6">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row " style="height: 80vh;">
                        <div class="col-lg">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-5">Login page</h1>
                                </div>
                                <?php if (session()->getflashdata('message')) : ?>
                                    <div class="alert alert-success" role="alert">
                                        <?= session()->getflashdata('message'); ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (session()->getflashdata('message1')) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?= session()->getflashdata('message1'); ?>
                                    </div>
                                <?php endif; ?>
                                <form class="user" method="POST" action="/Auth/Login">
                                    <div class="form-group mb-4" style="position: relative;">
                                        <input type="text" class="form-control form-control-user <?= $validation->hasError('email') ? 'is-invalid' : ''; ?>" id="email" aria-describedby="emailHelp" name="email" placeholder=" " value="<?= old('email'); ?>">
                                        <i class="fas fa-envelope"></i>
                                        <label for="email" id="for_email">Email</label>
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            <?= $validation->getError('email'); ?>
                                        </div>
                                    </div>
                                    <div class="form-group mb-4" style="position: relative;">
                                        <input type="password" class="form-control form-control-user <?= $validation->hasError('password') ? 'is-invalid' : ''; ?>" id="password" name="password" placeholder=" ">
                                        <i class="fas fa-lock"></i>
                                        <label for="password" id="for_password">Password</label>
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            <?= $validation->getError('password'); ?>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Login
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="/Auth/forgotPassword">Forgot Password?</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="/Auth/Registration">Create an Account!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<?= $this->endSection(); ?>