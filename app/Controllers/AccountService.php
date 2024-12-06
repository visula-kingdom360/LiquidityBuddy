<?php

namespace App\Controllers;
use DateTime;

class AccountService extends MainService
{
    public function getAccountSessionID($ID)
    {

        $condtionList = ['AccountID' => $ID, 'AccountStatus' => 'A'];
        $feildList = ['AccountSessionID'];

        // TODO:: User Session ID need to be handled from user login
        $response = $this->getDatafromDB(
                        ['account'], 
                        $condtionList,
                        $feildList
                    );

        if(isset($response['error_id']))
        {
            return $response;
        }

        return $response;
    }

    public function getAccountName($userID, $accountID)
    {
        $getAccountDetails = $this->activeAccountListAccessModule($userID, $accountID);

        if(isset($getAccountDetails['error_id']))
        {
            return $getAccountDetails;
        }

        return $getAccountDetails['AccountName'];
    }

    // Active Account List Access of the User ID
    public function activeAccountGroupsListAccessModule($userID, $accountgroupID = '')
    {
        $condtionList = ['UserSessionID' => $userID, 'AccountGroupStatus' => 'A'];
        $feildList = ['AccountGroupSessionID','AccountGroupName'];
        $organizerList = [];

        if($accountgroupID != ''){
            $condtionList['AccountGroupSessionID'] = $accountgroupID;
        }

        if($this->limit != 0){
            $organizerList['limit'] = $this->limit;
        }

        // TODO:: User Session ID need to be handled from user login
        $response = $this->getDatafromDB(
                        ['accountgroup'], 
                        $condtionList,
                        $feildList,
                        $organizerList
                    );

        return $response;
    }

    // Active Account List Access of the User ID
    public function activeAccountListAccessModule($userID, $accountID = '')
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

    public function getAccountCurrentBalance($userID, $accountID)
    {
        $getAccountDetails = $this->activeAccountListAccessModule($userID, $accountID);

        if(isset($getAccountDetails['error_id']))
        {
            return $getAccountDetails;
        }

        return $getAccountDetails['AccountCurrentBalance'];
    }

    public function accountInitProccess($userID, $accountName, $groupID, $amount)
    {
        $data = [
            'UserSessionID' => $userID,
            'AccountName' => $accountName,
            'AccountGroupSessionID' => $groupID,
            'AccountCurrentBalance' => 0
        ];

        // TODO:: Account Creation Process
        $response = $this->insertDatatoDB('account', $data);

        if(isset($response['error_id'])){
            return $response;
        }
        
        $response = $this->getAccountSessionID($response['id']);

        if(isset($response['error_id']))
        {
            return $response;
        }

        $accountID = $response['AccountSessionID'];
        
        $response = $this->getDefaultBudgetID($userID);

        if(isset($response['error_id']))
        {
            return $response;
        }

        $budgetID = $response['BudgetSessionID'];

        $response = $this->transactionInitProccess($userID, $accountName, $amount, 'income', $accountID, $budgetID);

        if(isset($response['error_id']))
        {
            return $response;
        }

        $response = $this->budgetUpdateProccess($userID, $budgetID, $amount);

        if(isset($response['error_id']))
        {
            return $response;
        }

        return $response;
    }

    // Active Transaction List Access of the User ID
    public function activeTransactionListAccess($userID, $accountID = '')
    {
        $condtionList = ['UserSessionID' => $userID, 'AccountStatus' => 'A', 'TransactionStatus' => 'A'];
        $feildList = ['AccountSessionID','AccountName','TransactionDescription','TransactionDate','TransactionAmount','TransactionPayableType','AccountCurrentBalance'];
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

    public function getBudgetDetails($userID, $budgetID = '')
    {
        $condtionList = ['UserSessionID' => $userID, 'BudgetStatus' => 'A'];
        $feildList = ['BudgetName','BudgetCreatedDateTime','BudgetUpdatedDateTime','BudgetAmount'];
        $organizerList = ['orderBy' => ['BudgetCreatedDateTime' => 'DESC', 'BudgetID' => 'DESC']];

        if($budgetID != ''){
            $condtionList['BudgetSessionID'] = $budgetID;
        }

        if($this->limit != 0){
            $organizerList['limit'] = $this->limit;
        }

        // TODO:: User Session ID need to be handled from user login
        $response = $this->getDatafromDB(
                        ['budget'], 
                        $condtionList,
                        $feildList,
                        $organizerList
                    );
        
        if(isset($response['error_id']))
        {
            return $response;
        }

        return $response;
    }

    public function getDefaultBudgetID($userID)
    {

        $condtionList = ['UserSessionID' => $userID, 'BudgetName' => 'Default'];
        $feildList = ['BudgetSessionID'];
        $organizerList = ['orderBy' => ['BudgetCreatedDateTime' => 'DESC', 'BudgetID' => 'DESC']];

        $response = $this->getDatafromDB(
                        ['budget'], 
                        $condtionList,
                        $feildList,
                        $organizerList
                    );
        
        if(isset($response['error_id']))
        {
            return $response;
        }
            
        return $response;
    }

    public function budgetUpdateProccess($userID, $budgetID, $amount)
    {
        $response = $this->getBudgetDetails($userID, $budgetID);

        if(isset($response['error_id']))
        {
            return $response;
        }

        $response = $this->updateDBData('budget', ['UserSessionID' => $userID, 'BudgetSessionID' => $budgetID], ['BudgetAmount' => ($amount + $response['BudgetAmount'])]);

        if(isset($response['error_id']))
        {
            return $response;
        }

        return $response;
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
