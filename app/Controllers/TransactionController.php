<?php

namespace App\Controllers;

class TransactionController extends AccountService
{

    // Account Page initiation function
    public function createTransaction()
    {
        $data = [];

        $data = [
            'StoredText' => [
                'Header' => 'Transaction Page',
                'ScreenTitle' => 'Transaction',
                'ErrorStatus' => 'Error Status: ',
            ]
        ];

        $data['Head'] = $this->commonHead();
        $data['CurrentID'] = 'transaction-page';

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

        // // TODO:: link user default user
        // $this->limit = 20;
        // $transactionDetails = $this->activeTransactionListAccess($this->user_id);
        // $this->limit = 0;

        // // TODO:: Error Handling Method
        // if(isset($transactionDetails['error_id'])){

        //     // TODO:: Change the route the accout create URL
        //     return $this->errorHandleLogAndPageRedirection($transactionDetails, '/account/list');
        //     // return redirect()->to(base_url('/account/list'))->with('msg', $accountDetails['error_message']);
        // }

        // if(!isset($transactionDetails[0])){
        //     $transactions[] = $transactionDetails;
        // }else{
        //     $transactions = $transactionDetails;
        // }

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

        $data['paymentPlan'] = $this->periodic;

        $data['external_trans_content'] = view('Transaction/external_trans_module', $data);
        $data['internal_trans_content'] = view('Transaction/internal_trans_module', $data);
        $data['other_trans_content'] = view('Transaction/other_trans_module', $data);
        $data['purchase_content'] = view('Transaction/purchase_module', $data);
        $data['account_list_content'] = view('Account/commonModule/account_info_module', $data['accountInfo']);
        $data['transaction_proccess_container'] = view('Transaction/transaction_proccess_module', $data);
        return view('Transaction/create', $data);
    }
}
