<?php

namespace App\Controllers;

use DateTime;

class PurchaseService extends MainService
{
    public function __construct() {
        helper('text'); // Load the text helper containing random_string()
    }

    protected function purchaseInitProcess($userID, $description, $shopID, $amount, $itemList)
    {
        $createPurchaseData = [
            'ShopSessionID' => $shopID,
            'PurchaseDescription' => $description,
            'PurchaseDate' => date_format(new DateTime(),'Y-m-d'),
            'UserSessionID' => $userID,
            'PurchaseDateTime' => strtotime(date_format(new DateTime(),'Y-m-d h:i:s')),
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
        }else{
            $TotalAmt = $amount;
            $finalAmt = $amount;
        }

        $shopInfo = $this->getDatafromDB(
                        ['shopaccessorder'], 
                        ['ShopSessionID' => $shopID,'UserSessionID' => $userID],
                        ['ShopAccessOrderAccessCount']
                    );

        if(isset($shopInfo['error_id'])){
            // return $shopInfo;

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
                        'ShopAccessOrderAccessCount' => ($shopInfo['ShopAccessOrderAccessCount'] + 1)
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

    protected function paymentPlanInitProccess($userID, $link, $linkID, $scheduled_info, $amount)
    {
        $schdule_type = ($scheduled_info['schedule_type']) ? $scheduled_info['schedule_type'] : 'I';
        $make_initial_payment = ($scheduled_info['make_initial_payment'])?$scheduled_info['make_initial_payment']:'';
        $period = isset($scheduled_info['period']) ? $scheduled_info['period'] : 0;

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
            'PaymentPlanStartDateTime' => strtotime($start_date),
            'PaymentPlanEndDate' => date('Y-m-d', strtotime($start_date . ' + ' . ($this->getDaysofPeriodType($schdule_type) * $period) . ' days')),
            'PaymentPlanEndDateTime' => strtotime(date('Y-m-d', strtotime($start_date . ' + ' . ($this->getDaysofPeriodType($schdule_type) * $period) . ' days'))),
            'PaymentPlanCreatedDateTime' => strtotime(date_format(new DateTime(),'Y-m-d h:i:s')),
            'PaymentPlanUpdatedDateTime' => strtotime(date_format(new DateTime(),'Y-m-d h:i:s')),
            'UserSessionID' => $userID
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

        if($period > 0){
            for ($no=0; $no < $period; $no++) {
                # code...
                if($no != 0){
                    $next_date = date('Y-m-d', strtotime($next_date . ' + ' . ($this->getDaysofPeriodType($schdule_type) * $no) . ' days'));
                }
            
                $createPayable = [
                    'PaymentPlanSessionID' => $purchaseInfo['PaymentPlanSessionID'],
                    'PayableDueDate' => $next_date,
                    'PayableDueAmount' => ($amount / $period),
                    'PayablePaidAmount' => $no ? 0 : ($make_initial_payment ? $amount / $period : 0),
                    'PayablePaidDate' => ($no == 0  && $make_initial_payment) ? $next_date : 0,
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
            $purchaseInfo['PaidAmount'] = $amount / $period;
        }else{
            $purchaseInfo['PaidAmount'] = $amount;
        }

        return ($purchaseInfo);


        return ['success' => true, 'data' => $purchaseInfo];
    }

    public function externalPaymentInitProccess($userID, $amount, $external_pay_type, $external_data_list)
    {
        if($external_pay_type == 'T'){
            $createPayable = [
                'UserSessionID' => $userID,
                'TravelDate' => date_format(new DateTime(),'Y-m-d'),
                'TravelCost' => $amount,
                'TravelTransportType' => $external_data_list['travel_mode'],
                'TravelFromLocation' => $external_data_list['from_location'],
                'TravelToLocation' => $external_data_list['to_location'],
                'TravelCreatedDateTime' => strtotime(date_format(new DateTime(),'Y-m-d h:i:s')),
                'TravelUpdatedDateTime' => strtotime(date_format(new DateTime(),'Y-m-d h:i:s'))
            ];

            $newPayable = $this->insertDatatoDB('travel', 
                        $createPayable
                        );

            if(isset($newPayable['error_id'])){
                return $newPayable;
            }

            return ['success' => true, 'data' => ['ExpenseSessionID' => $newPayable['id']]];
        }elseif($external_pay_type == 'C') {
            # code...
            return ['success' => true, 'data' => ['ExpenseSessionID' => random_string('alpha', 32)]];
        }elseif($external_pay_type == 'O') {
            return ['success' => true, 'data' => ['ExpenseSessionID' => random_string('alpha', 32)]];
        }
    }

    
}
