<?= $this->extend("layouts/merchent") ?>
<?= $this->section("content") ?>
    <div class="our-promotion">
        <h1 class="title m-5 head-type-1"><?= $StoredText['OurPromoTitle'] ?></h1>
        <div class="container">
            <?php foreach ($PromoDetails as $Promotion) { ?>
                <a href="<?= base_url('promo-detail/'.$Promotion['PromotionID']) ?>">
                    <div class="card mb-5 bg-shadow">
                        <div class="row m-0">
                            <div class="col-lg-2 p-0">
                                <img src="<?= base_url($Promotion['Photo']) ?>" alt="" width="100%" height="200px">
                            </div>
                            <div class="col-lg-2 py-3">
                                <div>
                                    <p class="text-type-1 text-center font-weight-600 font-color-1">Initated Date</p>
                                    <p class="text-type-2 text-center"><?= $Promotion['StartDate'] ?></p>
                                </div>
                                <div>
                                    <p class="text-type-1 text-center font-weight-600 font-color-1">Active Date</p>
                                    <p class="text-type-2 text-center"><?= $Promotion['EndDate'] ?></p>
                                </div>
                            </div>
                            <div class="col-lg-8 mt-2 px-5">
                                <h3 class="text-type-1 font-weight-900 py-3 font-color-1"><?= $Promotion['Name'] ?></h3>
                                <p class="text-type-2"><?= $Promotion['Description'] ?> </p>
                            </div>
                        </div>
                    </div>
                </a>
            <?php } ?>
        </div>
    </div>
<?= $this->endSection() ?>
