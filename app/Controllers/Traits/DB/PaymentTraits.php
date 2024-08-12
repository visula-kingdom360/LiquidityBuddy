<?php

namespace App\Controllers\Traits\DB;

use App\Models\Database\Common;

trait PaymentTraits{
    // the traits structure is in a format that even though the feild names change we access these traits from the frontend the same way so we would never have to make changes for frontend when we change table feild names or any data accessing method we use data changes the data type
       
    # 'FrontEndValues'[Not changed unless UI structures change] => 'BackEndFeilds'[Could change when table feild names or any data accessing method changes the data type]

    # PaymentPlan Table Structure assigned
    public function paymentplanStructure()
    {
        $this->table = 'paymentplan';
        
        $this->primaryKeys = [
            'PaymentPlanID' => 'id',
        ];
        
        $this->allKeys = [
            'PaymentPlanID'                 => 'id',
            'PaymentPlanSessionID'          => 'sessionid',
            'PaymentPlanLinkType'           => 'linktype',
            'PaymentPlanLinkSessionID'      => 'linksessionid',
            'PaymentPlan'                   => 'paymentplan',
            'PaymentPlanPeriod'             => 'period',
            'PaymentPlanRate'               => 'rate',
            'PaymentPlanStartDate'          => 'startdate',
            'PaymentPlanEndDate'            => 'enddate',
            'PaymentPlanCreatedDateTime'    => 'createddatetime',
            'PaymentPlanUpdatedDateTime'    => 'updateddatetime'
        ];
        
        // TODO: Update with with user information
        $this->foreignKeys = [
        ];
    }

    # settlement Table Structure assigned
    public function settlementStructure()
    {
        $this->table = 'settlement';
        
        $this->primaryKeys = [
            'SettlementID'  => 'ID'
        ];
        
        $this->allKeys = [
            'SettlementID'                 => 'id',
            'SettlementSessionID'          => 'sessionid',
            'AccountSessionID'              => 'accountsessionid',
            'PayableSessionID'              => 'payablesessionid',
            'SettlementFinalAmount'        => 'paidamount',
            'SettlementDate'               => 'date',
            'SettlementCreatedDateTime'    => 'createddatetime',
            'SettlementUpdatedDateTime'    => 'updateddatetime'
        ];
        
        $this->foreignKeys = [
            'AccountSessionID' => 'accountsessionid',
            'PayableSessionID' => 'payablesessionid'

        ];
    }

    # Payable Table Structure assigned
    public function payableStructure()
    {
        $this->table = 'payable';
        
        $this->primaryKeys = [
            'PayableID'  => 'ID'
        ];
        
        $this->allKeys = [
            'PayableID'                 => 'id',
            'PayableSessionID'          => 'sessionid',
            'PaymentPlanSessionID'      => 'paymentplansessionid',
            'PayableAmountPayable'      => 'amountpayable',
            'PayableDueDate'            => 'duedate',
            'PayableCreatedDateTime'    => 'createddatetime',
            'PayableUpdatedDateTime'    => 'updateddatetime'
        ];
        
        $this->foreignKeys = [
            'PaymentPlanSessionID' => 'paymentplansessionid'
        ];
    }

}