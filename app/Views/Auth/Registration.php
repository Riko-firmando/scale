<?= $this->extend('/layout/template_Auth'); ?>
<?= $this->section('content'); ?>


<div class="container">


    <div class="card o-hidden border-0 shadow-lg my-5 col-lg-7 mx-auto">
        <div class="card-body p-0">

            <div class="row">
                <div class="col-lg">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                        </div>
                        <form class="user" method="POST" action="/Auth/Save" enctype="multipart/form-data">
                            <div class="form-group">
                                <div class="mb-3">
                                    <input type="text" class="form-control form-control-user  <?= ($validation->hasError('name')) ? 'is-invalid' : '' ?>" id="name" name="name" placeholder="Full Name" value="<?= old('name'); ?>">
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        <?= $validation->getError('name'); ?>
                                    </div>
                                </div>
                                <input type="text" class="form-control form-control-user <?= ($validation->hasError('email') ? 'is-invalid' : ''); ?>   " id="email" name="email" placeholder="Email Address" value="<?= old('email'); ?>">
                                <div id="validationServer03Feedback" class="invalid-feedback">
                                    <?= $validation->getError('email'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" class="form-control form-control-user <?= ($validation->hasError('password1') ? 'is-invalid' : ''); ?>" id="password1" name="password1" placeholder="Password">
                                    <div id="validationServer03Feedback" class="invalid-feedback">
                                        <?= $validation->getError('password1'); ?>
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <input type="password" class="form-control form-control-user" id="password2" name="password2" placeholder="Repeat Password">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Register Account
                            </button>
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="<?= base_url('Auth'); ?> ">Already have an account? Login!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<?= $this->endSection(); ?>