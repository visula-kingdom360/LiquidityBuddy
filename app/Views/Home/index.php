<?= $this->extend("layouts/default") ?>
<?= $this->section("title") ?> Home <?= $this->endSection() ?>
<?= $this->section("content") ?>
    <link rel="stylesheet" href="<?= base_url('assets/css/home.css') ?>">
    <script type="text/javascript" charset="utf8" src="<?= base_url('assets/js/home.js') ?>"></script>
    <div id="demo" class="carousel slide bg-default mb-5" data-bs-ride="carousel">

        <div class="search-box container bg-shadow">
            <div class="mx-auto search-list py-3">
                <div class='search-btn bg-default'>
                    <span class="text-type-1 font-weight-600"><?= $StoredText['SearchTabLocation'] ?></span> : <span class="text-type-1 font-color-3"><?= $StoredText['SearchTabValue'] ?></span>
                </div>
                <div class='search-btn bg-default'>
                    <span class="text-type-1 font-weight-600"><?= $StoredText['SearchTabPrice'] ?></span> : <span class="text-type-1 font-color-3"><?= $StoredText['SearchTabValue'] ?></span>
                </div>
                <div class='search-btn bg-default'>
                    <span class="text-type-1 font-weight-600"><?= $StoredText['SearchTabCategories'] ?></span> : <span class="text-type-1 font-color-3"><?= $StoredText['SearchTabValue'] ?></span>
                </div>
                <div class='search-btn bg-default'>
                    <span class="text-type-1 font-weight-600"><?= $StoredText['SearchTabBrand'] ?></span> : <span class="text-type-1 font-color-3"><?= $StoredText['SearchTabValue'] ?></span>
                </div>
                <div class='search-btn bg-default'>
                    <span class="text-type-1 font-weight-600"><?= $StoredText['SearchTabText'] ?></span> : <span class="text-type-1 font-color-3"><?= $StoredText['SearchTabValue'] ?></span>
                </div>
                <div class="search-link">
                    <a href=""><?= $StoredText['SearchTabRegister'] ?></a> /
                    <a href="<?= base_url('login') ?>"><?= $StoredText['SearchTabLogin'] ?></a>
                </div>
            </div>
        </div>

        <!-- Indicators/dots -->
        <div class="carousel-indicators">
        <?php for ($i=0; $i < count($LatestPromo); $i++) {   ?>
            <button type="button" data-bs-target="#demo" data-bs-slide-to="<?= $i ?>" class="<?php if($i == 0){echo 'active';} ?>"></button>
        <?php }   ?>
        </div>
        
        <!-- The slideshow/carousel -->
        <div class="carousel-inner">
        <?php foreach ($LatestPromo as $key => $PromoDet) {   ?>   
            <div class="carousel-item <?php if($key == 0){echo 'active'; } ?> ">
                <a href="<?= $PromoDet['Link'] ?>">
                    <img src="<?= base_url($PromoImgPath.$PromoDet['Photo']) ?>" alt="<?= $PromoDet['Name'] ?>" class="mx-auto d-block" height="560">
                </a>
            </div>
        <?php } ?>
        </div>
        
        <!-- Left and right controls/icons -->
        <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>

        
    </div>
    <div class="container mb-5">
        <div class="row">
        <!-- Catelog Lists -->
        <?php foreach ($CatelogList as $key => $Catleog) { ?>
            <div class="col-md-4 mb-5 mx-auto">
                <div class="mx-auto catelog-segments" style="background-image: url('<?= base_url($Catleog['Icon']) ?>');">
                <a href="<?= base_url($Catleog['Link']) ?>">
                    <div class="catelog-word bg-shadow">
                        <span class="head-type-2 m-auto"><?= $Catleog['Name'] ?></span>
                    </div>
                </a>
                </div>
            </div>
        <?php } ?>
            <div class="category-list">

            </div>
        </div>
    </div>
<?= $this->endSection() ?>
