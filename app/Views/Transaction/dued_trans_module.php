 <script type="text/javascript" charset="utf8" src="<?= base_url('assets/js/transaction/dued.js') ?>"></script>
<div class="mb-3 transaction-type-list d-none" id="dued">
    <!-- <h3 class="mb-5">Income Transaction</h3> -->
    <div class="form">
        <div class="mb-3 d-flex row">
            <div class="col-12 mb-3">
                <div id="item-list">
                    <table class="table table-striped mb-3" id="dataTable">
                        <thead>
                            <tr>
                                <th>Dued Date</th>
                                <th>Payment Plan</th>
                                <th>Dued Amount</th>
                                <th>Settled Amount</th>
                                <th>Remaining</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
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