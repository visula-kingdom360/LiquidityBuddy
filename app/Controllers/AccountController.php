<?php

namespace App\Controllers;

class AccountController extends AccountService
{

    // Account Page initation function
    public function accountList()
    {
        // Login Check        
        $is_login = session()->get('is_login');

        if(!isset($is_login) || !$is_login){
            return redirect()->to(base_url('/login'));
            die;
        }

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
        $accountDetails = $this->activeAccountListAccessModule($this->userAccess());
        // $this->limit = 0;

        // TODO:: Error Handling Method
        if(isset($accountDetails['error_id'])){

            // TODO:: Change the route the accout create URL
            return $this->errorHandleLogAndPageRedirection($accountDetails, $this->init_trigger_url);
            return redirect()->to(base_url('/account/group'))->with('msg', $accountDetails['error_message']);
        }

        if(!isset($accountDetails[0])){
            $accounts[] = $accountDetails;
        }else{
            $accounts = $accountDetails;
        }

        // TODO:: link user default user
        $this->limit = 20;
        $transactionDetails = $this->activeTransactionListAccess($this->userAccess());
        $this->limit = 0;

        // TODO:: Error Handling Method
        if(isset($transactionDetails['error_id'])){

            // TODO:: Change the route the accout create URL
            return $this->errorHandleLogAndPageRedirection($transactionDetails, $this->init_trigger_url);
            // return redirect()->to(base_url('/account/list'))->with('msg', $accountDetails['error_message']);
        }

        if(!isset($transactionDetails[0])){
            $transactions[] = $transactionDetails;
        }else{
            $transactions = $transactionDetails;
        }

        // TODO:: link user default user
        // $this->limit = 5;
        $budgetDetails = $this->budgetList($this->userAccess());
        // $this->limit = 0;

        // TODO:: Error Handling Method
        if(isset($budgetDetails['error_id'])){

            // TODO:: Change the route the accout create URL
            return $this->errorHandleLogAndPageRedirection($budgetDetails, $this->init_trigger_url);
            // return redirect()->to(base_url('/account/list'))->with('msg', $accountDetails['error_message']);
        }

        if(!isset($budgetDetails[0])){
            $budgets[] = $budgetDetails;
        }else{
            $budgets = $budgetDetails;
        }

        // TODO:: link user default user
        $this->limit = 5;
        $shopDetails = $this->userShopList($this->userAccess());
        // $this->limit = 0;

        // TODO:: Error Handling Method
        if(isset($shopDetails['error_id'])){
            $shopDetails = $this->otherShopList();

            if(isset($shopDetails['error_id'])){
                return $this->errorHandleLogAndPageRedirection($shopDetails, $this->init_trigger_url);
            }
        }

        // TODO:: Change the route the accout create URL
        // return $this->errorHandleLogAndPageRedirection($shopDetails, '/account/list');
        // return redirect()->to(base_url('/account/list'))->with('msg', $accountDetails['error_message']);

        if(!isset($shopDetails[0])){
            $shops[] = $shopDetails;
        }else{
            $shops = $shopDetails;
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

        $data['shopInfo'] = $shops;

        // TODO:: link user default user
        $this->limit = 10;
        $stackholderDetails = $this->stackholderList($this->userAccess());
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
        // $data['transactionInfo']['$transactions'] = $transactions;

        $data['accountInfo'] = [
            'page_limit' => 5,
            'count' => count($accounts),
            'page_count' => ceil(count($accounts) / 5),
            'accounts' => $accounts,
            'allow_all_accounts' => true,
            'edit_mode' => false
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
        if(isset($data['accountInfo']['accounts'][1])){
            $data['internal_trans_content'] = view('Transaction/internal_trans_module', $data);
        }else{
            $data['internal_trans_content'] = "<div clasa='transaction-type-list' id='internal'><h3> Need more than one account to make internal transaction </h3></div>";
        }
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
        // Login Check        
        $is_login = session()->get('is_login');

        if(!isset($is_login) || !$is_login){
            return redirect()->to(base_url('/login'));
            die;
        }

        $data = [
            'StoredText'=>[
                'Header' => 'Login Details',
                'ScreenTitle' => 'User Login',
                'ErrorStatus' => 'Error Status: ',
            ]
        ];

        $transactionDetails = $this->activeTransactionListAccess($this->userAccess());

        // TODO:: Error Handling Method
        if(isset($transactionDetails['error_id'])){
            
            // Redirect to account page
            return $this->errorHandleLogAndPageRedirection($transactionDetails, $this->init_trigger_url);
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
        $fromAccountName = $this->getAccountName($this->userAccess(), $from_account);

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
        $toAccountName = $this->getAccountName($this->userAccess(), $to_account);

        if(isset($toAccountName['error_id'])){
            $this->errorHandleforAPIResponses($toAccountName);
        }

        $fromDescription = 'Transferred from '.$fromAccountName;
        $toDescription = 'Transferred to '.$toAccountName;
        $needBalanceCheckAccID = $from_account;
        // ---End Automated Description

        // Account Balance Validation handle functionality
        // TODO:: link user default user
        $accBalAccount = $this->getAccountCurrentBalance($this->userAccess(), $needBalanceCheckAccID);

        if(isset($accBalAccount['error_id'])){
            $this->errorHandleforAPIResponses($accBalAccount);
        }

        if($accBalAccount < $amount){
            // return $accBalAccount;

            $errorResponse = [
                'error_id' => '0019',
                'category' => 'Data_Issue',
                'error_category' => 'Account Balance',
                'error_message' => 'The amount entered is larger than the amount in account. Plesae check and rectify.',
            ];

            $this->errorHandleforAPIResponses($errorResponse);
        }
        // ---End Account Balance Validation handle functionality

        // TODO:: link user default user
        $fromTransactionChanges = $this->transactionInitProccess($this->userAccess(),$fromDescription, $amount, $transaction_type, $from_account, $budget);

        if(isset($fromTransactionChanges['error_id'])){
            $this->errorHandleforAPIResponses($fromTransactionChanges);
        }

        $type = /*($transaction_type == 'income') ? 'expense' :*/ 'income';

        // TODO:: link user default user
        $toTransactionChanges = $this->transactionInitProccess($this->userAccess(), $toDescription, $amount, $type, $to_account, $budget);

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

    public function addAccount()
    {
        // Login Check        
        $is_login = session()->get('is_login');

        if(!isset($is_login) || !$is_login){
            return redirect()->to(base_url('/login'));
            die;
        }

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
        $accountGroupDetails = $this->activeAccountGroupsListAccessModule($this->userAccess());
        // $this->limit = 0;


        if(!isset($accountGroupDetails[0])){
            $accountGroupsInfo[] = $accountGroupDetails;
        }else{
            $accountGroupsInfo = $accountGroupDetails;
        }
        $data['accountGroupDetails'] = $accountGroupsInfo;

        // TODO:: link user default user
        // $this->limit = 0;
        $accountDetails = $this->activeAccountListAccessModule($this->userAccess());
        // $this->limit = 0;

        // TODO:: Error Handling Method
        if(!isset($accountDetails['error_id'])){

            // TODO:: Change the route the accout create URL
            // return $this->errorHandleLogAndPageRedirection($accountDetails, '/account/list');
            // return redirect()->to(base_url('/account/list'))->with('msg', $accountDetails['error_message']);

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
                'allow_all_accounts' => true,
                'edit_mode' => true
            ];

            $data['account_list_content'] = view('Account/commonModule/account_info_module', $data['accountInfo']);
        }else{
            $data['account_list_content'] = '';
        }

        return view('Account/creation', $data);
    }

    public function createAccount()
    {
        $request_data = $this->handlePOSTBodyDataList();

        // passing parameters --> (amount [required], transaction_type [required], from_account [required], to_account [required])
        $requiredParameters = $this->handleRequiredParameters($request_data, ['accountName', 'groupID', 'amount']);

        if(isset($requiredParameters['error_id'])){
            return $requiredParameters;
        }

        $accountName = $request_data['accountName'];
        $groupID = $request_data['groupID'];
        $amount = $request_data['amount'];

        // TODO:: link user default user
        $accountCreation = $this->accountInitProccess($this->userAccess(), $accountName, $groupID, $amount);

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

    public function accountPage($account_id)
    {
        // Login Check        
        $is_login = session()->get('is_login');

        if(!isset($is_login) || !$is_login){
            return redirect()->to(base_url('/login'));
            die;
        }

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
        $response = $this->activeTransactionListAccess($this->userAccess(), $account_id);
        // $this->limit = 0;

        // TODO:: Error Handling Method
        if(isset($response['error_id'])){
            // TODO:: Change the route the accout create URL
            if ($response['error_id'] == '0004') {
                # code...
                return redirect()->to(base_url($this->init_trigger_url))->with('msg', 'No transaction for the selected account');
            }
            return $this->errorHandleLogAndPageRedirection($response, $this->init_trigger_url);
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

    public function updateAccount(){
        $request_data = $this->handlePOSTBodyDataList();

        // passing parameters --> (account_id [required], accountName [required], group_id [required], amount [required])
        $requiredParameters = $this->handleRequiredParameters($request_data, ['account_id', 'account_name', 'account_group']);

        if(isset($requiredParameters['error_id']))
        {
            return $requiredParameters;
        }

        $accountID = $request_data['account_id'];
        $accountName = $request_data['account_name'];
        $groupID = $request_data['account_group'];

        // TODO:: link user default user
        $accountUpdate = $this->accountUpdateProccess($this->userAccess(), $accountID, $accountName, $groupID);

        if(isset($accountUpdate['error_id'])){            
            $response = $this->errorHandleforAPIResponses($accountUpdate);
            echo $response;
            exit;
            // return $accountUpdate;
        }

        $response = [
            'data' => [
                'success'  => true,
                'response' => 'Successfully updated account',
                'data' => [
                    'accountUpdate' => $accountUpdate
                ]
            ]
        ];

        echo json_encode($response['data']);
        exit;
    }

    public function deleteAccount(){
        $request_data = $this->handlePOSTBodyDataList();

        // passing parameters --> (account_id [required])
        $requiredParameters = $this->handleRequiredParameters($request_data, ['account_id']);

        if(isset($requiredParameters['error_id']))
        {
            return $requiredParameters;
        }

        $accountID = $request_data['account_id'];

        // TODO:: link user default user
        $accountDelete = $this->accountDeleteProccess($this->userAccess(), $accountID);

        if(isset($accountDelete['error_id'])){            
            $response = $this->errorHandleforAPIResponses($accountDelete);
            echo $response;
            exit;
            // return $accountDelete;
        }

        $response = [
            'data' => [
                'success'  => true,
                'response' => 'Successfully deleted account',
                'data' => [
                    'accountDelete' => $accountDelete
                ]
            ]
        ];

        echo json_encode($response['data']);
        exit;
    }

    public function accountGroupPage(){
        $is_login = session()->get('is_login');

        if(!isset($is_login) || !$is_login){
            return redirect()->to(base_url('/login'));
            die;
        }
        
        $data = [];

        $data = [
            'StoredText' => [
                'Header' => 'Account Group Page',
                'ScreenTitle' => 'Account Group List',
                'ErrorStatus' => 'Error Status: ',
            ]
        ];

        $data['Head'] = $this->commonHead();
        $data['CurrentID'] = 'account-group-list';

        // TODO:: link user default user
        // $this->limit = 10;
        $accountGroupDetails = $this->activeAccountGroupsListAccessModule($this->userAccess());
        // $this->limit = 0;

        // TODO:: Error Handling Method
        if(isset($accountGroupDetails['error_id'])){
            // TODO:: Change the route the accout create URL
            // return $this->errorHandleLogAndPageRedirection($accountGroupDetails, $this->init_trigger_url);
            if($accountGroupDetails['error_id'] == '0004'){
                # code...
                $data['account_group_details_container'] = '';
                return view('Account/create_account_group', $data);
            }
        }

        if(!isset($accountGroupDetails[0])){
            $accountGroups[] = $accountGroupDetails;
        }else{
            $accountGroups = $accountGroupDetails;
        }

        $data['accountGroupInfo'] = [
            'page_limit' => 10,
            'count' => count($accountGroups),
            'page_count' => ceil(count($accountGroups) / 10),
            'accountGroups' => $accountGroups,
            'edit_mode' => true
        ];

        $data['account_group_details_container'] = view('Account/commonModule/account_group_details_module', $data['accountGroupInfo']);

        return view('Account/create_account_group', $data);
    }

    public function createAccountGroup(){
        $request_data = $this->handlePOSTBodyDataList();

        $requiredParameters = $this->handleRequiredParameters($request_data, ['account_group_name']);

        if(isset($requiredParameters['error_id'])){
            return $requiredParameters;
        }

        $accountGroupName = $request_data['account_group_name'];

        // TODO:: link user default user
        $accountGroupCreate = $this->accountGroupCreateProccess($this->userAccess(), $accountGroupName);

        if(isset($accountGroupCreate['error_id'])){            
            $response = $this->errorHandleforAPIResponses($accountGroupCreate);
            echo $response;
            exit;
            // return $accountGroupCreate;
        }

        $response = [
            'data' => [
                'success'  => true,
                'response' => 'Successfully created account group',
            ]
        ];

        echo json_encode($response['data']);
        exit;
    }

    public function updateAccountGroup(){
        $request_data = $this->handlePOSTBodyDataList();

        // passing parameters --> (account_group_id [required], account_group_name [required])
        $requiredParameters = $this->handleRequiredParameters($request_data, ['account_group_id', 'account_group_name']);

        if(isset($requiredParameters['error_id']))
        {
            return $requiredParameters;
        }

        $accountGroupID = $request_data['account_group_id'];
        $accountGroupName = $request_data['account_group_name'];

        // TODO:: link user default user
        $accountGroupUpdate = $this->accountGroupUpdateProccess($this->userAccess(), $accountGroupID, $accountGroupName);

        if(isset($accountGroupUpdate['error_id'])){            
            $response = $this->errorHandleforAPIResponses($accountGroupUpdate);
            echo $response;
            exit;
        }

        $response = [
            'data' => [
                'success'  => true,
                'response' => 'Successfully updated account group',
            ]
        ];
    }

    public function deleteAccountGroup(){
        $request_data = $this->handlePOSTBodyDataList();    

        $requiredParameters = $this->handleRequiredParameters($request_data, ['account_group_id']);

        if(isset($requiredParameters['error_id']))
        {
            return $requiredParameters;
        }

        $accountGroupID = $request_data['account_group_id'];

        // TODO:: link user default user
        $accountGroupDelete = $this->accountGroupDeleteProccess($this->userAccess(), $accountGroupID);

        if(isset($accountGroupDelete['error_id'])){            
            $response = $this->errorHandleforAPIResponses($accountGroupDelete);
            echo $response;
            exit;
        }

        $response = [
            'data' => [
                'success'  => true,
                'response' => 'Successfully deleted account group',
            ]
        ];
    }

    public function addBudget(){
        $is_login = session()->get('is_login');

        if(!isset($is_login) || !$is_login){
            return redirect()->to(base_url('/login'));
            die;
        }

        $data = [];
        
        $data['StoredText'] = [
            'Header' => 'Create Budget',
            'ScreenTitle' => 'Create Budget',
            'ErrorStatus' => 'Error Status: ',
        ];

        $data['Head'] = $this->commonHead();
        $data['CurrentID'] = 'create-new-budget';

        $this->limit = 10;
        $response = $this->budgetList($this->userAccess());
        $this->limit = 0;

        // TODO:: Error Handling Method
        if(isset($response['error_id'])){
            if($response['error_id'] != '0004'){
                // TODO:: Change the route the accout create URL
                return $this->errorHandleLogAndPageRedirection($response, $this->init_trigger_url);
            }else{
                $data['budget_details_container'] = '';
                $data['budgetInfo'] = [
                    'payment_plan' => $this->periodic,
                ];
            }
        }else{
            if(!isset($response[0])){
                $budgets[] = $response;
            }else{
                $budgets = $response;
            }

            $data['budgetInfo'] = [
                'page_limit' => 10,
                'count' => count($budgets),
                'page_count' => ceil(count($budgets) / 10),
                'budgets' => $budgets,
                'payment_plan' => $this->periodic,
                'edit_mode' => true
            ];

            $data['budget_details_container'] = view('Account/commonModule/budget_details_module', $data['budgetInfo']);
        }

        return view('Account/create_budget', $data);
    }

    public function createBudget(){
        $budgetName = $this->request->getPost('budgetName');
        $budgetPlan = $this->request->getPost('budgetPlan');
        $budgetAmount = $this->request->getPost('budgetAmount');

        // TODO:: link user default user
        $budgetCreation = $this->budgetInitProccess($this->userAccess(), $budgetName, $budgetPlan, $budgetAmount);

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
        $budgetUpdate = $this->budgetUpdateProccess($this->userAccess(), $budgetID, $budgetName ,$budgetPlan, $budgetAmount);

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
        $budgetDelete = $this->budgetDeleteProccess($this->userAccess(), $budgetID);

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
