<?= $this->extend('/layout/template_Auth'); ?>
<?= $this->section('content'); ?>


<div class="container">


    <div class="card o-hidden border-0 shadow-lg my-5 col-lg-7 mx-auto">
        <div class="card-body p-0">

            <div class="row">
                <div class="col-lg">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Change password</h1>
                        </div>
                        <form class="user" method="POST" action="/Auth/savePassword" enctype="multipart/form-data">
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" class="form-control form-control-user <?= ($validation->hasError('password1') ? 'is-invalid' : ''); ?>" id="password1" name="password1" placeholder="Password">
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        <?= $validation->getError('password1'); ?>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <input type="password" class="form-control form-control-user <?= ($validation->hasError('password2') ? 'is-invalid' : ''); ?>" id="password2" name="password2" placeholder="Repeat Password">
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        <?= $validation->getError('password2'); ?>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Reset Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection(); ?>