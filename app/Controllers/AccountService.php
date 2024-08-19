<?php

namespace App\Controllers;

class AccountService extends MainService
{
    protected function getAccountName($userID, $accountID)
    {
        $getAccountDetails = $this->activeAccountListAccess($userID, $accountID);

        // var_dump($getAccountDetails['AccountName']);
        // die;

        if(isset($getAccountDetails['error_id']))
        {
            return $getAccountDetails;
        }

        return $getAccountDetails['AccountName'];
    }
}
