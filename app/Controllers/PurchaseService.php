<?php

namespace App\Controllers;

use DateTime;

class PurchaseService extends MainService
{

    protected function purchaseInitProcess($userID, $description, $shopID, $amount, $itemList)
    {
        $createPurchaseData = [
            'ShopSessionID' => $shopID,
            'PurchaseDescription' => $description,
            'PurchaseDate' => date_format(new DateTime(),'Y-m-d'),
            'UserSessionID' => $userID,
            'PurchaseCreatedDateTime' => strtotime(date_format(new DateTime(),'Y-m-d h:i:s')),
            'PurchaseUpdatedDateTime' => strtotime(date_format(new DateTime(),'Y-m-d h:i:s')),
        ];

        $newPurchase = $this->insertDatatoDB('purchase', 
                    $createPurchaseData
                    );

        if(isset($newPurchase['error_id'])){
            return $newPurchase;
        }

        $purchaseInfo = $this->getDatafromDB(
                        ['purchase'], 
                        ['PurchaseID' => $newPurchase['id']],
                        ['PurchaseSessionID']
                    );

        if(isset($purchaseInfo['error_id'])){
            return $purchaseInfo;
        }
        
        $TotalAmt = 0;
        $discountAmt = 0;
        $finalAmt = 0;

        if($itemList != ''){
            foreach ($itemList as $key => $item) {
                # code...
                $TotalAmt += ($item['units'] * $item['unit_price']);
                $discountAmt += ($item['discount']);
                $finalAmt += ($item['units'] * $item['unit_price']) - ($item['discount']);

                $createItemData = [
                            'PurchaseSessionID' => $purchaseInfo['PurchaseSessionID'],
                            'ItemName' => $item['name'],
                            'ItemDescription' => '('.$item['name'].' * '.$item['units'].')',
                            'ItemOriginalPrice' => ($item['units'] * $item['unit_price']),
                            'ItemlDiscountAmount' => ($item['discount']),
                            'ItemFinalPrice' => ($item['units'] * $item['unit_price']) - ($item['discount']),
                            'ItemUnits' => $item['units'],
                            'ItemUnitPrice' => $item['unit_price']
                        ];

                $newItem = $this->insertDatatoDB('item', 
                            $createItemData
                            );

                if(isset($newItem['error_id'])){
                    // return $newItem;
                }
            }
        }

        $purchaseInfo = $this->getDatafromDB(
                        ['shopaccessorder'], 
                        ['ShopSessionID' => $shopID,'UserSessionID' => $userID],
                        ['ShopAccessOrderAccessCount']
                    );

        if(isset($purchaseInfo['error_id'])){
            // return $purchaseInfo;

            $createShopAccessData = [
                        'ShopSessionID' => $shopID,
                        'UserSessionID' => $userID,
                        'ShopAccessOrderAccessCount' => 1
                    ];

            $newShopAccess = $this->insertDatatoDB('shopaccessorder', 
                        $createShopAccessData
                        );

            if(isset($newShopAccess['error_id'])){
                // return $newItem;
            }
        }else{
            $shopAccessUpdated = $this->updateDBData(
                    'shopaccessorder', 
                    ['ShopSessionID' => $shopID, 'UserSessionID' => $userID], 
                    [
                        'ShopAccessOrderAccessCount' => ($purchaseInfo['ShopAccessOrderAccessCount'] + 1)
                    ]
                );

            if(isset($shopAccessUpdated['error_id'])){
                // return $shopAccessUpdated;
            }
        }

        if($finalAmt == $amount){
            $userUpdated = $this->updateDBData(
                    'purchase', 
                    ['PurchaseSessionID' => $purchaseInfo['PurchaseSessionID'], 'PurchaseStatus' => 'I'], 
                    [
                        'PurchaseTotalAmount' => $TotalAmt,
                        'PurchaseTotalDiscount' => $discountAmt,
                        'PurchaseFinalAmount' => $finalAmt,
                        'PurchaseUpdatedDateTime' => strtotime(date_format(new DateTime(),'Y-m-d h:i:s'))
                    ]
                );

            if(isset($userUpdated['error_id'])){
                return $userUpdated;
            }

        return ['success' => true, 'data' => $purchaseInfo];
        }else{
            return 'Error';
        }
    }

    protected function paymentPlanInitProccess($link, $linkID, $scheduled_info, $amount)
    {
        $schdule_type = ($scheduled_info['schedule_type']) ? $scheduled_info['schedule_type'] : 'I';
        $period = ($scheduled_info['period']) ? $scheduled_info['period'] : 2;
        $rate = 0;
        $start_date = ($scheduled_info['start_date']) ? $scheduled_info['start_date'] : date_format(new DateTime(),'Y-m-d');
        
        // TODO:: rate need to be added
        $createPaymentPlan = [
            'PaymentPlanLink' => $link,
            'PaymentPlanLinkSessionID' => $linkID,
            'PaymentPlan' => $schdule_type,
            'PaymentPlanPeriod' => $period,
            'PaymentPlanRate' => $rate,
            'PaymentPlanStartDate' => $start_date,
            'PaymentPlanEndDate' => date('Y-m-d', strtotime($start_date . ' + ' . ($this->getDaysofPeriodType($schdule_type) * $period) . ' days')),
            'PaymentPlanCreatedDateTime' => strtotime(date_format(new DateTime(),'Y-m-d h:i:s')),
            'PaymentPlanUpdatedDateTime' => strtotime(date_format(new DateTime(),'Y-m-d h:i:s'))
        ];

        $newPaymentPlan = $this->insertDatatoDB('paymentplan', 
                    $createPaymentPlan
                    );

        if(isset($newPaymentPlan['error_id'])){
            return $newPaymentPlan;
        }

        $purchaseInfo = $this->getDatafromDB(
                        ['paymentplan'], 
                        ['PaymentPlanID' => $newPaymentPlan['id']],
                        ['PaymentPlanSessionID']
                    );

        if(isset($purchaseInfo['error_id'])){
            return $purchaseInfo;
        }

        $next_date = $start_date;
        for ($no=0; $no < $period; $no++) { 
            # code...
            if($no != 0){
                $next_date = date('Y-m-d', strtotime($next_date . ' + ' . ($this->getDaysofPeriodType($schdule_type) * $no) . ' days'));
            }
        
            $createPayable = [
                'PaymentPlanSessionID' => $purchaseInfo['PaymentPlanSessionID'],
                'PayableDueDate' => $next_date,
                'PayableDueAmount' => ($amount / $period),
                'PayablePaidAmount' => 0,
                'PayableCreatedDateTime' => strtotime(date_format(new DateTime(),'Y-m-d h:i:s')),
                'PayableUpdatedDateTime' => strtotime(date_format(new DateTime(),'Y-m-d h:i:s'))
            ];

            $newPayable = $this->insertDatatoDB('payable', 
                        $createPayable
                        );

            if(isset($newPayable['error_id'])){
                return $newPayable;
            }
        }
    }
}
