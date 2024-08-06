<?= $this->extend("layouts/merchent") ?>
<script type="text/javascript" charset="utf8" src="<?= base_url('assets/js/addnewpromo.js') ?>"></script>
<?= $this->section("content") ?>
    <div class="add-new-promotion">
        <h1 class="title head-size-1"><?= $StoredText['AddModPromoTitle'] ?></h1>
        <form class="form-inputs" action="<?= base_url($StoredText['AddModPromoFormLnk']) ?>" method="post">
            <?php if(isset($PromoDetails['PromotionID'])){ ?>
            <div class="form-floating">
                <input type="text" class="form-control" id="promo-id" name="promo-id" value="<?= $PromoDetails['PromotionID'] ?>" require>
                <label for="promo-name"><?= $StoredText['AddModPromoPromID'] ?></label>
            </div>
            <?php } ?>
            <div class="form-floating">
                <input type="text" class="form-control" id="promo-name" name="promo-name" placeholder="<?= $StoredText['AddModPromoName'] ?>" value="<?= $PromoDetails['Name'] ?>" require>
                <label for="promo-name"><?= $StoredText['AddModPromoName'] ?></label>
            </div>
            <div class="form-floating">
                <textarea class="form-control" id="promo-desc" name="promo-desc" placeholder="<?= $StoredText['AddModPromoPlcDes'] ?>" style="height: auto"><?= $PromoDetails['Description'] ?></textarea>
                <label for="promo-desc"><?= $StoredText['AddModPromoDesc'] ?></label>
            </div>
            <div class="form-floating">
                <textarea class="form-control" id="promo-terms" name="promo-terms" placeholder="<?= $StoredText['AddModPromoPlcTerm'] ?>" style="height: auto"><?= $PromoDetails['TermsConditions'] ?></textarea>
                <label for="promo-terms"><?= $StoredText['AddModPromoTerm'] ?></label>
            </div>
            <div class="form-floating">
                <select class="form-select" id="discounttype" name="discounttype">
                    <option value="amount" <?php if($PromoDetails['DiscountType'] == 'Amount'){ echo 'selected'; } ?> ><?= $StoredText['AddModPromoDisTp1'] ?></option>
                    <option value="rate" <?php if($PromoDetails['DiscountType'] == 'Rate'){ echo 'selected'; } ?> ><?= $StoredText['AddModPromoDisTp2'] ?></option>
                </select>
                <label for="discounttype" class="form-label"><?= $StoredText['AddModPromoDisType'] ?></label>
            </div>
            <div class="form-floating">
                <input type="number" class="form-control" id="discountval" name="discountval" value="<?= $PromoDetails['DiscountValue'] ?>">
                <label for="discountval"><?= $StoredText['AddModPromoDisVal'] ?></label>
            </div>
            <div class="form-floating">
                <input type="date" class="form-control" id="sdate" name="sdate" value="<?= $PromoDetails['StartDate'] ?>" require>
                <label for="sdate"><?= $StoredText['AddModPromoActDte'] ?></label>
            </div>
            <div class="form-floating">
                <input type="date" class="form-control" id="edate" name="edate" value="<?= $PromoDetails['EndDate'] ?>" require>
                <label for="edate"><?= $StoredText['AddModPromoEndDte'] ?></label>
            </div>
            <div class="form-floating">
                <input type="number" class="form-control" id="minval" name="minval" value="<?= $PromoDetails['MinimumValue'] ?>">
                <label for="minval"><?= $StoredText['AddModPromoMinVal'] ?></label>
            </div>
            <div class="form-floating">
                <input type="number" class="form-control" id="maxval" name="maxval" value="<?= $PromoDetails['MaximumValue'] ?>">
                <label for="maxval"><?= $StoredText['AddModPromoMaxVal'] ?></label>
            </div>
            <div class="form-floating">
                <input type="url" class="form-control" id="urllink" name="urllink" placeholder="<?= $StoredText['AddModPromoPlcURL'] ?>" value="<?= $PromoDetails['Link'] ?>">
                <label for="urllink"><?= $StoredText['AddModPromoURLLnk'] ?></label>
            </div>
            <div class="mb-3">
                <input type="file" class="form-control" id="imgfile" name="imgfile" value="<?= $PromoDetails['PhotoName'] ?>" onchange="preview()">
                <img id="imgframe" src="<?= base_url($PromoDetails['Photo']) ?>" alt="image File missing" class="img-fluid" width="100%"/>
            </div>
            <div class="text-center mb-3">
                <button type="submit" class="btn btn-submit"><?= $StoredText['AddModPromoBtnSub'] ?></button>
                <button type="reset" class="btn btn-reset"><?= $StoredText['AddModPromoBtnRst'] ?></button>
            </div>
            <script>
                function preview() {
                    imgframe.src = URL.createObjectURL(event.target.files[0]);
                }
            </script>
        </form>
    </div>
<?= $this->endSection() ?>
 