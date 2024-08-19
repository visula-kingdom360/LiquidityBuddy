<?php

namespace App\Controllers;

use DateTime;

class MainService extends BlueprintService
{
    // TODO: remove the user id
    protected $user_id = '01b9ff2b173400203b74b4cbec306d6f';
    protected $limit = 0;

    protected $periodic = [
            'I' => 'Instant',
            'D' =>'Daily',
            'W' => 'Weekly',
            'M' => 'Monthly',
            'A' => 'Anually'
            // 'C' => 'Continously'
        ];

    public function encryptLogic($password, $encrypt = true)
    {
        if($encrypt){
            return MD5($password); 
        }
    }

    public function FormattedStatus($status)
    {
        // switch to handle the status
        switch ($status) {
            case 'A':
                # Active Status
                return 'Active';
            case 'D':
                # Deactive Status
                return 'Dective';
            case 'L':
                # Locked Status
                return 'Locked';
            case 'I':
                # Inactive Status
                return 'Inactive';
            case 'C':
                # Cancelled Status
                return 'Cancelled';
            default:
                # Default Status
                return 'Default';
        }
    }
    
    public function passwordFormatHandler($password)
    {
        if(strlen($password) < 8){
            return $error = [
                        'error_id' => '0014',
                        'category' => 'Format_Issue',
                        'error_category' => 'Password Length',
                        'error_message'  => 'Please enter a password length higher than 8'
                    ];
        }

        return $response = ['success' => true];

    }
 
    public function contactNoFormatHandler($contactNo)
    {
        if(strlen($contactNo) < 9){
            return $error = [
                        'error_id' => '0015',
                        'category' => 'Format_Issue',
                        'error_category' => 'Contact No Length',
                        'error_message'  => 'Contact no length should be higher than 9'
                    ];
        }

        if(strlen($contactNo) > 16){
            return $error = [
                        'error_id' => '0016',
                        'category' => 'Format_Issue',
                        'error_category' => 'Contact No Length',
                        'error_message'  => 'Contact no length should be lower than 16'
                    ];
        }

        if(!is_numeric($contactNo)){
                    return $error = [
                    'error_id' => '0017',
                    'category' => 'Format_Issue',
                    'error_category' => 'Contact No Format',
                    'error_message'  => 'Contact no cannot have string values'
                ];
        }

        return $response = ['success' => true];

    }

    public function handleRequiredParameters($parameters, $requiredFeilds)
    {
        foreach ($requiredFeilds as $feilds) {
            # code...
            if(!isset($parameters[$feilds])){
                return $error = [
                        'error_id' => '0018',
                        'category' => 'Format_Issue',
                        'error_category' => 'Required Parameters',
                        'error_message'  => 'Required parameter "'.$feilds.'" is missing, and the follow is blocked'
                    ];
            }
        }
    }

    public function imageFormat($imageFormat)
    {
        // return base64_decode($imageFormat);
        return $imageFormat;
    }
    
    public function periodicHandle($periodType)
    {
        return $this->periodic[$periodType];
    }

    public function getDaysofPeriodType($periodType)
    {
        switch ($periodType) {
            case 'D':
                # code...
                return 1;
                break;
            
            case 'W':
                # code...
                return 7;
                break;
            
            case 'M':
                # code...
                return 28;
                break;
            
            case 'A':
                # code...
                return 365;
                break;
            
            default:
                # code...
                break;
        }

    }

    // Active Budget List Access of the User ID
    protected function budgetList($userID, $budgetID = '')
    {
        $condtionList = ['UserSessionID' => $userID, 'BudgetStatus' => 'A'];
        $feildList = ['BudgetSessionID','BudgetName','BudgetPeriodic','BudgetAmount'];
        $organizerList = [];

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

        return $response;
    }

    // Active Budget List Access of the User ID
    protected function stackholderList($userID, $stackholderID = '')
    {
        $condtionList = ['UserSessionID' => $userID];
        $feildList = ['StackholderSessionID','StackholderName','StackholderRelationship'];
        $organizerList = [];

        if($stackholderID != ''){
            $condtionList['StackholderSessionID'] = $stackholderID;
        }

        if($this->limit != 0){
            $organizerList['limit'] = $this->limit;
        }

        // TODO:: User Session ID need to be handled from user login
        $response = $this->getDatafromDB(
                        ['stackholder'], 
                        $condtionList,
                        $feildList,
                        $organizerList
                    );

        return $response;
    }

    // Active User Shop List Access of the User ID
    protected function userShopList($userID, $shopID = '')
    {
        $condtionList = ['UserSessionID' => $userID];
        $feildList = ['ShopSessionID','ShopName','ShopDescription'];
        $organizerList = ['orderBy' => ['ShopAccessOrderAccessCount' => 'DESC']];
        // $organizerList = [];

        if($shopID != ''){
            $condtionList['ShopSessionID'] = $shopID;
        }

        if($this->limit != 0){
            $organizerList['limit'] = $this->limit;
        }

        // TODO:: User Session ID need to be handled from user login
        $response = $this->getDatafromDB(
                        ['shopaccessorder', 'shop'], 
                        $condtionList,
                        $feildList,
                        $organizerList
                    );

        return $response;
    }

    // Active User Shop List Access of the User ID
    protected function otherShopList($expectionShop)
    {
        $condtionList = [];
        $feildList = ['ShopSessionID','ShopName','ShopDescription'];
        $organizerList = ['orderBy' => ['ShopID' => 'ASC']];

        if($expectionShop != ''){
            $condtionList = ['sqldecrypt' => "sessionid NOT IN ('".implode("','", $expectionShop)."')"];
        }

        // if($shopID != '' && !in_array($shopID,$expectionShop)){
        //     $condtionList['ShopSessionID'] = $shopID;
        // }

        if($this->limit != 0){
            $organizerList['limit'] = $this->limit;
        }

        // TODO:: User Session ID need to be handled from user login
        $response = $this->getDatafromDB(
                        ['shop'], 
                        $condtionList,
                        $feildList,
                        $organizerList
                    );

                    
        
        // var_dump($response);
        // die;

        return $response;
    }

    // Active Account List Access of the User ID
    protected function activeAccountListAccess($userID, $accountID = '')
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
    protected function activeTransactionListAccess($userID, $accountID = '')
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

    protected function getAccountCurrentBalance($userID, $accountID)
    {
        $getAccountDetails = $this->activeAccountListAccess($userID, $accountID);

        if(isset($getAccountDetails['error_id']))
        {
            return $getAccountDetails;
        }

        return $getAccountDetails['AccountCurrentBalance'];
    }

    protected function transactionInitProccess($userID, $description, $amount, $type, $accountID, $budgetID)
    {
        $createTransactionData = [
                            'TransactionDescription' => $description,
                            'TransactionAmount' => $amount,
                            'TransactionPayableType' => $type,
                            'AccountSessionID' => $accountID,
                            'TransactionDate' => date_format(new DateTime(),'Y-m-d'),
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
