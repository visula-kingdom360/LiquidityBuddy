<?php

namespace App\Controllers;

use DateTime;

class AccountController extends MainController
{
    private $user_id = '01b9ff2b173400203b74b4cbec306d6f';
    private $limit = 0;

    // Account Page initation function
    public function accountList()
    {
        $data = [
            'StoredText'=>[
                'Header' => 'Main Menu',
                'ScreenTitle' => 'User Login',
                'ErrorStatus' => 'Error Status: ',
            ]
        ];

        // TODO:: link user default user
        // $this->limit = 5;
        $accountDetails = $this->activeAccountListAccess($this->user_id);
        // $this->limit = 0;

        // TODO:: Error Handling Method
        if(isset($accountDetails['error_id'])){

            // TODO:: Change the route the accout create URL
            return $this->errorHandleLogAndPageRedirection($accountDetails, '/account/list');
            // return redirect()->to(base_url('/account/list'))->with('msg', $accountDetails['error_message']);
        }

        if(!isset($accountDetails[0])){
            $accounts[] = $accountDetails;
        }else{
            $accounts = $accountDetails;
        }

        // TODO:: link user default user
        $this->limit = 10;
        $transactionDetails = $this->activeTransactionListAccess($this->user_id);
        $this->limit = 0;

        // TODO:: Error Handling Method
        if(isset($transactionDetails['error_id'])){

            // TODO:: Change the route the accout create URL
            return $this->errorHandleLogAndPageRedirection($transactionDetails, '/account/list');
            // return redirect()->to(base_url('/account/list'))->with('msg', $accountDetails['error_message']);
        }

        if(!isset($transactionDetails[0])){
            $transactions[] = $transactionDetails;
        }else{
            $transactions = $transactionDetails;
        }

        // var_dump($accounts);
        // die;
        $data['accountInfo'] = $accounts;
        $data['transactionInfo'] = $transactions;

        return view('Account/list', $data);
    }

    // Transaction List Page initation function
    public function transactionList()
    {
        $data = [
            'StoredText'=>[
                'Header' => 'Login Details',
                'ScreenTitle' => 'User Login',
                'ErrorStatus' => 'Error Status: ',
            ]
        ];

        $transactionDetails = $this->activeTransactionListAccess($this->user_id);

        // TODO:: Error Handling Method
        if(isset($transactionDetails['error_id'])){
            
            // Redirect to account page
            return $this->errorHandleLogAndPageRedirection($transactionDetails, '/account/list');
            // return redirect()->to(base_url('/account/list'))->with('msg', $transactionDetails['error_message']);
        }

        // TODO:: link user default user

        return view('Transaction/list', $data);
    }

    public function internalTransaction()
    {
        $request_data = $this->handlePOSTBodyDataList();

        // passing parameters --> (amount [required], transaction_type [required], from_account [required], to_account [required])
        $requiredParameters = $this->handleRequiredParameters($request_data, ['amount', 'transaction_type', 'from_account', 'to_account']);

        if(isset($requiredParameters['error_id'])){
            return $requiredParameters;
        }

        $amount = $request_data['amount'];
        $transaction_type = $request_data['transaction_type'];
        $from_account = $request_data['from_account'];
        $to_account = $request_data['to_account'];

        // TODO:: link user default user
        $fromAccountName = $this->getAccountName($this->user_id, $from_account);

        if(isset($fromAccountName['error_id'])){
            return $fromAccountName;
        }

        // TODO:: link user default user
        $toAccountName = $this->getAccountName($this->user_id, $to_account);

        if(isset($toAccountName['error_id'])){
            return $toAccountName;
        }

        if($transaction_type == 'income'){
            $fromDescription = 'Transferred to '.$fromAccountName;
            $toDescription = 'Transferred from '.$toAccountName;
            $needBalanceCheckAccID = $to_account;
        }elseif($transaction_type == 'expense'){
            $fromDescription = 'Transferred from '.$fromAccountName;
            $toDescription = 'Transferred to '.$toAccountName;
            $needBalanceCheckAccID = $from_account;
        }

        // TODO:: link user default user
        $accBalAccount = $this->getAccountCurrentBalance($this->user_id, $needBalanceCheckAccID);

        if(isset($accBalAccount['error_id'])){
            return $accBalAccount;
        }

        if($accBalAccount < $amount){
            return $accBalAccount;
        }

        // TODO:: link user default user
        $fromTransactionChanges = $this->transactionInitProccess($this->user_id,$fromDescription, $amount, $transaction_type, $from_account);

        if(isset($fromTransactionChanges['error_id'])){
            return $fromTransactionChanges;
        }

        $type = ($transaction_type == 'income') ? 'expense' : 'income';

        // TODO:: link user default user
        $toTransactionChanges = $this->transactionInitProccess($this->user_id, $toDescription, $amount, $type, $to_account);

        if(isset($toTransactionChanges['error_id'])){
            return $toTransactionChanges;
        }

        $response = [
            'data' => [
                'success'  => true,
                'response' => 'Successfully created new chat',
                'data' => [
                    'fromTransactionChanges' => $fromTransactionChanges,
                    'toTransactionChanges' => $toTransactionChanges
                    ]
                // 'ChatList'  => $chatRequest
            ],
            'code' => 200
        ];

        echo json_encode($response['data']);
        exit;
    }

    // Active Account List Access of the User ID
    private function activeAccountListAccess($userID, $accountID = '')
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
    private function activeTransactionListAccess($userID, $accountID = '')
    {
        $condtionList = ['UserSessionID' => $userID, 'AccountStatus' => 'A', 'TransactionStatus' => 'A'];
        $feildList = ['AccountName','TransactionDescription','TransactionDate','TransactionAmount','TransactionType','AccountCurrentBalance'];
        $organizerList = ['orderBy' => ['TransactionDate' => 'DESC']];

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

    private function getAccountName($userID, $accountID)
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

    private function getAccountCurrentBalance($userID, $accountID)
    {
        $getAccountDetails = $this->activeAccountListAccess($userID, $accountID);

        // var_dump($getAccountDetails['AccountName']);
        // die;

        if(isset($getAccountDetails['error_id']))
        {
            return $getAccountDetails;
        }

        return $getAccountDetails['AccountCurrentBalance'];
    }

    private function transactionInitProccess($userID, $description, $amount, $type, $accountID)
    {
        $createTransactionData = [
                        'TransactionDescription' => $description,
                        'TransactionAmount' => $amount,
                        'TransactionType' => $type,
                        'AccountSessionID' => $accountID,
                        'TransactionDate' => date_format(new DateTime(),'Y-m-d'),
                        'TransactionCreatedDateTime' => strtotime(date_format(new DateTime(),'Y-m-d')),
                        'TransactionUpdatedDateTime' => strtotime(date_format(new DateTime(),'Y-m-d'))
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
}
