 <script type="text/javascript" charset="utf8" src="<?= base_url('assets/js/transaction/dued.js') ?>"></script>
<div class="mb-3 transaction-type-list d-none" id="dued">
    <!-- <h3 class="mb-5">Income Transaction</h3> -->
    <div class="form">
        <div class="mb-3 d-flex row">
            <div class="col-12 mb-3" id="description-input">
                <div class="form-floating">
                    <input type="text" class="form-control" placeholder="Enter the transaction information" name="description" id="description">
                    <label for="description">Description</label>
                </div>
            </div>
            <div class="col-6">
                <div class="form-floating">
                    <input type="text" class="form-control" placeholder="Enter the amount" name="amount" id="amount" disabled>
                    <label for="amount">Enter an Amount</label>
                </div>
            </div>
            <div class="col-6">
                <div class="form-floating">
                    <select class="form-select current-account-list" name="current-account-list" id="current-account-list">
                        <?php foreach($accountInfo['accounts'] as $key => $account){ ?>
                            <option class="<?= $account['AccountSessionID']?> <?php if($key == 1){echo 'd-none';} ?>" value="<?= $account['AccountSessionID']?>" data-running-balance="<?= number_format($account['AccountCurrentBalance'],2)?>"><?= $account['AccountName'] ?></option>
                        <?php } ?>
                    </select>
                    <label for="to-account-list" class="form-label">Current Account:</label>
                </div>
                <input type="text" class="form-control" name="current-running-balance" id="current-running-balance" value="<?= number_format($accountInfo['accounts'][0]['AccountCurrentBalance'],2)?>" readonly>
            </div>
            <div class="col-6 mb-3">
                <div class="form-floating">
                    <select class="form-select budget-list" name="budget-list" id="budget-list">
                        <?php foreach($budgetInfo as $key => $budget){ ?>
                            <option class="<?= $budget['BudgetSessionID']?>" value="<?= $budget['BudgetSessionID']?>"><?= $budget['BudgetName'] ?></option>
                        <?php } ?>
                    </select>
                    <label for="from-account-list" class="form-label">Budget Handle:</label>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-3 justify-content-center">
        <a id="payment-btn" class="btn btn-primary">Make Payment</a>
    </div>
    <div class="form">
        <div class="mb-3 d-flex row">
            <div class="col-12 mb-3">
                <div id="item-list">
                    <table class="table table-striped mb-3" id="dataTable">
                        <thead>
                            <tr>
                                <th>Dued Date</th>
                                <th>Payment Plan ID</th>
                                <th>Dued Amount</th>
                                <th>Settled Amount</th>
                                <th>Remaining</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($unpaidList[0])){ 
                                foreach($unpaidList as $key => $payment){
                                    if(isset($payment['PayableList'][0])){
                                        foreach($payment['PayableList'] as $key => $due){ ?>
                                        <tr>
                                            <td><?= $due['PayableDueDate'] ?></td>
                                            <td><?= $payment['PaymentPlanSessionID'] ?></td>
                                            <td><?= number_format($due['PayableDueAmount'],2) ?></td>
                                            <td><?= number_format($due['PayablePaidAmount'],2) ?></td>
                                            <td><?= number_format($due['PayableDueAmount'] - $due['PayablePaidAmount'],2) ?></td>
                                            <td>
                                                <input class="form-check-input payment-check" type="checkbox" id="<?= $due['PayableSessionID'] ?>" name="payment-this" value="<?= $due['PayableDueAmount'] - $due['PayablePaidAmount'] ?>">
                                            </td>
                                        </tr>
                            <?php       }
                                        }
                                    }
                                } ?>
                            <!-- Rows will be added here dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-3 justify-content-center">
        <a id="payment-btn" class="btn btn-primary">Make Payment</a>
    </div>
</div>