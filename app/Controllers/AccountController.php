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
        $accountDetails = $this->activeAccountListAccessModule($this->user_id);
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
        $this->limit = 20;
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

        // $data['accountInfo'] = $accounts;
        $data['budgetInfo'] = $budgets;
        $data['stackholderInfo'] = $stackholders;
        $data['shopInfo'] = $shops;
        // $data['transactionInfo']['$transactions'] = $transactions;

        $data['accountInfo'] = [
            'page_limit' => 5,
            'count' => count($accounts),
            'page_count' => ceil(count($accounts) / 5),
            'accounts' => $accounts,
            'allow_all_accounts' => true
        ];

        $data['transactionInfo'] = [
            'page_limit' => 10,
            'count' => count($transactions),
            'page_count' => ceil(count($transactions) / 10),
            'transactions' => $transactions,
            'allow_all_accounts' => true
        ];

        $data['paymentPlan'] = $this->periodic;

        $data['external_trans_content'] = view('Transaction/external_trans_module', $data);
        $data['internal_trans_content'] = view('Transaction/internal_trans_module', $data);
        $data['other_trans_content'] = view('Transaction/other_trans_module', $data);
        $data['purchase_content'] = view('Transaction/purchase_module', $data);
        $data['account_list_content'] = view('Account/commonModule/account_info_module', $data['accountInfo']);
        $data['transaction_proccess_container'] = view('Transaction/transaction_proccess_module', $data);
        $data['transaction_details_container'] = view('Transaction/transaction_details_module', $data['transactionInfo']);
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

        // TODO:: link user default user
        // $this->limit = 5;
        $accountGroupDetails = $this->activeAccountGroupsListAccessModule($this->user_id);
        // $this->limit = 0;


        if(!isset($accountGroupDetails[0])){
            $accountGroupsInfo[] = $accountGroupDetails;
        }else{
            $accountGroupDetails = $accountGroupDetails;
        }
        $data['accountGroupDetails'] = $accountGroupDetails;

        // TODO:: link user default user
        // $this->limit = 0;
        $accountDetails = $this->activeAccountListAccessModule($this->user_id);
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
        
        $data['accountInfo'] = [
            'page_limit' => 5,
            'count' => count($accounts),
            'page_count' => ceil(count($accounts) / 5),
            'accounts' => $accounts,
            'allow_all_accounts' => true
        ];

        $data['account_list_content'] = view('Account/commonModule/account_info_module', $data['accountInfo']);

        return view('Account/creation', $data);
    }

    public function createAccount(){

        $accountName = $this->request->getPost('accountName');
        $groupID = $this->request->getPost('groupID');
        $amount = $this->request->getPost('amount');

        // TODO:: link user default user
        $accountCreation = $this->accountInitProccess($this->user_id, $accountName, $groupID, $amount);

        if(isset($accountCreation['error_id'])){            
            $response = $this->errorHandleforAPIResponses($accountCreation);
            echo $response;
            exit;
            // return $accountCreation;
        }

        $response = [
            'data' => [
                'success'  => true,
                'response' => 'Successfully created account',
                'data' => [
                    'accountCreation' => $accountCreation
                    ]
            ],
            'code' => 200
        ];

        echo json_encode($response['data']);
        exit;

    }

    public function accountPage($account_id){
        $data = [];

        $data = [
            'StoredText' => [
                'Header' => 'Account Page',
                'ScreenTitle' => 'Account List',
                'ErrorStatus' => 'Error Status: ',
            ]
        ];

        $data['Head'] = $this->commonHead();
        $data['CurrentID'] = 'account-list';

        // TODO:: link user default user
        // $this->limit = 10;
        $response = $this->activeTransactionListAccess($this->user_id, $account_id);
        // $this->limit = 0;

        // TODO:: Error Handling Method
        if(isset($response['error_id'])){
            // TODO:: Change the route the accout create URL
            if ($response['error_id'] == '0004') {
                # code...
                return redirect()->to(base_url('/account/list'))->with('msg', 'No transaction for the selected account');
            }
            return $this->errorHandleLogAndPageRedirection($response, '/account/list');
        }

        if(!isset($response[0])){
            $transaction[] = $response;
        }else{
            $transaction = $response;
        }
        
        $data['transactionInfo'] = [
            'page_limit' => 10,
            'count' => count($transaction),
            'page_count' => ceil(count($transaction) / 10),
            'transactions' => $transaction,
            'allow_all_accounts' => true
        ];

        $data['transaction_details_container'] = view('Transaction/transaction_details_module', $data['transactionInfo']);


        return view('Account/page', $data);
    }

    public function addBudget(){
        $data = [];
        $data['StoredText'] = [
            'Header' => 'Create Budget',
            'ScreenTitle' => 'Create Budget',
            'ErrorStatus' => 'Error Status: ',
        ];

        $data['Head'] = $this->commonHead();
        $data['CurrentID'] = 'create-new-budget';

        $this->limit = 10;
        $budgets = $this->budgetList($this->user_id);
        $this->limit = 0;

        // TODO:: Error Handling Method
        if(isset($budgets['error_id'])){
            // TODO:: Change the route the accout create URL
            return $this->errorHandleLogAndPageRedirection($budgets, '/account/list');
        }

        if(!isset($budgets[0])){
            $budgets[] = $budgets;
        }

        $data['budgetInfo'] = [
            'page_limit' => 10,
            'count' => count($budgets),
            'page_count' => ceil(count($budgets) / 10),
            'budgets' => $budgets,
            'payment_plan' => $this->periodic,
        ];

        $data['budget_details_container'] = view('Account/commonModule/budget_details_module', $data['budgetInfo']);

        return view('Account/create_budget', $data);
    }

    public function createBudget(){
        $budgetName = $this->request->getPost('budgetName');
        $budgetPlan = $this->request->getPost('budgetPlan');
        $budgetAmount = $this->request->getPost('budgetAmount');

        // TODO:: link user default user
        $budgetCreation = $this->budgetInitProccess($this->user_id, $budgetName, $budgetPlan, $budgetAmount);

        // TODO:: Error Handling Method
        if(isset($budgetCreation['error_id'])){
            return $this->errorHandleforAPIResponses($budgetCreation);
        }

        $response = [
            'data' => [
                'success'  => true,
                'response' => 'Successfully created budget',
                'data' => [
                    'budgetCreation' => $budgetCreation
                    ]
            ],
            'code' => 200
        ];

        echo json_encode($response['data']);
        exit;
    }

    public function updateBudget(){
        $request_data = $this->handlePOSTBodyDataList();

        $requiredParameters = $this->handleRequiredParameters($request_data, ['budget_id','budget_name','budget_plan','budget_amount']);

        if(isset($requiredParameters['error_id'])){
            return $requiredParameters;
        }

        $budgetID = $request_data['budget_id'];
        $budgetName = $request_data['budget_name'];
        $budgetPlan = $request_data['budget_plan'];
        $budgetAmount = $request_data['budget_amount'];

        

        // TODO:: link user default user
        $budgetUpdate = $this->budgetUpdateProccess($this->user_id, $budgetID, $budgetName ,$budgetPlan, $budgetAmount);

        // TODO:: Error Handling Method
        if(isset($budgetUpdate['error_id'])){
            return $this->errorHandleforAPIResponses($budgetUpdate);
        }

        $response = [
            'data' => [
                'success'  => true,
                'response' => 'Successfully updated budget',
                'data' => [
                    'budgetUpdate' => $budgetUpdate
                    ]
            ],
            'code' => 200
        ];

        echo json_encode($response['data']);
        exit;
    }

    public function deleteBudget(){
        $request_data = $this->handlePOSTBodyDataList();

        $requiredParameters = $this->handleRequiredParameters($request_data, ['budget_id']);

        if(isset($requiredParameters['error_id'])){
            return $requiredParameters;
        }

        $budgetID = $request_data['budget_id'];

        // TODO:: link user default user
        $budgetDelete = $this->budgetDeleteProccess($this->user_id, $budgetID);

        // TODO:: Error Handling Method
        if(isset($budgetDelete['error_id'])){
            return $this->errorHandleforAPIResponses($budgetDelete);
        }

        $response = [
            'data' => [
                'success'  => true,
                'response' => 'Successfully deleted budget',
                'data' => [
                    'budgetDelete' => $budgetDelete
                    ]
            ],
            'code' => 200
        ];

        echo json_encode($response['data']);
        exit;
    }
}
