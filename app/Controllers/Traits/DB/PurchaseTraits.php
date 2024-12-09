<?php

namespace App\Controllers\Traits\DB;

use App\Models\Database\Common;

trait PurchaseTraits{
    // the traits structure is in a format that even though the feild names change we access these traits from the frontend the same way so we would never have to make changes for frontend when we change table feild names or any data accessing method we use data changes the data type
       
    # 'FrontEndValues'[Not changed unless UI structures change] => 'BackEndFeilds'[Could change when table feild names or any data accessing method changes the data type]

    # Shop Table Structure assigned
    public function shopStructure()
    {
        $this->table = 'shop';
        
        $this->primaryKeys = [
            'ShopID'        => 'id',
            'ShopSessionID' => 'sessionid'
        ];
        
        $this->allKeys = [
            'ShopID'            => 'id',
            'ShopSessionID'     => 'sessionid',
            'ShopName'          => 'name',
            'ShopDescription'   => 'description',
            'ShopMoreInfo'      => 'moreinfo'
        ];
        
        // TODO: Update with with user information
        $this->foreignKeys = [
        ];
    }

    # Shop Access Order Table Structure assigned
    public function shopaccessorderStructure()
    {
        $this->table = 'shopaccessorder';
        
        $this->primaryKeys = [
            'UserSessionID' => 'usersessionid',
            'ShopSessionID' => 'shopsessionid'
        ];
        
        $this->allKeys = [
            'UserSessionID'                 => 'usersessionid',
            'ShopSessionID'                 => 'shopsessionid',
            'ShopAccessOrderAccessCount'    => 'accesscount'
        ];
        
        // TODO: Update with with user information
        $this->foreignKeys = [
            'UserSessionID' => 'user',
            'ShopSessionID' => 'shop'
        ];
    }
    # Item Table Structure assigned
    public function itemStructure()
    {
        $this->table = 'item';
        
        $this->primaryKeys = [
            'ItemID'        => 'id',
            'ItemSessionID' => 'sessionid'
        ];
        
        $this->allKeys = [
            'ItemID'                => 'id',
            // 'ItemSessionID'         => 'sessionid',
            'PurchaseSessionID'     => 'purchasesessionid',
            'ItemName'              => 'name',
            'ItemDescription'       => 'description',
            // 'ItemDate'              => 'date',
            'ItemOriginalPrice'     => 'originalprice',
            'ItemlDiscountAmount'   => 'discountamount',
            'ItemFinalPrice'        => 'finalprice',
            'ItemUnits'             => 'units',
            'ItemUnitPrice'         => 'unitprice'
        ];
        
        $this->foreignKeys = [
            'PurchaseSessionID' => 'purchase'
        ];
    }

    # Purchase Table Structure assigned
    public function purchaseStructure()
    {
        $this->table = 'purchase';
        
        $this->primaryKeys = [
            'PurchaseID'        => 'id',
            'PurchaseSessionID' => 'sessionid'
        ];
        
        $this->allKeys = [
            'PurchaseID'                => 'id',
            'PurchaseSessionID'         => 'sessionid',
            'ShopSessionID'             => 'shopsessionid',
            'UserSessionID'             => 'usersessionid',
            'PurchaseDescription'       => 'description',
            'PurchaseDate'              => 'date',
            'PurchaseDateTime'          => 'datetime',
            'PurchaseTotalAmount'       => 'totalamount',
            'PurchaseTotalDiscount'     => 'totaldiscount',
            'PurchaseFinalAmount'       => 'finalamount',
            'PurchaseStatus'            => 'status',
            'PurchaseCreatedDateTime'   => 'createddatetime',
            'PurchaseUpdatedDateTime'   => 'updateddatetime'
        ];
        
        $this->foreignKeys = [
            'ShopSessionID'              => 'shop'
        ];
    }

    # Borrowed Table Structure assigned
    public function borrowedStructure()
    {
        $this->table = 'borrowed';
        
        $this->primaryKeys = [
            'BorrowedID'        => 'id',
            'BorrowedSessionID' => 'sessionid'
        ];
        
        $this->allKeys = [
            'BorrowedID'                => 'id',
            'BorrowedSessionID'         => 'sessionid',
            'StackholderSessionID'      => 'stackholdersessionid',
            'BorrowedAmount'            => 'amount',
            'BorrowedDate'              => 'date',
            'BorrowedPaidDate'          => 'paiddate',
            'BorrowedExpected'          => 'expected',
            'BorrowedCreatedDateTime'   => 'createddatetime',
            'BorrowedUpdatedDateTime'   => 'updateddatetime'
        ];
        
        // TODO: Update with with user information
        $this->foreignKeys = [
            'StackholderSessionID' => 'stackholder'
        ];
    }

    # Travel Table Structure assigned
    public function travelStructure()
    {
        $this->table = 'travel';
        
        $this->primaryKeys = [
            'TravelID' => 'id',
        ];
        
        $this->allKeys = [
            'TravelID'              => 'id',
            // 'TravelSessionID'         => 'sessionid',
            'TravelTransportType'   => 'transporttype',
            'TravelCost'            => 'cost',
            'TravelDate'            => 'date',
            'TravelFromLocation'    => 'fromlocation',
            'TravelToLocation'      => 'tolocation',
            'TravelCreatedDateTime' => 'createddatetime',
            'TravelUpdatedDateTime' => 'updateddatetime'
        ];
        
        // TODO: Update with with user information
        $this->foreignKeys = [
        ];
    }

}