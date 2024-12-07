<?= $this->extend("layouts/default") ?>
<?= $this->section("title") ?> <?= $StoredText['ScreenTitle'] ?> <?= $this->endSection() ?>
<?= $this->section("header") ?> <?= $StoredText['Header'] ?> <?= $this->endSection() ?>
<?= $this->section("scripts") ?> 
<script type="text/javascript" charset="utf8" src="<?= base_url('assets/js/account/create.js') ?>"></script>
<script type="text/javascript" charset="utf8" src="<?= base_url('assets/js/common_modules/pagination.js') ?>"></script>

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
                        <!-- <h3>New Account Creation</h3> -->
                        <div class="form">
                            <div class="mb-3 d-flex row">
                                <div class="col-6 mb-3">
                                    <div class="form-floating">
                                        <select class="form-select account-group-list" name="account-group-list" id="account-group-list">
                                            <?php foreach($accountGroupDetails as $key => $accountGroup){ ?>
                                                <option class="<?= $accountGroup['AccountGroupSessionID']?>" value="<?= $accountGroup['AccountGroupSessionID']?>"><?= $accountGroup['AccountGroupName'] ?></option>
                                            <?php } ?>
                                        </select>
                                        <label for="account-group-list" class="form-label">Account Group:</label>
                                    </div>
                                </div>
                                <div class="col-6 mb-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" placeholder="Enter the transaction information" name="account-name" id="account-name">
                                        <label for="account-name">Enter Account Name</label>
                                        
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" placeholder="Enter the current amount" name="amount" id="amount">
                                        <label for="amount">Current Amount</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <p class="error-message">&nbsp;</p>
                            </div>
                        </div>
                        <div class="mb-3 justify-content-center ">
                            <a id="create-account-btn" class="btn btn-primary">Create Account</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>