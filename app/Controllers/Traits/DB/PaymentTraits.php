<?php

namespace App\Controllers\Traits\DB;

use App\Models\Database\Common;

trait PaymentTraits{
    // the traits structure is in a format that even though the feild names change we access these traits from the frontend the same way so we would never have to make changes for frontend when we change table feild names or any data accessing method we use data changes the data type
       
    # 'FrontEndValues'[Not changed unless UI structures change] => 'BackEndFeilds'[Could change when table feild names or any data accessing method changes the data type]

    # Purchase Plan Table Structure assigned
    public function paymentplanStructure()
    {
        $this->table = 'paymentplan';
        
        $this->primaryKeys = [
            'PaymentPlanID'         => 'id',
            'PaymentPlanSessionID'  => 'sessionid'
        ];
        
        $this->allKeys = [
            'PaymentPlanID'                 => 'id',
            'PaymentPlanSessionID'          => 'sessionid',
            'PaymentPlanLink'               => 'paymentplanlink',
            'PaymentPlanLinkSessionID'      => 'paymentplansessionid',
            'UserSessionID'                 => 'usersessionid',
            'PaymentPlan'                   => 'paymentplan',
            'PaymentPlanPeriod'             => 'period',
            'PaymentPlanRate'               => 'rate',
            'PaymentPlanStartDate'          => 'startdate',
            'PaymentPlanEndDate'            => 'enddate',
            'PaymentPlanCreatedDateTime'    => 'createddatetime',
            'PaymentPlanUpdatedDateTime'    => 'updateddatetime'
        ];
        
        $this->foreignKeys = [
        ];
    }

    # Payable Table Structure assigned
    public function payableStructure()
    {
        $this->table = 'payable';
        
        $this->primaryKeys = [
            'PayableID'         => 'id',
            'PayableSessionID'  => 'sessionid'
        ];
        
        $this->allKeys = [
            'PayableID'                 => 'id',
            'PayableSessionID'          => 'sessionid',
            'PaymentPlanSessionID'      => 'paymentplansessionid',
            'PayableDueDate'            => 'duedate',
            'PayablePaidDate'           => 'paiddate',
            'PayableDueAmount'          => 'dueamount',
            'PayablePaidAmount'         => 'paidamount',
            'PayableCreatedDateTime'    => 'createddatetime',
            'PayableUpdatedDateTime'    => 'updateddatetime'
        ];
        
        $this->foreignKeys = [
            'PaymentPlanSessionID' => 'paymentplan',
        ];
    }

    # Claim Table Structure assigned
    public function claimStructure()
    {
        $this->table = 'claim';
        
        $this->primaryKeys = [
            'ClaimID'  => 'id'
        ];
        
        $this->allKeys = [
            'ClaimID'               => 'id',
            'StackholderSessionID'  => 'stackholdersessionid',
            'PaymentPlanSessionID'  => 'paymentplansessionid',
            'ClaimRate'             => 'rate',
            'ClaimStartedDate'      => 'starteddate',
            'ClaimEndDate'          => 'endate',
            'ClaimAmount'           => 'amount',
            'ClaimCreatedDateTime'  => 'createddatetime',
            'ClaimUpdatedDateTime'  => 'updateddatetime'
        ];
        
        $this->foreignKeys = [
            'StackholderSessionID'  => 'stackholdersessionid',
            'PaymentPlanSessionID'  => 'paymentplansessionid'
        ];
    }
}