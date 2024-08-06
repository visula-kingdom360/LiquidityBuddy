<?= $this->extend("layouts/merchent") ?>
<?= $this->section("content") ?>
    <div class="our-promotion">
        <h1 class="title m-5 head-type-1"><?= $StoredText['PromoDetTitle'] ?></h1>
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <a href="<?= $PromoDetail['Link'] ?>">
                        <img src="<?= base_url($PromoDetail['Photo']) ?>" alt="" width="300" height="450px">
                    </a>
                </div>
                <div class="col-lg-8">
                    <h1 class="head-type-3 mb-5"><?= $PromoDetail['Name'] ?></h1>
                    <p class="text-type-1"><?= $PromoDetail['Description'] ?></p>
                    <!-- <h3 class="head-type-3 mt-3 mb-2">Terms and Conditions</h3>
                    <p class="text-type-1"><?= $PromoDetail['TermsConditions'] ?></p> -->
                    <a class="" href="<?= $PromoDetail['Link'] ?>"><?= $PromoDetail['Link'] ?></a>
                    <!-- <div>
                        <span class="mr-2 font-weight-600">Active Date</span> => <span><?= $PromoDetail['StartDate'] ?></span>
                    </div>
                    <div>
                        <span class="mr-2 font-weight-600">Expire Date</span> => <span><?= $PromoDetail['EndDate'] ?></span>
                    </div>
                    <div>
                        <span class="mr-2 font-weight-600">Minimum Amount</span> => <span><?= $PromoDetail['MinimumValue'] ?></span>
                    </div>
                    <div>
                        <span class="mr-2 font-weight-600">Maximum Amount</span> => <span><?= $PromoDetail['MaximumValue'] ?></span>
                    </div>
                    <div>
                        <span class="mr-2 font-weight-600">Discount</span> => <span><?php if($PromoDetail['DiscountType'] == 'Amount'){ echo 'Rs.';} echo $PromoDetail['DiscountValue']; if($PromoDetail['DiscountType'] == 'Rate'){ echo '%';} ?></span>
                    </div> -->
                </div>

            </div>
           
        </div>
    </div>
<?= $this->endSection() ?>
