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
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th>Account Name</th>
                                    <th>Running Balance</th>
                                </tr>
                                </thead>
                                <?php foreach($accountInfo as $account){ ?>
                                    <tbody>
                                        <tr class="t-row-action" account="<? $account['AccountSessionID']?>">
                                            <td><?= $account['AccountName'] ?></td>
                                            <td><?= number_format($account['AccountCurrentBalance'],2) ?></td>
                                        </tr>
                                    </tbody>
                                <?php } ?>
                            </table>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>