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
            'ShopID' => 'id',
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

    # Purchase Table Structure assigned
    public function purchaseStructure()
    {
        $this->table = 'purchase';
        
        $this->primaryKeys = [
            'PurchaseID'  => 'ID'
        ];
        
        $this->allKeys = [
            'PurchaseID'                 => 'id',
            'ShopSessionID'              => 'shopsessionid',
            'PurchaseSessionID'          => 'sessionid',
            'PurchaseDescription'        => 'description',
            'PurchaseDate'               => 'date',
            'PurchaseTotalAmount'        => 'totalamount',
            'PurchaseTotalDiscount'      => 'totaldiscount',
            'PurchaseFinalAmount'        => 'finalamount',
            'PurchaseCreatedDateTime'    => 'createddatetime',
            'PurchaseUpdatedDateTime'    => 'updateddatetime'
        ];
        
        $this->foreignKeys = [
            'ShopSessionID'              => 'shopsessionid'
        ];
    }

    # Item Table Structure assigned
    public function itemStructure()
    {
        $this->table = 'item';
        
        $this->primaryKeys = [
            'ItemID'  => 'ID'
        ];
        
        $this->allKeys = [
            'ItemID'                => 'id',
            'PurchaseSessionID'     => 'purchasesessionid',
            'ItemSessionID'         => 'sessionid',
            'ItemName'              => 'name',
            'ItemDescription'       => 'description',
            'ItemDate'              => 'date',
            'ItemOriginalPrice'     => 'originalprice',
            'ItemlDiscountAmount'   => 'discountamount',
            'ItemFinalPrice'        => 'finalprice',
            'ItemUnits'             => 'units',
            'ItemUnitPrice'         => 'unitprice'
        ];
        
        $this->foreignKeys = [
            'PurchaseSessionID' => 'purchasesessionid'
        ];
    }

}