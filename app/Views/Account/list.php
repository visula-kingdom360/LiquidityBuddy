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
            </div>
            <div class="row">
                <div class="col-md-6 col-12">
                    <table class="table table-striped mb-3">
                        <thead>
                        <tr>
                            <th>Account Name</th>
                            <th>Running Balance</th>
                        </tr>
                        </thead>
                        <?php foreach($accountInfo as $key => $account){ ?>
                            <tbody>
                                <tr class="t-row-acount-action <?php if($key > 4){echo 'd-none';}?>" account="<?= $account['AccountSessionID']?>">
                                    <td><?= $account['AccountName'] ?></td>
                                    <td><?= number_format($account['AccountCurrentBalance'],2) ?></td>
                                </tr>
                            </tbody>
                        <?php } ?>
                    </table>
                </div>
                <div class="col-md-6 col-12">
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
                <div class="col-12">
                    <div class="mb-3">
                        <h3>Transaction Details</h3>
                    </div>
                    <table class="table table-striped mb-3">
                        <thead>
                        <tr>
                            <th>Description</th>
                            <th>Date</th>
                            <th>Income</th>
                            <th>Expense</th>
                            <!-- <th>Running Balance</th> -->
                            <th>Account Name</th>
                        </tr>
                        </thead>
                        <?php foreach($transactionInfo as $transaction){ ?>
                            <tbody>
                                <tr class="t-row-transaction-action" account="<? $transaction['AccountSessionID']?>">
                                    <td><?= $transaction['TransactionDescription'] ?></td>
                                    <td><?= $transaction['TransactionDate'] ?></td>
                                    <?php if($transaction['TransactionPayableType'] == 'income') { ?>
                                        <td><?= number_format($transaction['TransactionAmount'],2) ?></td>
                                        <td><?= number_format(0,2) ?></td>
                                    <?php }elseif($transaction['TransactionPayableType'] == 'expense'){ ?>
                                        <td><?= number_format(0,2) ?></td>
                                        <td><?= number_format($transaction['TransactionAmount'],2) ?></td>
                                    <?php } ?>
                                    <!-- <td><?= number_format($transaction['AccountCurrentBalance'],2) ?></td> -->
                                    <td><?= $transaction['AccountName'] ?></td>
                                </tr>
                            </tbody>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>
    <!-- </body>
</html> -->