<script type="text/javascript" charset="utf8" src="<?= base_url('assets/js/common_modules/pagination.js') ?>"></script>
<div class="mb-3 w-100 bg-shadow p-3">
    <h3 class="text-center font-color-3"><?= $Info['Title'] ?></h3>
</div>
<div class="table-responsive">
    <table class="table table-striped table-bordered" id="transaction-summary-table">
        <thead>
            <tr>
                <th class="text-center"><?= $Info['Feild'] ?></th>
                <th class="text-center">Total Income</th>
                <th class="text-center">Total Expense</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($Data as $key => $summary) { ?>
                <tr>
                    <td><?= $summary['Name'] ?></td>
                    <td class="text-end font-income"><?= number_format($summary['Income'], 2) ?></td>
                    <td class="text-end font-expense"><?= number_format($summary['Expense'],2) ?></td>
                </tr>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <th class="text-type-1 font-weight-900">Total</th>
                <th class="text-end font-income"><?= number_format($Info['TotalIncome'], 2) ?></th>
                <th class="text-end font-expense"><?= number_format($Info['TotalExpense'],2) ?></th>
            </tr>
        </tfoot>
    </table>
    <p class="mb-3">* Note that the <?= $Info['Feild'] ?> only shows the date range selected, access <?= $Info['Feild'] ?>.</p>
</div>
