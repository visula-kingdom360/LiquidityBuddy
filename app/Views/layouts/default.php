<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection("title") ?></title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= base_url('assets/css/default.css') ?>">
    <?= $this->renderSection("styles") ?>

    <!-- Bootstrap 5 JS Bundle -->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="<?= base_url('assets/js/default.js') ?>"></script>
    <?= $this->renderSection("scripts") ?>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= $Head['Link'] ?>"><?= $Head['Title'] ?></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav me-auto menu-item-list">
                    <?php foreach ($Head['MainList'] as $main_list_key => $value) : ?>
                        <?php if($value['Link'] == '') { ?>
                            <li class="nav-item dropdown">
                                <a class="<?php if($CurrentID == $value['ID']) { echo 'active'; } else { echo ''; } ?> nav-link dropdown-toggle" id="account-list" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?= $value['Title'] ?>
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    <?php foreach($value['SubMenu'] as $sub_menu_key => $account){ ?>
                                        <li><a class="<?php if($CurrentID == $value['ID']) { echo 'active'; } else { echo ''; } ?> dropdown-item" href="#"><?= $account['AccountName'] ?></a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                        <?php }else { ?>
                        <li class="nav-item">
                            <a class="nav-link" id="<?= $value['ID'] ?>" href="<?= $value['Link'] ?>"><?= $value['Title'] ?></a>
                        </li>
                        <?php } ?>
                    <?php endforeach; ?>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="account-list" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?= $Head['Profile']['Title'] ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="account-list">
                        <?php foreach($Head['Profile']['SubMenu'] as $key => $profile) { ?>
                        <li><a class="dropdown-item" href="<?= $profile['Link'] ?>"><?= $profile['Title'] ?></a></li>
                        <?php } ?>
                    </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-fluid mb-5 text-center">
        <div class="head-type-4 bg-menu-pannel py-2"><?= $this->renderSection("header") ?></div>
    </div>
    <?= $this->renderSection("content") ?>
</body>
</html>