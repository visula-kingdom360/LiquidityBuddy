<table class="table table-striped mb-3">
    <thead>
    <tr>
        <th>Account Name</th>
        <th>Running Balance</th>
    </tr>
    </thead>
    <tbody>
        <?php foreach($accounts as $key => $account){ 
            $currentPage = ceil(($key + 1) / $page_limit);
            ?>
            <tr class="t-row-account-action <?php if(($key + 1) > $page_limit){echo 'd-none';}?>" data-page-no="account-page-no-<?= $currentPage?>" account="<?= $account['AccountSessionID']?>">
                <td><?= $account['AccountName'] ?></td>
                <td class="text-end"><?= number_format($account['AccountCurrentBalance'],2) ?></td>
            </tr>
        <?php } ?>                        
    </tbody>
</table>
<?php if($page_count > 1){ ?>
    <ul class="pagination account" pagination-type="account">
        <li class="page-item disabled" disabled=true><a class="page-link previous-page" href="#">Previous</a></li>
            <?php for ($page=1; $page < ($page_count + 1); $page++) {  ?>
                <li class="page-item <?php if($page == 1){echo 'active first';}elseif($page == ($page_count)){echo 'last';}?>"><a class="page-link page-list" id="account-page-no-<?= $page ?>"><?= $page ?></a></li>
            <?php } ?>
        <li class="page-item"><a class="page-link next-page" href="#">Next</a></li>
    </ul>
<?php } ?>