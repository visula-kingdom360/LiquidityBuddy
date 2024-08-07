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
        <!-- <script type="text/javascript" charset="utf8" src="<?= base_url('assets/js/default.js') ?>"></script> -->
        <script type="text/javascript" charset="utf8" src="<?= base_url('assets/js/login.js') ?>"></script>
        <title><?= $StoredText['ScreenTitle'] ?></title>
    </head>
    <body>
        <div class="container">
            <div class="d-flex justify-content-center">
                <div class="row">
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
                    <div class="m-3">
                        <h1 class="head-type-1"><?= $StoredText['Header'] ?></h1>
                    </div>
                    <form action="<?= base_url('login-validation') ?>" method="post">
                        <div class="mb-3">
                            <div class="text-type-1"><?= $StoredText['UsernameLabel'] ?></div>
                            <div>
                                <input type="text" id="username" name="username" class='form-control' placeholder="<?= $StoredText['UsernamePlaceholder'] ?>" required>
                            </div>
                            <div class="text-type-1"><?= $StoredText['PasswordLabel'] ?></div>
                            <div>
                                <input type="password" id="password" name="password" class='form-control' placeholder="<?= $StoredText['PasswordPlaceholder'] ?>" required>
                            </div>
                        </div>
                        <div>
                            <button class="btn btn-success text-type-2 px-5" id="login-request" type="submit"><?= $StoredText['LoginButton'] ?></button>
                            <button class="btn btn-danger text-type-2 px-5" type="reset"><?= $StoredText['RestButton'] ?></button>
                        </div>
                        <div>
                            <p><?= $StoredText['SignupPara'] ?> <a href="<?= $StoredText['SignupLink'] ?>"><?= $StoredText['SignupAnchor'] ?></a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>