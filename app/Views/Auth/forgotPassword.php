<?= $this->extend('/layout/template_Auth'); ?>
<?= $this->section('content'); ?>


<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-lg-7">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">insert your email</h1>
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
                                <form class="user" method="POST" action="/Auth/getEmail">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user <?= $validation->hasError('email') ? 'is-invalid' : ''; ?>" id="email" aria-describedby="emailHelp" name="email" placeholder="Email Address..." value="<?= old('email'); ?>">
                                        <div id="validationServer03Feedback" class="invalid-feedback">
                                            <?= $validation->getError('email'); ?>
                                        </div>
                                    </div>
                                    <hr>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        send email
                                    </button>
                                </form>
                                <div class="text-center mt-3">
                                    <a class="small" href="/auth"> Back to Login</a>
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