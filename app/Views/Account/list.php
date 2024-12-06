<?= $this->extend("layouts/default") ?>
<?= $this->section("title") ?> <?= $StoredText['ScreenTitle'] ?> <?= $this->endSection() ?>
<?= $this->section("header") ?> <?= $StoredText['Header'] ?> <?= $this->endSection() ?>
<?= $this->section("scripts") ?> 
    <script type="text/javascript" charset="utf8" src="<?= base_url('assets/js/account/list.js') ?>"></script>
<?= $this->endSection() ?>
<?= $this->section("styles") ?>
<?= $this->endSection() ?>
<?= $this->section("content") ?>
    <div class="container">
        <div class="justify-content-center">
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
            </div>
            <div class="row">
                <div class="col-md-5 col-12">
                    <?= $account_list_content ?>
                </div>
                <div class="col-md-7 col-12">
                    <div class="mb-3">
                        <ul class="nav nav-tabs">
                            <li class="nav-item"><a class="nav-link active select-transction-type" href="#External" data-transaction-type="external">External Transactions</a></li>
                            <li class="nav-item"><a class="nav-link select-transction-type" href="#Internal" data-transaction-type="internal">Internal Transactions</a></li>
                            <li class="nav-item"><a class="nav-link select-transction-type" href="#Income" data-transaction-type="income">Incomes</a></li>
                            <li class="nav-item"><a class="nav-link select-transction-type" href="#Purchase" data-transaction-type="purchase">Purchases</a></li>
                        </ul>
                    </div>
                    <?= $external_trans_content ?>
                    <?= $internal_trans_content ?>
                    <?= $purchase_content ?>
                    <p class="error d-none" id="common-error">* Error</p>
                    <?= $other_trans_content ?>
                </div>
                <?= $transaction_details_container ?>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>