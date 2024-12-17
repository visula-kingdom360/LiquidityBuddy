<?php

namespace App\Controllers;

class ReportService extends MainService
{
    public function reportProccess($userID, $accountID, $budgetID, $startDate, $endDate, $transactionType = 'income')
    {
        $searchData = [];

        if($accountID != 0){
            $searchData['AccountSessionID'] = $accountID;
        }
        
        if($budgetID != 0){
            $searchData['BudgetSessionID'] = $budgetID;
        }

        if($transactionType == 'income' || $transactionType == 'expense'){
            $searchData['TransactionPayableType'] = $transactionType;
        }

        $searchData['sqldecrypt'] = 'datetime <= '.$endDate.' AND datetime >= '.$startDate;

        $transactionHistory = $this->getDatafromDB(
                        ['transaction','account','budget'], 
                         $searchData,
                        []
                    );

        if(isset($transactionHistory['error_id'])){
            return $transactionHistory;
        }

        return $transactionHistory;
    }

    public function purchaseReportProccess($userID, $startDate, $endDate)
    {
        $searchData = [];

        $searchData['UserSessionID'] = $userID;
        $searchData['sqldecrypt'] = 'datetime <= '.$endDate.' AND datetime >= '.$startDate;

        $purchaseHistory = $this->getDatafromDB(
                        ['purchase','shop'], 
                         $searchData,
                        []
                    );

        if(isset($purchaseHistory['error_id'])){
            return $purchaseHistory;
        }

        foreach ($purchaseHistory as $key => $purchase) {
            # code...
            $purchaseHistory[$key]['PurchaseDateTime'] = date('Y-m-d h:i:s',$purchase['PurchaseDateTime']);
            $purchaseHistory[$key]['PurchaseTotalAmount'] = ($purchase['PurchaseTotalAmount']) ? $purchase['PurchaseTotalAmount'] : 0;
            $purchaseHistory[$key]['PurchaseTotalDiscount'] = ($purchase['PurchaseTotalDiscount']) ? $purchase['PurchaseTotalDiscount'] : 0;
            $purchaseHistory[$key]['PurchaseFinalAmount'] = ($purchase['PurchaseFinalAmount']) ? $purchase['PurchaseFinalAmount'] : 0;;
            

            $itemInfo = $this->getDatafromDB(
                        ['item'], 
                        ['PurchaseSessionID' => $purchase['PurchaseSessionID']],
                        []
                    );

            if(isset($itemInfo['error_id'])){
                continue;
            }

            $purchaseHistory[$key]['Items'] = $itemInfo;
        }

        return $purchaseHistory;
    }
}