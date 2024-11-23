<?php

namespace App\Controllers;
use DateTime;
use App\Controllers\AccountService;

class PurchaseController extends PurchaseService
{
    public function expenseTransaction()
    {
        $accountService = new AccountService();
        $request_data = $this->handlePOSTBodyDataList();

        // passing parameters --> (amount [required], transaction_type [required], from_account [required], to_account [required])
        $requiredParameters = $this->handleRequiredParameters($request_data, ['amount', 'current_account','budget']);

        if(isset($requiredParameters['error_id'])){
            return $requiredParameters;
        }

        $amount = $request_data['amount'];
        $description = ($request_data['description'])?$request_data['description']:'Payment Made';
        $transaction_type = 'expense';
        $current_account = $request_data['current_account'];
        $budget = $request_data['budget'];
        $scheduled_info = ($request_data['scheduled_info'])?$request_data['scheduled_info']:'';

        // TODO:: need to add a condition to implement the first payment and handle the the fisrt payment with the scheudle.
        // to implement the above need to allow scheduled info in to the transaction
        if(($scheduled_info == '')){
            // Account Balance Validation handle functionality
            // TODO:: link user default user
            $accBalAccount = $accountService->getAccountCurrentBalance($this->user_id, $current_account);

            if(isset($accBalAccount['error_id'])){
                return $accBalAccount;
            }

            if($accBalAccount < $amount){
                return $accBalAccount;
            }
            // ---End Account Balance Validation handle functionality
        }

        // need
        if(($scheduled_info != '')){
            $purchasePlanResponse = $this->paymentPlanInitProccess('purchase', $purchaseResponse['data']['PurchaseSessionID'], $scheduled_info, $amount);
        
            if(isset($purchasePlanResponse['error_id'])){
                return $purchasePlanResponse;
            }
        }

        // TODO:: need to add a condition to implement the first payment and handle the the fisrt payment with the scheudle.
        // to implement the above need to allow scheduled info in to the transaction
        if(($scheduled_info == '')){

            // TODO:: link user default user
            $transactionResponse = $accountService->transactionInitProccess($this->user_id, $description, $amount, $transaction_type, $current_account, $budget);

            if(isset($transactionResponse['error_id'])){
                return $transactionResponse;
            }
        }

        $response = [
            'data' => [
                'success'  => true,
                'response' => 'Successfully created new expense',
                'data' => [
                    // 'fromTransactionChanges' => $fromTransactionChanges,
                    'createdResponse' => isset($transactionResponse)?$transactionResponse:''
                    ]
                // 'ChatList'  => $chatRequest
            ],
            'code' => 200
        ];

        echo json_encode($response['data']);
        exit;
    }

    public function purchaseTransaction()
    {
        $accountService = new AccountService();

        $request_data = $this->handlePOSTBodyDataList();

        // passing parameters --> (amount [required], current_account [required], budget [required], shop [required])
        $requiredParameters = $this->handleRequiredParameters($request_data, ['amount', 'current_account','budget','shop']);

        if(isset($requiredParameters['error_id'])){
            return $requiredParameters;
        }

        $amount = $request_data['amount'];
        $description = ($request_data['description'])?$request_data['description']:'Payment Made';
        $item_list = ($request_data['item_list'])?$request_data['item_list']:'';
        $scheduled_info = ($request_data['scheduled_info'])?$request_data['scheduled_info']:'';
        $current_account = $request_data['current_account'];
        $transaction_type = 'expense';
        $budget = $request_data['budget'];
        $shop = $request_data['shop'];

        // TODO:: need to add a condition to implement the first payment and handle the the fisrt payment with the scheudle.
        // to implement the above need to allow scheduled info in to the transaction
        if(($scheduled_info == '')){
            // Account Balance Validation handle functionality
            // TODO:: link user default user
            $accBalAccount = $accountService->getAccountCurrentBalance($this->user_id, $current_account);

            if(isset($accBalAccount['error_id'])){
                return $accBalAccount;
            }

            if($accBalAccount < $amount){
                return $accBalAccount;
            }
            // ---End Account Balance Validation handle functionality
        }

        $purchaseResponse = $this->purchaseInitProcess($this->user_id, $description, $shop, $amount, $item_list);
        
        if(isset($purchaseResponse['error_id'])){
            return $purchaseResponse;
        }

        if(($scheduled_info != '')){
            $purchasePlanResponse = $this->paymentPlanInitProccess('purchase', $purchaseResponse['data']['PurchaseSessionID'], $scheduled_info, $amount);
        
            if(isset($purchasePlanResponse['error_id'])){
                return $purchasePlanResponse;
            }
        }
        
        // TODO:: need to add a condition to implement the first payment and handle the the fisrt payment with the scheudle.
        // to implement the above need to allow scheduled info in to the transaction
        if(($scheduled_info == '')){
            // TODO:: link user default user
            $transactionResponse = $accountService->transactionInitProccess($this->user_id, $description, $amount, $transaction_type, $current_account, $budget);

            if(isset($transactionResponse['error_id'])){
                return $transactionResponse;
            }
        }

        $response = [
            'data' => [
                'success'  => true,
                'response' => 'Successfully created new purchase',
                'data' => [
                    'createdResponse' => isset($transactionResponse) ? $transactionResponse : $purchasePlanResponse
                ]
            ],
            'code' => 200
        ];

        echo json_encode($response['data']);
        exit;
    }
}
