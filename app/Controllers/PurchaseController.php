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
        $requiredParameters = $this->handleRequiredParameters($request_data, ['amount', 'current_account','budget','external_pay_type']);

        if(isset($requiredParameters['error_id'])){
            return $requiredParameters;
        }

        $amount = $request_data['amount'];
        $description = ($request_data['description'])?$request_data['description']:'Payment Made';
        $transaction_type = 'expense';
        $current_account = $request_data['current_account'];
        $budget = $request_data['budget'];
        $scheduled_info = ($request_data['scheduled_info'])?$request_data['scheduled_info']:'';
        $make_initial_payment = (isset($scheduled_info['make_initial_payment']) && $scheduled_info['make_initial_payment'])?$scheduled_info['make_initial_payment']:1;
        $external_pay_type = ($request_data['external_pay_type'])?$request_data['external_pay_type']:'O';
        $external_data_list = (isset($request_data['external_data_list']) && $request_data['external_data_list'])?$request_data['external_data_list']:'';

        $transactionResponse = $this->externalPaymentInitProccess($this->userAccess(), $amount, $external_pay_type, $external_data_list);

        if(isset($transactionResponse['error_id'])){
            return $transactionResponse;
        }

        $expenseSessionId = ($transactionResponse['data']['ExpenseSessionID'])?$transactionResponse['data']['ExpenseSessionID']:random_int(1, 1000);

        // TODO:: need to add a condition to implement the first payment and handle the the fisrt payment with the schedule.
        // to implement the above need to allow scheduled info in to the transaction
        if(($scheduled_info == '')){
            // Account Balance Validation handle functionality
            // TODO:: link user default user
            $accBalAccount = $accountService->getAccountCurrentBalance($this->userAccess(), $current_account);

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
            $purchasePlanResponse = $this->paymentPlanInitProccess($this->userAccess(),'expense', $expenseSessionId, $scheduled_info, $amount);
        
            if(isset($purchasePlanResponse['error_id'])){
                return $purchasePlanResponse;
            }

            $amount = $purchasePlanResponse['data']['PaidAmount'];
        }

        // DONE:: need to add a condition to implement the first payment and handle the the fisrt payment with the scheudle.
        // to implement the above need to allow scheduled info in to the transaction
        if($make_initial_payment){

            // TODO:: link user default user
            $transactionResponse = $accountService->transactionInitProccess($this->userAccess(), $description, $amount, $transaction_type, $current_account, $budget);

            if(isset($transactionResponse['error_id'])){
                return $transactionResponse;
            }
        }

        $response = [
            'data' => [
                'success'  => true,
                'response' => 'Successfully created new expense',
                'data' => [
                    'createdResponse' => isset($transactionResponse)?$transactionResponse:''
                    ]
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
        $make_initial_payment = isset($scheduled_info['make_initial_payment'])?$scheduled_info['make_initial_payment']:1;
        $current_account = $request_data['current_account'];
        $transaction_type = 'expense';
        $budget = $request_data['budget'];
        $shop = $request_data['shop'];

        // TODO:: need to add a condition to implement the first payment and handle the the fisrt payment with the scheudle.
        // to implement the above need to allow scheduled info in to the transaction
        if($scheduled_info == ''){
            // Account Balance Validation handle functionality
            // TODO:: link user default user
            $accBalAccount = $accountService->getAccountCurrentBalance($this->userAccess(), $current_account);

            if(isset($accBalAccount['error_id'])){
                return $accBalAccount;
            }

            if($accBalAccount < $amount){
                return $accBalAccount;
            }
            // ---End Account Balance Validation handle functionality
        }

        $purchaseResponse = $this->purchaseInitProcess($this->userAccess(), $description, $shop, $amount, $item_list);
        
        if(isset($purchaseResponse['error_id'])){
            return $purchaseResponse;
        }

        if(($scheduled_info != '')){
            $purchasePlanResponse = $this->paymentPlanInitProccess($this->userAccess(),'purchase', $purchaseResponse['data']['PurchaseSessionID'], $scheduled_info, $amount);

            if(isset($purchasePlanResponse['error_id'])){
                return $purchasePlanResponse;
            }

            $amount = $purchasePlanResponse['data']['PaidAmount'];
        }
        
        // TODO:: need to add a condition to implement the first payment and handle the the fisrt payment with the scheudle.
        // to implement the above need to allow scheduled info in to the transaction
        if(($make_initial_payment)){
            // TODO:: link user default user
            $transactionResponse = $accountService->transactionInitProccess($this->userAccess(), $description, $amount, $transaction_type, $current_account, $budget);

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

    public function incomeTransaction(){
        $request_data = $this->handlePOSTBodyDataList();
        $accountService = new AccountService();

        $requiredParameters = $this->handleRequiredParameters($request_data, ['type','amount','account_id','budget_id']);

        if(isset($requiredParameters['error_id'])){
            return $requiredParameters;
        }

        // required feilds
        $type = $request_data['type'];
        $amount = $request_data['amount'];
        $accountID = $request_data['account_id'];
        $budgetID = $request_data['budget_id'];

        // optional feilds
        $description = ($request_data['description'])?$request_data['description']:'Payment Received';
        $collectionPlan = isset($request_data['collection_plan'])?$request_data['collection_plan']:'';

        // $accountResponse = $accountService->getAccountSessionID($accountID);

        // if(isset($accountResponse['error_id'])){
        //     return $accountResponse;
        // }

        if($type == 'till' || $type == 'monthly'){
            $purchasePlanResponse = $this->paymentPlanInitProccess($this->userAccess(),'income', random_string('alpha', 32), $collectionPlan, $amount);

            if(isset($purchasePlanResponse['error_id'])){
                return $purchasePlanResponse;
            }

            $trans_amount = $purchasePlanResponse['data']['PaidAmount'];
        }else{
            $trans_amount = $amount;
        }

        $type = /*($transaction_type == 'income') ? 'expense' :*/ 'income';

        if($trans_amount != 0){
            // DONE:: link user default user
            $transactionCreation = $accountService->transactionInitProccess($this->userAccess(), $description, $amount, $type, $accountID, $budgetID);
            // transactionInitProccess($userID, $description, $amount, $type, $accountID, $budgetID)

            // TODO:: Error Handling Method
            if(isset($transactionCreation['error_id'])){
                return $this->errorHandleforAPIResponses($transactionCreation);
            }

            $response = $transactionCreation;
        }else{
            $response = $purchasePlanResponse;
        }

        $response = [
            'data' => [
                'success'  => true,
                'response' => 'Successfully created transaction',
                'data' => [
                    'createdResponse' => $response
                    ]
            ],
            'code' => 200
        ];

        echo json_encode($response['data']);
        exit;
    }

    public function duedTransaction(){
        $request_data = $this->handlePOSTBodyDataList();
        $accountService = new AccountService();

        $requiredParameters = $this->handleRequiredParameters($request_data, ['amount','account_id','budget_id']);

        if(isset($requiredParameters['error_id'])){
            return $requiredParameters;
        }

        // required feilds
        $amount = $request_data['amount'];
        $accountID = $request_data['account_id'];
        $budgetID = $request_data['budget_id'];

        // optional feilds
        $description = ($request_data['description'])?$request_data['description']:'Payment Received';
        $paymentList = isset($request_data['payment_list'])?$request_data['payment_list']:'';

        // $accountResponse = $accountService->getAccountSessionID($accountID);

        // if(isset($accountResponse['error_id'])){
        //     return $accountResponse;
        // }

        // $paymentList = json_decode($paymentList, true);

        $response = $this->settlePayment($paymentList);

        if(isset($response['error_id'])){
            return $response;
        }

        // DONE:: link user default user
        $transactionCreation = $accountService->transactionInitProccess($this->userAccess(), $description, $amount, 'expense', $accountID, $budgetID);

        // TODO:: Error Handling Method
        if(isset($transactionCreation['error_id'])){
            return $this->errorHandleforAPIResponses($transactionCreation);
        }

        $response = [
            'data' => [
                'success'  => true,
                'response' => 'Successfully created transaction',
                'data' => [
                    'createdResponse' => $transactionCreation
                    ]
            ],
            'code' => 200
        ];


    }
}
