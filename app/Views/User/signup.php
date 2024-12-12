<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <link rel="stylesheet" href="<?= base_url('assets/css/default.css') ?>">
        <link rel="stylesheet" href="<?= base_url('assets/css/login.css') ?>">
        <script type="text/javascript" charset="utf8" src="<?= base_url('assets/js/login.js') ?>"></script>
        <title><?= $StoredText['ScreenTitle'] ?></title>
    </head>
    <body>
        <div class="container mx-md-auto">
        <div class="row d-flex justify-content-center">
            <?php
                if(session()->getFlashdata('status'))
                {
            ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    <strong class="me-auto"><?= $StoredText['ErrorStatus'] ?></strong>
                    <p><?= session()->getFlashdata('status') ?></p>
                </div>
            <?php
                }
            ?>
            <div class="col-12 login-width mx-md-5">
                <div class="head-type-3 text-center mb-4">
                    <?= $StoredText['Header'] ?>
                </div>
                <form action="<?= base_url('/user/signup-validation') ?>" method="post">
                    <div class="mb-3">
                        <div class="form-floating mb-3 mt-3">
                            <input type="text" class="form-control" id="fname" placeholder="<?= $StoredText['FirstNamePlaceholder'] ?>" name="fname" required>
                            <label class="text-type-1" for="fname"><?= $StoredText['FirstNameLabel'] ?></label>
                        </div>
                        <div class="form-floating mb-3 mt-3">
                            <input type="text" class="form-control" id="lname" placeholder="<?= $StoredText['LastNamePlaceholder'] ?>" name="lname" required>
                            <label class="text-type-1" for="lname"><?= $StoredText['LastNameLabel'] ?></label>
                        </div>
                        <div class="form-floating mb-3 mt-3">
                            <input type="text" class="form-control" id="email" placeholder="<?= $StoredText['EmailPlaceholder'] ?>" name="email" required>
                            <label class="text-type-1" for="email"><?= $StoredText['EmailLabel'] ?></label>
                        </div>
                        <div class="form-floating mt-3 mb-3">
                            <input type="password" class="form-control" id="password" placeholder="<?= $StoredText['PasswordPlaceholder'] ?>" name="password" minlength="8" required>
                            <label class="text-type-1" for="password"><?= $StoredText['PasswordLabel'] ?></label>
                        </div>
                        <div class="form-floating mt-3 mb-3">
                            <input type="password" class="form-control" id="repassword" placeholder="<?= $StoredText['RePasswordPlaceholder'] ?>" name="repassword" minlength="8" required>
                            <label class="text-type-1" for="repassword"><?= $StoredText['RePasswordLabel'] ?></label>
                        </div>
                    </div>
                    <div class="text-center my-4">
                        OR
                    </div>
                    <div>
                        <a class="btn info w-100 mb-3 py-3 text-type-1" href="<?php echo base_url('google-login'); ?>">
                            <img class="image-25" src="<?= base_url($StoredText['GoogleIcon']) ?>" alt="">
                            Sign in with Google
                        </a>
                    </div>
                    <div>
                        <button class="btn btn-primary py-3 w-100 mb-3 text-type-1" id="login-request" type="submit"><?= $StoredText['SignupButton'] ?></button>
                    </div>
                    <div>
                        <p class="text-center text-type-1"><?= $StoredText['LoginPara'] ?> <a href="<?= $StoredText['LoginLink'] ?>"><?= $StoredText['LoginAnchor'] ?></a></p>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </body>
</html>