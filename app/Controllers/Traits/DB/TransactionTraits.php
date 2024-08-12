<?php

namespace App\Controllers\Traits\DB;

use App\Models\Database\Common;

trait TransactionTraits{
    // the traits structure is in a format that even though the feild names change we access these traits from the frontend the same way so we would never have to make changes for frontend when we change table feild names or any data accessing method we use data changes the data type
       
    # 'FrontEndValues'[Not changed unless UI structures change] => 'BackEndFeilds'[Could change when table feild names or any data accessing method changes the data type]

    # Account Table Structure assigned
    public function accountStructure()
    {
        $this->table = 'account';
        
        $this->primaryKeys = [
            'AccountID'  => 'ID'
        ];
        
        $this->allKeys = [
            'AccountID'                 => 'id',
            'UserSessionID'             => 'usersessionid',
            'AccountSessionID'          => 'sessionid',
            'AccountName'               => 'name',
            'AccountCurrentBalance'     => 'currentbalance',
            'AccountCreatedDateTime'    => 'createddatetime',
            'AccountUpdatedDateTime'    => 'updateddatetime',
            'AccountStatus'             => 'status'
        ];
        
        // TODO: Update with with user information
        $this->foreignKeys = [
            'UserSessionID' => 'user',
        ];
    }

    # Transaction Table Structure assigned
    public function transactionStructure()
    {
        $this->table = 'transaction';
        
        $this->primaryKeys = [
            'AccountID'  => 'ID'
        ];
        
        $this->allKeys = [
            'TransactionID'                 => 'id',
            'AccountSessionID'              => 'accsessionid',
            'TransactionSessionID'          => 'sessionid',
            'TransactionDescription'        => 'description',
            'TransactionDate'               => 'date',
            'TransactionAmount'             => 'amount',
            'TransactionType'               => 'type',
            'TransactionCreatedDateTime'    => 'createddatetime',
            'TransactionUpdatedDateTime'    => 'updateddatetime',
            'TransactionStatus'             => 'status'
        ];
        
        $this->foreignKeys = [
            'AccountSessionID'              => 'account'
        ];
    }

}