<?php

namespace App\Controllers;
use DateTime;

class AccountService extends MainService
{
    public function getAccountName($userID, $accountID)
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

    // Active Account List Access of the User ID
    public function activeAccountListAccess($userID, $accountID = '')
    {
        $condtionList = ['UserSessionID' => $userID, 'AccountStatus' => 'A'];
        $feildList = ['AccountSessionID','AccountName','AccountCurrentBalance'];
        $organizerList = [];

        if($accountID != ''){
            $condtionList['AccountSessionID'] = $accountID;
        }

        if($this->limit != 0){
            $organizerList['limit'] = $this->limit;
        }

        // TODO:: User Session ID need to be handled from user login
        $response = $this->getDatafromDB(
                        ['account'], 
                        $condtionList,
                        $feildList,
                        $organizerList
                    );

        return $response;
    }

    // Active Transaction List Access of the User ID
    public function activeTransactionListAccess($userID, $accountID = '')
    {
        $condtionList = ['UserSessionID' => $userID, 'AccountStatus' => 'A', 'TransactionStatus' => 'A'];
        $feildList = ['AccountName','TransactionDescription','TransactionDate','TransactionAmount','TransactionPayableType','AccountCurrentBalance'];
        $organizerList = ['orderBy' => ['TransactionCreatedDateTime' => 'DESC', 'TransactionID' => 'DESC']];

        if($accountID != ''){
            $condtionList['AccountSessionID'] = $accountID;
        }

        if($this->limit != 0){
            $organizerList['limit'] = $this->limit;
        }

        // TODO:: User Session ID need to be handled from user login
        $response = $this->getDatafromDB(
                        ['account','transaction'], 
                        $condtionList,
                        $feildList,
                        $organizerList
                    );

        return $response;
    }

    public function getAccountCurrentBalance($userID, $accountID)
    {
        $getAccountDetails = $this->activeAccountListAccess($userID, $accountID);

        if(isset($getAccountDetails['error_id']))
        {
            return $getAccountDetails;
        }

        return $getAccountDetails['AccountCurrentBalance'];
    }

    public function transactionInitProccess($userID, $description, $amount, $type, $accountID, $budgetID)
    {
        $createTransactionData = [
                            'TransactionDescription' => $description,
                            'TransactionAmount' => $amount,
                            'TransactionPayableType' => $type,
                            'AccountSessionID' => $accountID,
                            'TransactionDate' => date_format(new DateTime('now'),'Y-m-d'),
                            'TransactionCreatedDateTime' => strtotime(date_format(new DateTime(),'Y-m-d h:i:s')),
                            'TransactionUpdatedDateTime' => strtotime(date_format(new DateTime(),'Y-m-d h:i:s')),
                            'BudgetSessionID' => $budgetID
                        ];
        
        $newTransation = $this->insertDatatoDB('transaction', 
                    $createTransactionData
                    );


        if(isset($newTransation['error_id'])){
            return $newTransation;
        }

        // TODO:: link user default user
        $currentAccountBalance =  $this->getAccountCurrentBalance($userID, $accountID);

        if(isset($currentAccountBalance['error_id'])){
            return $currentAccountBalance;
        }

        // TODO:: error handle
        if($type == 'expense' && $currentAccountBalance < $amount)
        {
            return;
        }

        $currentAccountBalance = ($type == 'expense') ? ($currentAccountBalance - $amount) : ($currentAccountBalance + $amount);

        $userUpdated = $this->updateDBData('account', ['UserSessionID' => $userID, 'AccountSessionID' => $accountID], ['AccountCurrentBalance' => $currentAccountBalance]);

        if(isset($userUpdated['error_id'])){
            return $userUpdated;
        }

        return ['createTransactionData' => $createTransactionData, 'currentAccountBalance' => $currentAccountBalance];
    }
    // ... (Inside your controller)
}
