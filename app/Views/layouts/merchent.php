<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Merchent</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="<?= base_url('assets/css/default.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/merchent.css') ?>">
    <script type="text/javascript" charset="utf8" src="<?= base_url('assets/js/merchent.js') ?>"></script>
</head>
<body class='merchent-bg'>
    <div class="bg-shadow">
        <div class="d-flex">
            <div class="img-segment my-auto mr-3">
                <img src="<?= base_url($MenuData['Logo']) ?>" alt="logo" width="100" height="100">
            </div>
            <div class="head-segment">
                <h1 class="company-name"><?= $MenuData['HeaderSection'] ?></h1>
                <p class="user-details"><?= $MenuData['UserSection'] ?> <a href=""><?= $MenuData['LogoutAnchor'] ?></a> </p>
            </div>
            <div class="merchent-menu">
                <ul>
                    <?php foreach ($MenuData['MenuList'] as $screen) { ?>
                        <li><a class="menu-link <?php if($screen['ScreenCode'] == $CurrentClass){echo 'active';} ?>" id="<?= $screen['ScreenCode'] ?>"><?= $screen['ScreenTitle'] ?></a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="merchent-body">
        <?= $this->renderSection("content") ?>
    </div>
</body>
</html>