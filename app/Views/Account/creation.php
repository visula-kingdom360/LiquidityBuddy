<?= $this->extend("layouts/default") ?>
<?= $this->section("title") ?> <?= $StoredText['ScreenTitle'] ?> <?= $this->endSection() ?>
<?= $this->section("header") ?> <?= $StoredText['Header'] ?> <?= $this->endSection() ?>
<?= $this->section("scripts") ?> 
    <script type="text/javascript" charset="utf8" src="<?= base_url('assets/js/account/create.js') ?>"></script>
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
                    <table class="table table-striped mb-3">
                        <thead>
                        <tr>
                            <th>Account Name</th>
                            <th>Running Balance</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php foreach($accountInfo['accounts'] as $key => $account){ 
                                $currentPage = ceil(($key + 1) / $accountInfo['page-limit']);
                                ?>
                            
                                <tr class="t-row-acount-action <?php if(($key + 1) > $accountInfo['page-limit']){echo 'd-none';}?>" data-page-no="account-page-no-<?= $currentPage?>" account="<?= $account['AccountSessionID']?>">
                                    <td><?= $account['AccountName'] ?></td>
                                    <td class="text-end"><?= number_format($account['AccountCurrentBalance'],2) ?></td>
                                </tr>
                            <?php } ?>                        
                        </tbody>
                    </table>
                    <?php if($accountInfo['page-count'] > 1){ ?>
                        <ul class="pagination">
                            <li class="page-item disabled" disabled=true><a class="page-link previous-page" href="#">Previous</a></li>
                                <?php for ($page=1; $page < ($accountInfo['page-count'] + 1); $page++) {  ?>
                                    <li class="page-item <?php if($page == 1){echo 'active first';}elseif($page == ($accountInfo['page-count'])){echo 'last';}?>"><a class="page-link page-list" href="#" id="account-page-no-<?= $page ?>"><?= $page ?></a></li>
                                <?php } ?>
                            <li class="page-item"><a class="page-link next-page" href="#">Next</a></li>
                        </ul>
                    <?php } ?>
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