<table class="table table-striped mb-3">
    <thead>
    <tr>
        <th>Budget Name</th>
        <th>Budget Amount</th>
        <th>Budget Period</th>
    </tr>
    </thead>
    <tbody>
        <?php foreach($budgets as $key => $budget){
            $currentPage = ceil(($key + 1) / $page_limit);
            ?>
            <tr class="t-row-budget-action <?php if(($key + 1) > $page_limit){echo 'd-none';}?>" data-page-no="budget-page-no-<?= $currentPage?>" id="<?= $budget['BudgetSessionID']?>">
                <td class="budget-name"><?= $budget['BudgetName'] ?></td>
                <td class="text-end budget-amount"><?= number_format($budget['BudgetAmount'],2) ?></td>
                <td class="text-center budget-period" data-budget-period="<?= $budget['BudgetPeriodic'] ?>"><?= $payment_plan[$budget['BudgetPeriodic']] ?></td>
                <?php if($edit_mode){ ?>
                    <td class="text-center"><a data-budget-id="<?= $budget['BudgetSessionID'] ?>" class="btn btn-primary update-budget-btn">Update</a></td>
                    <td class="text-center"><a data-budget-id="<?= $budget['BudgetSessionID'] ?>"  class="btn btn-danger delete-budget-btn">Remove</a></td>
                <?php } ?>
            </tr>
        <?php } ?>
    </tbody>
</table>
<?php if($page_count > 1){ ?>
    <ul class="pagination budget" pagination-type="budget">
        <li class="page-item disabled" disabled=true><a class="page-link previous-page" href="#">Previous</a></li>
            <?php for ($page=1; $page < ($page_count + 1); $page++) {  ?>
                <li class="page-item <?php if($page == 1){echo 'active first';}elseif($page == ($page_count)){echo 'last';}?>"><a class="page-link page-list" id="budget-page-no-<?= $page ?>"><?= $page ?></a></li>
            <?php } ?>
        <li class="page-item"><a class="page-link next-page" href="#">Next</a></li>
    </ul>
<?php } ?>