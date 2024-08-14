<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <link rel="stylesheet" href="<?= base_url('assets/css/default.css') ?>">
        <!-- <script type="text/javascript" charset="utf8" src="<?= base_url('assets/js/default.js') ?>"></script> -->
        <script type="text/javascript" charset="utf8" src="<?= base_url('assets/js/account/list.js') ?>"></script>
        <title><?= $StoredText['ScreenTitle'] ?></title>
    </head>
    <body>
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
                    <h1 class="head-type-1"><?= $StoredText['Header'] ?></h1>
                    <div class="col-6">
                        <div class="d-flex justify-content-between mb-3">
                            <h3>Account Details</h3>
                            <a href="" class="btn btn-primary ml-5">Add New Account</a>
                        </div>
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
                        <div class="mb-3">
                            <ul class="nav nav-tabs">
                                <li class="nav-item"><a class="nav-link active select-transction-type" href="#Purchase" transaction-type="purchase">Purchases</a></li>
                                <li class="nav-item"><a class="nav-link select-transction-type" href="#Internal" transaction-type="internal">Internal Transactions</a></li>
                                <li class="nav-item"><a class="nav-link select-transction-type" href="#External" transaction-type="external">External Transactions</a></li>
                                <li class="nav-item"><a class="nav-link select-transction-type" href="#Income" transaction-type="income">Incomes</a></li>
                            </ul>
                        </div>
                        <div class="mb-3 transaction-type-list d-none" id="internal">
                            <h3>Internal Transaction</h3>
                            <div class="form">
                                <div class="mb-3 d-flex row">
                                    <!-- <div class="col-12">
                                        <input type="text" class="form-control" placeholder="Enter the transaction information" name="description" id="description">
                                    </div> -->
                                    <div class="col-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" placeholder="Enter the amount" name="amount" id="amount">
                                            <label for="amount">Enter an Amount</label>
                                        </div>
                                        <div class="form-floating">
                                            <select class="form-select justify-content-center" name="transaction-type" id="transaction-type">
                                                <option value="income">Income</option>
                                                <option value="expense">Expense</option>
                                            </select>
                                            <label for="sel1" class="form-label">Income or Expense:</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating">
                                            <select class="form-select to-account-list" name="to-account-list" id="to-account-list">
                                                <?php foreach($bugdetInfo as $key => $budget){ ?>
                                                    <option class="<?= $budget['BudgetSessionID']?>" value="<?= $budget['BudgetSessionID']?>"><?= $budget['BudgetName'] ?></option>
                                                <?php } ?>
                                            </select>
                                            <label for="from-account-list" class="form-label">Budget Handle:</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating">
                                            <select class="form-select current-account-list" name="current-account-list" id="current-account-list">
                                                <?php foreach($accountInfo as $key => $account){ ?>
                                                    <option class="<?= $account['AccountSessionID']?>" value="<?= $account['AccountSessionID']?>" data-running-balance="<?= number_format($account['AccountCurrentBalance'],2)?>"><?= $account['AccountName'] ?></option>
                                                <?php } ?>
                                            </select>
                                            <label for="to-account-list" class="form-label">Current Account:</label>
                                        </div>
                                        <input type="text" class="form-control" name="current-running-balance" id="current-running-balance" value="<?= number_format($accountInfo[0]['AccountCurrentBalance'],2)?>" readonly>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating">
                                            <select class="form-select to-account-list" name="to-account-list" id="to-account-list">
                                                <?php foreach($accountInfo as $key => $account){ ?>
                                                    <option class="<?= $account['AccountSessionID']?> <?php if($key == 0){echo 'd-none';} ?>" value="<?= $account['AccountSessionID']?>" data-running-balance="<?= number_format($account['AccountCurrentBalance'],2)?>" <?php if($key == 1){echo 'selected';} ?>><?= $account['AccountName'] ?></option>
                                                <?php } ?>
                                            </select>
                                            <label for="from-account-list" class="form-label">Transfer to Account:</label>
                                        </div>
                                        <input type="text" class="form-control" name="to-running-balance" id="to-running-balance" value="<?= number_format($accountInfo[1]['AccountCurrentBalance'],2)?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 justify-content-center">
                                <a id="transferred" class="btn btn-primary">Transferred</a>
                            </div>
                        </div>
                        <!-- <div class="mb-3">
                            <h3>Create Transaction</h3>
                            <div class="form">
                                <div class="mb-3">
                                    <input type="text" class="form-control" placeholder="Enter the transaction information" name="description" id="description">
                                </div>
                                <div class="mb-3 d-flex row">
                                    <div class="col-6">
                                        <input type="text" class="form-control" placeholder="Enter the amount" name="amount" id="amount">
                                        <select class="form-select justify-content-center" name="transaction-type" id="transaction-type">
                                            <option value="income">Income</option>
                                            <option value="expense">Expense</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <select class="form-select" name="account-list" id="account-list">
                                            <?php foreach($accountInfo as $key => $account){ ?>
                                                <option value="<?= $account['AccountSessionID']?>" data-running-balance="<?= number_format($account['AccountCurrentBalance'],2)?>"><?= $account['AccountName'] ?></option>
                                            <?php } ?>
                                        </select>
                                        <input type="text" class="form-control" name="running-balance" id="running-balance" value="<?= number_format($accountInfo[0]['AccountCurrentBalance'],2)?>" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3 justify-content-center">
                                <a id="create-transaction" class="btn btn-primary">Create Transaction</a>
                            </div>
                        </div> -->
                    </div>
                    <div class="col-6">
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
    </body>
</html>