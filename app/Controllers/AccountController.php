<?php

namespace App\Controllers;

class AccountController extends AccountService
{

    // Account Page initation function
    public function accountList()
    {
        $data = [
            'StoredText' => [
                'Header' => 'Main Menu',
                'ScreenTitle' => 'User Login',
                'ErrorStatus' => 'Error Status: ',
            ]
        ];
        $data['Head'] = $this->commonHead();
        $data['CurrentID'] = 'main-menu';

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

        // TODO:: link user default user
        // $this->limit = 5;
        $budgetDetails = $this->budgetList($this->user_id);
        // $this->limit = 0;

        // TODO:: Error Handling Method
        if(isset($budgetDetails['error_id'])){

            // TODO:: Change the route the accout create URL
            return $this->errorHandleLogAndPageRedirection($budgetDetails, '/account/list');
            // return redirect()->to(base_url('/account/list'))->with('msg', $accountDetails['error_message']);
        }

        if(!isset($budgetDetails[0])){
            $budgets[] = $budgetDetails;
        }else{
            $budgets = $budgetDetails;
        }

        // TODO:: link user default user
        $this->limit = 5;
        $shopDetails = $this->userShopList($this->user_id);
        // $this->limit = 0;

        // TODO:: Error Handling Method
        if(!isset($shopDetails['error_id'])){

            // TODO:: Change the route the accout create URL
            // return $this->errorHandleLogAndPageRedirection($shopDetails, '/account/list');
            // return redirect()->to(base_url('/account/list'))->with('msg', $accountDetails['error_message']);

            if(!isset($shopDetails[0])){
                $shops[] = $shopDetails;
            }else{
                $shops = $shopDetails;
            }
        }

        if(count($shops) < $this->limit){
            $shopIds = array_column($shops, 'ShopSessionID');
            // TODO:: link user default user
            $this->limit = ($this->limit - count($shops));
            // var_dump($shopIds);
            // die;
            $otherShopDetails = $this->otherShopList($shopIds);
            
            $this->limit = 0;

            // TODO:: Error Handling Method
            if(!isset($otherShopDetails['error_id'])){

                // TODO:: Change the route the accout create URL
                // return $this->errorHandleLogAndPageRedirection($shopDetails, '/account/list');
                // return redirect()->to(base_url('/account/list'))->with('msg', $accountDetails['error_message']);

                if(!isset($otherShopDetails[0])){
                    $shops[] = $otherShopDetails;
                }else{
                    $shops = array_merge($shops, $otherShopDetails);
                }
            }
        }

        // TODO:: link user default user
        $this->limit = 10;
        $stackholderDetails = $this->stackholderList($this->user_id);
        $this->limit = 0;

        // TODO:: Error Handling Method
        if(isset($stackholderDetails['error_id'])){

            // TODO:: Change the route the accout create URL
            $stackholderDetails = [];
            // return $this->errorHandleLogAndPageRedirection($stackholderDetails, '/account/list');
            // return redirect()->to(base_url('/account/list'))->with('msg', $accountDetails['error_message']);
        }

        if(!isset($stackholderDetails[0])){
            $stackholders[] = $stackholderDetails;
        }else{
            $stackholders = $stackholderDetails;
        }

        // var_dump($stackholders);
        // die;
        
        $data['accountInfo'] = $accounts;
        $data['budgetInfo'] = $budgets;
        $data['stackholderInfo'] = $stackholders;
        $data['shopInfo'] = $shops;
        $data['transactionInfo'] = $transactions;

        $data['paymentPlan'] = $this->periodic;

        $data['external_trans_content'] = view('Transaction/external_trans_module', $data);
        $data['internal_trans_content'] = view('Transaction/internal_trans_module', $data);
        $data['other_trans_content'] = view('Transaction/other_trans_module', $data);
        $data['purchase_content'] = view('Transaction/purchase_module', $data);
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
        $requiredParameters = $this->handleRequiredParameters($request_data, ['amount', 'from_account', 'to_account','budget']);

        if(isset($requiredParameters['error_id'])){
            return $requiredParameters;
        }

        $amount = $request_data['amount'];
        $transaction_type = 'expense';
        $from_account = $request_data['from_account'];
        $to_account = $request_data['to_account'];
        $budget = $request_data['budget'];

        
        if($amount <= 0){
            $response = [
                'data' => [
                    'success'  => false,
                    'response' => 'The transaction amount cannot be zero'
                ]
            ];

            echo json_encode($response['data']);
            exit;
        }

        // Automated Description for branches to create a user friendly narration for both transaction
        // TODO:: link user default user
        $fromAccountName = $this->getAccountName($this->user_id, $from_account);

        if(isset($fromAccountName['error_id'])){
            // $response = [
            //     'data' => [
            //         'success'  => false,
            //         'response' => 'Failure with the account details, Please check the account or refresh and retry.'
            //     ]
            // ];

            $this->errorHandleforAPIResponses($fromAccountName);
        }

        // TODO:: link user default user
        $toAccountName = $this->getAccountName($this->user_id, $to_account);

        if(isset($toAccountName['error_id'])){
            $this->errorHandleforAPIResponses($toAccountName);
        }

        $fromDescription = 'Transferred from '.$fromAccountName;
        $toDescription = 'Transferred to '.$toAccountName;
        $needBalanceCheckAccID = $from_account;
        // ---End Automated Description

        // Account Balance Validation handle functionality
        // TODO:: link user default user
        $accBalAccount = $this->getAccountCurrentBalance($this->user_id, $needBalanceCheckAccID);

        if(isset($accBalAccount['error_id'])){
            $this->errorHandleforAPIResponses($accBalAccount);
        }

        if($accBalAccount < $amount){
            // return $accBalAccount;

            $errorResponse = [
                'error_id' => '0019', // LASTEST Error Code
                'category' => 'Data_Issue',
                'error_category' => 'Account Balance',
                'error_message' => 'The amount entered is larger than the amount in account. Plesae check and rectify.',
            ];

            $this->errorHandleforAPIResponses($errorResponse);
        }
        // ---End Account Balance Validation handle functionality

        // TODO:: link user default user
        $fromTransactionChanges = $this->transactionInitProccess($this->user_id,$fromDescription, $amount, $transaction_type, $from_account, $budget);

        if(isset($fromTransactionChanges['error_id'])){
            $this->errorHandleforAPIResponses($fromTransactionChanges);
        }

        $type = /*($transaction_type == 'income') ? 'expense' :*/ 'income';

        // TODO:: link user default user
        $toTransactionChanges = $this->transactionInitProccess($this->user_id, $toDescription, $amount, $type, $to_account, $budget);

        if(isset($toTransactionChanges['error_id'])){
            $this->errorHandleforAPIResponses($toTransactionChanges);
            // return $toTransactionChanges;
        }

        $response = [
            'data' => [
                'success'  => true,
                'response' => 'Successfully tranferred to accounts',
                'data' => [
                    'fromTransactionChanges' => $fromTransactionChanges,
                    'toTransactionChanges' => $toTransactionChanges
                    ]
            ],
            'code' => 200
        ];

        echo json_encode($response['data']);
        exit;
    }

    public function addAccount(){
        $data = [];

        $data = [
            'StoredText' => [
                'Header' => 'Add New Account',
                'ScreenTitle' => 'User Login',
                'ErrorStatus' => 'Error Status: ',
            ]
        ];
        $data['Head'] = $this->commonHead();
        $data['CurrentID'] = 'add-new-account';

        return view('Account/creation', $data);
    }
}
