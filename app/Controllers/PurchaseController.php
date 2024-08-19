<?php

namespace App\Controllers;
use DateTime;

class PurchaseController extends PurchaseService
{
    public function expenseTransaction()
    {
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

        // Account Balance Validation handle functionality
        // TODO:: link user default user
        $accBalAccount = $this->getAccountCurrentBalance($this->user_id, $current_account);

        if(isset($accBalAccount['error_id'])){
            return $accBalAccount;
        }

        if($accBalAccount < $amount){
            return $accBalAccount;
        }
        // ---End Account Balance Validation handle functionality

        // TODO:: link user default user
        $toTransactionChanges = $this->transactionInitProccess($this->user_id, $description, $amount, $transaction_type, $current_account, $budget);

        if(isset($toTransactionChanges['error_id'])){
            return $toTransactionChanges;
        }

        $response = [
            'data' => [
                'success'  => true,
                'response' => 'Successfully created new expense',
                'data' => [
                    // 'fromTransactionChanges' => $fromTransactionChanges,
                    'toTransactionChanges' => $toTransactionChanges
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
        $request_data = $this->handlePOSTBodyDataList();

        // passing parameters --> (amount [required], current_account [required], budget [required], shop [required])
        $requiredParameters = $this->handleRequiredParameters($request_data, ['amount', 'current_account','budget','shop']);

        if(isset($requiredParameters['error_id'])){
            return $requiredParameters;
        }

        $amount = $request_data['amount'];
        $description = ($request_data['description'])?$request_data['description']:'Payment Made';
        $item_list = ($request_data['item_list'])?$request_data['item_list']:'';
        $scheduled_info = $request_data['scheduled_info'];
        $current_account = $request_data['current_account'];
        $transaction_type = 'expense';
        $budget = $request_data['budget'];
        $shop = $request_data['shop'];

        // Account Balance Validation handle functionality
        // TODO:: link user default user
        $accBalAccount = $this->getAccountCurrentBalance($this->user_id, $current_account);

        if(isset($accBalAccount['error_id'])){
            return $accBalAccount;
        }

        if($accBalAccount < $amount){
            return $accBalAccount;
        }
        // ---End Account Balance Validation handle functionality

        $purchaseResponse = $this->purchaseInitProcess($this->user_id, $description, $shop, $amount, $item_list);
        
        if(isset($purchaseResponse['error_id'])){
            return $purchaseResponse;
        }

        if(($scheduled_info != '')){
            $purchasePlanResponse = $this->paymentPlanInitProccess('purchase', $purchaseResponse['data']['PurchaseSessionID'], $scheduled_info, $amount);
        
            if(isset($purchasePlanResponse['error_id'])){
                return $purchasePlanResponse;
            }
        }else{
            // TODO:: link user default user
            $transactionChanges = $this->transactionInitProccess($this->user_id, $description, $amount, $transaction_type, $current_account, $budget);

            if(isset($transactionChanges['error_id'])){
                return $transactionChanges;
            }
        }

        $response = [
            'data' => [
                'success'  => true,
                'response' => 'Successfully created new purchase',
                'data' => [
                    'createdResponse' => ($transactionChanges) ? $transactionChanges : $purchasePlanResponse
                ]
            ],
            'code' => 200
        ];

        echo json_encode($response['data']);
        exit;
    }
}
